<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #eee;
        }
    </style>
</head>

<body>
    <h2>Relatório de Vendas</h2>
    <p>Período: {{ $start ?? 'início' }} até {{ $end ?? 'hoje' }}</p>

    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Valor</th>
                <th>Categoria</th>
                <th>Comprador</th>
                <th>Vendedor</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $sale)
            <tr>
                <td>{{ $sale->purchase_date->format('d/m/Y') }}</td>
                <td>R$ {{ number_format($sale->total_price, 2, ',', '.') }}</td>
                <td>{{ $sale->category->name }}</td>
                <td>{{ $sale->buyer->name }}</td>
                <td>{{ $sale->seller->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>