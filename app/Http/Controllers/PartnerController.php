<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PartnerController extends Controller
{
    public function searchPartners(Request $request)
    {
        $search = $request->input('search');
        $typePartner = $request->input('typePartner');
        if ($typePartner && $search) {
            $filteredData = DB::select("SELECT * FROM partner
                                        WHERE
                                            (partner.name LIKE '%$search%'
                                            OR partner.tax LIKE '%$search%'
                                            OR partner.address LIKE '%$search%'
                                            OR partner.phone LIKE '%$search%'
                                            OR partner.email LIKE '%$search%'
                                            OR partner.note LIKE '%$search%')
                                            AND partner.type = ?", [$typePartner]);
            return response()->json(['data' => $filteredData]);
        } else {
            // If typePartner is not set or search is empty, return an empty response or handle it accordingly
            return response()->json(['error' => []]);
        }
    }


    public function getPartners()
    {

        $countPartners = DB::table('partner')->count();
        return view('layouts.partner.partners', [
            'countPartners' => $countPartners
        ]);
    }
    public function initialLoadPartners(Request $request)
    {
        $typePartner = $request->input('typePartner');
        if ($typePartner) {
            $getPartners = DB::select("SELECT * FROM partner WHERE partner.type LIKE ?
            ORDER BY partner.latestUpdated DESC LIMIT 30 OFFSET 0",  ['%' . $typePartner . '%']);
            return response()->json(['data' => $getPartners]);
        } else {
            // If typePartner is not set, return an empty response or handle it accordingly
            return response()->json(['data' => []]);
        }
    }

    public function loadMorePartners(Request $request)
    {
        $offset = $request->input('offset');
        $limit = $request->input('limit');

        $typePartner = $request->input('typePartner');
        if ($typePartner) {
            $getPartners = DB::select("SELECT * FROM partner WHERE partner.type LIKE ?
                           ORDER BY partner.latestUpdated DESC LIMIT $limit OFFSET $offset",  ['%' . $typePartner . '%']);
            return response()->json(['data' => $getPartners]);
        } else {
            // If typePartner is not set, return an empty response or handle it accordingly
            return response()->json(['data' => []]);
        }
    }


    public function addPartner(Request $request) // thêm 01 Partner
    {
        // Get input values
        $name = $request->input('nameAdd');
        $tax = $request->input('taxAdd');
        $address = $request->input('addressAdd');
        $email = $request->input('emailAdd');
        $phone = $request->input('phoneAdd');
        $type = $request->input('typeAdd');
        $note = $request->input('noteAdd');
        // Check if a similar record already exists
        $existingRecord = partner::where('tax', $tax)
            ->where('name', $name)
            ->first();
        if ($existingRecord) {
            // Similar record exists, handle accordingly (e.g., show an error message)
            return redirect()->back()->withErrors(['error' => 'Dữ liệu trùng']);
        }
        // No similar record found, proceed with adding the new partner
        $partner = new Partner();
        $partner->name = $name;
        $partner->tax = $tax;
        $partner->address = $address;
        $partner->email = $email;
        $partner->phone = $phone;
        $partner->type = $type;
        $partner->note = $note;
        $partner->latestUpdated      = now();
        $res = $partner->save();
        if ($res) {
            // Successful addition
            session()->flash('success', 'Thao tác thành công');
            return redirect('/partners');
        } else {
            // Error during addition
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        }
    }
    public function deletePartner($id) // xoá 01 Partner
    {
        try {
            $partner = Partner::find($id);
            $partner->delete();
            session()->flash('success', 'Thao tác thành công');
            return redirect('/partners');
        } catch (QueryException $e) {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        }
    }
    public function showModal($id)
    {
        $getPartnerToEdit = DB::select("SELECT * FROM partner  WHERE id = $id");

        return response()->json([
            'getPartnerToEdit' => $getPartnerToEdit
        ]);
    }


    public function editPartner(Request $request,  $id) // sửa 01 Partner
    {
        $name = $request->input('nameEdit');
        $tax = $request->input('taxEdit');
        $address = $request->input('addressEdit');
        $email = $request->input('emailEdit');
        $phone = $request->input('phoneEdit');
        $type = $request->input('typeEdit');
        $note = $request->input('noteEdit');

        $partner = Partner::find($id);
        // Check if a similar record already exists
        if ($partner->name != $name || $partner->type != $type) {
            $existingRecord = partner::where('tax', $tax)->where('name', $name)->first();
            if ($existingRecord) {
                // Similar record exists, handle accordingly (e.g., show an error message)
                return redirect()->back()->withErrors(['error' => 'Dữ liệu trùng']);
            }
        }
        $partner->name = $name;
        $partner->tax = $tax;
        $partner->address = $address;
        $partner->email = $email;
        $partner->phone = $phone;
        $partner->type = $type;
        $partner->note = $note;
        $partner->latestUpdated      = now();

        $res = $partner->update();
        if ($res) {
            session()->flash('success', 'Thao tác thành công');
            return redirect('/partners');
        } else {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        }
    }



    public function getPartner($id)
    {
        $getDropListPhases = DB::select("SELECT id,name From phase ORDER BY id ASC  ");
        $saveID = $id;

        return view('layouts.partner.detail', [
            'getDropListPhases' => $getDropListPhases,
            'saveID' => $saveID
        ]);
    }

    public function jsonPartnerInfo($id)
    {
        $getPartner = DB::select("SELECT id, name, address, tax,type, note FROM partner Where id = $id");
        $getPOs = DB::select("SELECT pd.*, p.code as product_code, po.POOnUTC as po_createdUTC, po.approve as approve
                            FROM purchaseOrderDetail pd
                            LEFT JOIN purchaseOrder po ON po.id = pd.purchaseOrderID
                            LEFT JOIN product p ON p.id = pd.productID
                            WHERE po.partnerID = ?", [$id]);
        $getQuotations = DB::select("SELECT qd.*, p.code as product_code, q.quotationNo as quotationNo, q.approve as approve
                            FROM quotationDetail qd
                            LEFT JOIN quotation q ON q.id = qd.quotationID
                            LEFT JOIN product p ON p.id = qd.productID
                            WHERE q.partnerID = ?", [$id]);
        $getProductsBuy = DB::select("SELECT pd.*, p.code as product_code FROM productDetail pd
                                    LEFT JOIN product p ON pd.productID = p.id
                                    WHERE pd.partnerID = ?", [$id]);

        $numProductsBuy = count($getProductsBuy);
        $numQuotations = count($getQuotations);
        $numPOs = count($getPOs);


        return response()->json([
            'numPOs' => $numPOs,
            'numQuotations' => $numQuotations,
            'numProductsBuy' => $numProductsBuy,
            'getPartner' => $getPartner
        ]);
    }
    public function jsonPartnerPO(Request $request)
    {
        $selectedPhaseID = $request->selectedPhaseID;
        $selectedPartnerID = $request->selectedPartnerID;
        $getPOs = DB::select("SELECT pd.*, p.code as product_code, po.POOnUTC as po_createdUTC, po.approve as approve
                            FROM purchaseOrderDetail pd
                            LEFT JOIN purchaseOrder po ON po.id = pd.purchaseOrderID
                            LEFT JOIN product p ON p.id = pd.productID
                            WHERE po.partnerID = $selectedPartnerID AND po.phaseID = $selectedPhaseID");

        return response()->json(['data' => $getPOs]);
    }
    public function jsonPartnerQuotation(Request $request)
    {
        $selectedPhaseID = $request->selectedPhaseID;
        $selectedPartnerID = $request->selectedPartnerID;

        $getQuotations = DB::select("SELECT qd.*, p.code as product_code, q.quotationNo as quotationNo, q.approve as approve
                            FROM quotationDetail qd
                            LEFT JOIN quotation q ON q.id = qd.quotationID
                            LEFT JOIN product p ON p.id = qd.productID
                            WHERE q.partnerID = $selectedPartnerID" );
        return response()->json(['data' => $getQuotations]);
    }

    public function jsonPartnerProdutBuy(Request $request)
    {
        $selectedPhaseID = $request->selectedPhaseID;
        $selectedPartnerID = $request->selectedPartnerID;
        $getProductsBuy = DB::select("SELECT pd.*, p.code as product_code FROM productDetail pd
                                    LEFT JOIN product p ON pd.productID = p.id
                                    WHERE pd.partnerID = $selectedPartnerID and p.phaseID = $selectedPhaseID");
        return response()->json(['data' => $getProductsBuy]);
    }
}
