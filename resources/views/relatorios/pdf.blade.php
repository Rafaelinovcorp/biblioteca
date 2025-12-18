<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Requisições</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h2 {
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        th {
            background: #eee;
        }
    </style>
</head>
<body>

    <h2>Relatório de Requisições</h2>

    <p>
        <strong>Período:</strong>
        {{ \Carbon\Carbon::parse($data['inicio'])->format('d/m/Y') }}
        —
        {{ \Carbon\Carbon::parse($data['fim'])->format('d/m/Y') }}
    </p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Livro</th>
                <th>Cidadão</th>
                <th>Início</th>
                <th>Entrega</th>
                <th>Estado</th>
                <th>Dias</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requisicoes as $r)
                <tr>
                    <td>{{ $r->numero }}</td>
                    <td>{{ $r->livro->nome }}</td>
                    <td>{{ $r->user->name }}</td>
                    <td>{{ $r->data_inicio->format('d/m/Y') }}</td>
                    <td>
                        {{ $r->data_fim_real
                            ? $r->data_fim_real->format('d/m/Y')
                            : '-' }}
                    </td>
                    <td>{{ ucfirst($r->estado) }}</td>
                    <td>{{ $r->dias_decorridos ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
