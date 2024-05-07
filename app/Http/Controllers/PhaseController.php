<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Phase;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class PhaseController extends Controller
{
    public function getPhases()
    {
        $getPhases = DB::select("SELECT * FROM phase ORDER BY id DESC");
        return view('layouts.classification.phase', [
            'getPhases' => $getPhases
        ]);
    }
    public function addPhase(Request $request) // thêm 01 Phase
    {
        $phase = new Phase();
        $phase->name = $request->input('nameAdd');
        $phase->USDtoVND = $request->input('usdToVNDAdd') == '' ? null :str_replace(',', '',$request->input('usdToVNDAdd'));
        $phase->USDtoJPY = $request->input('usdToJPYAdd') == '' ? null :str_replace(',', '',$request->input('usdToJPYAdd'));
        $phase->JPYtoVND = $request->input('jpyToVNDAdd') == '' ? null :str_replace(',', '',$request->input('jpyToVNDAdd'));
        $phase->Al =  $request->input('AlAdd') == '' ? null : str_replace(',', '',$request->input('AlAdd'));

        $res = $phase->save();
        if ($res) {
            session()->flash('success', 'Thao tác thành công');
            return redirect('/phases');
        } else {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        }
    }
    public function deletePhase($id) // xoá 01 Phase
    {
        try {
            $phase = Phase::find($id);
            $phase->delete();
            session()->flash('success', 'Thao tác thành công');
            return redirect('/phases');
        } catch (QueryException $e) {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        }
    }
    public function editPhase(Request $request,  $id) // sửa 01 Phase
    {
        $phase = Phase::find($id);
        $phase->name = $request->input('nameEdit');
        $phase->USDtoVND = $request->input('usdToVNDEdit') == '' ? null :str_replace(',', '',$request->input('usdToVNDEdit'));
        $phase->USDtoJPY = $request->input('usdToJPYEdit') == '' ? null :str_replace(',', '',$request->input('usdToJPYEdit'));
        $phase->JPYtoVND = $request->input('jpyToVNDEdit') == '' ? null :str_replace(',', '',$request->input('jpyToVNDEdit'));
        $phase->Al =  $request->input('AlEdit') == '' ? null : str_replace(',', '',$request->input('AlEdit'));
        $res = $phase->update();
        if ($res) {
            session()->flash('success', 'Thao tác thành công');
            return redirect('/phases');
        } else {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        }
    }
}
