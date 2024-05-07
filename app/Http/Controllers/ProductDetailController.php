<?php

namespace App\Http\Controllers;

use App\Models\ProductDetail;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductDetailController extends Controller
{
    public function searchProductDetails(Request $request)
    {
        $search = $request->input('search');
        $phaseIDSelected = $request->input('phaseIDSelectionToProductList');
        if ($phaseIDSelected && $search) {
            $filteredData = DB::select(" SELECT pd.*,
                                        p.name as product_name, p.code as product_code,
                                        pn.name as partner_name,
                                        phase.name as phase_name
                                    FROM productDetail pd
                                    LEFT JOIN product p  on p.id = pd.productID
                                    LEFT JOIN partner pn          on pn.id = pd.partnerID
                                    LEFT JOIN phase         on p.phaseID = phase.id

                                        WHERE
                                            ( p.name LIKE '%$search%'
                                            OR pn.name LIKE '%$search%'
                                            OR phase.name LIKE '%$search%'
                                            OR pd.orderCode LIKE '%$search%'
                                            OR pd.createdOnUTC LIKE '%$search%')
                                            AND phase.id = ?
                                        ORDER BY pd.latestUpdated ", [$phaseIDSelected]);
            return response()->json(['data' => $filteredData]);
        } else {
            // If phaseIDSelected is not set or search is empty, return an empty response or handle it accordingly
            return response()->json(['error' => []]);
        }
    }


    public function getProductDetails(Request $request)
    {
        $getDropListProducts = DB::select("SELECT id, name From product  ");

        $getDropListPhases = DB::select("SELECT id, name From phase ORDER BY id ASC  ");
        $countProductDetails = DB::table('productDetail')->count();
        return view('layouts.product.product-detail', [
            'countProductDetails' => $countProductDetails,
            'getDropListProducts' => $getDropListProducts,
            'getDropListPhases' => $getDropListPhases
        ]);
    }
    public function initialLoadProductDetails(Request $request)
    {
        $phaseIDSelected = $request->input('phaseIDSelectionToProductList');
        if ($phaseIDSelected) {
            $getProductDetails = DB::select(" SELECT pd.*,
                                        p.name as product_name, p.code as product_code,
                                        pn.name as partner_name,
                                        phase.name as phase_name
                                    FROM productDetail pd
                                    LEFT JOIN product p  on p.id = pd.productID
                                    LEFT JOIN partner pn          on pn.id = pd.partnerID
                                    LEFT JOIN phase         on p.phaseID = phase.id
                                    WHERE phase.id = ?
                                    ORDER BY pd.latestUpdated DESC LIMIT 50 OFFSET 0", [$phaseIDSelected]);

            return response()->json(['data' => $getProductDetails]);
        } else {
            // If phaseIDSelected is not set, return an empty response or handle it accordingly
            return response()->json(['data' => []]);
        }
    }

    public function loadMoreProductDetails(Request $request)
    {
        $offset = $request->input('offset');
        $limit = $request->input('limit');
        $phaseIDSelected = $request->input('phaseIDSelectionToProductList');
        if ($phaseIDSelected) {
            $getProductDetails = DB::select(
                "SELECT pd.*,
                                                    p.name as product_name, p.code as product_code,
                                                    pn.name as partner_name,
                                                    phase.name as phase_name
                                                FROM productDetail pd
                                                LEFT JOIN product p  on p.id = pd.productID
                                                LEFT JOIN partner pn          on pn.id = pd.partnerID
                                                LEFT JOIN phase         on p.phaseID = phase.id
                                                WHERE phase.id = ?
                                                ORDER BY pd.latestUpdated  DESC LIMIT $limit OFFSET $offset",
                [$phaseIDSelected]
            );
            return response()->json(['data' => $getProductDetails]);
        } else {
            // If phaseIDSelected is not set, return an empty response or handle it accordingly
            return response()->json(['data' => []]);
        }
    }



    public function addProductDetail(Request $request) // thêm 01 ProductDetail
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
        $existingRecord = productDetail::where('categoryID', $categoryID)
            ->where('typeID', $typeID)
            ->where('groupID', $groupID)
            ->where('phaseID', $phaseID)
            ->first();

        if ($existingRecord) {
            // Similar record exists, handle accordingly (e.g., show an error message)
            return redirect()->back()->withErrors(['error' => 'Dữ liệu trùng']);
        }

        // No similar record found, proceed with adding the new productDetail
        $productDetail = new ProductDetail();
        $productDetail->phaseID = $phaseID;
        $productDetail->categoryID = $categoryID;
        $productDetail->typeID = $typeID;
        $productDetail->groupID = $groupID;
        $productDetail->warehouseID = $warehouseID;
        $productDetail->code = $code;
        $productDetail->name = $name;
        $productDetail->unit = $unit;
        $productDetail->latestUpdated      = now();

        $res = $productDetail->save();

        if ($res) {
            // Successful addition
            session()->flash('success', 'Thao tác thành công');
            return redirect('/productDetails');
        } else {
            // Error during addition
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        }
    }
    public function deleteProductDetail($id) // xoá 01 ProductDetail
    {
        try {
            $productDetail = ProductDetail::find($id);
            $productDetail->delete();
            session()->flash('success', 'Thao tác thành công');
            return redirect('/productDetails');
        } catch (QueryException $e) {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        }
    }


    public function showAddModal()
    {
        $getDropListProducts = DB::select("SELECT id, name, phaseID From product  ");
        $getDropListPartners = DB::select("SELECT id, name From partner ORDER BY id ASC  ");

        return response()->json([
            'getDropListPartners' => $getDropListPartners,
            'getDropListProducts' => $getDropListProducts
        ]);
    }
    public function editProductDetail(Request $request,  $id) // sửa 01 ProductDetail
    {
        $phaseID     = $request->input('phaseIDEdit');
        $categoryID  = $request->input('categoryIDEdit')  == 0 ? null : $request->input('categoryIDEdit');
        $typeID      = $request->input('typeIDEdit')  == 0 ? null : $request->input('typeIDEdit');
        $groupID     = $request->input('groupIDEdit')  == 0 ? null : $request->input('groupIDEdit');
        $warehouseID = $request->input('warehouseIDEdit');
        $code        = $request->input('codeEdit');
        $name        = $request->input('nameEdit');
        $unit        = $request->input('unitEdit');

        $productDetail = ProductDetail::find($id);
        if ($productDetail->phaseID != $phaseID || $productDetail->groupID != $groupID || $productDetail->typeID != $typeID) {
            $existingRecord = productDetail::where('categoryID', $categoryID)
                ->where('typeID', $typeID)
                ->where('groupID', $groupID)
                ->where('phaseID', $phaseID)
                ->first();

            if ($existingRecord) {
                // Similar record exists, handle accordingly (e.g., show an error message)
                return redirect()->back()->withErrors(['error' => 'Dữ liệu trùng']);
            }
        }

        $productDetail->phaseID = $phaseID;
        $productDetail->categoryID = $categoryID;
        $productDetail->typeID = $typeID;
        $productDetail->groupID = $groupID;
        $productDetail->warehouseID = $warehouseID;
        $productDetail->code = $code;
        $productDetail->name = $name;
        $productDetail->unit = $unit;
        $productDetail->latestUpdated      = now();

        $res = $productDetail->update();
        if ($res) {
            session()->flash('success', 'Thao tác thành công');
            return redirect('/productDetails');
        } else {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        }
    }

    public function insertProductDetailsByPhase(Request $request)
    {
        try {
            $phaseIDCurrent = $request->input('phaseIDCurrent');
            $phaseIDSelection = $request->input('phaseIDSelection');

            // Thực hiện truy vấn để insert các dòng với giá trị mới của PhaseID
            $res = DB::statement("INSERT INTO productDetail (categoryID,
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
                                    FROM productDetail
                                    WHERE phaseID = ?", [$phaseIDSelection, $phaseIDCurrent]);
            if ($res) {
                session()->flash('success', 'Thao tác thành công');
                return redirect('/productDetails');
            } else {
                session()->flash('error', 'Kiểm tra lại thao tác');
            }
        } catch (QueryException $e) {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        }
    }
    public function removeProductDetailsByPhase(Request $request) // xoá 01 ProductDetail
    {
        try {
            $phaseIDSelected = $request->input('phaseIDSelected');
            $productDetail = ProductDetail::where('phaseID', $phaseIDSelected);
            $productDetail->delete();
            session()->flash('success', 'Thao tác thành công');
            return redirect('/productDetails');
        } catch (QueryException $e) {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        }
    }
}
