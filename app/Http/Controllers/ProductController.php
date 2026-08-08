<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $products = Product::visibleTo($user)
            ->withDetails()
            ->paginate(10);

        $categories = Category::all();

        return view('product-list', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Product::class);

        $validatedData = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'nome'        => 'required|string|max:255',
            'foto'        => 'nullable|image|max:2048',
            'descricao'   => 'nullable|string',
            'preco'       => 'required|numeric|min:0',
            'quantidade'  => 'required|integer|min:0',
        ]);

        if ($request->hasFile('foto')) {
            $validatedData['foto'] = $request->file('foto')->store('produtos', 'public');
        }

        $validatedData['user_id'] = Auth::id();


        Product::create($validatedData);
        return redirect()->route('products.index')->with('success', 'Produto cadastrado com sucesso!');
    }


    public function show(Product $product) //pagina de produto 
    {
        if ($product != null)
            return view('product-page', compact('product'));
        return null;
    }


    public function update(Request $request, Product $product)
    {

        $this->authorize('update', $product);

        $validatedData = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'nome'        => 'required|string|max:255',
            'foto'        => 'nullable|image|max:2048',
            'descricao'   => 'nullable|string',
            'preco'       => 'required|numeric|min:0',
            'quantidade'  => 'required|integer|min:0',
        ]);

        if ($request->hasFile('foto')) {
            $validatedData['foto'] = $request->file('foto')->store('produtos', 'public');
            if ($product->foto) {
                Storage::disk('public')->delete($product->foto);
            }
        } else {
            $validatedData['foto'] = $product->foto;
        }

        $product->update($validatedData);
        return redirect()->route('products.index')->with('success', 'Produto editado com sucesso!');
    }

    public function destroy(Product $product)
    {

        $this->authorize('delete', $product);

        if ($product->foto) {
            Storage::disk('public')->delete($product->foto);
        }
        $product->delete();
    }
}
