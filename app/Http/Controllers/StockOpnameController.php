<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\StockOpname;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class StockOpnameController extends Controller
{
    public function index(){
        $user_type = Session::get('session_user_type');
        if(!in_array($user_type, ['admin', 'staff', 'owner'])) {
            return redirect('index')->with("fail", "Hanya Admin yang dapat mengakses halaman ini.");
        }else{
            $stockOpnames = StockOpname::with('inventory')->paginate(10);

            return view('stock_opname', compact('stockOpnames'));
        }
    }

    public function store(Request $request){
        $user_type = Session::get('session_user_type');
        if(!in_array($user_type, ['admin', 'staff', 'owner'])) {
            return redirect('index')->with("fail", "Hanya Admin yang dapat mengakses halaman ini.");
        }
        $request->validate([
            'inventory_id' => 'required',
            'stock_opname' => 'required',
        ]);
        $stockOpname = new StockOpname();
        $stockOpname->inventory_id = $request->input('inventory_id');
        $stockOpname->system_stock = $request->input('stock_opname');
        $stockOpname->actual_stock = $request->input('stock_opname');
        $stockOpname->difference = $request->input('stock_opname');
        $stockOpname->notes = $request->input('notes');
        $stockOpname->save();
        return redirect()->back()->with('success', 'Stock Opname berhasil disimpan');
    }

}
