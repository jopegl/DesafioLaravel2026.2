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

        $priceMin = $request->filled('price_min') ? max(0, $request->price_min) : null;
        $priceMax = $request->filled('price_max') ? max(0, $request->price_max) : null;


        $products = Product::query()
            ->when(auth()->check(), fn($q) => $q->where('user_id', '!=', auth()->id()))
            ->search($request->search)
            ->inCategory($request->category)
            ->priceBetween($priceMin, $priceMax)
            ->inStock($request->in_stock)
            ->sortBy($request->sort)
            ->paginate(12);

        $categories = Category::all();

        $heroSlides = [
            [
                'image' => asset('images/hero-iphone.jpeg'),
                'eyebrow' => 'Lançamento',
                'title' => 'A nova geração chegou',
                'subtitle' => 'Performance e design em outro nível.',
            ],
            [
                'image' => asset('images/hero-2.jpeg'),
                'eyebrow' => 'Oferta especial',
                'title' => 'Até 30% OFF',
                'subtitle' => 'Só até o fim da semana.',
            ],
            [
                'image' => asset('images/hero-3.jpeg'),
                'eyebrow' => 'Novidade',
                'title' => 'Acessórios em destaque',
                'subtitle' => 'Combine estilo e funcionalidade.',
            ],
        ];


        return view('catalog.home', compact('products', 'categories', 'heroSlides'));
    }
}
