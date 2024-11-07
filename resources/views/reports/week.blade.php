<!-- resources/views/reportes/semanal.blade.php -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Semanal de Sobres</title>
    <style>
        .container {
            margin: auto;
            margin-top: 20px;
        }

        .title {
            text-align: center;
            font-size: 24px;
            margin-bottom: 15px;
        }

        .table_container {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #4a4a4a;
            /* Color gris oscuro */
            color: #ffffff;
            /* Texto blanco */
            font-weight: bold;
        }

        tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
            /* Color gris claro */
        }

        tbody tr:nth-child(even) {
            background-color: #ffffff;
            /* Color blanco */
        }

        td {
            word-wrap: break-word;
        }

        /* Repetir el encabezado en cada página */
        thead {
            display: table-header-group;
        }

        /* Opcional: pie de página para cada página, si se requiere */
        tfoot {
            display: table-footer-group;
        }

        /* Configuración para la impresión */
        @page {
            margin: 1cm;
        }
    </style>

</head>

<body>
    <div class="container">
        <h1 class="title">Reporte Semanal de Sobres</h1>
        <div class="table_container">
            <table>
                <thead>
                    <tr>
                        <th>Sobre #</th>
                        <th>Nombre y Apellido</th>
                        <th>Monto Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($envelopes as $envelope)
                        <tr>
                            <td>{{ $envelope->envelope_number }}</td>
                            <td>{{ $envelope->member->firstname }} {{ $envelope->member->lastname }}</td>
                            <td>{{ number_format($envelope->total, 2) }} Bs.</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>