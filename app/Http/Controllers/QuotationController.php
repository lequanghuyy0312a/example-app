<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use App\Models\QuotationDetail;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuotationController extends Controller
{
    public function searchQuotations(Request $request)
    {
        $search = $request->input('searchInput');
        $phaseIDSelected = $request->input('phaseIDSelectionToQuotation');
        if ($phaseIDSelected && $search) {
            $filteredData = DB::select("SELECT quotation.*, partner.name as partner_name, phase.name as phase_name
                                        FROM quotation
                                        LEFT JOIN phase ON phase.id = quotation.phaseID
                                        LEFT JOIN partner ON partner.id = quotation.partnerID
                                        WHERE
                                        (quotation.quotationNo LIKE '%$search%'
                                            OR quotation.quotationDate LIKE '%$search%'
                                            OR quotation.validityDate LIKE '%$search%'
                                            OR quotation.createdOnUTC LIKE '%$search%'
                                            OR partner.name  LIKE '%$search%'
                                            AND quotation.phaseID = ?", [$phaseIDSelected]);
            return response()->json(['data' => $filteredData]);
        } else {
            // If typeQuotation is not set or search is empty, return an empty response or handle it accordingly
            return response()->json(['error' => []]);
        }
    }


    public function getQuotations()
    {
        $getDropListPhases = DB::select("SELECT id,name From phase ORDER BY id ASC  ");
        $getDropListPartners = DB::select("SELECT id,name From partner ORDER BY id ASC  ");
        $countQuotations = DB::table('quotation')->count();

        return view('layouts.quotation.quotations', [
            'getDropListPhases' => $getDropListPhases,
            'countQuotations' => $countQuotations,
            'getDropListPartners' => $getDropListPartners
        ]);
    }
    public function initialLoadQuotations(Request $request)
    {
        $phaseIDSelected = $request->input('phaseIDSelectionToQuotation');
        if ($phaseIDSelected) {
            $getQuotations = DB::select("SELECT quotation.*, partner.name as partner_name, phase.name as phase_name
                                        FROM quotation
                                        LEFT JOIN phase on phase.id = quotation.phaseID
                                        LEFT JOIN partner on partner.id = quotation.partnerID
                                        WHERE quotation.phaseID = ?
                                        ORDER BY quotation.latestUpdated DESC LIMIT 20 OFFSET 0", [$phaseIDSelected]);
            return response()->json(['data' => $getQuotations]);
        } else {
            // If phaseIDSelected is not set, return an empty response or handle it accordingly
            return response()->json(['data' => []]);
        }
    }

    public function loadMoreQuotations(Request $request)
    {
        $offset = $request->input('offset');
        $limit = $request->input('limit');
        $phaseIDSelected = $request->input('phaseIDSelectionToQuotation');
        if ($phaseIDSelected) {
            $getQuotations = DB::select("SELECT quotation.*, partner.name as partner_name, phase.name as phase_name
                                        FROM quotation
                                        LEFT JOIN phase on phase.id = quotation.phaseID
                                        LEFT JOIN partner on partner.id = quotation.partnerID
                                        WHERE quotation.phaseID = ?
                                        ORDER BY quotation.latestUpdated  DESC LIMIT $limit OFFSET $offset", [$phaseIDSelected]);
            return response()->json(['data' => $getQuotations]);
        } else {
            // If phaseIDSelected is not set, return an empty response or handle it accordingly
            return response()->json(['data' => []]);
        }
    }
    public function showAddModal()
    {
        $getDropListProducts = DB::select("SELECT id, name, code, phaseID From product  ");
        $getDropListPartners = DB::select("SELECT id, name From partner ORDER BY id ASC  ");

        return response()->json([
            'getDropListPartners' => $getDropListPartners,
            'getDropListProducts' => $getDropListProducts
        ]);
    }

    public function addQuotation(Request $request)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        // No similar record found, proceed with adding the new quotationAdd
        $quotationAdd = new Quotation();
        $quotationAdd->phaseID = $request->input('hiddenPhaseID');
        $quotationAdd->quotationNo = $request->input('quotationNoAdd');
        $quotationAdd->quotationDate = $request->input('quotationDateAdd');
        $quotationAdd->validityDate = $request->input('validityDateAdd');
        $quotationAdd->partnerID = $request->input('partnerIDQuotationAdd');
        $quotationAdd->exchangeRate = $request->input('exchangeRateAdd');
        $quotationAdd->contact = $request->input('contactAdd');
        $quotationAdd->payment = $request->input('termPaymentAdd');
        $quotationAdd->delivery = $request->input('placeDeliveryAdd');
        $quotationAdd->savedBy = $request->input('savedByAdd');
        $quotationAdd->receivedFrom = $request->input('receivedFromAdd');
        $quotationAdd->leadTime = $request->input('leadTimeAdd');
        $quotationAdd->note = $request->input('noteAdd');
        $quotationAdd->createdOnUTC      = now();
        $quotationAdd->latestUpdated      = now();
        $quotationAdd->approve      = 0;
        $res = $quotationAdd->save();
        if ($res) {
            // Successful addition
            $quotationId = $quotationAdd->id;
            $productlIDs = $request->input('productIDAdd');

            // Kiểm tra xem $productlIDs có giá trị không
            if (!empty($productlIDs)) {
                // Tiếp tục thực hiện các thao tác nếu $productlIDs có giá trị
                $orderProductNames = $request->input('orderProductNameAdd');
                $orderCodes = $request->input('orderCodeAdd');
                $descriptions = $request->input('descriptionAdd');
                $units = $request->input('unitAdd');
                $quantities = $request->input('quantityAdd');
                $unitPrices = $request->input('unitPriceAdd');
                $vat = $request->input('VATAdd');

                foreach ($productlIDs as $key => $productlID) {
                    $quotationDetail = new QuotationDetail();
                    $quotationDetail->quotationID = $quotationId;
                    $quotationDetail->productID = $productlID;
                    $quotationDetail->orderProductName = $orderProductNames[$key + 1];
                    $quotationDetail->orderCode = $orderCodes[$key + 1];
                    $quotationDetail->description = $descriptions[$key + 1];
                    $quotationDetail->unit = $units[$key + 1];
                    $quotationDetail->quantity = $quantities[$key + 1];
                    $quotationDetail->unitPrice = $unitPrices[$key + 1];
                    $quotationDetail->vat = $vat[$key + 1];
                    $resDetail = $quotationDetail->save();
                }

                if ($resDetail) {
                    session()->flash('success', 'Thao tác thành công');
                    return redirect('/quotations');
                } else {
                    // Error during addition
                    return redirect()->back()->withErrors(['error' => 'Thao tác thêm chi tiết báo giá sai']);
                }
            } else {
                // Nếu $productlIDs không có giá trị, trở về trang trước
                return redirect()->back();
            }
        } else {
            // Error during addition
            return redirect()->back()->withErrors(['error' => 'Thao tác thêm báo giá sai']);
        }
    }

    public function showModal($id)
    {
        $getQuotationToEdit = DB::select("SELECT * FROM quotation  WHERE id = $id");
        $getOriginalProductsToEdit = DB::select("SELECT quotation.id, .quotation.name,
                                                        phase.name as phase_name, phase.id as phase_id
                                                FROM quotation
                                                left JOIN phase on phase.id = quotation.phaseID");

        return response()->json([
            'getQuotationToEdit' => $getQuotationToEdit,
            'getOriginalProductsToEdit' => $getOriginalProductsToEdit
        ]);
    }
    public function showInfoModal($id)
    {
        $getQuotationToInfo = DB::select("SELECT q.*, p.name as partner_name, p.phone as partner_phone, p.address as partner_address
                                            FROM quotation q
                                            LEFT JOIN partner p ON p.id = q.partnerID
                                            WHERE q.id = $id");
        $getQuotationDetailToInfo = DB::select("SELECT  qd.*,  p.code AS product_code
                                                FROM  quotationDetail qd
                                                LEFT JOIN product p ON  p.id = qd.productID
                                                    where qd.quotationID = $id");

        return response()->json([
            'getQuotationToInfo' => $getQuotationToInfo,
            'getQuotationDetailToInfo' => $getQuotationDetailToInfo

        ]);
    }

    public function approvePO($id)
    {
        $quotation = Quotation::findOrFail($id);
        if ($quotation->approve == 0) {
            $quotation->approve = 1;
        } else {
            $quotation->approve = 0;
        }
        $quotation->update();
        session()->flash('success', 'Thao tác thành công');
        return response()->json(['data' => 'Thao tác thành công']);
    }


    public function editQuotation(Request $request,  $id) // sửa 01 Quotation
    {
        $quotation = Quotation::find($id);
        $quotation = new Quotation();
        $quotation->phaseID    =  $request->input('phaseIDEdit');
        $quotation->quotationCode    = $request->input('quotationCodeEdit');
        $quotation->quotationDate      = $request->input('quotationDateEdit');
        $quotation->orderCode    = $request->input('orderCodeEdit');
        $quotation->validityDate = $request->input('validityDateEdit');
        $quotation->createdOnUTC = now();
        $quotation->partnerID    = $request->input('partnerIDEdit');
        $quotation->latestUpdated = now();

        $res = $quotation->update();
        if ($res) {
            session()->flash('success', 'Thao tác thành công');
            return redirect('/quotations');
        } else {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        }
    }

    public function deleteQuotation($id) // xoá 01 Type
    {
        $quotationDelete = Quotation::find($id);
        $quotationDelete->delete();
        session()->flash('success', 'Thao tác thành công');
        return response()->json(['data' => 'Thao tác thành công']);
    }


    ////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////
    public function getComparePrices() // load view
    {
        $getDropListPhases = DB::select("SELECT id,name From phase ORDER BY id ASC  ");
        return view('layouts.quotation.compare-prices', [
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
                                            FROM quotationDetail qd
                                            LEFT JOIN quotation q on q.id = qd.quotationID
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
                                                            RIGHT join quotationDetail ON product.id = quotationDetail.productID
                                                            ORDER BY product.id DESC   ");

        return response()->json([
            'getDropListPhases' => $getDropListPhases,
            'getDropListProducts' => $getDropListProducts,
            'getDropListPartners' => $getDropListPartners
        ]);
    }
}
