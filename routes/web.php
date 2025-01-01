<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('register');
// });

Route::get('/', [UserController::class, 'index']);
Route::get('/index', [UserController::class, 'index']);
Route::get('/login', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class, 'login_post']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/emp_registration', [UserController::class, 'emp_registration']);
Route::post('/emp_registration', [UserController::class, 'emp_registration_post']);
Route::get('/emp_list', [UserController::class, 'emp_list']);
Route::get('/emp_edit/{id}', [UserController::class, 'emp_edit']);
Route::put('/emp_edit_post/{id}', [UserController::class, 'emp_edit_post'])->name('emp_edit_post');
Route::delete('/emp_delete/{id}', [UserController::class, 'emp_delete']);
Route::get('/emp_detail/{id}', [UserController::class, 'emp_detail']);


Route::get('/category', [CategoryController::class, 'category']);
Route::get('/category_add', [CategoryController::class, 'category_add']);
Route::post('/category', [CategoryController::class, 'category_post']);
Route::get('/category_list', [CategoryController::class, 'category_list']);
Route::get('/category_edit/{id}', [CategoryController::class, 'category_edit']);
Route::put('/edit_category/{id}', [CategoryController::class, 'category_edit_post'])->name('edit_category');
Route::delete('/category_delete/{id}', [CategoryController::class, 'category_delete']);



Route::get('/add_item', [InventoryController::class, 'add_item']);
Route::post('/add_item_entry', [InventoryController::class, 'add_item_post']);
Route::get('/list_item', [InventoryController::class, 'list_barang']);
Route::get('/list_stock_in', [InventoryController::class, 'list_barang'])->defaults('sort','desc');
Route::get('/list_item_status', [InventoryController::class, 'list_item_status']);
Route::get('/list_item_out', [InventoryController::class, 'list_item_out']);
Route::get('/item_out_add', [InventoryOutsController::class, 'add_item_out']);
Route::post('/inventory_out', [InventoryOutsController::class, 'inventory_outs']);
Route::get('/list_item_status_change/{id}/{item_status}', [InventoryController::class, 'list_item_status_change']);
Route::post('/get_item', [InventoryController::class, 'get_item']);
Route::post('/edit_item', [InventoryController::class, 'edit_item']);
Route::delete('/inventory_delete/{id}', [InventoryController::class, 'delete_item']);
Route::get('/export_inventory_in', [InventoryController::class, 'reportinventory_In']);
Route::get('/export_inventory_out', [InventoryController::class, 'reportinventory_Out']);
Route::get('/edit_item/{id}', [InventoryController::class, 'edit_item']);
Route::put('/edit_item_post/{id}', [InventoryController::class, 'edit_item_post'])->name('edit_item_post');
Route::get('/item_detail/{id}', [InventoryController::class, 'detail_item']);

Route::get('/stock_updates', [InventoryController::class, 'sendStockUpdates']);

Route::get('/stock_opname', [StockOpnameController::class, 'index']);


Route::get('/add_supplier', [SupplierController::class, 'add_suplier']);
Route::post('/add_suplier_post', [SupplierController::class, 'store']);
Route::get('/supp_list', [SupplierController::class, 'index']);
Route::delete('/supp_delete/{id}', [SupplierController::class, 'delete']);


Route::get('/export', [InventoryController::class, 'exportInventory']);
Route::get('/import', [InventoryController::class, 'importInventory']);
Route::post('/import', [InventoryController::class, 'importInventoryPost']);
Route::get('/download_pdf', [InventoryController::class, 'downloadPDF']);



