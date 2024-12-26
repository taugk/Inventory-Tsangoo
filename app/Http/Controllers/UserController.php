<?php

namespace App\Http\Controllers;

use App\Models\cr;
use App\Models\Logs;
use App\Models\User;
use App\Models\Supplier;
use App\Models\Inventory;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Symfony\Component\VarDumper\VarDumper;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Membuat session
        if(session()->has('session_id')) {
            $sum_qty = Inventory::selectRaw('SUM(quantity) as total_qty')
            ->value('total_qty');

            $supplier_count = Supplier::count();

            $total_amount = Transactions::selectRaw('SUM(price*quantity) as total_amount')
            ->value('total_amount');

            $logs = Logs::get();

            $low_stock_items = Inventory::where('quantity', '<', 10)
            ->orderBy('quantity', 'asc')
            ->get();

            return view('index', compact('sum_qty', 'total_amount', 'supplier_count', 'logs', 'low_stock_items'));
        }
        else {
            return redirect('login');
        }

    }

    public function login(){
        $data = User::all();
        if(count ($data)>0) {
            return view('login', compact('data'));
        }
        else {
            return view('login');
        }
    }

    function logout(){
        if(session()->has('session_id')) {
            session()->pull('session_id');
            Session::flush();
            return redirect('login');
        }
    }

    public function login_post(Request $request)
    {

        // Validate the incoming request data
        $request->validate([
            'email' => 'required',
            'pwd' => 'required',
        ]);





        // Check if the user exists in the database
        $user = User::where('email', $request->email)->first();

        // If user exists, check if the password matches
        if($user) {
            if (Hash::check($request->pwd, $user->password)) {

                $user_type = '';
                if ($user->role == 'admin') {
                    $user_type = 'admin';
                } elseif ($user->role == 'staff') {
                    $user_type = 'staff';
                }

                // Menyimpan session
                $sess_array = [
                    'session_id' => $user->id,
                    'session_name' => $user->name,
                    'session_email' => $user->email,
                    'session_user_type' => $user_type,  // Menyimpan tipe pengguna berdasarkan status
                    'loggedin' => 'UserLoggedIn'
                ];
                $request->session()->put($sess_array);

                return redirect('index')->with('success', 'Login berhasil!');
            } else {
                return back()->with('fail', 'Password salah!');
            }
        } else {
            return back()->with('fail', 'Email tidak ditemukan!');
        }
    }

    public function emp_registration(){
        $user_type = Session::get('session_user_type');
        if($user_type == 'admin'){
            return view('registration');
        }
        else{
            return redirect('index')->with("fail", "Hanya Admin yang dapat menambah karyawan");
        }
    }

    public function emp_registration_post(Request $request){
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'role' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);
    }

    public function emp_list(){
        $user_type = Session::get('session_user_type');
        if($user_type == 'admin'){
            $emp_list = User::all();
            return view('emp_list', compact('emp_list'));
        }
        else{
            return redirect('index')->with("fail", "Hanya Admin yang dapat melihat daftar karyawan");
        }
    }

    public function emp_edit($id){
        $user_type = Session::get('session_user_type');
        if($user_type == 'admin'){
            $data = User::find($id);
            return view('emp_edit', compact('data'));
        }
        else{
            return redirect('index')->with("fail", "Hanya Admin yang dapat mengedit karyawan");
        }
    }

    public function emp_edit_post(Request $request, $id){
        $user_type = Session::get('session_user_type');
        if($user_type == 'admin'){
            $rules = [
                'name' => 'required',
                'username' => 'required',
                'role' => 'required',
            ];

                $messages = [
                    'name.required' => 'Nama harus diisi',
                    'username.required' => 'Username harus diisi',
                    'role.required' => 'Role harus diisi',
                ];

                $validated = $request->validate($rules, $messages);
                $user = User::find($id);
                if($user){
                    $user ->update($validated);
                    return redirect('emp_list')->with("success", "Data berhasil diubah");

                }
                else{
                    return redirect('emp_list')->with("fail", "Data tidak ditemukan");
                }
        }
        else{
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

    public function detail($id){
        $user_type = Session::get('session_user_type');
        if($user_type == 'admin'){
            $data = User::find($id);
            return view('detail', compact('data'));
        }
        else{
            return redirect('index')->with("fail", "Hanya Admin yang dapat melihat detail karyawan");
        }
    }
}
