<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\BoMController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ProcessController;
use App\Http\Controllers\PhaseController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\PartnerController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Session;

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

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () { //...


        Route::get('/setlocale/{locale}', function ($locale) {
            // Define a default array of supported locales
            $defaultSupportedLocales = ['en', 'vi'];
            $supportedLocales = config('app.locales') ?: $defaultSupportedLocales;
            if (in_array($locale, $supportedLocales)) {
                Session::put('locale', $locale);
            }

            // Redirect back to the previous route with the selected language
            return redirect()->back();
        })->name('changeLanguage');
        Route::get('/', function () {
            return view("home.index");
        });
        // BoM                          // getBoMs
        Route::get('/bill-of-material/{id}', [BoMController::class, 'getBoM'])->name('getBoM')->name('bom-process');                         // getBoM
        Route::get('/bom/{id}/remove', [BoMController::class, 'removeBoM'])->name('removeBoM');
        Route::get('/bom/{productByPhaseID}/{materialByPhaseID}/delete/{productIDParrent}', [BoMController::class, 'deleteBoMChild']);  // delete BoM
        Route::get('/print-BoM/{id}', [BoMController::class, 'printBoM']); // get print
        Route::get('/bom-edit/modal/{productID}/{materialID}', [BoMController::class, 'showModalEdit']);
        Route::patch('/bom-edit-submit', [BoMController::class, 'editBoM'])->name('bom-edit-submit');
        Route::get('/bom/modal/{id}', [BoMController::class, 'showModalAdd']);
        Route::get('/bom/modal-copy/{id}', [BoMController::class, 'showModalCopy']);
        Route::get('/bom/modal-copy/checkReplaceBoM', [BoMController::class, 'checkReplaceBoM']);

        Route::post('/bom-add-submit', [BoMController::class, 'addBoM'])->name('bom-add-submit');      // post - add 1 BoM
        Route::post('/bom-copy-submit', [BoMController::class, 'copyBoM'])->name('bom-copy-submit');      // post - add 1 BoM

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
        Route::post('/product-insert-byPhase', [ProductController::class, 'insertProductsByPhase'])->name('product-insert-byPhase');      // post - add multiple Products
        Route::get('/product-byPhase/remove', [ProductController::class, 'removeProductsByPhase'])->name('product-remove-byPhase');                     // delete product
        // product details
        Route::get('/load-more-product-details',  [ProductDetailController::class, 'loadMoreProductDetails']);
        Route::get('/product-details', [ProductDetailController::class, 'getProductDetails'])->name('getProductDetails'); // get product-details
        Route::get('/product-details/{id}', [ProductDetailController::class, 'getProduct'])->name('getProductDetails');                                  // get product
        Route::get('/product-details/{id}/delete', [ProductDetailController::class, 'deleteProduct'])->name('deleteProductDetails');                     // delete product
        Route::patch('/product-details/{id}/edit-submit', [ProductDetailController::class, 'editProduct'])->name('product-details-edit-submit');      // post - edit 1 product
        Route::post('/product-details-add-submit', [ProductDetailController::class, 'addProduct'])->name('product-details-add-submit');             // post - add 1 product
        Route::get('/product-details/modal-edit/{id}', [ProductDetailController::class, 'showEditModal']);
        Route::get('/showmodal-product-details', [ProductDetailController::class, 'showAddModal']);
        Route::get('/search-product-details', [ProductDetailController::class, 'searchProductDetails']);
        Route::get('/initial-load-product-details',  [ProductDetailController::class, 'initialLoadProductDetails']);
        Route::post('/product-details-insert', [ProductDetailController::class, 'insertProductDetails'])->name('product-details-insert');      // post - add multiple ProductDetails
        Route::get('/product-details/remove', [ProductDetailController::class, 'removeProductDetails'])->name('product-details-remove');                     // delete product

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

        //import-export
        Route::get('/import-export', [WarehouseController::class, 'getIportExportList'])->name('getIportExportList'); // getIportExportList

        // process
        Route::get('/processes', [ProcessController::class, 'getProcesses'])->name('getProcesses'); // getProcesses
        Route::get('/process/{id}', [ProcessController::class, 'getProcess'])->name('getProcess');                                  // get type
        Route::get('/process/{id}/delete', [ProcessController::class, 'deleteProcess'])->name('deleteProcess');                     // delete type
        Route::patch('/process/{id}/edit-submit', [ProcessController::class, 'editProcess'])->name('process-edit-submit');      // post - edit 1 type
        Route::post('/process-add-submit', [ProcessController::class, 'addProcess'])->name('process-add-submit');             // post - add 1 type



        // partner
        Route::get('/load-more-partners',  [PartnerController::class, 'loadMorePartners']);
        Route::get('/partners', [PartnerController::class, 'getPartners'])->name('getPartners'); // get partners
        Route::get('/partner/{id}/delete', [PartnerController::class, 'deletePartner'])->name('deletePartner');                     // delete partner
        Route::patch('/partner/{id}/edit-submit', [PartnerController::class, 'editPartner'])->name('partner-edit-submit');      // post - edit 1 partner
        Route::post('/partner-add-submit', [PartnerController::class, 'addPartner'])->name('partner-add-submit');             // post - add 1 partner
        Route::get('/partner/modal/{id}', [PartnerController::class, 'showModal']);
        Route::get('/search-partners', [PartnerController::class, 'searchPartners']);
        Route::get('/initial-load-partners',  [PartnerController::class, 'initialLoadPartners']);
        Route::post('/partner-insert-byPhase', [PartnerController::class, 'insertPartnersByPhase'])->name('partner-insert-byPhase');      // post - add multiple Partners
        Route::get('/partner-byPhase/remove', [PartnerController::class, 'removePartnersByPhase'])->name('partner-remove-byPhase');

        // partner - detail
        Route::get('/partner/{id}', [PartnerController::class, 'getPartner'])->name('getPartner');                                  // get partner
        Route::get('/partner/jsoninfo/{id}',  [PartnerController::class, 'jsonPartnerInfo']);
        Route::get('/partner/jsonquotation/{phaseID}/{partnerID}',  [PartnerController::class, 'jsonPartnerQuotation']);
        Route::get('/partner/jsonpo/{phaseID}/{partnerID}',  [PartnerController::class, 'jsonPartnerPO']);
        Route::get('/partner/jsonproduct/{phaseID}/{partnerID}',  [PartnerController::class, 'jsonPartnerProdutBuy']);

        // delete partner

        // quotation
        Route::get('/load-more-quotations',  [QuotationController::class, 'loadMoreQuotations']);
        Route::get('/quotations', [QuotationController::class, 'getQuotations'])->name('getQuotations'); // get quotations
        Route::get('/quotation/{id}', [QuotationController::class, 'getQuotation'])->name('getQuotation');                                  // get quotation
        Route::get('/quotation/{id}/delete', [QuotationController::class, 'deleteQuotation']);                  // delete quotation
        Route::patch('/quotation/{id}/edit-submit', [QuotationController::class, 'editQuotation'])->name('quotation-edit-submit');      // post - edit 1 quotation
        Route::post('/quotation-add-submit', [QuotationController::class, 'addQuotation'])->name('quotation-add-submit');             // post - add 1 quotation
        Route::get('/quotation/modal-eit/{id}', [QuotationController::class, 'showModal']);
        Route::get('/search-quotations', [QuotationController::class, 'searchQuotations']);
        Route::get('/initial-load-quotations',  [QuotationController::class, 'initialLoadQuotations']);                    // delete quotation
        Route::get('/quotation/info-modal/{id}', [QuotationController::class, 'showInfoModal']);
        Route::get('/showmodal/quotation-add', [QuotationController::class, 'showAddModal']);
        Route::get('/compare-prices', [QuotationController::class, 'getComparePrices'])->name('getComparePrices'); // get quotations
        Route::get('/load-compare-prices',  [QuotationController::class, 'loadComparePrices']);
        Route::get('/load-droplist-view',  [QuotationController::class, 'jsonComparePrices']);
        Route::get('/quotation/approve/{id}', [QuotationController::class, 'approvePO']);


        // purchase-order
        Route::get('/load-more-purchase-orders',  [PurchaseOrderController::class, 'loadMorePurchaseOrders']);
        Route::get('/purchase-orders', [PurchaseOrderController::class, 'getPurchaseOrders'])->name('getPurchaseOrders'); // get purchase-orders
        Route::get('/purchase-order/{id}', [PurchaseOrderController::class, 'getPurchaseOrder'])->name('getPurchaseOrder');                                  // get purchase-order
        Route::get('/purchase-order/{id}/delete', [PurchaseOrderController::class, 'deletePurchaseOrder'])->name('deletePurchaseOrder');                     // delete purchase-order
        Route::patch('/purchase-order/{id}/edit-submit', [PurchaseOrderController::class, 'editPurchaseOrder'])->name('purchase-order-edit-submit');      // post - edit 1 purchase-order
        Route::post('/purchase-order-add-submit', [PurchaseOrderController::class, 'addPurchaseOrder'])->name('purchase-order-add-submit');             // post - add 1 purchase-order
        Route::get('/purchase-order/modal-eit/{id}', [PurchaseOrderController::class, 'showModal']);
        Route::get('/search-purchase-orders', [PurchaseOrderController::class, 'searchPurchaseOrders']);
        Route::get('/initial-load-purchase-orders',  [PurchaseOrderController::class, 'initialLoadPurchaseOrders']);
        Route::post('/purchase-order-insert-byPhase', [PurchaseOrderController::class, 'insertPurchaseOrdersByPhase'])->name('purchase-order-insert-byPhase');      // post - add multiple PurchaseOrders
        Route::get('/purchase-order-byPhase/remove', [PurchaseOrderController::class, 'removePurchaseOrdersByPhase'])->name('purchase-order-remove-byPhase');                     // delete purchase-order
        Route::get('/purchase-order/info-modal/{id}', [PurchaseOrderController::class, 'showInfoModal']);
        Route::get('/showmodal/purchase-order-add', [PurchaseOrderController::class, 'showAddModalAddPO']);
        Route::get('/purchase-order-add/get-info', [PurchaseOrderController::class, 'showAddModalAddPOGetInfo']);

        Route::get('/print-PO/{purchaseOrderId}', [PurchaseOrderController::class, 'printPO']);

        Route::get('/po-process/{purchaseOrderId}', [PurchaseOrderController::class, 'processPO']);
        Route::post('/po-process-add-submit/{materialID}', [PurchaseOrderController::class, 'addPOProcess'])->name('po-process-add-submit');
        Route::get('/po-process/{id}/delete/{poid}', [PurchaseOrderController::class, 'deletePOProcess']);



    }


);
