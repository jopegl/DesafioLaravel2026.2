<?php

namespace App\Http\Controllers;

use App\Exports\SalesExport;
use App\Models\Sale;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use Maatwebsite\Excel\Facades\Excel;

class SaleController extends Controller
{
    public function indexSalesHistory(Request $request)
    {
        $user = Auth::user();
        $sales = Sale::asSeller($user)
            ->withDetails()
            ->period($request->input('start'), $request->input('end'))
            ->orderByDesc('purchase_date')
            ->paginate(8);

        return view('sales', compact('sales'));
    }

    public function indexPurchaseHistory(Request $request)
    {
        $user = Auth::user();

        $purchases = Sale::asBuyer($user)
            ->withDetails()
            ->period($request->input('start'), $request->input('end'))
            ->orderByDesc('purchase_date')
            ->paginate(8);
        return view('purchase-history', compact('purchases'));
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

    private function generateGraphic()
    {
        $user = Auth::user();
        $this->authorize('generateGraphic', Sale::class);

        $chart_options = [
            'chart_title'       => 'Vendas Realizadas por Mês',
            'model'              => Sale::class,
            'chart_type'         => 'line',
            'report_type'        => 'group_by_date',
            'group_by_field'     => 'purchase_date',
            'group_by_period'    => 'month',
            'filter_field'       => 'purchase_date',
            'filter_days'        => 365,
            'continuous_time' => true,
            'conditions' => [
                [
                    'name' => 'Vendas',
                    'condition' => "seller_id = " . $user->id,
                    'color' => 'blue',
                ],
            ],
        ];

        $chart = new LaravelChart($chart_options);
        return $chart;
    }
}
