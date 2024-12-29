<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Supplier;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Inventory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\InventoryOuts;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Session;


class InventoryController extends Controller
{
    public function list_barang(Request $request, $sort = 'default')
    {
        $user_type = Session::get('session_user_type');

        // Periksa apakah user adalah admin atau staff
        if ($user_type === 'admin' || $user_type === 'staff') {
            // Inisialisasi query untuk mengambil data Inventory
            $data = Inventory::query();

            // Filter berdasarkan tanggal jika ada input date_range
            if ($request->filled('date_range')) {
                try {
                    $date_range = explode(' - ', $request->date_range);

                    // Validasi dan parsing tanggal dengan menggunakan Carbon
                    $start_date = \Carbon\Carbon::createFromFormat('Y-m-d', $date_range[0])->startOfDay();
                    $end_date = \Carbon\Carbon::createFromFormat('Y-m-d', $date_range[1])->endOfDay();

                    // Filter data berdasarkan rentang tanggal yang diberikan
                    $data->whereBetween('created_at', [$start_date, $end_date]);
                } catch (\Exception $e) {
                    return redirect()->back()->with('error', 'Format rentang tanggal tidak valid.');
                }
            }

            // Mengatur urutan data berdasarkan parameter
            if ($sort == 'desc') {
                // Urutkan berdasarkan tanggal terbaru (created_at descending)
                $data = $data->orderByDesc('created_at');
            }

            // Ambil data dengan pagination setelah semua filter diterapkan
            $items = $data->paginate(10)->appends($request->query());

            // Return view dengan data barang
            if ($sort == 'desc') {
                return view('list_in_new', compact('items'));
            } else {
                return view('list_item', compact('items'));
            }
        }

        // Redirect jika bukan admin atau staff
        return redirect('index')->with("fail", "Hanya Admin yang dapat melihat daftar barang.");
    }


    public function add_item(){
        $user_type = Session::get('session_user_type');
        if ($user_type == 'admin') {
            $items = Category::all();
            $suppliers = Supplier::all();
            return view('add_item', compact('items', 'suppliers'));
        }
        return redirect('index')->with("fail", "Hanya Admin yang dapat menambahkan barang.");
    }


    public function add_item_post(Request $request)
{
    $user_type = Session::get('session_user_type');

    if ($user_type == 'admin') {
        try {
            // Validasi input
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'supplier_name' => 'required|string|max:255',  // Nama supplier
                'supplier_id' => 'nullable|exists:suppliers,id',  // ID supplier
                'quantity' => 'required|numeric|min:1',
                'unit' => 'required|string',
                'description' => 'nullable|string|max:500',
                'expiry_date' => 'required|date_format:Y-m-d',
                'entry_date' => 'required|date_format:Y-m-d',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'purchase_price' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            ]);


            // Cari supplier berdasarkan supplier_name
            $supplier = Supplier::where('name', $validated['supplier_name'])->first();

            // Jika supplier tidak ditemukan, kita buat supplier baru
            if (!$supplier) {
                $supplier = Supplier::create([
                    'name' => $validated['supplier_name'],
                    'contact' => null,
                    'address' => null,
                    'email' => null,
                ]);
            }

            // Pastikan supplier_id yang benar diteruskan
            $validated['supplier_id'] = $supplier->id;  // Assign the correct supplier_id

            // Menyimpan SKU secara acak
            $validated['sku'] = strtoupper(Str::random(10));

            // Menangani upload gambar
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image_name = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/item'), $image_name);
                $validated['image'] = asset('uploads/item/' . $image_name);
            }

            // Pastikan format tanggal valid dan disimpan dengan benar
            $validated['entry_date'] = \Carbon\Carbon::parse($validated['entry_date'])->format('Y-m-d');
            $validated['expiry_date'] = \Carbon\Carbon::parse($validated['expiry_date'])->format('Y-m-d');

            $validated['purchase_price'] = floatval($validated['purchase_price']);


            // Menyimpan data barang
            Inventory::create([
                'sku' => $validated['sku'],
                'name' => $validated['name'],
                'category_id' => $validated['category_id'],
                'supplier_id' => $validated['supplier_id'],  // Menggunakan supplier_id
                'quantity' => $validated['quantity'],
                'unit' => $validated['unit'],
                'description' => $validated['description'],
                'price' => $validated['purchase_price'],
                'image' => $validated['image'],
                'entry_date' => $validated['entry_date'],
                'expiry_date' => $validated['expiry_date'],
                'status' => 'active',
            ]);

            return redirect('list_item')->with('success', 'Barang berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan barang: ' . $e->getMessage());
        }
    }

    return redirect('index')->with("fail", "Hanya Admin yang dapat menambahkan barang.");
}


public function delete_item($id){
    $user_type = Session::get('session_user_type');
    if ($user_type == 'admin') {
        $item = Inventory::find($id);
        $item->delete();
        return redirect('list_item')->with('success', 'Barang berhasil dihapus.');
    }
    return redirect('index')->with("fail", "Hanya Admin yang dapat menghapus barang.");
}


public function list_item_out(Request $request, $sort = 'default')
{
    $user_type = Session::get('session_user_type');

    // Periksa apakah user adalah admin atau staff
    if ($user_type === 'admin') {
        // Inisialisasi query untuk mengambil data barang keluar
        $data = InventoryOuts::query();

        // Filter berdasarkan tanggal jika ada input date_range
        if ($request->filled('date_range')) {
            try {
                $date_range = explode(' - ', $request->date_range);

                // Validasi dan parsing tanggal dengan menggunakan Carbon
                $start_date = \Carbon\Carbon::createFromFormat('Y-m-d', $date_range[0])->startOfDay();
                $end_date = \Carbon\Carbon::createFromFormat('Y-m-d', $date_range[1])->endOfDay();

                // Filter data berdasarkan rentang tanggal yang diberikan
                $data->whereBetween('transaction_date', [$start_date, $end_date]);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Format rentang tanggal tidak valid.');
            }
        }

        // Mengatur urutan data berdasarkan parameter
        if ($sort == 'desc') {
            // Urutkan berdasarkan tanggal terbaru (transaction_date descending)
            $data = $data->orderByDesc('transaction_date');
        }

        // Ambil data dengan pagination setelah semua filter diterapkan
        $inventoryOuts = $data->paginate(10)->appends($request->query());

        // Return view dengan data barang keluar
        return view('list_item_out', compact('inventoryOuts'));
    }

    // Redirect jika bukan admin atau staff
    return redirect('index')->with("fail", "Hanya Admin yang dapat melihat daftar barang keluar.");
}


private function generateReport($viewName, $filePrefix, $dataQuery, $type) {
    $startDate = date('Y-m-d', strtotime('-7 days'));
    $endDate = date('Y-m-d');

    try {
        // Jalankan query untuk mengambil data
        $data = $dataQuery->get();

        // Hitung total quantity
        $totalQuantity = $data->sum('quantity');

        // Buat laporan PDF
        $pdf = PDF::LoadView($viewName, compact('data', 'startDate', 'endDate', 'totalQuantity', 'type'));

        // Unduh laporan PDF dengan nama file yang unik
        $filename = $filePrefix . '_' . date('Ymd_His') . '.pdf';
        return $pdf->download($filename);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Terjadi kesalahan saat memproses laporan: ' . $e->getMessage()], 500);
    }
}

public function reportinventory_In() {
    $dataQuery = Inventory::whereBetween('entry_date', [now()->subDays(7), now()]);
    return $this->generateReport('layouts.reportinventory', 'reportinventory_in', $dataQuery, 'Barang Masuk');
}

public function reportinventory_Out() {
    $dataQuery = InventoryOuts::whereBetween('date_out', [now()->subDays(7), now()]);
    return $this->generateReport('layouts.reportinventory', 'reportinventory_out', $dataQuery, 'Barang Keluar');
}







}
