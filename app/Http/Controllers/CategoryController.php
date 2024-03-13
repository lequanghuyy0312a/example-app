<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use Exception;
use Illuminate\Database\QueryException;

class CategoryController extends Controller
{
    //
    public function getCategories()
    {
        $getCategories = DB::select("SELECT * FROM category ORDER BY id DESC");
        return view('layouts.classification.category', [
            'getCategories' => $getCategories
        ]);
    }
    public function addCategory(Request $request) // thêm 01 Category
    {
        $category = new Category();
        $category->name = $request->input('nameAdd');
        $res = $category->save();
        if ($res) {
            session()->flash('success', 'Thao tác thành công');
            return redirect('/categories');
        } else {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        }
    }
    public function deleteCategory($id) // xoá 01 Category
    {
        try {
            $category = Category::find($id);
            $category->delete();
            session()->flash('success', 'Thao tác thành công');
            return redirect('/categories');
        } catch (QueryException $e) {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        }
    }
    public function editCategory(Request $request,  $id) // sửa 01 Category
    {
        $category = Category::find($id);
        $category->name      = $request->input('nameEdit');
        $res = $category->update();
        if ($res) {
            session()->flash('success', 'Thao tác thành công');
            return redirect('/categories');
        } else {
            return redirect()->back()->withErrors(['error' => 'Kiểm tra lại thao tác']);
        }
    }
}
