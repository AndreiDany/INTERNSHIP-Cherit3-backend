<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductController extends Controller
{
    public function index()
    {
        return "In ProductController";
    }

    // extragerea tuturor produselor si returnarea acestora
    public function getAll(Request $request)
    {

        return Product::all();
    }

    // extragerea produselor dintr-o anumita categorie
    public function getProducts($categoryId)
    {

        return Product::where('category_id', 'like', '%' . $categoryId . '%')->get();
    }

    // extragerea produselor dintr-o anumita categorie
    public function getProduct($productId)
    {

        return Product::where('id', $productId)->get();
    }


    // Create, update, delete
    function addProduct(Request $request)
    {

        return Product::create($request->all());
    }

    function editProduct(Request $request, $productId)
    {
        try {
            $product = Product::findOrFail($productId);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Product not found.'
            ], 403);
        }

        $product->update($request->all());

        return response()->json(['message' => 'Product updated successfully.']);
    }

    function deleteProduct(Request $request, $productId)
    {

        try {
            $product = Product::findOrFail($productId);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Product not found.'
            ], 403);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully.']);
    }

}