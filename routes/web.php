<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BoMController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ProcessController;
use App\Http\Controllers\PhaseController;
use App\Http\Controllers\ProductByPhaseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view("home.index");
});
// BoM
Route::get('/bill-of-materials', [BoMController::class, 'getBoMs'])->name('getBoMs');                           // getBoMs
Route::get('/bill-of-material/{id}', [BoMController::class, 'getBoM'])->name('getBoM')->name('bom-process');                         // getBoM
Route::get('/bom/{id}/remove', [BoMController::class, 'removeBoM'])->name('removeBoM');
Route::get('/bom/{productByPhaseID}/{materialByPhaseID}/delete', [BoMController::class, 'deleteBoMChild']);  // delete BoM
Route::get('/print-BoM/{id}', [BoMController::class, 'printBoM']); // get print
Route::get('/bom-edit/modal/{productID}/{materialID}', [BoMController::class, 'showModalEdit']);
Route::patch('/bom-edit-submit', [BoMController::class, 'editBoM'])->name('bom-edit-submit');
Route::get('/bom/modal/{id}', [BoMController::class, 'showModalAdd']);
Route::post('/bom-add-submit', [BoMController::class, 'addBoM'])->name('bom-add-submit');      // post - add 1 BoM

// category
Route::get('/categories', [CategoryController::class, 'getCategories'])->name('getCategories');                        // getCategories
Route::get('/category/{id}', [CategoryController::class, 'getCategory'])->name('getCategory');                         // get Category
Route::get('/category/{id}/delete', [CategoryController::class, 'deleteCategory'])->name('deleteCategory');            // delete Category
Route::patch('/category/{id}/edit-submit', [CategoryController::class, 'editCategory'])->name('category-edit-submit'); // post - edit 1 Category
Route::post('/category-add-submit', [CategoryController::class, 'addCategory'])->name('category-add-submit');        // post - add 1 Category

//group
Route::get('/groups', [GroupController::class, 'getGroups'])->name('getGroups');                                // getGroups
Route::get('/group/{id}', [GroupController::class, 'getGroup'])->name('getGroup');                              // get Group
Route::get('/group/{id}/delete', [GroupController::class, 'deleteGroup'])->name('deleteGroup');                 // delete Group
Route::patch('/group/{id}/edit-submit', [GroupController::class, 'editGroup'])->name('group-edit-submit');  // post - edit 1 Group
Route::post('/group-add-submit', [GroupController::class, 'addGroup'])->name('group-add-submit');         // post - add 1 Group

// phase
Route::get('/phases', [PhaseController::class, 'getPhases'])->name('getPhases');                                    // Phase
Route::get('/phase/{id}', [PhaseController::class, 'getPhase'])->name('getPhase');                                  // get Group
Route::get('/phase/{id}/delete', [PhaseController::class, 'deletePhase'])->name('deletePhase');                     // delete Phase
Route::patch('/phase/{id}/edit-submit', [PhaseController::class, 'editPhase'])->name('phase-edit-submit');      // post - edit 1 Phase
Route::post('/phase-add-submit', [PhaseController::class, 'addPhase'])->name('phase-add-submit');             // post - add 1 Phase


// product
Route::get('/load-more-products',  [ProductController::class, 'loadMoreProducts']);
Route::get('/products', [ProductController::class, 'getProducts'])->name('getProducts'); // get products
Route::get('/product/{id}', [ProductController::class, 'getProduct'])->name('getProduct');                                  // get product
Route::get('/product/{id}/delete', [ProductController::class, 'deleteProduct'])->name('deleteProduct');                     // delete product
Route::patch('/product/{id}/edit-submit', [ProductController::class, 'editProduct'])->name('product-edit-submit');      // post - edit 1 product
Route::post('/product-add-submit', [ProductController::class, 'addProduct'])->name('product-add-submit');             // post - add 1 product
Route::get('/product/modal/{id}', [ProductController::class, 'showModal']);
Route::get('/search-products', [ProductController::class, 'searchProducts']);
Route::get('/initial-load-products',  [ProductController::class, 'initialLoadProducts']);

//type
Route::get('/types', [TypeController::class, 'getTypes'])->name('getTypes'); // get Types
Route::get('/type/{id}', [TypeController::class, 'getType'])->name('getType');                                  // get type
Route::get('/type/{id}/delete', [TypeController::class, 'deleteType'])->name('deleteType');                     // delete type
Route::patch('/type/{id}/edit-submit', [TypeController::class, 'editType'])->name('type-edit-submit');      // post - edit 1 type
Route::post('/type-add-submit', [TypeController::class, 'addType'])->name('type-add-submit');             // post - add 1 type

// warehouse
Route::get('/warehouses', [WarehouseController::class, 'getWarehouses'])->name('getWarehouses'); // getWarehouses
Route::get('/warehouse/{id}', [WarehouseController::class, 'getWarehouse'])->name('getWarehouse');                                  // get type
Route::get('/warehouse/{id}/delete', [WarehouseController::class, 'deleteWarehouse'])->name('deleteWarehouse');                     // delete type
Route::patch('/warehouse/{id}/edit-submit', [WarehouseController::class, 'editWarehouse'])->name('warehouse-edit-submit');      // post - edit 1 type
Route::post('/warehouse-add-submit', [WarehouseController::class, 'addWarehouse'])->name('warehouse-add-submit');             // post - add 1 type

// process
Route::get('/processes', [ProcessController::class, 'getProcesses'])->name('getProcesses'); // getProcesses
Route::get('/process/{id}', [ProcessController::class, 'getProcess'])->name('getProcess');                                  // get type
Route::get('/process/{id}/delete', [ProcessController::class, 'deleteProcess'])->name('deleteProcess');                     // delete type
Route::patch('/process/{id}/edit-submit', [ProcessController::class, 'editProcess'])->name('process-edit-submit');      // post - edit 1 type
Route::post('/process-add-submit', [ProcessController::class, 'addProcess'])->name('process-add-submit');             // post - add 1 type
