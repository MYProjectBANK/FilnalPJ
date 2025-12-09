<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Dorm; // ป้องกันการลบ Category ที่ถูกใช้งานอยู่

class AdminCategoryController extends Controller
{
    // GET /admin/categories
    public function index()
    {
        return response()->json([
            'status' => true,
            'data'   => Category::all()
        ]);
    }

    // POST /admin/categories
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category = Category::create($validated);

        return response()->json([
            'status'   => true,
            'message'  => 'Category created successfully',
            'category' => $category
        ], 201);
    }

    // GET /admin/categories/{id}
    public function show($id)
    {
        return response()->json([
            'status' => true,
            'data'   => Category::findOrFail($id)
        ]);
    }

    // PUT /admin/categories/{id}
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category = Category::findOrFail($id);
        $category->update($validated);

        return response()->json([
            'status'   => true,
            'message'  => 'Category updated successfully',
            'category' => $category
        ]);
    }

    // DELETE /admin/categories/{id}
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Prevent deleting category while used
        if ($category->dorms()->count() > 0) {
            return response()->json([
                'status'  => false,
                'message' => 'Cannot delete this category. It is assigned to one or more dorms.'
            ], 400);
        }

        $category->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Category deleted successfully'
        ]);
    }
}
