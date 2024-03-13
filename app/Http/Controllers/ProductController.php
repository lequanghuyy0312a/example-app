<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function searchProducts(Request $request)
    {
        $search = $request->input('search');
        if ($search) {
            $filteredData = DB::select("SELECT p.*,
                                                groupProduct.name as thuocnhom,
                                                type.name as thuocloai,
                                                category.name as thuocchung,
                                                phase.name as thuocky,
                                                warehouse.name as thuockhonhapve
                                        FROM product p
                                        LEFT JOIN groupProduct  on p.groupID = groupProduct.id
                                        LEFT JOIN type          on p.typeID = type.id
                                        LEFT JOIN category      on p.categoryID = category.id
                                        LEFT JOIN phase         on p.phaseID = phase.id
                                        LEFT JOIN warehouse       on p.warehouseID = warehouse.id
                                                WHERE
                                                    p.code LIKE '%$search%'
                                                    OR p.name LIKE '%$search%'
                                                    OR p.orderCode LIKE '%$search%'
                                                    OR p.unit LIKE '%$search%'
                                                    OR  groupProduct.name LIKE '%$search%'
                                                    OR type.name LIKE '%$search%'
                                                    OR phase.name LIKE '%$search%'
                                                    OR warehouse.name LIKE '%$search%' ");
        }

        return response()->json(['data' => $filteredData]);
    }

    public function getProducts()
    {
        $getDropListProducts = DB::select("SELECT * From product ORDER BY id ASC  ");
        $getDropListPhases = DB::select("SELECT * From phase ORDER BY id ASC  ");
        $getDropListGroups = DB::select("SELECT * From groupProduct ORDER BY id ASC  ");
        $getDropListTypes = DB::select("SELECT * From type ORDER BY id ASC  ");
        $getDropListCategories = DB::select("SELECT * From category ORDER BY id ASC  ");
        $getDropListWarehouses = DB::select("SELECT * From warehouse ORDER BY id ASC  ");
        return view('layouts.product.product', [
            'getDropListCategories' => $getDropListCategories,
            'getDropListTypes' => $getDropListTypes,
            'getDropListProducts' => $getDropListProducts,
            'getDropListPhases' => $getDropListPhases,
            'getDropListWarehouses' => $getDropListWarehouses,
            'getDropListGroups' => $getDropListGroups
        ]);
    }
    public function initialLoadProducts()
    {
        // $getProducts = DB::select("SELECT * FROM product  ORDER BY id ASC LIMIT 20 OFFSET 0");
        $getProducts = DB::select(" SELECT p.*,
                                            groupProduct.name as thuocnhom,
                                            type.name as thuocloai,
                                            category.name as thuocchung,
                                            phase.name as thuocky,
                                            warehouse.name as thuockhonhapve
                                    FROM product p
                                    LEFT JOIN groupProduct  on p.groupID = groupProduct.id
                                    LEFT JOIN type          on p.typeID = type.id
                                    LEFT JOIN category      on p.categoryID = category.id
                                    LEFT JOIN phase         on p.phaseID = phase.id
                                    LEFT JOIN warehouse       on p.warehouseID = warehouse.id
                                    ORDER BY p.latestUpdated DESC LIMIT 50 OFFSET 0");


        return response()->json(['data' => $getProducts]);
    }
    public function loadMoreProducts(Request $request)
    {
        $offset = $request->input('offset');
        $limit = $request->input('limit');

        $getProducts = DB::select("SELECT p.*,
                                            groupProduct.name as thuocnhom,
                                            type.name as thuocloai,
                                            category.name as thuocchung,
                                            phase.name as thuocky,
                                            warehouse.name as thuockhonhapve
                                    FROM product p
                                    LEFT JOIN groupProduct  on p.groupID = groupProduct.id
                                    LEFT JOIN type          on p.typeID = type.id
                                    LEFT JOIN category      on p.categoryID = category.id
                                    LEFT JOIN phase         on p.phaseID = phase.id
                                    LEFT JOIN warehouse       on p.warehouseID = warehouse.id
                                    ORDER BY p.latestUpdated DESC LIMIT $limit OFFSET $offset");
        return response()->json(['data' => $getProducts]);
    }


    public function addProduct(Request $request) // thêm 01 Product
    {
        // Get input values
        $phaseID = $request->input('phaseIDAdd');
        $categoryID = $request->input('categoryIDAdd')  == 0 ? null : $request->input('categoryIDAdd');
        $typeID = $request->input('typeIDAdd')  == 0 ? null : $request->input('typeIDAdd');
        $groupID = $request->input('groupIDAdd')  == 0 ? null : $request->input('groupIDAdd');
        $warehouseID = $request->input('warehouseIDAdd');
        $code = $request->input('codeAdd');
        $name = $request->input('nameAdd');
        $orderCode = $request->input('orderCodeAdd');
        $unit = $request->input('unitAdd');
        $costPrice = str_replace(',', '', $request->input('costPriceAdd'));
        $sellingPrice = str_replace(',', '', $request->input('sellingPriceAdd'));


        // Check if a similar record already exists
        $existingRecord = product::where('categoryID', $categoryID)
            ->where('typeID', $typeID)
            ->where('groupID', $groupID)
            ->where('phaseID', $phaseID)
            ->where('costPrice', $costPrice)
            ->first();

        if ($existingRecord) {
            // Similar record exists, handle accordingly (e.g., show an error message)
            return redirect()->back()->withErrors(['error' => 'Dữ liệu trùng']);
        }

        // No similar record found, proceed with adding the new product
        $product = new Product();
        $product->phaseID = $phaseID;
        $product->categoryID = $categoryID;
        $product->typeID = $typeID;
        $product->groupID = $groupID;
        $product->warehouseID = $warehouseID;
        $product->code = $code;
        $product->name = $name;
        $product->unit = $unit;
        $product->orderCode = $orderCode;
        $product->costPrice = $costPrice;
        $product->sellingPrice = $sellingPrice;
        $product->latestUpdated      = now();

        $res = $product->save();

        if ($res) {
            // Successful addition
            session()->flash('success', 'Thao tác thành công');
            return redirect('/products');
        } else {
            // Error during addition
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        }
    }
    public function deleteProduct($id) // xoá 01 Product
    {
        try {
            $product = Product::find($id);
            $product->delete();
            session()->flash('success', 'Thao tác thành công');
            return redirect('/products');
        } catch (QueryException $e) {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        }
    }
    public function showModal($id)
    {
        $getProductToEdit = DB::select("SELECT * FROM product  WHERE id = $id");
        $getDropListCategories = DB::select("SELECT * From category ORDER BY id ASC  ");
        $getDropListPhases = DB::select("SELECT * From phase ORDER BY id ASC  ");
        $getDropListGroups = DB::select("SELECT * From groupProduct ORDER BY id ASC  ");
        $getDropListTypes = DB::select("SELECT * From type ORDER BY id ASC  ");
        $getDropListWarehouses = DB::select("SELECT * From warehouse ORDER BY id ASC  ");

        return response()->json([
            'getDropListCategories' => $getDropListCategories,
            'getDropListTypes' => $getDropListTypes,
            'getDropListGroups' => $getDropListGroups,
            'getDropListPhases' => $getDropListPhases,
            'getDropListWarehouses' => $getDropListWarehouses,
            'getProductToEdit' => $getProductToEdit
        ]);
    }


    public function editProduct(Request $request,  $id) // sửa 01 Product
    {

        $phaseID     = $request->input('phaseIDEdit');
        $categoryID  = $request->input('categoryIDEdit')  == 0 ? null : $request->input('categoryIDEdit');
        $typeID      = $request->input('typeIDEdit')  == 0 ? null : $request->input('typeIDEdit');
        $groupID     = $request->input('groupIDEdit')  == 0 ? null : $request->input('groupIDEdit');
        $warehouseID = $request->input('warehouseIDEdit');
        $code        = $request->input('codeEdit');
        $name        = $request->input('nameEdit');
        $orderCode   = $request->input('orderCodeEdit');
        $unit        = $request->input('unitEdit');
        $costPrice   = str_replace(',', '', $request->input('costPriceEdit'));
        $sellingPrice = str_replace(',', '', $request->input('sellingPriceEdit'));

        $product = Product::find($id);

        $existingRecord = product::where('categoryID', $categoryID)
            ->where('typeID', $typeID)
            ->where('groupID', $groupID)
            ->where('phaseID', $phaseID)
            ->where('costPrice', $costPrice)
            ->where('sellingPrice', $sellingPrice)
            ->first();

        if ($existingRecord) {
            // Similar record exists, handle accordingly (e.g., show an error message)
            return redirect()->back()->withErrors(['error' => 'Dữ liệu trùng']);
        }

        $product->phaseID = $phaseID;
        $product->categoryID = $categoryID;
        $product->typeID = $typeID;
        $product->groupID = $groupID;
        $product->warehouseID = $warehouseID;
        $product->code = $code;
        $product->name = $name;
        $product->unit = $unit;
        $product->orderCode = $orderCode;
        $product->costPrice = $costPrice;
        $product->sellingPrice = $sellingPrice;
        $product->latestUpdated      = now();


        $res = $product->update();
        if ($res) {
            session()->flash('success', 'Thao tác thành công');
            return redirect('/products');
        } else {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        }
    }
}
