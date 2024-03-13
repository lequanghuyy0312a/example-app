<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use App\Models\Type;
    use Exception;
    use Illuminate\Database\QueryException;
class TypeController extends Controller
{
    //
    public function getTypes()
    {
        $getTypes = DB::select("SELECT * FROM type ORDER BY id DESC");
        return view('layouts.classification.type', [
            'getTypes' => $getTypes
        ]);
    }
    public function addType(Request $request) // thêm 01 Type
    {
        $type = new Type();
        $type->name = $request->input('nameAdd');
        $res = $type->save();
        if ($res) {
            session()->flash('success', 'Thao tác thành công');
            return redirect('/types');
        } else {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        }
    }
    public function deleteType($id) // xoá 01 Type
    {
        try {
            $type = Type::find($id);
            $type->delete();
            session()->flash('success', 'Thao tác thành công');
            return redirect('/types');
        } catch (QueryException $e) {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        }
    }
    public function editType(Request $request,  $id) // sửa 01 Type
    {
        $type = Type::find($id);
        $type->name      = $request->input('nameEdit');

        $res = $type->update();
        if ($res) {
            session()->flash('success', 'Thao tác thành công');
            return redirect('/types');
        } else {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        }
    }
}
