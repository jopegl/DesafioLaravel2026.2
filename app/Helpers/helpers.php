<?php

use App\Models\Product;

if (! function_exists('formatarPreco')) {

    function formatarPreco(float $valor): string
    {
        return 'R$' . number_format($valor, 2, ',', '.');
    }
}

if (! function_exists('produtoEmEstoque')) {
    function produtoEmEstoque(Product $produto): bool
    {
        return $produto->quantidade > 0;
    }
}

if (! function_exists('urlFotoProduto')) {
    function urlFotoProduto(?string $foto): string
    {
        return file_exists($foto)
            ? asset('storage/' . $foto)
            : asset('images/placeholder-produto.png');
    }
}
