<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $produtos = Product::query()
            ->buscar($request->busca)
            ->daCategoria($request->categoria)
            ->paginate(12);

        $categorias = Category::all();

        return view('home', compact('produtos', 'categorias'));
    }
}
