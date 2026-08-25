<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
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

        $priceMin = $request->filled('price_min') ? max(0, $request->price_min) : null;
        $priceMax = $request->filled('price_max') ? max(0, $request->price_max) : null;

        $products = Product::visibleTo($user)
            ->search($request->search)
            ->inCategory($request->category)
            ->priceBetween($priceMin, $priceMax)
            ->inStock($request->in_stock)
            ->sortBy($request->sort)
            ->paginate(8);

        $categories = Category::all();

        $graphic = $user->is_admin ? $this->generateGraphic() : null;

        return view('products.index', compact('products', 'categories', 'graphic'));
    }

    public function store(StoreProductRequest $request)
    {
        $this->authorize('create', Product::class);

        $validatedData = $request->validated();

        if ($request->hasFile('photo')) {
            $validatedData['photo'] = $request->file('photo')
                ->store('products', 'public');
        }

        $validatedData['user_id'] = Auth::id();

        Product::create($validatedData);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produto cadastrado com sucesso!');
    }

    public function show(Product $product)
    {
        return view('catalog.product', compact('product'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->authorize('update', $product);

        $validatedData = $request->validated();

        if ($request->hasFile('photo')) {
            $validatedData['photo'] = $request->file('photo')
                ->store('products', 'public');

            if ($product->photo) {
                Storage::disk('public')->delete($product->photo);
            }
        } else {
            $validatedData['photo'] = $product->photo;
        }

        $product->update($validatedData);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produto editado com sucesso!');
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
        $product->forceDelete();
        return redirect()->route('products.index')->with('success', 'Produto destruído com sucesso!');
    }

    private function generateGraphic()
    {
        $chart_options = [
            'chart_title'    => 'Produtos Cadastrados por Mes',
            'model'          => Product::class,
            'chart_type'     => 'bar',
            'report_type'    => 'group_by_date',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'chart_color'    => '0,122,255',
        ];

        return new LaravelChart($chart_options);
    }
}
