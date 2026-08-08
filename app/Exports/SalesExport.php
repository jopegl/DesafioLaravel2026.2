<?php

namespace App\Exports;

use App\Models\Sale;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class SalesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithTitle
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function __construct(
        protected ?string $start = null,
        protected ?string $end = null
    ) {}

    public function collection()
    {
        return Sale::asSeller(Auth::user())
            ->withDetails()
            ->period($this->start, $this->end)
            ->orderByDesc('purchase_date')
            ->get();
    }

    public function headings(): array
    {
        return ['Data', 'Valor', 'Categoria', 'Comprador', 'Vendedor'];
    }

    public function map($sale): array
    {
        return [
            $sale->purchase_date->format('d/m/Y'),
            $sale->total_price,
            $sale->category->name,
            $sale->buyer->name,
            $sale->seller->name,
        ];
    }

    public function title(): string
    {
        return 'Relatório de Vendas';
    }
}
