<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Group;
use Exception;
use Illuminate\Database\QueryException;

use Illuminate\Http\Request;

class GroupController extends Controller
{
    //
    public function getGroups()
    {
        $getGroups = DB::select("SELECT * FROM groupProduct  ORDER BY id DESC");
        return view('layouts.classification.group', [
            'getGroups' => $getGroups
        ]);
    }
    public function addGroup(Request $request) // thêm 01 Group
    {
        $group = new Group();
        $group->name = $request->input('nameAdd');

        $res = $group->save();
        if ($res) {
            session()->flash('success', 'Thao tác thành công');
            return redirect('/groups');
        } else {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        }
    }
    public function deleteGroup($id) // xoá 01 Group
    {
        $group = Group::find($id);
        $group->delete();
        session()->flash('success', 'Thao tác thành công');
        return redirect('/groups');
    }
    public function editGroup(Request $request,  $id) // sửa 01 Group
    {
        $group = Group::find($id);
        $group->name      = $request->input('nameEdit');

        $res = $group->update();
        if ($res) {
            session()->flash('success', 'Thao tác thành công');
            return redirect('/groups');
        } else {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        }
    }
}
