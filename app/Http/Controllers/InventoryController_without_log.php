<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
// use PDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class InventoryController_without_log extends Controller
{
    public function add_item()
    {
        return view('add_item');
    }

    public function add_item_post(Request $request)
    {
        $request->validate([
            'item_name' => 'required',
            'item_hsn' => 'required',
            'item_unit' => 'required',
            'item_desc' => 'required',
            'item_mrp' => 'required',
            'item_purchase' => 'required',
            'item_sale' => 'required'
        ]);

        $user = DB::table('item')->insert([
            'item_name' => $request->item_name,
            'item_hsn' => $request->item_hsn,
            'item_unit' => $request->item_unit,
            'item_desc' => $request->item_desc,
            'item_mrp' => $request->item_mrp,
            'item_purchase' => $request->item_purchase,
            'item_sale' => $request->item_sale,
            'item_stock' => 0,
            'item_created_at' => Carbon::now(),
            'item_updated_at' => Carbon::now(),
            'item_status' => 1
        ]);

        if (!$user) {
            return redirect(url('add_item'))->with("error", "Item adding Failed,try again");
        }
        return redirect(url('list_item'))->with("success", "Item added successfully");
    }

    public function list_item()
    {
        $list_item = DB::table('item')->get();

        // Mengecek apakah data ada
        if ($list_item->isEmpty()) {
            return view('list_item', ['message' => 'No items found']);
        }

        return view('list_item', compact('list_item'));
    }



    public function get_item(Request $request)
    {
        $item['item'] = DB::table('item')
            ->where("id", $request->id)
            ->get()
            ->first();
        $purchase_item['item'] = DB::table('purchase_item')
            ->where("item_id", $request->id)
            ->get();
        $sale_item['item'] = DB::table('sale_item')
            ->where("item_id", $request->id)
            ->get();
        return response()->json([
            'item' => $item,
            'purchase_item' => $purchase_item,
            'sale_item' => $sale_item
        ]);
    }

    public function edit_item(Request $request)
    {
        $get_item_ajax['item'] = DB::table('item')
            ->where("id", $request->id)
            ->get()
            ->first();
        return response()->json($get_item_ajax);
    }

    public function edit_item_post(Request $request)
    {
        $request->validate([
            'item_name' => 'required',
            'item_hsn' => 'required',
            'item_unit' => 'required',
            'item_desc' => 'required',
            'item_mrp' => 'required',
            'item_purchase' => 'required',
            'item_sale' => 'required'
        ]);

        $edit = DB::table('item')->where('id', $request->item_id)
            ->update([
                'item_name' => $request->item_name,
                'item_hsn' => $request->item_hsn,
                'item_unit' => $request->item_unit,
                'item_desc' => $request->item_desc,
                'item_mrp' => $request->item_mrp,
                'item_purchase' => $request->item_purchase,
                'item_sale' => $request->item_sale,
                'item_stock' => $request->item_stock,
                'item_updated_at' => Carbon::now()
            ]);

        if (!$edit) {
            return redirect(url('list_item'))->with("error", "Item adding Failed,try again");
        }
        return redirect(url('list_item'))->with("success", "Item updated successfully");
    }

    public function exportInventory()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Add header row
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Item Name');
        $sheet->setCellValue('C1', 'Stock');
        $sheet->setCellValue('D1', 'HSN');
        $sheet->setCellValue('E1', 'MRP');
        $sheet->setCellValue('F1', 'PURCHASE');
        $sheet->setCellValue('G1', 'SALE');
        $sheet->setCellValue('H1', 'DESC');
        $sheet->setCellValue('I1', 'UNIT');
        // Add other columns as needed

        // Fetch data from the database
        $inventory = DB::table('item')->get();
        $row = 2; // Starting from the second row

        foreach ($inventory as $item) {
            $sheet->setCellValue('A' . $row, $item->id);
            $sheet->setCellValue('B' . $row, $item->item_name);
            $sheet->setCellValue('C' . $row, $item->item_stock);
            $sheet->setCellValue('D' . $row, $item->item_hsn);
            $sheet->setCellValue('E' . $row, $item->item_mrp);
            $sheet->setCellValue('F' . $row, $item->item_purchase);
            $sheet->setCellValue('G' . $row, $item->item_sale);
            $sheet->setCellValue('H' . $row, $item->item_desc);
            $sheet->setCellValue('I' . $row, $item->item_unit);
            // Add other columns as needed

            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'item.xlsx';

        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function importInventory()
    {
        return view('import');
    }

    public function importInventoryPost(Request $request)
    {
        $file = $request->file('excel_file');
        $spreadsheet = IOFactory::load($file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        foreach ($rows as $index => $row) {
            if ($index === 0) {
                continue; // Skip header row
            }

            // Process each row
            DB::table('item')->insert([
                'item_name' => $row[1],
                'item_stock' => $row[2],
                'item_hsn' => $row[3],
                'item_mrp' => $row[4],
                'item_purchase' => $row[5],
                'item_sale' => $row[6],
                'item_desc' => $row[7],
                'item_unit' => $row[8],
                'item_created_at' => Carbon::now(),
                'item_updated_at' => Carbon::now(),
                'item_status' => 1

                // Map other columns as needed
            ]);
        }

        return back()->with('success', 'Inventory imported successfully.');
    }

    public function downloadPDF()
    {
        $data = ['list_item' => DB::table('item')->get()];
        // Data to pass to the view
        // $data = [
        //     'title' => 'Stock Details',
        //     'date' => date('m/d/Y'),
        // ];

        // Load the view file and pass the data
        $pdf = PDF::loadView('example', $data);

        // Generate a filename with the current date and time
        $fileName = 'stock_details_' . date('Ymd_His') . '.pdf';

        // Download the PDF with the generated filename
        return $pdf->download($fileName);
    }



}
