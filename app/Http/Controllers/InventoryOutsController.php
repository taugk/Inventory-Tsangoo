<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Inventory;
use App\Models\StockOpname;
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

        if ($user_type == 'admin'|| $user_type == 'staff') {
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

    if ($user_type == 'admin'|| $user_type == 'staff') {
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

            // Update the inventory quantity (subtracting the quantity being taken out)
            $inventory->quantity -= $quantities[$key];
            $inventory->save();

           // Log the inventory update
            Log::create( [
                'level' => 'info',
                'message' => "Barang keluar: {$inventory->name}, Jumlah: {$quantities[$key]}",
                'context' => json_encode([
                    'user_id' => Session::get('session_user_id'),
                    'user_type' => Session::get('session_user_type'),
                    'user_name' => Session::get('session_name'),
                    'item_id' => $inventory->id,
                    'quantity' => $quantities[$key],
                ]),
                'action' => 'add_item',
            ]);


            // Update item status based on remaining stock
            if ($inventory->quantity == 0) {
                $inventory->status = 'not available';
            } elseif ($inventory->quantity <= 3) {
                $inventory->status = 'low stock';
            } else {
                $inventory->status = 'available';
            }

            $inventory->save(); // Save the item after updating the status

            // Check if StockOpname already exists for this inventory item
            $stockOpname = StockOpname::where('inventory_id', $item_id)->first();

            if ($stockOpname) {
                // If StockOpname exists, only update the actual_stock (decrease it by the quantity taken out)
                $stockOpname->actual_stock -= $quantities[$key];
                $stockOpname->difference = $stockOpname->system_stock - $stockOpname->actual_stock;
                $stockOpname->save();
            } else {
                // If StockOpname doesn't exist, create a new one
                $stockOpname = new StockOpname();
                $stockOpname->inventory_id = $item_id;
                $stockOpname->system_stock = $inventory->quantity + $quantities[$key]; // Set initial system stock (before reduction)
                $stockOpname->actual_stock = $stockOpname->system_stock - $quantities[$key]; // Subtract the quantity from system stock to get actual stock
                $stockOpname->difference = $stockOpname->system_stock - $stockOpname->actual_stock;
                $stockOpname->save();
            }
        }

        return redirect('list_item_out')->with("success", "Data berhasil disimpan!");
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
