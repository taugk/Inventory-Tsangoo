<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
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
                }elseif ($user->role == 'owner') {
                    $user_type = 'owner';
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

    public function forgot_password(){
        return view('forgot_password');
    }


}
