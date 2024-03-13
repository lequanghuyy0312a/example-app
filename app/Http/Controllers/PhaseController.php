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
        $phase->name      = $request->input('nameEdit');
        $res = $phase->update();
        if ($res) {
            session()->flash('success', 'Thao tác thành công');
            return redirect('/phases');
        } else {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        }
    }
}
