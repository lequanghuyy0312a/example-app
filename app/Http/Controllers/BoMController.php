<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\BoM;
use Exception;
use Illuminate\Database\QueryException;
use App\Models\Product;

class BoMController extends Controller
{
    //

    public function showModalAdd($id, Request $request)
    {

        $getProductsToAdd = DB::select(" SELECT product.name,
                                                product.code,
                                                phase.name as phase
                                        FROM product
                                        left join phase on phase.id = product.phaseID
                                        Where phase.id ");
        $getProductToAdd = DB::select(" SELECT product.name,
                                                product.id,
                                                product.code,
                                                phase.name as phase
                                        FROM product
                                        left join phase on phase.id = product.phaseID
                                        WHERE product.id = $id");
        return response()->json([
            'getProductsToAdd' => $getProductsToAdd,
            'getProductToAdd' => $getProductToAdd

        ]);
    }

    public function addBoM(Request $request)
    {
        // Retrieve data from the request
        $materialIDs = $request->input('materialIDAdd');
        $productID = $request->input('productIDAdd');
        $quantities = $request->input('quantityAdd');
        $weights = $request->input('weightAdd');
        $hiddenProductIdParrentAddBoM = $request->input('hiddenProductIdParrentAddBoM');

        // Retrieve the product
        $product = Product::find($productID);

        // Check if the product exists
        if (!$product) {
            // Handle the case where the product does not exist
            return response()->json(['error' => 'Product not found'], 404);
        }

        // Loop through the data and save each BoM entry
        foreach ($materialIDs as $key => $materialID) {
            // Retrieve the material
            $material = Product::find($materialID);

            // Check if the material exists
            if (!$material) {
                // Handle the case where the material does not exist
                continue; // Skip adding BoM entry for non-existent material
            }

            // Create a new BoM entry
            $bom = new BoM();

            $bom->productID = $productID;
            $bom->productCode = $product->code;
            $bom->materialID = $materialID;
            $bom->materialCode = $material->code;
            $bom->phaseID = $product->phaseID;
            $bom->quantity = $quantities[$key + 1];
            $bom->weight = $weights[$key + 1];
            $bom->latestUpdated = now();

            $res = $bom->save();
        }


        if ($res) {
            session()->flash('success', 'Thao tác thành công');

            return redirect('/bill-of-material/' . $hiddenProductIdParrentAddBoM);
        } else {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        }
    }

    public function removeBoM($id, Request $request) // xoá 01 BoM
    {

        BoM::where('productID', $id)->delete();

        session()->flash('success', 'Thao tác thành công');
        return redirect('/bill-of-material/' . $id);
    }
    public function deleteBoMChild($productID, $materialID, $productIDParrent)
    {
        BoM::where('productID', $productID)
            ->where('materialID', $materialID)
            ->delete();

        session()->flash('success', 'Thao tác thành công');
        return redirect('/bill-of-material/' . $productIDParrent);
    }

    public function showModalEdit($materialID, $productID)
    {
        $getMaterialEdit = DB::select("SELECT  product.name,
                                              product.code,
                                              phase.name as phase
                                       FROM product
                                       LEFT JOIN phase ON phase.id = product.phaseID
                                       WHERE product.id = $materialID");

        $getInfoToEdit = DB::select("SELECT weight, quantity FROM BoM
                                      WHERE productID = $productID
                                      AND   materialID = $materialID");

        return response()->json([
            'getMaterialEdit' => $getMaterialEdit,
            'getInfoToEdit' => $getInfoToEdit
        ]);
    }

    public function editBoM(Request $request)
    {
        $hiddenProductIdParrentEditBoM = $request->input('hiddenProductIdParrentEditBoM');

        BoM::where('productID',  $request->input('productIDHidden'))
            ->where('materialID',  $request->input('materialIDHidden'))
            ->update([
                'quantity' => $request->input('quantityEdit'),
                'weight' => $request->input('weightEdit'),
                'latestUpdated'  => now()
            ]);
        session()->flash('success', 'Thao tác thành công');
        return redirect('/bill-of-material/' . $hiddenProductIdParrentEditBoM);
    }

    public function printBoM($id)
    {
        $getBoMs = DB::select(" SELECT BoM.*,
                                            p.code as product_code, p.name as product_name,
                                            m.code as material_code, m.name as material_name,
                                            mPhase.name as material_phase,
                                            pPhase.name as product_phase
                                    FROM BoM
                                    LEFT JOIN productByPhase getp on BoM.productID = getp.id
                                    LEFT JOIN productByPhase getm on BoM.materialID = getm.id
                                    LEFT JOIN product p on getp.productID = p.id
                                    LEFT JOIN product m on getm.productID = m.id
                                    LEFT JOIN phase mPhase on getm.phaseID = mPhase.id
                                    LEFT JOIN phase pPhase on getp.phaseID = pPhase.id");

        $getDropListProducts = DB::select(" SELECT productByPhase.*, phase.name as phase, product.code as p_code, product.name as p_name
                                            From productByPhase
                                            LEFT JOIN product ON productByPhase.productID = product.id
                                            LEFT JOIN phase ON productByPhase.phaseID = phase.id
                                            WHERE productByPhase.id = $id ");
        return view('layouts.Fpdf.pdfBoM', [
            'getBoMs' => $getBoMs,
            'getDropListProducts' => $getDropListProducts
        ]);
    }

    public function getBoM($id)
    {

        $getBoMs = DB::select(" SELECT b.*,
                                        p.id as product_id,
                                        pPhase.name as product_phase,
                                        p.code as product_code,
                                        p.name as product_name,
                                        p.unit as product_unit,
                                        wp.name as product_Warehouse,

                                        m.id as material_id,
                                        mPhase.name as material_phase,
                                        m.code as material_code,
                                        m.name as material_name,
                                        m.unit as material_unit,
                                        wm.name as material_Warehouse
                                FROM BoM b
                                INNER JOIN product p on b.productID = p.id
                                INNER JOIN product m on b.materialID = m.id

                                INNER JOIN phase mPhase on m.phaseID = mPhase.id
                                INNER JOIN phase pPhase on p.phaseID = pPhase.id

                                INNER JOIN warehouse wm on m.warehouseID = wm.id
                                INNER JOIN warehouse wp on p.warehouseID = wp.id

                                ORDER BY b.phaseID,  p.code");

        $getDropListProducts = DB::select(" SELECT product.name,
                                                    product.code,
                                                    product.id,
                                                    product.unit,
                                                    phase.name as phase,
                                                    phase.id as phase_id,
                                                    product.phaseID as product_PhaseID
                                            FROM product
                                            left join phase on phase.id = product.phaseID
                                            WHERE product.id = $id ");


        $getListProducts = DB::select("SELECT distinct p.id, p.code, p.name, p.phaseID as product_PhaseID,
                                    phase.name as phase, w.name as warehouse
                                    From product p
                                    LEFT JOIN phase ON p.phaseID = phase.id
                                    LEFT JOIN warehouse  w ON p.phaseID = w.id
                                    LEFT JOIN BoM  b ON b.productID = p.id  ");

        $bomData = $this->getCurrentBomCTEData($getDropListProducts[0]->code, $getDropListProducts[0]->phase_id);
        $countBomData = count($bomData);


        $getDropListPhasesToCopy = DB::select("SELECT id, name From phase ");
        return view('layouts.bom.bom-process', [
            'getBoMs' => $getBoMs,
            'getDropListProducts' => $getDropListProducts,
            'getListProducts' => $getListProducts,
            'getDropListPhasesToCopy' => $getDropListPhasesToCopy,
            'countBomData' => $countBomData,

        ]);
    }


    // copy BoM
    public function showModalCopy($productID)
    {
        $getProductToCopy = DB::select("SELECT  product.name,
                                                product.phaseID,
                                                product.code,
                                                phase.name as phase
                                       FROM product
                                       LEFT JOIN phase ON phase.id = product.phaseID
                                       WHERE product.id = $productID");

        $getInfoToCopy = DB::select("SELECT weight, quantity FROM BoM
                                      WHERE productID = $productID ");
        $getProductToCheck = DB::select("SELECT  code, phaseID from product");
        return response()->json([
            'getProductToCopy' => $getProductToCopy,
            'getProductToCheck' => $getProductToCheck,
            'getInfoToCopy' => $getInfoToCopy
        ]);
    }

    public function copyBoM(Request $request)
    {
        // Lấy dữ liệu từ yêu cầu của người dùng
        $hiddenShowCodeCopy = $request->input('hiddenShowCodeCopy');
        $phaseIDcopy = $request->input('phaseIDcopy');
        $hiddenPhaseIDCurrent = $request->input('hiddenPhaseIDCurrent');

        $productId = $request->input('showProductIDCopy');
        $phaseIdToUpdate = $phaseIDcopy;

        if ($request->input('checkOptionToDelete') == 0) {
            // xoá tất cả các dòng trong bảng BoM khi thoả điều kiện (productCode, phaseID, materialCode)
            $getLeftTable = ($this->getCurrentBomCTEData($hiddenShowCodeCopy, $hiddenPhaseIDCurrent));

            foreach ($getLeftTable as $data) {
                BoM::where('productCode', $data->productCode)
                    ->where('phaseID', $phaseIDcopy)
                    ->where('materialCode', $data->materialCode)
                    ->delete();
            }
        } else {
            // xoá tất cả các dòng trong bảng BoM khi thoả điều kiện (productCode, phaseID)
            $bomDataToDelete = $this->getCurrentBomCTEData($hiddenShowCodeCopy, $phaseIDcopy);
            foreach ($bomDataToDelete as $data) {
                $bom = BoM::find($data->id);
                $bom->delete();
            }
        }

        // Lấy danh sách sản phẩm từ truy vấn đệ quy BomCTE
        $bomData = $this->getCurrentBomCTEData($hiddenShowCodeCopy, $hiddenPhaseIDCurrent);

        // Tạo một mảng để lưu trữ thông tin cần thêm mới vào bảng BoM
        $newBoMData = [];

        // Lặp qua kết quả truy vấn đã suy vấn được
        foreach ($bomData as $item) {
            // Lấy product ID từ bảng product dựa trên productCode và phaseID mới
            $newProductId = DB::table('product')
                ->where('code', $item->productCode)
                ->where('phaseID', $phaseIdToUpdate)
                ->value('id');

            // Nếu tìm thấy product ID, thêm thông tin mới vào mảng newBoMData
            if ($newProductId) {
                // Lấy newMaterialID từ bảng product dựa trên materialCode và phaseID mới
                $newMaterialID = DB::table('product')
                    ->where('code', $item->materialCode)
                    ->where('phaseID', $phaseIdToUpdate)
                    ->value('id');

                // Nếu tìm thấy newMaterialID, thêm thông tin mới vào mảng newBoMData
                if ($newMaterialID) {
                    $newBoMData[] = [
                        'phaseID' => $phaseIdToUpdate,
                        'productID' => $newProductId,
                        'materialID' => $newMaterialID,
                        'productCode' => $item->productCode,
                        'materialCode' => $item->materialCode,
                        'quantity' => $item->quantity,
                        'weight' => $item->weight,
                        'latestUpdated' =>  NOW()
                    ];

        //             // Lấy danh sách các hàng con từ truy vấn đệ quy BomCTE
        //             $children = $this->getChildBomData($newProductId, $phaseIdToUpdate);

        //             // Thêm các hàng con vào mảng newBoMData
        //             foreach ($children as $child) {
        //                 // Lấy newMaterialID cho hàng con
        //                 $newChildMaterialID = DB::table('product')
        //                     ->where('code', $child->materialCode)
        //                     ->where('phaseID', $phaseIdToUpdate)
        //                     ->value('id');

        //                 // Nếu tìm thấy newChildMaterialID, thêm thông tin hàng con vào mảng newBoMData
        //                 if ($newChildMaterialID) {
        //                     $newBoMData[] = [
        //                         'phaseID' => $phaseIdToUpdate,
        //                         'productID' => $child->productID,
        //                         'materialID' => $newChildMaterialID,
        //                         'productCode' => $child->productCode,
        //                         'materialCode' => $child->materialCode,
        //                         'quantity' => $item->quantity,
        //                         'weight' => $item->weight,
        //                         'latestUpdated' =>  NOW()
        //                     ];
        //                 }
        //             }
                }
            }
        }

        // Thêm các bản ghi mới vào bảng BoM
        DB::table('BoM')->insert($newBoMData);

        // Trả về kết quả hoặc thực hiện các hành động khác tùy thuộc vào yêu cầu
        session()->flash('success', 'Thao tác thành công');
        return redirect('/bill-of-material/' . $productId);
    }

    private function getChildBomData($productId, $phaseId)
    {
        $childBomData = [];

        // Lấy dữ liệu từ bảng BoM cho các hàng con của sản phẩm có $productId và $phaseId
        $tempChildBomData = $this->getBomData($productId, $phaseId);

        // Lặp lại việc lấy dữ liệu từ bảng theo mối quan hệ cha-con
        while (!empty($tempChildBomData)) {
            // Thêm dữ liệu vào mảng chính
            $childBomData = array_merge($childBomData, $tempChildBomData);

            // Lấy danh sách materialID từ kết quả trước đó để lấy dữ liệu tiếp theo
            $materialIds = array_column($tempChildBomData, 'materialID');

            // Lấy dữ liệu từ bảng với materialID là danh sách vừa lấy được
            $tempChildBomData = $this->getBomData($materialIds, $phaseId);
        }

        return $childBomData;
    }

    private function getBomData($productId, $phaseId)
    {
        // Truy vấn dữ liệu từ bảng BoM
        $bomData = DB::table('BoM')
            ->select('id', 'phaseID', 'productID', 'materialID', 'productCode', 'materialCode')
            ->where('productID', $productId)
            ->where('phaseID', $phaseId)
            ->get();

        return $bomData->toArray();
    }


    private function getCurrentBomCTEData($productCode, $phaseId)
    {
        // Truy vấn dữ liệu từ truy vấn đệ quy BomCTE
        $bomData = DB::select("WITH RECURSIVE BomCTE AS (
            SELECT
                id, phaseID, productID, materialID, productCode, materialCode, quantity, weight
            FROM
                BoM
            WHERE
                productCode = '$productCode' AND phaseID = $phaseId
            UNION ALL
            SELECT
                t.id, t.phaseID, t.productID, t.materialID, t.productCode, t.materialCode, t.quantity, t.weight
            FROM
                BoM t
            INNER JOIN
                BomCTE c ON  t.productID = c.materialID
        )
        SELECT
            *
        FROM
            BomCTE
                ");

        return $bomData;
    }




    // copy BoM
}
