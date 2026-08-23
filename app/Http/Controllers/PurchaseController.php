<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function indexPurchaseHistory(Request $request)
    {
        $user = Auth::user();

        $purchases = Sale::asBuyer($user)
            ->withDetails()
            ->period($request->input('start'), $request->input('end'))
            ->orderByDesc('purchase_date')
            ->paginate(8);
        return view('purchases.history', compact('purchases'));
    }

    public function generatePdfPurchases(Request $request)
    {
        $user = Auth::user();

        $purchases = Sale::asBuyer($user)
            ->withDetails()
            ->period($request->input('start'), $request->input('end'))
            ->orderByDesc('purchase_date')
            ->get();

        $pdf = Pdf::loadView('purchases.pdf-purchases', [
            'purchases' => $purchases,
            'start'     => $request->input('start'),
            'end'       => $request->input('end'),
        ]);

        return $pdf->stream('relatorio-compras.pdf');
    }
}
