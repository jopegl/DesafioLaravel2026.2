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
    <p>Período: {{ $inicio ?? 'início' }} até {{ $fim ?? 'hoje' }}</p>

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
            @foreach ($vendas as $venda)
            <tr>
                <td>{{ $venda->data_compra->format('d/m/Y') }}</td>
                <td>R$ {{ number_format($venda->valor_total, 2, ',', '.') }}</td>
                <td>{{ $venda->category->nome }}</td>
                <td>{{ $venda->buyer->name }}</td>
                <td>{{ $venda->seller->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>