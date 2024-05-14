<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Stock;
use Exception;
use Illuminate\Database\QueryException;

use Illuminate\Http\Request;

class StockController extends Controller
{
    //
    public function getStocks()
    {
        $getStocks = DB::select("SELECT stock.*, p.name AS partner_name, po.purchaseOrderNo as PONo,
                                        product.name as product_name, product.code as product_code
                                FROM stock
                                LEFT JOIN purchaseOrder po on po.id = stock.POID
                                LEFT JOIN partner p on p.id = po.partnerID
                                LEFT JOIN product on product.id = stock.productID
                                ORDER BY id DESC");
        return view('layouts.warehouse.import-export', [
            'getStocks' => $getStocks
        ]);
    }
    public function addStock(Request $request) // thêm 01 Stock
    {
        $stock = new Stock();
        $stock->name = $request->input('nameAdd');

        $res = $stock->save();
        if ($res) {
            session()->flash('success', 'Thao tác thành công');
            return redirect('/import-export');
        } else {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        }
    }
    public function deleteStock($id) // xoá 01 Stock
    {
        $stock = Stock::find($id);
        $stock->delete();
        session()->flash('success', 'Thao tác thành công');
        return redirect('/groups');
    }
    public function editStock(Request $request,  $id) // sửa 01 Stock
    {
        $stock = Stock::find($id);
        $stock->name      = $request->input('nameEdit');

        $res = $stock->update();
        if ($res) {
            session()->flash('success', 'Thao tác thành công');
            return redirect('/import-export');
        } else {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        }
    }
}
