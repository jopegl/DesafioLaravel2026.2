<?php

namespace App\Http\Controllers;

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

        //return view('productsindex', $products);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Product::class);

        $dadosValidados = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'nome'        => 'required|string|max:255',
            'foto'        => 'nullable|image|max:2048',
            'descricao'   => 'nullable|string',
            'preco'       => 'required|numeric|min:0',
            'quantidade'  => 'required|integer|min:0',
        ]);

        if ($request->hasFile('foto')) {
            $dadosValidados['foto'] = $request->file('foto')->store('produtos', 'public');
        }

        $dadosValidados['user_id'] = Auth::id();


        Product::create($dadosValidados);
    }


    public function show(Product $produto)
    {
        if ($produto != null)
            return view('product-page', $produto);
        return null;
    }

    public function edit(Product $produto)
    {
        if (!$produto) {
            abort(404);
        }
        //return view('products.edit', compact('produto'));
    }

    public function update(Request $request, Product $produto)
    {

        $this->authorize('update', $produto);

        $dadosValidados = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'nome'        => 'required|string|max:255',
            'foto'        => 'nullable|image|max:2048',
            'descricao'   => 'nullable|string',
            'preco'       => 'required|numeric|min:0',
            'quantidade'  => 'required|integer|min:0',
        ]);

        if ($produto->foto) {
            Storage::disk('public')->delete($produto->foto);
        }

        if ($request->hasFile('foto')) {
            $dadosValidados['foto'] = $request->file('foto')->store('produtos', 'public');
        }

        $produto->update($dadosValidados);
    }

    public function destroy(Product $produto)
    {

        $this->authorize('delete', $produto);

        if ($produto->foto) {
            Storage::disk('public')->delete($produto->foto);
        }
        $produto->delete();
    }
}
