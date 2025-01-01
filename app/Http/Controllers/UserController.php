<?php

namespace App\Http\Controllers;

use App\Models\cr;
use Carbon\Carbon;
use App\Models\Log;
use App\Models\User;
use App\Models\Supplier;
use App\Models\Inventory;
use App\Models\Transactions;
use Illuminate\Http\Request;
use App\Models\InventoryOuts;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use Symfony\Component\VarDumper\VarDumper;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
    if (session()->has('session_id')) {
        // Total quantity of stock
        $sum_qty = Inventory::selectRaw('SUM(quantity) as total_qty')
            ->value('total_qty');

        // Count of suppliers
        $supplier_count = Supplier::count();

        // Total amount (price * quantity) of transactions
        $total_amount = Transactions::selectRaw('SUM(price*quantity) as total_amount')
            ->value('total_amount');

        // Logs
        $logs = Log::get();

        // Low stock items (less than 10 quantity)
        $low_stock_items = Inventory::where('quantity', '<', 10)
            ->orderBy('quantity', 'asc')
            ->get();

        // Calculate total Barang Masuk (Stock In)
        $total_stock_in = Inventory::where('entry_date', '>=', now()->subDays(7))  // for the last 7 days
            ->sum('quantity');

        // Calculate total Barang Keluar (Stock Out)
        $total_stock_out = InventoryOuts::where('date_out', '>=', now()->subDays(7))  // for the last 7 days
            ->sum('quantity');

        // Total supplier
        $total_supplier = Supplier::count();

        //Low Stock Items
        $items = Inventory::where('status', 'low stock')->get();

        return view('index', compact('sum_qty', 'supplier_count', 'items', 'total_supplier','total_amount', 'logs', 'low_stock_items', 'total_stock_in', 'total_stock_out'));
    }
    return redirect('login');
    }



    public function emp_registration(){
        $user_type = Session::get('session_user_type');
        if($user_type == 'admin'){
            return view('emp_registration');
        }
        else{
            return redirect('index')->with("fail", "Hanya Admin yang dapat menambah karyawan");
        }

    }

    public function emp_registration_post(Request $request){
    $user_type = Session::get('session_user_type');

    if ($user_type == 'admin') {
        try {
            // Validasi input
            $validated = $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
                'phone' => 'required',
                'address' => 'required',
                'city' => 'required',
                'state' => 'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'role' => 'required',
            ]);

            // Hash password sebelum menyimpan
            $validated['password'] = Hash::make($validated['password']);

            // Proses gambar jika ada
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image_name = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/user'), $image_name);

                // Menyimpan URL penuh gambar
                $validated['image'] = asset('uploads/user/' . $image_name);
            } else {
                // URL default jika tidak ada gambar
                $validated['image'] = asset('assets/images/user/form-user.png');
            }


            // Tambahkan timestamp
            $validated['created_at'] = Carbon::now();
            $validated['updated_at'] = Carbon::now();

            // Simpan data ke database
            User::create($validated);

            return redirect('emp_list')->with('success', 'Data Berhasil Ditambahkan');
        } catch (\Exception $e) {
            // Tampilkan error jika terjadi kegagalan
            return redirect()->back()->with('error', 'Gagal Menambahkan Data: ' . $e->getMessage());
        }
    } else {
        return redirect('index')->with("fail", "Hanya Admin yang dapat menambah karyawan");
    }
}

    public function emp_list(Request $request){
        $user_type = Session::get('session_user_type');
        if($user_type == 'admin'){
            $query = User::query();
            if($request->filled('date_range')) {
                $dates = explode(' - ', $request->date_range);
                $starDate = $dates[0];
                $endDate = $dates[1];
                $query->whereBetween('created_at', [$starDate, $endDate]);
            }
            $emp_list = $query->paginate(10);
            return view('emp_list', compact('emp_list'));
        }else{
            return redirect('index')->with("fail", "Hanya Admin yang dapat menampilkan data karyawan");
        }
    }

    public function emp_edit($id){
        $user_type = Session::get('session_user_type');
        if($user_type == 'admin'){
            $emp = User::find($id);
            return view('emp_edit', compact('emp'));
        }
        else{
            return redirect('index')->with("fail", "Hanya Admin yang dapat mengedit karyawan");
        }
    }

    public function emp_edit_post(Request $request, $id){
        $user_type = Session::get('session_user_type');

        if ($user_type == 'admin') {
            try {
                // Validasi input
                $validated = $request->validate([
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email,' . $id, // Tambahkan $id untuk pengecualian
                    'password' => 'nullable|min:6',
                    'phone' => 'required|regex:/^\+62[8][1-9][0-9]{6,11}$/', // Pembatas regex diganti
                    'address' => 'required',
                    'city' => 'required',
                    'state' => 'required',
                    'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                    'role' => 'required',
                ]);

                // Cari user berdasarkan ID
                $user = User::findOrFail($id);

                // Gunakan data lama jika tidak ada perubahan
                $dataToUpdate = [
                    'name' => $validated['name'] ?? $user->name,
                    'email' => $validated['email'] ?? $user->email,
                    'phone' => $validated['phone'] ?? $user->phone,
                    'address' => $validated['address'] ?? $user->address,
                    'city' => $validated['city'] ?? $user->city,
                    'state' => $validated['state'] ?? $user->state,
                    'role' => $validated['role'] ?? $user->role,
                ];

                // Proses password hanya jika diisi
                if (!empty($validated['password'])) {
                    $dataToUpdate['password'] = Hash::make($validated['password']);
                }

                // Proses gambar jika ada
                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $image_name = time() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('uploads/user'), $image_name);

                    // Simpan URL penuh gambar
                    $dataToUpdate['image'] = asset('uploads/user/' . $image_name);
                } else {
                    // Gunakan gambar lama jika tidak diubah
                    $dataToUpdate['image'] = $user->image;
                }

                // Perbarui data pengguna
                $user->update($dataToUpdate);

                return redirect('emp_list')->with('success', 'Data Berhasil Diperbarui');
            } catch (\Exception $e) {
                // Tampilkan error jika terjadi kegagalan
                return redirect()->back()->with('error', 'Gagal Memperbarui Data: ' . $e->getMessage());
            }
        } else {
            return redirect('index')->with("fail", "Hanya Admin yang dapat mengedit karyawan");
        }
    }




    public function emp_delete($id){
        $user_type = Session::get('session_user_type');
        if($user_type == 'admin'){
            $data = User::find($id);
            $data->delete();
            return redirect('emp_list')->with("success", "Data berhasil dihapus");
        }
        else{
            return redirect('index')->with("fail", "Hanya Admin yang dapat menghapus karyawan");
        }
    }

    public function emp_detail($id){
        $user_type = Session::get('session_user_type');
        if($user_type == 'admin'){
            $emp = User::find($id);
            return view('emp_detail', compact('emp'));
        }
        else{
            return redirect('index')->with("fail", "Hanya Admin yang dapat melihat detail karyawan");
        }
    }

    public function emp_import(){
        $user_type = Session::get('session_user_type');
        if($user_type == 'admin'){

            return view('emp_import');
        }
        else{
            return redirect('index')->with("fail", "Hanya Admin yang dapat mengimport karyawan");
        }
    }
    public function emp_import_post(Request $request)
{
    $user_type = Session::get('session_user_type');

    if ($user_type == 'admin') {
        // Validasi file
        $request->validate([
            'import_file' => 'required|file|mimes:xlsx,csv|max:2048', // Hanya file Excel atau CSV
        ]);

        try {
            // Impor file menggunakan Maatwebsite Excel
            Excel::import(new User, $request->file('import_file'));

            return redirect('emp_list')->with('success', 'Data berhasil diimpor.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengimpor data: ' . $e->getMessage());
        }
    } else {
        return redirect('index')->with('fail', 'Hanya Admin yang dapat mengimpor karyawan.');
    }
}
}
