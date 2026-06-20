<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Relatório</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px 20px 50px 20px;
            color: #333;
            position: relative;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
        }

        header img {
            height: 50px;
        }

        header h1 {
            font-size: 16px;
            margin: 0;
            flex-grow: 1;
            text-align: center;
        }

        header p {
            margin: 0;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 10px;
        }

        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        .total {
            font-weight: bold;
        }

        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 20px;
            text-align: center;
            font-size: 10px;
            background-color: #fff;
            border-top: 1px solid #ddd;
            padding-top: 5px;
        }

        .page-number {
            position: fixed;
            bottom: 10px;
            right: 10px;
            font-size: 10px;
        }

        .page-break {
            page-break-before: always;
        }

        table {
            page-break-inside: auto;
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
    </style>
</head>

<body>
    <header>
        <h1>Relatório</h1>
        <p>Gerado em: {{ now()->format('d/m/Y H:i:s') }}</p>
    </header>
    <table>
        <thead>
            <tr>
                <th>idTicket</th>
                <th>Assunto</th>
                <th>Data Resolução</th>
                <th>Status</th>
                <th>Criado Por</th>
                <th>Responsavel</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dados as $item)
                <tr>
                    <td>{{ $item['id'] }}</td>
                    <td>{{ $item['subject'] }}</td>
                    <td>{{ $item['resolvedIn'] }}</td>
                    <td>{{ $item['status'] }}</td>
                    <td>{{ $item['createdBy']['businessName'] ?? 'Não Informado'}} </td>
                    <td>{{ $item['owner']['businessName'] ?? 'Não Informado'}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script type="text/php">
        if (isset($pdf)) {
            $pdf->page_script(function ($pageNumber, $totalPages, $pdf) {
                $text = "Página $pageNumber de $totalPages";
                $font = $pdf->get_font('Arial', 'normal');
                $size = 10;
                $pdf->text(520, 820, $text, $font, $size); 
            });
        }
    </script>

    <footer>
        <p>DoctorTicket® - Todos os direitos reservados</p>
    </footer>
</body>

</html>
