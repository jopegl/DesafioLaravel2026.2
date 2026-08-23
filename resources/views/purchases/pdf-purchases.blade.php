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
    <h2>Relatório de Compras</h2>
    <p>Período: {{ $start ?? 'início' }} até {{ $end ?? 'hoje' }}</p>

    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Valor</th>
                <th>Vendedor</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($purchases as $purchase)
            <tr>
                <td>{{ $purchase->purchase_date->format('d/m/Y') }}</td>
                <td>{{ $purchase->product->name }}</td>
                <td>{{ $purchase->quantity }}</td>
                <td>R$ {{ number_format($purchase->total_price, 2, ',', '.') }}</td>
                <td>{{ $purchase->seller->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>