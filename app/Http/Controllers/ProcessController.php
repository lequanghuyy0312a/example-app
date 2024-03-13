<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Process;
use Exception;
use Illuminate\Database\QueryException;
class ProcessController extends Controller
{
    //
    public function getProcesses()
    {
        $getProcesses = DB::select("SELECT p.*, w_import.name as warehouseImportName, w_export.name as warehouseExportName
                                    FROM process p
                                    LEFT JOIN warehouse w_import ON w_import.id = p.warehouseImport
                                    LEFT JOIN warehouse w_export ON w_export.id = p.warehouseExport
                                    ORDER BY p.id DESC");
        $getDropListWarehouses = DB::select("SELECT * FROM warehouse ORDER BY id ASC");
        return view('layouts.warehouse.process', [
            'getProcesses' => $getProcesses,
            'getDropListWarehouses' => $getDropListWarehouses
        ]);
    }
    public function addProcess(Request $request) // thêm 01 Process
    {
        $process = new Process();
        $process->name = $request->input('nameAdd');
        $process->warehouseImport = $request->input('warehouseImportAdd');
        $process->warehouseExport = $request->input('warehouseExportAdd');

        $res = $process->save();
        if ($res) {
            session()->flash('success', 'Thao tác thành công');
            return redirect('/processes');
        } else {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        }
    }
    public function deleteProcess($id) // xoá 01 Process
    {
        try {
            $process = Process::find($id);
            $process->delete();
            session()->flash('success', 'Thao tác thành công');
            return redirect('/processes');
        } catch (QueryException $e) {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        }
    }
    public function editProcess(Request $request,  $id) // sửa 01 Process
    {
        $process = Process::find($id);
        $process->name = $request->input('nameEdit');
        $process->warehouseImport = $request->input('warehouseImportEdit');
        $process->warehouseExport = $request->input('warehouseExportEdit');
        $res = $process->update();
        if ($res) {
            session()->flash('success', 'Thao tác thành công');
            return redirect('/processes');
        } else {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        }
    }
}
