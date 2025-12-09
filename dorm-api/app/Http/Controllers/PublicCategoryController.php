<?php

namespace App\Http\Controllers;

use App\Models\Category;

class PublicCategoryController extends Controller
{
    public function index()
    {
        return response()->json(Category::all());
    }
}

