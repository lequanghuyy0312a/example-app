<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\BoM;
use Exception;
use Illuminate\Database\QueryException;

class BoMController extends Controller
{
    //
    public function getBoMs()
    {
        $getBoMs = DB::select(" SELECT b.*,
                                p.id as product_id,
                                pPhase.name as product_phase,
                                p.code as product_code,
                                p.name as product_name,
                                p.unit as product_unit,
                                p.sellingPrice as product_sellPrice,
                                p.costPrice as product_costPrice,
                                wp.name as product_Warehouse,

                                m.id as material_id,
                                mPhase.name as material_phase,
                                m.code as material_code,
                                m.name as material_name,
                                m.unit as material_unit,
                                m.sellingPrice as material_sellPrice,
                                m.costPrice as material_costPrice,
                                wm.name as material_Warehouse
                        FROM BoM b
                        INNER JOIN product p on b.productID = p.id
                        INNER JOIN product m on b.materialID = m.id

                        INNER JOIN phase mPhase on m.phaseID = mPhase.id
                        INNER JOIN phase pPhase on p.phaseID = pPhase.id

                        INNER JOIN warehouse wm on m.warehouseID = wm.id
                        INNER JOIN warehouse wp on p.warehouseID = wp.id

                        ORDER BY b.latestUpdated DESC ");

        $getListProducts = DB::select("SELECT distinct p.id, p.code, p.name, p.orderCode, p.costPrice,
                                            phase.name as phase, w.name as warehouse
                                            From product p
                                            LEFT JOIN phase ON p.phaseID = phase.id
                                            LEFT JOIN warehouse  w ON p.phaseID = w.id
                                            LEFT JOIN BoM  b ON b.productID = p.id
                                            ORDER BY b.latestUpdated DESC ");
        return view('layouts.bom.list', [

            'getBoMs' => $getBoMs,
            'getListProducts' => $getListProducts
        ]);
    }
    public function showModalAdd($id)
    {
        $getProductsToAdd = DB::select(" SELECT product.name,
                                                product.code,
                                                product.costPrice,
                                                phase.name as phase
                                        FROM product
                                        left join phase on phase.id = product.phaseID");
        $getProductToAdd = DB::select(" SELECT product.name,
                                                product.id,
                                                product.code,
                                                product.costPrice,
                                                phase.name as phase
                                        FROM product
                                        left join phase on phase.id = product.phaseID
                                        WHERE product.id = $id");
        return response()->json([
            'getProductsToAdd' => $getProductsToAdd,
            'getProductToAdd' => $getProductToAdd,
        ]);
    }
    public function addBoM(Request $request)
    {
        // Retrieve data from the request
        $materialIDs = $request->input('materialIDAdd');
        $quantities = $request->input('quantityAdd');
        $weights = $request->input('weightAdd');
        $weights = $request->input('weightAdd');


        // Loop through the data and save each BoM entry
        foreach ($materialIDs as $key => $materialID) {
            $bom = new BoM();
            $bom->productID = $request->input('productIDAdd'); // You need to define this field in your form
            $bom->materialID = $materialID;
            $bom->quantity = $quantities[$key+1];
            $bom->weight = $weights[$key+1];
            $bom->latestUpdated  = now();

            $res = $bom->save();
        }

        if ($res) {
            session()->flash('success', 'Thao tác thành công');
            return redirect('/bill-of-materials');
        } else {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        }
    }

    public function removeBoM($id) // xoá 01 BoM
    {
        BoM::where('productID', $id)->delete();

        session()->flash('success', 'Thao tác thành công');
        return redirect('/bill-of-materials');
    }
    public function deleteBoMChild($productID, $materialID)
    {
        BoM::where('productID', $productID)
            ->where('materialID', $materialID)
            ->delete();

        session()->flash('success', 'Thao tác thành công');
        return redirect('/bill-of-materials');
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
        BoM::where('productID',  $request->input('productIDHidden'))
            ->where('materialID',  $request->input('materialIDHidden'))
            ->update(['quantity' => $request->input('quantityEdit'),
                      'weight' => $request->input('weightEdit'),
                      'latestUpdated'  => now()
                    ]);
        session()->flash('success', 'Thao tác thành công');
        return redirect('/bill-of-materials');
    }

    public function printBoM($id)
    {
        $getBoMs = DB::select(" SELECT BoM.*,
                                            p.code as product_code, p.name as product_name,
                                            m.code as material_code, m.name as material_name,
                                            mPhase.name as material_phase,
                                            pPhase.name as product_phase,
                                            getp.sellingPrice as product_sellPrice,
                                            getp.costPrice as product_costPrice,
                                            getm.sellingPrice as material_sellPrice,
                                            getm.costPrice as material_costPrice
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
                                        p.sellingPrice as product_sellPrice,
                                        p.costPrice as product_costPrice,
                                        wp.name as product_Warehouse,

                                        m.id as material_id,
                                        mPhase.name as material_phase,
                                        m.code as material_code,
                                        m.name as material_name,
                                        m.unit as material_unit,
                                        m.sellingPrice as material_sellPrice,
                                        m.costPrice as material_costPrice,
                                        wm.name as material_Warehouse
                                FROM BoM b
                                INNER JOIN product p on b.productID = p.id
                                INNER JOIN product m on b.materialID = m.id

                                INNER JOIN phase mPhase on m.phaseID = mPhase.id
                                INNER JOIN phase pPhase on p.phaseID = pPhase.id

                                INNER JOIN warehouse wm on m.warehouseID = wm.id
                                INNER JOIN warehouse wp on p.warehouseID = wp.id

                                ORDER BY p.name ASC");

        $getDropListProducts = DB::select(" SELECT product.name,
                                                    product.code,
                                                    product.unit,
                                                    product.costPrice,
                                                    phase.name as phase
                                            FROM product
                                            left join phase on phase.id = product.phaseID
                                            WHERE product.id = $id ");
        return view('layouts.bom.bom-process', [
            'getBoMs' => $getBoMs,
            'getDropListProducts' => $getDropListProducts
        ]);
    }
}
