<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{

    public function index(Request $request)
    {


        $products = Product::query()
            ->search($request->search)
            ->inCategory($request->category)
            ->priceBetween($request->price_min, $request->price_max)
            ->inStock($request->in_stock)
            ->sortBy($request->sort)
            ->paginate(12);

        $categories = Category::all();

        return view('home', compact('products', 'categories'));
    }
}
