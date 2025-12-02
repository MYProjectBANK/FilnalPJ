<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class AdminCategoryController extends Controller
{
    public function index() { return response()->json(Category::all()); }
    public function store(Request $request) {
        $request->validate(['name'=>'required|string']);
        $category = Category::create($request->all());
        return response()->json(['message'=>'Category created','category'=>$category]);
    }
    public function show($id) { return response()->json(Category::findOrFail($id)); }
    public function update(Request $request,$id) {
        $category = Category::findOrFail($id);
        $category->update($request->all());
        return response()->json(['message'=>'Category updated','category'=>$category]);
    }
    public function destroy($id) { 
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json(['message'=>'Category deleted']);
    }
}
