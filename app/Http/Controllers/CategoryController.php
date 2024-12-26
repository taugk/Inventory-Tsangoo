<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{

    public function category(){
        $session = Session::get('session_user_type');
        if($session == 'admin'){
            $cat_list = Category::all();
            return view('category', compact('cat_list'));
        }
        else{
            return redirect('index')->with("fail", "Hanya Admin yang dapat melihat daftar kategori");
        }

    }

    public function category_edit($id){
       $session = Session::get('session_user_type');
       if($session == 'admin'){
        $cat_list = Category::all();
        $edit_data = Category::find($id);

        if(!$edit_data){
            return redirect()->back()->with('error', 'Category not found');
        }

        return view('category', compact('cat_list'));
    }
    else{
        return redirect('index')->with("fail", "Hanya Admin yang dapat mengedit kategori");
    }
}

    public function category_edit_post(Request $request, $id){
        $session = Session::get('session_user_type');
        if($session == 'admin'){
            $validate = $request->validate([
                'name' => 'required',

            ]);
            $edit_data = Category::find($id);
            if($edit_data){
                $edit_data->name = $request->name;
                $edit_data->save();
                return redirect()->back()->with('success', 'Kategori berhasil diubah');
            }else{
                return redirect()->back()->with('error', 'Kategori tidak ditemukan');
            }
        }
        else{
            return redirect('index')->with("fail", "Hanya Admin yang dapat mengedit kategori");
            }
    }

    public function category_add(){
        $session = Session::get('session_user_type');
        if($session == 'admin'){
        return view('add_category');
        }
        else{
            return redirect('index')->with("fail", "Hanya Admin yang dapat menambah kategori");
        }
    }

    public function category_post(Request $request){
        $session = Session::get('session_user_type');
        if($session == 'admin'){
             // Validasi input
    $rules = [
        'name' => 'required|unique:categories,name|max:255',
    ];

    $messages = [
        'name.required' => 'Nama kategori tidak boleh kosong.',
        'name.unique' => 'Nama kategori sudah ada. Silakan masukkan nama lain.',
        'name.max' => 'Nama kategori tidak boleh lebih dari 255 karakter.',
    ];

    $validatedData = $request->validate($rules, $messages);



    // Menambahkan kategori ke database
    $cat = Category::create([
        'name' => $validatedData['name'],
    ]);



    // Memeriksa apakah penyimpanan berhasil
    if ($cat) {
        return redirect('category')->with('success', 'Kategori berhasil ditambahkan.');
    } else {
        return redirect('add_category')->with('error', 'Kategori gagal ditambahkan. Silakan coba lagi.');
    }
}
else{
    return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk menambah kategori');
}

}

}
