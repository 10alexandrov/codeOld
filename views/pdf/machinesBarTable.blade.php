<!DOCTYPE html>
<html>

<head>
    <title>Maquinas bares</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        .ttl {
            width: 100%;
            text-align: center;
            margin-bottom: 15px;
        }

        .header {
            text-align: right;
            font-size: 12px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="header">
        <p>{{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
    </div>
    <div class="ttl">
        <h1>MÁQUINAS DELEGACIÓN DE {{ strtoupper($delegation->name) }}</h1>
    </div>
    <div class="ttl">
        <h2>BARES</h2>
    </div>
    @foreach ($bars as $bar)
        <h3>{{ $bar->name }}</h3>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Alias</th>
                    <th>Identificador</th>
                </tr>
            </thead>
            <tbody>
                @php
                    // Filtramos las máquinas para el local actual
                    $barMachines = $machines->where('bar_id', $bar->id);
                @endphp

                @if ($barMachines->isEmpty())
                    <tr>
                        <td colspan="3" class="text-center">No hay máquinas asociadas a este bar.</td>
                    </tr>
                @else
                    @foreach ($barMachines as $machine)
                        <tr>
                            <td>{{ $machine->name }}</td>
                            <td>{{ $machine->alias }}</td>
                            <td>{{ $machine->identificador }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <br>
    @endforeach
</body>

</html>
