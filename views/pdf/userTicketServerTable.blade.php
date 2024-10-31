<!DOCTYPE html>
<html>
<head>
    <title>Usuarios del ticketserver</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        .ttl{
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
        <h1>DELEGACIÓN DE {{strtoupper($delegation->name)}}</h1>
    </div>
    <h2>Técnicos</h2>
    <table>
        <thead>
            <tr>
                <th>Usuario</th>
                <th>PID</th>
                <th>Contraseña</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $user)
                @if ($user->rol == 'Técnicos')
                    <tr>
                        <td>{{$user->User}}</td>
                        <td>
                            @php
                                try {
                                    $decryptPID = Crypt::decrypt($user->PID);
                                } catch (Exception $e) {
                                    $decryptPID = '';
                                }
                            @endphp
                            {{ $decryptPID }}
                        </td>
                        <td>
                            @php
                                try {
                                    $decryptPassword = Crypt::decrypt($user->Password);
                                } catch (Exception $e) {
                                    $decryptPassword = '';
                                }
                            @endphp
                            {{ $decryptPassword }}
                        </td>

                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    <h2>Personal de sala</h2>
    <table>
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Nombre</th>
                <th>Contraseña</th>
                <th>Salones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $user)
                @if ($user->rol == 'Personal sala' && $user->PID == '')
                    <tr>
                        <td>{{$user->User}}</td>
                        <td>{{$user->Name}}</td>
                        <td>
                            @php
                                try {
                                    $decryptPass = Crypt::decrypt($user->Password);
                                } catch (Exception $e) {
                                    $decryptPass = '';
                                }
                            @endphp
                            {{ $decryptPass }}
                        </td>
                        <td>
                            {{ $user->locals->pluck('name')->implode(', ') }}
                        </td>

                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>


    <h2>Personal de sala con PID</h2>
    <table>
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Contraseña</th>
                <th>PID</th>
                <th>Salones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $user)
                @if ($user->rol == 'Personal sala' && $user->PID != '')
                    <tr>
                        <td>{{$user->User}}</td>
                        <td>
                            @php
                                try {
                                    $decryptPass = Crypt::decrypt($user->Password);
                                } catch (Exception $e) {
                                    $decryptPass = '';
                                }
                            @endphp
                            {{ $decryptPass }}
                        </td>
                        <td>
                            @php
                                try {
                                    $decryptPID = Crypt::decrypt($user->PID);
                                } catch (Exception $e) {
                                    $decryptPID = '';
                                }
                            @endphp
                            {{ $decryptPID }}
                        </td>
                        <td>
                            {{ $user->locals->pluck('name')->implode(', ') }}
                        </td>

                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>


    <h2>Usuarios caja</h2>
    <table>
        <thead>
            <tr>
                <th>Usuario</th>
                <th>PID</th>
                <th>Contraseña</th>
                <th>Locales</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $user)
                @if ($user->rol == 'Caja')
                    <tr>
                        <td>{{$user->User}}</td>
                        <td>
                            @php
                                try {
                                    $decryptPID = Crypt::decrypt($user->PID);
                                } catch (Exception $e) {
                                    $decryptPID = '';
                                }
                            @endphp
                            {{ $decryptPID }}
                        </td>
                        <td>
                            @php
                                try {
                                    $decryptPass = Crypt::decrypt($user->Password);
                                } catch (Exception $e) {
                                    $decryptPass = '';
                                }
                            @endphp
                            {{ $decryptPass }}
                        </td>
                        <td>
                            {{ $user->locals->pluck('name')->implode(', ') }}
                        </td>

                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

</body>
</html>
