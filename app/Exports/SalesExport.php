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
        protected ?string $inicio = null,
        protected ?string $fim = null
    ) {}

    public function collection()
    {
        return Sale::asSeller(Auth::user())
            ->withDetails()
            ->periodo($this->inicio, $this->fim)
            ->orderByDesc('data_compra')
            ->get();
    }

    public function headings(): array
    {
        return ['Data', 'Valor', 'Categoria', 'Comprador', 'Vendedor'];
    }

    public function map($venda): array
    {
        return [
            $venda->data_compra->format('d/m/Y'),
            $venda->valor_total,
            $venda->category->nome,
            $venda->buyer->name,
            $venda->seller->name,
        ];
    }

    public function title(): string
    {
        return 'Relatório de Vendas';
    }
}
