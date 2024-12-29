<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Models\InventoryOuts;
use Illuminate\Support\Facades\Session;

class InventoryOutsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function add_item_out(Request $request)
    {
        $user_type = Session::get('session_user_type');

        if ($user_type == 'admin') {
            // Fetch items with quantity > 0
            $items = Inventory::where('quantity', '>', 0)->orderBy('created_at', 'desc')->get();

            // If there is a quantity request
            if ($request->has('quantity')) {
                $quantities = $request->input('quantity');
                $itemIds = $request->input('item_id');

                // Loop through items and check stock
                foreach ($itemIds as $index => $item_id) {
                    $item = Inventory::find($item_id);
                    if ($item && $item->quantity < $quantities[$index]) {
                        // Return failure message if stock is insufficient
                        return redirect()->back()->with('fail', 'Stock for ' . $item->name . ' is insufficient. Available: ' . $item->quantity);
                    }
                }
            }

            return view('add_item_out', compact('items'));
        } else {
            return redirect('index')->with("fail", "Hanya Admin yang dapat mengakses halaman ini.");
        }
    }

    /**
     * Process the inventory out request.
     */
    public function inventory_outs(Request $request)
    {
        $user_type = Session::get('session_user_type');

        if ($user_type == 'admin') {
            // Validate input
            $request->validate([
                'item_id.*' => 'required|exists:Inventory,id',   // Ensure item exists in Inventory
                'quantity.*' => 'required|integer|min:1',        // Ensure quantity is a positive integer
                'unit.*' => 'required',                          // Ensure unit is provided
                'date.*' => 'required|date',                     // Ensure date is a valid date
            ], [
                'item_id.*.required' => 'Item is required',
                'quantity.*.required' => 'Quantity is required',
                'unit.*.required' => 'Unit is required',
                'date.*.required' => 'Date is required',
            ]);

            // Loop through each item and check stock
            $items = $request->input('item_id');
            $quantities = $request->input('quantity');

            foreach ($items as $key => $item_id) {
                // Get the item from the database
                $inventory = Inventory::find($item_id);

                if ($inventory) {
                    // Check if the requested quantity is greater than the available stock
                    if ($quantities[$key] > $inventory->quantity) {
                        return redirect()->back()->with('fail', 'Stock for ' . $inventory->name . ' is insufficient. Available: ' . $inventory->quantity);
                    }
                } else {
                    return redirect()->back()->with('fail', 'Item not found in the inventory.');
                }
            }


            // Proceed with processing the inventory out
            foreach ($items as $key => $item_id) {
                $inventory = Inventory::find($item_id);

                // Create the InventoryOut record
                $inventoryOut = new InventoryOuts();
                $inventoryOut->inventory_id = $item_id;
                $inventoryOut->quantity = $quantities[$key];
                $inventoryOut->date_out = $request->input('date')[$key];
                $inventoryOut->user_id = Session::get('session_id');
                $inventoryOut->supplier_id = $inventory->supplier_id;
                $inventoryOut->save();

                // Update the inventory quantity
                $inventory->quantity -= $quantities[$key];
                $inventory->save();
            }

            return redirect('inventory_outs')->with("success", "Data berhasil disimpan!");
        } else {
            return redirect('index')->with("fail", "Hanya Admin yang dapat mengakses halaman ini.");
        }
    }





    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(InventoryOuts $inventoryOuts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InventoryOuts $inventoryOuts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InventoryOuts $inventoryOuts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InventoryOuts $inventoryOuts)
    {
        //
    }
}
