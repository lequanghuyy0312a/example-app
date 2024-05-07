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
        $phaseIDSelected = $request->input('phaseIDSelectionToList');
        if ($phaseIDSelected && $search) {
            $filteredData = DB::select("SELECT p.*,
                                                groupProduct.name as thuocnhom,
                                                type.name as thuocloai,
                                                category.name as thuocchung,
                                                phase.name as thuocky,
                                                phase.id as phase_id,
                                                warehouse.name as thuockhonhapve
                                        FROM product p
                                        LEFT JOIN groupProduct  on p.groupID = groupProduct.id
                                        LEFT JOIN type          on p.typeID = type.id
                                        LEFT JOIN category      on p.categoryID = category.id
                                        LEFT JOIN phase         on p.phaseID = phase.id
                                        LEFT JOIN warehouse       on p.warehouseID = warehouse.id
                                        WHERE
                                            (p.code LIKE '%$search%'
                                            OR p.name LIKE '%$search%'
                                            OR p.unit LIKE '%$search%'
                                            OR groupProduct.name LIKE '%$search%'
                                            OR type.name LIKE '%$search%'
                                            OR warehouse.name LIKE '%$search%')
                                            AND phase.id = ?", [$phaseIDSelected]);
            return response()->json(['data' => $filteredData]);
        } else {
            // If phaseIDSelected is not set or search is empty, return an empty response or handle it accordingly
            return response()->json(['error' => []]);
        }
    }


    public function getProducts()
    {
        $getDropListProducts = DB::select("SELECT * From product ORDER BY id ASC  ");
        $getDropListPhases = DB::select("SELECT * From phase ORDER BY id ASC  ");
        $getDropListGroups = DB::select("SELECT * From groupProduct ORDER BY id ASC  ");
        $getDropListTypes = DB::select("SELECT * From type ORDER BY id ASC  ");
        $getDropListCategories = DB::select("SELECT * From category ORDER BY id ASC  ");
        $getDropListWarehouses = DB::select("SELECT * From warehouse ORDER BY id ASC  ");
        $countProducts = DB::table('product')->count();
        return view('layouts.product.product', [
            'countProducts' => $countProducts,
            'getDropListCategories' => $getDropListCategories,
            'getDropListTypes' => $getDropListTypes,
            'getDropListProducts' => $getDropListProducts,
            'getDropListPhases' => $getDropListPhases,
            'getDropListWarehouses' => $getDropListWarehouses,
            'getDropListGroups' => $getDropListGroups
        ]);
    }
    public function initialLoadProducts(Request $request)
    {
        $phaseIDSelected = $request->input('phaseIDSelectionToList');
        if ($phaseIDSelected) {
            $getProducts = DB::select(" SELECT p.*,
                                        groupProduct.name as thuocnhom,
                                        type.name as thuocloai,
                                        category.name as thuocchung,
                                        phase.name as thuocky,
                                        warehouse.name as thuockhonhapve,
                                        phase.id as phase_ID
                                    FROM product p
                                    LEFT JOIN groupProduct  on p.groupID = groupProduct.id
                                    LEFT JOIN type          on p.typeID = type.id
                                    LEFT JOIN category      on p.categoryID = category.id
                                    LEFT JOIN phase         on p.phaseID = phase.id
                                    LEFT JOIN warehouse       on p.warehouseID = warehouse.id
                                    WHERE phase.id = ?
                                    ORDER BY p.latestUpdated DESC LIMIT 50 OFFSET 0", [$phaseIDSelected]);

            return response()->json(['data' => $getProducts]);
        } else {
            // If phaseIDSelected is not set, return an empty response or handle it accordingly
            return response()->json(['data' => []]);
        }
    }

    public function loadMoreProducts(Request $request)
    {
        $offset = $request->input('offset');
        $limit = $request->input('limit');
        $phaseIDSelected = $request->input('phaseIDSelectionToList');
        if ($phaseIDSelected) {
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
                                    WHERE phase.id = ?

                                    ORDER BY p.latestUpdated DESC LIMIT $limit OFFSET $offset", [$phaseIDSelected]);
            return response()->json(['data' => $getProducts]);
        } else {
            // If phaseIDSelected is not set, return an empty response or handle it accordingly
            return response()->json(['data' => []]);
        }
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
        $unit = $request->input('unitAdd');

        // Check if a similar record already exists
        $existingRecord = product::where('categoryID', $categoryID)
            ->where('typeID', $typeID)
            ->where('groupID', $groupID)
            ->where('phaseID', $phaseID)
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
        $unit        = $request->input('unitEdit');

        $product = Product::find($id);
        if ($product->phaseID != $phaseID || $product->groupID != $groupID || $product->typeID != $typeID) {
            $existingRecord = product::where('categoryID', $categoryID)
                ->where('typeID', $typeID)
                ->where('groupID', $groupID)
                ->where('phaseID', $phaseID)
                ->first();

            if ($existingRecord) {
                // Similar record exists, handle accordingly (e.g., show an error message)
                return redirect()->back()->withErrors(['error' => 'Dữ liệu trùng']);
            }
        }

        $product->phaseID = $phaseID;
        $product->categoryID = $categoryID;
        $product->typeID = $typeID;
        $product->groupID = $groupID;
        $product->warehouseID = $warehouseID;
        $product->code = $code;
        $product->name = $name;
        $product->unit = $unit;
        $product->latestUpdated      = now();


        $res = $product->update();
        if ($res) {
            session()->flash('success', 'Thao tác thành công');
            return redirect('/products');
        } else {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        }
    }

    public function insertProductsByPhase(Request $request)
    {
        try {
            $phaseIDCurrent = $request->input('phaseIDCurrent');
            $phaseIDSelection = $request->input('phaseIDSelection');

            // Thực hiện truy vấn để insert các dòng với giá trị mới của PhaseID
            $res = DB::statement("INSERT INTO product (categoryID,
                                            typeID,
                                            groupID,
                                            code,
                                            name,
                                            image,
                                            warehouseID,
                                            latestUpdated,
                                            unit,
                                            phaseID)
                                    SELECT categoryID,
                                                        typeID,
                                                        groupID,
                                                        code,
                                                        name,
                                                        image,
                                                        warehouseID,
                                                        NOW(),
                                                        unit,
                                                        ?
                                    FROM product
                                    WHERE phaseID = ?", [$phaseIDSelection, $phaseIDCurrent]);
            if ($res) {
                session()->flash('success', 'Thao tác thành công');
                return redirect('/products');
            } else {
                session()->flash('error', 'Kiểm tra lại thao tác');
            }
        } catch (QueryException $e) {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        }
    }
    public function removeProductsByPhase(Request $request) // xoá 01 Product
    {
        try {
            $phaseIDSelected = $request->input('phaseIDSelected');
            $product = Product::where('phaseID', $phaseIDSelected);
            $product->delete();
            session()->flash('success', 'Thao tác thành công');
            return redirect('/products');
        } catch (QueryException $e) {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        }
    }
}
