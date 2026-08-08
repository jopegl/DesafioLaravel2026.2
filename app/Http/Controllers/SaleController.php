<?php

namespace App\Http\Controllers;

use App\Exports\SalesExport;
use App\Models\Sale;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Excel;

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

        return view('sales', compact('sales'));
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

    public function generatePDF(Request $request)
    {
        $user = Auth::user();

        $vendas = Sale::asSeller($user)
            ->withDetails()
            ->periodo($request->input('inicio'), $request->input('fim'))
            ->orderByDesc('data_compra')
            ->get();

        $pdf = Pdf::loadView('sales.pdf-sales', [
            'vendas' => $vendas,
            'inicio' => $request->input('inicio'),
            'fim'    => $request->input('fim'),
        ]);

        return $pdf->stream('relatorio-vendas.pdf');
    }

    public function  generateXlsx(Request $request)
    {
        $this->authorize('exportXlsx', Sale::class);
        return Excel::download(
            new SalesExport($request->input('inicio'), $request->input('fim')),
            'relatorio-vendas.xlsx'
        );
    }
}
