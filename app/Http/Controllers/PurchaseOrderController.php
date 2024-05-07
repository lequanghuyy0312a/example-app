<?php

namespace App\Http\Controllers;

use App\Models\Process;
use App\Models\ProcessPurchase;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    public function searchPurchaseOrders(Request $request)
    {
        $search = $request->input('search');
        $phaseIDSelected = $request->input('phaseIDSelectionToPurchaseOrder');
        if ($phaseIDSelected && $search) {
            $filteredData = DB::select(" SELECT purchaseOrder.*, partner.name
                                        FROM purchaseOrder
                                        LEFT JOIN partner ON partner.id = purchaseOrder.partnerID
                                        WHERE
                                            (
                                                purchaseOrder.purchaseOrderNo LIKE '%$search%'
                                                OR purchaseOrder.POOnUTC LIKE '%$search%'
                                                OR partner.name LIKE '%$search%'
                                            )
                                            AND purchaseOrder.phaseID =? ", [$phaseIDSelected]);
            return response()->json(['data' => $filteredData]);
        } else {
            // If typePurchaseOrder is not set or search is empty, return an empty response or handle it accordingly
            return response()->json(['error' => []]);
        }
    }


    public function getPurchaseOrders()
    {
        $getDropListPhases = DB::select("SELECT id,name From phase ORDER BY id ASC  ");
        $countPurchaseOrders = DB::table('purchaseOrder')->count();

        return view('layouts.po.purchase-order', [
            'getDropListPhases' => $getDropListPhases,
            'countPurchaseOrders' => $countPurchaseOrders
        ]);
    }
    public function initialLoadPurchaseOrders(Request $request)
    {
        $phaseIDSelected = $request->input('phaseIDSelectionToPurchaseOrder');
        if ($phaseIDSelected) {
            $getPurchaseOrders = DB::select("   SELECT po.*, p.name as partner_name
                                                FROM purchaseOrder po
                                                LEFT JOIN partner p on p.id = po.partnerID
                                                WHERE po.phaseID = ?
                                                ORDER BY po.POOnUTC DESC LIMIT 20 OFFSET 0", [$phaseIDSelected]);
            return response()->json(['data' => $getPurchaseOrders]);
        } else {
            // If phaseIDSelected is not set, return an empty response or handle it accordingly
            return response()->json(['data' => []]);
        }
    }

    public function loadMorePurchaseOrders(Request $request)
    {
        $offset = $request->input('offset');
        $limit = $request->input('limit');
        $phaseIDSelected = $request->input('phaseIDSelectionToPurchaseOrder');
        if ($phaseIDSelected) {
            $getPurchaseOrders = DB::select("   SELECT po.*, p.name as partner_name
                                                FROM purchaseOrder po
                                                LEFT JOIN partner p on p.id = po.partnerID
                                                WHERE po.phaseID = ?
                                                ORDER BY po.POOnUTC DESC LIMIT $limit OFFSET $offset", [$phaseIDSelected]);
            return response()->json(['data' => $getPurchaseOrders]);
        } else {
            // If phaseIDSelected is not set, return an empty response or handle it accordingly
            return response()->json(['data' => []]);
        }
    }
    public function showAddModalAddPO()
    {
        // $getDropListProducts = DB::select("SELECT  p.id, p.code, p.phaseID, q.partnerID
        //                                     From  product p
        //                                     RIGHT JOIN quotationDetail qd on qd.productID = p.id
        //                                     RIGHT JOIN quotation q on q.id = qd.quotationID");
        $getDropListPartners = DB::select(" SELECT DISTINCT p.id, p.name From partner p
                                            RIGHT JOIN quotation q on q.partnerID = p.id
                                            WHERE q.approve = 1
                                            ORDER BY p.latestUpdated DESC ");
        return response()->json([
            'getDropListPartners' => $getDropListPartners,
            // 'getDropListProducts' => $getDropListProducts
        ]);
    }
    public function showAddModalAddPOGetInfo()
    {
        $getDropListProducts = DB::select("SELECT  p.id, p.code, p.phaseID, q.partnerID as partnerID
                                            From  product p
                                            LEFT JOIN quotationDetail qd on qd.productID = p.id
                                            LEFT JOIN quotation q on q.id = qd.quotationID  where q.approve = 1");

        $getQuotationToAddPO = DB::select("SELECT  qd.*, p.name as product_name, q.partnerID as partnerID, p.code as product_code, p.id as product_id, q.phaseID as phaseID
                                            From  quotationDetail qd
                                            LEFT JOIN product p on qd.productID = p.id
                                            LEFT JOIN quotation q on q.id = qd.quotationID
                                            where q.approve = 1
                                            order by q.id

        ");
        return response()->json([
            'getDropListProducts' => $getDropListProducts,
            'getQuotationToAddPO' => $getQuotationToAddPO
        ]);
    }

    public function addPurchaseOrder(Request $request)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        // No similar record found, proceed with adding the new purchaseOrderAdd
        $purchaseOrderAdd = new PurchaseOrder();
        $purchaseOrderAdd->phaseID = $request->input('hiddenPhaseID');
        $purchaseOrderAdd->ATTN = $request->input('ATTNAdd');
        $purchaseOrderAdd->purchaseOrderNo = $request->input('purchaseOrderNoAdd');
        $purchaseOrderAdd->POOnUTC = $request->input('POOnUTCAdd');
        $purchaseOrderAdd->currency = $request->input('currencyAdd');
        $purchaseOrderAdd->partnerID = $request->input('partnerIDPurchaseOrderAdd');
        $purchaseOrderAdd->acceptedBy = NULL;
        $purchaseOrderAdd->acceptedOnUTC = NULL;
        $purchaseOrderAdd->note = $request->input('noteAdd');
        $purchaseOrderAdd->approve = 0;
        $purchaseOrderAdd->createdBy = 'Khoa';
        $purchaseOrderAdd->rate = $request->input('rateAdd');
        $res = $purchaseOrderAdd->save();
        if ($res) {
            // Successful addition
            $purchaseOrderId = $purchaseOrderAdd->id;
            $productIDs        = $request->input('productIDPOAdd');
            $units              = $request->input('unitAdd');
            $quantities         = $request->input('quantityAdd');
            $unitPrices         = $request->input('unitPriceAdd');
            $vats               = $request->input('VATAdd');
            $descriptions       = $request->input('descriptionAdd');
            $deliveryDates              = $request->input('deliveryDateAdd');
            $POnotes              = $request->input('PONoteAdd');



            foreach ($productIDs as $key => $productID) {
                $purchaseOrderDetail = new PurchaseOrderDetail();
                $purchaseOrderDetail->purchaseOrderID = $purchaseOrderId;
                $purchaseOrderDetail->productID = $productID;
                $purchaseOrderDetail->MOQ = $quantities[$key + 1];
                $purchaseOrderDetail->unitPrice = $unitPrices[$key + 1];
                $purchaseOrderDetail->description = $descriptions[$key + 1];
                $purchaseOrderDetail->unit = $units[$key + 1];
                $purchaseOrderDetail->vat = $vats[$key + 1];
                $purchaseOrderDetail->deliveryDate = $deliveryDates[$key + 1];
                $purchaseOrderDetail->note = $POnotes[$key + 1];
                $resDetail = $purchaseOrderDetail->save();
            }
            if ($resDetail) {
                session()->flash('success', 'Thao tác thành công');
                return redirect('/purchase-orders');
            } else {
                // Error during addition
                return redirect()->back()->withErrors(['error' => 'Thao tác thêm chi tiết báo giá sai']);
            }
        } else {
            // Error during addition
            return redirect()->back()->withErrors(['error' => 'Thao tác thêm báo giá sai']);
        }
    }

    public function showEditModal($id)
    {
        $getPurchaseOrderToEdit = DB::select("SELECT * FROM purchaseOrder  WHERE id = $id");
        $getOriginalProductsToEdit = DB::select("SELECT purchaseOrder.id, .purchaseOrder.name,
                                                        phase.name as phase_name, phase.id as phase_id
                                                FROM purchaseOrder
                                                left JOIN phase on phase.id = purchaseOrder.phaseID");

        return response()->json([
            'getPurchaseOrderToEdit' => $getPurchaseOrderToEdit,
            'getOriginalProductsToEdit' => $getOriginalProductsToEdit
        ]);
    }
    public function showInfoModal($id)
    {
        $getPurchaseOrderToInfo = DB::select("  SELECT po.*, p.name as partner_name,
                                                        p.phone as partner_phone,
                                                       p.address as partner_address
                                                FROM purchaseOrder po
                                                LEFT JOIN partner p ON p.id = po.partnerID
                                                WHERE po.id =  $id");
        $getPurchaseOrderDetailToInfo = DB::select("SELECT  pd.*,  p.code AS product_code,
                                                    p.name AS product_name, po.purchaseOrderNo as orderCode,
                                                    pd.deliveryDate as deliveryDate
                                                    FROM  purchaseOrderDetail pd
                                                    LEFT JOIN product p ON  p.id = pd.productID
                                                    LEFT JOIN purchaseOrder po ON  po.id = pd.purchaseOrderID
                                                    where pd.purchaseOrderID =  $id");

        return response()->json([
            'getPurchaseOrderToInfo' => $getPurchaseOrderToInfo,
            'getPurchaseOrderDetailToInfo' => $getPurchaseOrderDetailToInfo

        ]);
    }


    public function editPurchaseOrder(Request $request,  $id) // sửa 01 PurchaseOrder
    {

        $purchaseOrder = PurchaseOrder::find($id);
        $purchaseOrder = new PurchaseOrder();
        $purchaseOrder->phaseID    =  $request->input('phaseIDEdit');
        $purchaseOrder->purchaseOrderCode    = $request->input('purchaseOrderCodeEdit');
        $purchaseOrder->purchaseOrderDate      = $request->input('purchaseOrderDateEdit');
        $purchaseOrder->orderCode    = $request->input('orderCodeEdit');
        $purchaseOrder->validityDate = $request->input('validityDateEdit');
        $purchaseOrder->createdOnUTC = now();
        $purchaseOrder->partnerID    = $request->input('partnerIDEdit');
        $purchaseOrder->latestUpdated = now();

        $res = $purchaseOrder->update();
        if ($res) {
            session()->flash('success', 'Thao tác thành công');
            return redirect('/purchase-orders');
        } else {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        }
    }

    public function deletePurchaseOrder($id) // xoá 01 Type
    {
        try {
            $purchaseOrderDelete = PurchaseOrder::find($id);
            $purchaseOrderDelete->delete();
            session()->flash('success', 'Thao tác thành công');
            return redirect('/purchase-orders');
        } catch (QueryException $e) {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        }
    }


    ////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////
    public function getComparePrices() // load view
    {
        $getDropListPhases = DB::select("SELECT id,name From phase ORDER BY id ASC  ");
        return view('layouts.purchaseOrder.compare-prices', [
            'getDropListPhases' => $getDropListPhases
        ]);
    }

    public function loadComparePrices(Request $request) // load table
    {
        $productIDSelectionToCompare = $request->input('productIDSelectionToCompare');
        if ($productIDSelectionToCompare) {
            $getComparePrices = DB::select("SELECT qd.*, p.name as partner_name,
                                            q.note as note,
                                            q.delivery as delivery,
                                            q.leadTime as leadTime
                                            FROM purchaseOrderDetail qd
                                            LEFT JOIN purchaseOrder q on q.id = qd.purchaseOrderID
                                            LEFT JOIN partner p on p.id = q.partnerID
                                            WHERE qd.productID = ?
                                            ORDER BY q.latestUpdated DESC", [$productIDSelectionToCompare]);
            return response()->json(['data' => $getComparePrices]);
        } else {
            // If phaseIDSelected is not set, return an empty response or handle it accordingly
            return response()->json(['data' => []]);
        }
    }
    public function jsonComparePrices() // load droplist
    {
        $getDropListPhases = DB::select("SELECT id,name From phase ORDER BY id ASC  ");
        $getDropListPartners = DB::select("SELECT id,name From partner ORDER BY id ASC  ");
        $getDropListProducts = DB::select("SELECT DISTINCT  product.phaseID as product_PhaseID,
                                                            product.id as product_id,
                                                            product.code as product_code,
                                                            product.name as product_name
                                                            FROM product
                                                            RIGHT join purchaseOrderDetail ON product.id = purchaseOrderDetail.productID
                                                            ORDER BY product.id DESC   ");

        return response()->json([
            'getDropListPhases' => $getDropListPhases,
            'getDropListProducts' => $getDropListProducts,
            'getDropListPartners' => $getDropListPartners
        ]);
    }
    public function printPO($id)
    {
        $getPurchaseOrderToInfo = DB::select("  SELECT po.*, p.name as partner_name,
                                                    p.phone as partner_phone,
                                                    p.address as partner_address
                                                FROM purchaseOrder po
                                                LEFT JOIN partner p ON p.id = po.partnerID
                                                WHERE po.id =  $id");
        $getPurchaseOrderDetailToInfo = DB::select("SELECT  pd.*,  p.code AS product_code,
                                                    p.name AS product_name, po.purchaseOrderNo as orderCode,
                                                    pd.deliveryDate as deliveryDate
                                                    FROM  purchaseOrderDetail pd
                                                    LEFT JOIN product p ON  p.id = pd.productID
                                                    LEFT JOIN purchaseOrder po ON  po.id = pd.purchaseOrderID
                                                    where pd.purchaseOrderID =  $id");
        return view(
            'layouts.Fpdf.pdf-PO',
            [
                'getPurchaseOrderToInfo' => $getPurchaseOrderToInfo,
                'getPurchaseOrderDetailToInfo' => $getPurchaseOrderDetailToInfo
            ]
        );
    }


    //process purchase order
    public function processPO($id)
    {
        $getPurchaseOrderToProcess = DB::select("  SELECT po.*, p.name as partner_name,
                                                    p.phone as partner_phone,
                                                    p.address as partner_address
                                                FROM purchaseOrder po
                                                LEFT JOIN partner p ON p.id = po.partnerID
                                                WHERE po.id =  $id");
        $getPurchaseOrderDetailToProcress = DB::select("SELECT  pd.*,  p.code AS product_code,
                                                    p.name AS product_name, po.purchaseOrderNo as orderCode,
                                                    pd.deliveryDate as deliveryDate
                                                    FROM  purchaseOrderDetail pd
                                                    LEFT JOIN product p ON  p.id = pd.productID
                                                    LEFT JOIN purchaseOrder po ON  po.id = pd.purchaseOrderID
                                                    where pd.purchaseOrderID =  $id
                                                    ");
        $getProcessPurchase = DB::select("SELECT * FROM `processPurchase` WHERE POID =  $id");

        return view(
            'layouts.po.process-purchase',
            [
                'getPurchaseOrderToProcess' => $getPurchaseOrderToProcess,
                'getProcessPurchase' => $getProcessPurchase,
                'getPurchaseOrderDetailToProcress' => $getPurchaseOrderDetailToProcress,
                'savePOID' => $id
            ]
        );
    }

    public function addPOProcess(Request $request, $materialID) // sửa 01 Group
    {
        $process = new ProcessPurchase();
        $poid = $request->input('hiddenPOIDToAdd');
        $process->POID =  $poid;
        $process->materialID = $materialID;
        $process->quantity = $request->input('quantityAdd');
        $process->date = $request->input('dateAdd');
        $process->note = $request->input('noteAdd');
        $process->approve = 0;

        $res = $process->save();
        if ($res) {
            session()->flash('success', 'Thao tác thành công');
            return redirect('po-process/'.$poid);
        } else {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        }
    }
    public function deletePOProcess($id, $poid) // xoá 01 Type
    {
        try {
            $process = ProcessPurchase::find($id);
            $process->delete();
            session()->flash('success', 'Thao tác thành công');
            return redirect('po-process/'.$poid);
        } catch (QueryException $e) {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        }
    }

}
