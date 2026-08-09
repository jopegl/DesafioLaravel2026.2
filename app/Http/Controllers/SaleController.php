<?php

namespace App\Http\Controllers;

use App\Exports\SalesExport;
use App\Models\Sale;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $sales = Sale::asSeller($user)
            ->withDetails()
            ->period($request->input('start'), $request->input('end'))
            ->orderByDesc('purchase_date')
            ->paginate(8);

        return view('sales', compact('sales'));
    }


    public function generatePDF(Request $request)
    {
        $user = Auth::user();

        $sales = Sale::asSeller($user)
            ->withDetails()
            ->period($request->input('start'), $request->input('end'))
            ->orderByDesc('purchase_date')
            ->get();

        $pdf = Pdf::loadView('sales.pdf-sales', [
            'sales' => $sales,
            'start' => $request->input('start'),
            'end'   => $request->input('end'),
        ]);

        return $pdf->stream('relatorio-vendas.pdf');
    }

    public function  generateXlsx(Request $request)
    {
        $this->authorize('exportXlsx', Sale::class);
        return Excel::download(
            new SalesExport($request->input('start'), $request->input('end')),
            'relatorio-vendas.xlsx'
        );
    }
}
