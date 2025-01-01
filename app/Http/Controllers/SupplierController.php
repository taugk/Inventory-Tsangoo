<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $user_type = Session::get('session_user_type');

    if ($user_type == 'admin') {
        // Use the query builder and paginate directly
        $suppliers = Supplier::paginate(10);

        // Return the view with the suppliers list
        return view('list_supplier', compact('suppliers'));
    }

    // Redirect to the index page if the user is not an admin
    return redirect('index')->with('fail', 'Hanya Admin yang dapat mengakses halaman ini');
}


    /**
     * Show the form for creating a new resource.
     */
    public function add_supplier()
    {
        $user_type = Session::get('session_user_type');
        if ($user_type == 'admin') {
            return view('add_supplier');
        } else {
            return redirect('index')->with('fail', 'Hanya Admin yang dapat mengakses halaman ini');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_type = Session::get('session_user_type');
        if ($user_type == 'admin') {
            $rules=([
                'name' => 'required',
                'email' => 'required|email',
                'contact' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:12',
                'address' => 'required|min:5',
            ]);
            $messages = [
                'name.required' => 'Nama Supplier tidak boleh kosong',
                'email.required' => 'Email Supplier tidak boleh kosong',
                'contact.required' => 'Nomor Telepon Supplier tidak boleh kosong',
                'contact.regex' => 'Nomor Telepon Supplier harus berupa angka',
                'contact.min' => 'Nomor Telepon Supplier harus berjumlah 12 angka',
                'address.required' => 'Alamat Supplier tidak boleh kosong',
                'address.min' => 'Alamat Supplier harus berjumlah minimal 5 karakter',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $supplier = new Supplier();
            $supplier->name = $request->input('name');
            $supplier->email = $request->input('email');
            $supplier->contact = $request->input('contact');
            $supplier->address = $request->input('address');
            $supplier->save();

            return redirect('supplier')->with('success', 'Supplier berhasil ditambahkan');
        }
    }

    public function delete($id){
        $user_type = Session::get('session_user_type');
        if ($user_type == 'admin') {
            $supplier = Supplier::find($id);
            $supplier->delete();
            return redirect('supplier')->with('success', 'Supplier berhasil dihapus');
        }
        return redirect('index')->with('fail', 'Hanya Admin yang dapat mengakses halaman ini');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        //
    }
}
