<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryController extends Controller
{
    public function index()
    {
        return "In ProductController";
    }

    // Extragerea tuturor categoriilor si returnarea acestora
    public function getAll(Request $request)
    {

        return Category::all();
    }

    // Create, update, delete
    function addCategory(Request $request)
    {

        return Category::create($request->all());
    }

    function editCategory(Request $request, $categoryId)
    {
        try {
            $category = Category::findOrFail($categoryId);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Category not found.'
            ], 403);
        }

        $jsonData = $request->all();
        $name = $jsonData['name'];
        $category->update(['name' => $name]);

        return response()->json(['message' => 'Category updated successfully.']);
    }

    function deleteCategory(Request $request, $categoryId)
    {

        try {
            $category = Category::findOrFail($categoryId);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Category not found.'
            ], 403);
        }

        $category->delete();

        return response()->json(['message' => 'Category deleted successfully.']);
    }
}