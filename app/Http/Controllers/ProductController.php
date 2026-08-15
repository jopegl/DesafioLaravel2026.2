<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $products = Product::visibleTo($user)
            ->search($request->search)
            ->inCategory($request->category)
            ->priceBetween($request->price_min, $request->price_max)
            ->inStock($request->in_stock)
            ->sortBy($request->sort)
            ->paginate(8);

        $categories = Category::all();
        $graphic = $this->generateGraphic();

        return view('products.index', compact('products', 'categories', 'graphic'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Product::class);

        $validatedData = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'photo'       => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'quantity'    => 'required|integer|min:0',
        ]);

        if ($request->hasFile('photo')) {
            $validatedData['photo'] = $request->file('photo')->store('products', 'public');
        }

        $validatedData['user_id'] = Auth::id();


        Product::create($validatedData);
        return redirect()->route('products.index')->with('success', 'Produto cadastrado com sucesso!');
    }


    public function show(Product $product) //pagina de produto 
    {
        if ($product != null)
            return view('catalog.product', compact('product'));
        return null;
    }


    public function update(Request $request, Product $product)
    {

        $this->authorize('update', $product);

        $validatedData = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'photo'       => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'quantity'    => 'required|integer|min:0',
        ]);

        if ($request->hasFile('photo')) {
            $validatedData['photo'] = $request->file('photo')->store('products', 'public');
            if ($product->photo) {
                Storage::disk('public')->delete($product->photo);
            }
        } else {
            $validatedData['photo'] = $product->photo;
        }

        $product->update($validatedData);
        return redirect()->route('products.index')->with('success', 'Produto editado com sucesso!');
    }

    public function delete(Product $product)
    {

        $this->authorize('delete', $product);

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produto deletado com sucesso!');
    }

    public function forceDestroy(Product $product)
    {
        $this->authorize('delete', $product);

        if ($product->photo) {
            Storage::disk('public')->delete($product->photo);
        }
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produto destruído com sucesso!');
    }

    private function generateGraphic()
    {
        $user = Auth::user();
        $this->authorize('generateGraphic', Product::class);

        $chart_options = [
            'chart_title'       => 'Produtos Cadastros por Mes',
            'model'              => Product::class,
            'chart_type'         => 'bar',
            'report_type'        => 'group_by_date',
            'group_by_field'     => 'created_at',
            'group_by_period'    => 'month',
            'chart_clor'         => '0,122,255',
        ];

        $chart = new LaravelChart($chart_options);
        return $chart;
    }
}
