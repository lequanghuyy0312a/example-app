<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Warehouse;
use Exception;
use Illuminate\Database\QueryException;
class WarehouseController extends Controller
{
    //
    public function getWarehouses()
    {
        $getWarehouses = DB::select("SELECT * FROM warehouse ORDER BY id DESC");

        return view('layouts.warehouse.warehouse', [
            'getWarehouses' => $getWarehouses
        ]);
    }
    public function addWarehouse(Request $request) // thêm 01 Warehouse
    {
        $warehouse = new Warehouse();
        $warehouse->name = $request->input('nameAdd');
        $res = $warehouse->save();
        if ($res) {
            session()->flash('success', 'Thao tác thành công');
            return redirect('/warehouses');
        } else {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        }
    }
    public function deleteWarehouse($id) // xoá 01 Warehouse
    {
        try {
            $warehouse = Warehouse::find($id);
            $warehouse->delete();
            session()->flash('success', 'Thao tác thành công');
            return redirect('/warehouses');
        } catch (QueryException $e) {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        }
    }
    public function editWarehouse(Request $request,  $id) // sửa 01 Warehouse
    {
        $warehouse = Warehouse::find($id);
        $warehouse->name      = $request->input('nameEdit');

        $res = $warehouse->update();
        if ($res) {
            session()->flash('success', 'Thao tác thành công');
            return redirect('/warehouses');
        } else {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        }
    }
}
