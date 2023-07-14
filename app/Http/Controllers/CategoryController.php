<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return "In ProductController";
    }

    // extragerea tuturor categoriilor si returnarea acestora
    public function getAll(Request $request)
    {

        return Category::all();
    }
}
