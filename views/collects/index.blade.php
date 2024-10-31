@extends('plantilla.plantilla')
@section('titulo', 'Delegations')
@section('contenido')
    <div class="container d-flex align-items-center flex-column">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('delegations.index') }}">Delegaciones</a></li>
                <li class="breadcrumb-item"><a
                        href="{{ route('delegations.show', $local->zone->delegation->id) }}">{{ $local->zone->delegation->name }}</a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('zones.show', $local->zone->id) }}">{{ $local->zone->name }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $local->name }} -> Arqueo</li>
            </ol>
        </nav>
        <h1>{{ $local->name }}</h1>

        @if (!empty($collectsinfo))

            <div class="d-md-flex w-100">
                <div class="col-12 col-md-6">
                    <table class="w-100 table table-bordered">
                        <tr>
                            <th>Localización</th>
                            <th>Valor</th>
                            <th>Dinero total</th>
                        </tr>
                        @foreach ($collectsinfo as $dato)
                            @if ($dato->LocationType == 'Cashbox')
                                <tr>
                                    <td>Cajón</td>
                                    <td>{{ $dato->MoneyValue }}</td>
                                    <td>{{ $dato->Amount }}€</td>
                                </tr>
                            @elseif ($dato->LocationType == 'Hopper 2')
                                <tr @if ($dato->Quantity < 1000) class="table-danger" @endif>
                                    <td>Pagador 2</td>
                                    <td>{{ $dato->MoneyValue }}</td>
                                    <td>{{ $dato->Amount }}€</td>
                                </tr>
                            @elseif ($dato->LocationType == 'MultiCoin')
                                <tr @if ($dato->Quantity < 50) class="table-danger" @endif>
                                    <td>MultiMoneda</td>
                                    <td>{{ $dato->MoneyValue }}</td>
                                    <td>{{ $dato->Amount }}€</td>
                                </tr>
                            @elseif ($dato->LocationType == 'Cassette 1')
                                <tr>
                                    <td>Reciclador 1</td>
                                    <td>{{ $dato->MoneyValue }}</td>
                                    <td>{{ $dato->Amount }}€</td>
                                </tr>
                            @elseif ($dato->LocationType == 'Cassette 2')
                                <tr>
                                    <td>Reciclador 2</td>
                                    <td>{{ $dato->MoneyValue }}</td>
                                    <td>{{ $dato->Amount }}€</td>
                                </tr>
                            @elseif ($dato->LocationType == 'Cassette 3')
                                <tr>
                                    <td>Reciclador 3</td>
                                    <td>{{ $dato->MoneyValue }}</td>
                                    <td>{{ $dato->Amount }}€</td>
                                </tr>
                            @elseif ($dato->LocationType == 'Cassette 4')
                                <tr>
                                    <td>Reciclador 4</td>
                                    <td>{{ $dato->MoneyValue }}</td>
                                    <td>{{ $dato->Amount }}€</td>
                                </tr>
                            @elseif ($dato->LocationType == 'Cassette 5')
                                <tr>
                                    <td>Reciclador 5</td>
                                    <td>{{ $dato->MoneyValue }}</td>
                                    <td>{{ $dato->Amount }}€</td>
                                </tr>
                            @elseif ($dato->LocationType == 'Puloon Stacker')
                                <tr>
                                    <td>Rechazo</td>
                                    <td>{{ $dato->MoneyValue }}</td>
                                    <td>{{ $dato->Amount }}€</td>
                                </tr>
                            @elseif ($dato->LocationType == 'Stacker')
                                <tr>
                                    <td>Apilador</td>
                                    <td>{{ $dato->MoneyValue }}</td>
                                    <td>{{ $dato->Amount }}€</td>
                                </tr>
                            @endif
                        @endforeach
                        <tr>
                            <th colspan="2">Arqueo total:</th>
                            <td>{{ $valoresActivoyNoActivo['aTotal'] }}€</td>
                        </tr>
                    </table>
                </div>
                <div class="col-12 col-md-4 offset-md-1">
                    <table class="w-100 table table-bordered">
                        <tr>
                            <th colspan="2">Dinero Activo</th>
                        </tr>
                        <tr>
                            <td>Total recicladores</td>
                            <td>{{ $valoresActivoyNoActivo['tRecicladores'] }}€</td>
                        </tr>
                        <tr>
                            <td>Total pagadores</td>
                            <td>{{ $valoresActivoyNoActivo['tPagadores'] }}€</td>
                        </tr>
                        <tr>
                            <td>Total multimoneda</td>
                            <td>{{ $valoresActivoyNoActivo['tMultimoneda'] }}€</td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td>{{ $valoresActivoyNoActivo['dineroActivo'] }}€</td>
                        </tr>
                    </table>

                    <table class="w-100 table table-bordered">
                        <tr>
                            <th colspan="2">Dinero No Activo</th>
                        </tr>
                        <tr>
                            <td>Total apiladores</td>
                            <td>{{ $valoresActivoyNoActivo['tApiladores'] }} €</td>
                        </tr>
                        <tr>
                            <td>Total rechazo dispensador</td>
                            <td>{{ $valoresActivoyNoActivo['tRechazo'] }}€</td>
                        </tr>
                        <tr>
                            <td>Total cajones</td>
                            <td>{{ $valoresActivoyNoActivo['tCajones'] }}€</td>
                        </tr>
                        <tr>
                            <td>Total cajones virtuales</td>
                            <td>{{ $valoresActivoyNoActivo['tCajonesV'] }}€</td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td>{{ $valoresActivoyNoActivo['dineroNoActivo'] }}€</td>
                        </tr>
                    </table>
                </div>

            </div>
        @else
            <h3 class="alert alert-danger">No tiene datos</h3>
        @endif
    </div>
@endsection
