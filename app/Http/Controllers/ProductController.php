<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $produto = Product::query()->porId($id);
        if ($produto != null)
            return view('product-page', $produto);
        return null;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $produto = Product::query()->porId($id);
        if (!$produto) {
            abort(404);
        }
        //return view('products.edit', compact('produto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $produto = Product::query()->porId($id);

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

        $produto->update($dadosValidados);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $produto = Product::query()->porId($id);
        $produto->delete();
    }
}
