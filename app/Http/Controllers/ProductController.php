<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();
        
        if ($request->has('language') && $request->language != '') {
            $query->where('language', $request->language);
        }
        
        if ($request->has('level') && $request->level != '') {
            $query->where('level', $request->level);
        }

        if ($request->has('min_price') && $request->min_price != '') {
            $query->where('price', '>=', $request->min_price);
        }
        
        if ($request->has('max_price') && $request->max_price != '') {
            $query->where('price', '<=', $request->max_price);
        }
 
        $sort = $request->get('sort', 'name');
        $order = $request->get('order', 'asc');
        $query->orderBy($sort, $order);
        
        $products = $query->get();
 
        $languages = Product::distinct()->pluck('language');
        $levels = Product::distinct()->pluck('level');
        
        return view('products.index', compact('products', 'languages', 'levels'));
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
}
