<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

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

}