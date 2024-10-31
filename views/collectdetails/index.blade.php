@extends('plantilla.plantilla')
@section('titulo', 'Delegations')
@section('contenido')
    <div class="container d-flex flex-column align-items-center">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('delegations.index')}}">Delegaciones</a></li>
                <li class="breadcrumb-item"><a href="{{route('delegations.show', $local->zone->delegation->id)}}">{{ $local->zone->delegation->name }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('zones.show',$local->zone->id) }}">{{ $local->zone->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $local->name }} -> Auxiliares</li>
            </ol>
        </nav>

        <h1>{{ $local->name }}</h1>

        @if (!empty($collectdetailsinfo))

            <table class="w-50 table table-bordered text-end">
                <tr>
                    <td colspan="3" class="text-start">Saldo inicial Asignado = A-(B+C)</td>
                    <td>{{ $saldoInicial }}€</td>
                </tr>
                <tr @if ($principal < $porcientodel50) class="table-danger" @endif>
                    <td colspan="3" class="text-start">Disponible</td>
                    @foreach ($collectdetailsinfo as $collectdetail)
                        @if ($collectdetail->Name == 'Principal')
                            <td>{{ $collectdetail->Money1 }} €</td>
                        @endif
                    @endforeach
                </tr>
                <tr>
                    <td colspan="5"></td>
                </tr>
                <tr>
                    <th colspan="2">Entradas</th>
                    <th>Salidas</th>
                    <th>Balance&nbsp;(B)</th>
                </tr>
                @foreach ($collectdetailsinfo as $collectdetail)
                    @if ($collectdetail->Name == 'Apuestas')
                        <tr>
                            <td class="text-start">{{ $collectdetail->Name }}</td>
                            <td>{{ $collectdetail->Money1 }}€</td>
                            <td>{{ $collectdetail->Money2 }}€</td>
                            <td>{{ $collectdetail->Money3 }}€</td>
                        </tr>
                    @endif
                @endforeach
                <tr>
                    <td colspan="5"></td>
                </tr>
                <tr>
                    <th colspan="2">Entradas</th>
                    <th>Salidas</th>
                    <th>Balance&nbsp;(C)</th>
                </tr>
                @foreach ($collectdetailsinfo as $collectdetail)
                    @if ($collectdetail->Name != 'Principal' && $collectdetail->Name != 'Apuestas')
                        <tr>
                            <td class="text-start">{{ $collectdetail->Name }}</td>
                            <td>{{ $collectdetail->Money1 }}€</td>
                            <td>{{ $collectdetail->Money2 }}€</td>
                            <td>{{ $collectdetail->Money3 }}€</td>
                        </tr>
                    @endif
                @endforeach
            </table>
        @else

            <h3 class="alert alert-danger">No tiene datos</h3>

        @endif
    </div>
@endsection
