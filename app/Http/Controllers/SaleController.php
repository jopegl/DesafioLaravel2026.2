<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $sales = Sale::asSeller($user)
            ->withDetails()
            ->periodo($request->input('inicio'), $request->input('fim'))
            ->orderByDesc('data_compra')
            ->paginate(10);

        //return view()
    }

    public function show(string $id)
    {
        $user = Auth::user();
        $venda = Sale::asSeller($user)
            ->withDetails()
            ->find($id);

        if (!$venda) {
            abort(404);
        }

        //return view
    }

    public function gerarRelatiorioPDF()
    {
        //
    }

    public function  gerarRelatorioXlsx()
    {
        //
    }
}
