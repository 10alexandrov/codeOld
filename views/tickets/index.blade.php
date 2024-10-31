@extends('plantilla.plantilla')
@section('titulo', 'Delegations')
@section('contenido')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('delegations.index') }}">Delegaciones</a></li>
                <li class="breadcrumb-item"><a
                        href="{{ route('delegations.show', $local->zone->delegation->id) }}">{{ $local->zone->delegation->name }}</a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('zones.show', $local->zone->id) }}">{{ $local->zone->name }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $local->name }} -> Tickets</li>
            </ol>
        </nav>

        <h1>{{ $local->name }}</h1>

        @foreach ($tickets['totalTickets'] as $tipoTicket => $totalTicket)
            <table>
                <tr>
                    <th colspan="2">Total {{$tipoTicket}}</th>
                </tr>
                <tr>
                    <td>Total:</td>
                    <td>{{ $totalTicket }}&nbsp;€</td>
                </tr>
            </table>
        @endforeach
        <br>
        <div class="table-responsive d-none d-md-block">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Número de ticket</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Usuario</th>
                        <th scope="col">Valor&nbsp;€</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Comentarios</th>

                    </tr>
                </thead>
                <tbody>
                    @if ($tickets['tickets']->isNotEmpty())
                        @foreach ($tickets['tickets'] as $ticket)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $ticket->TicketNumber }}</td>
                                <td>{{ $ticket->DateTime }}</td>
                                <td>{{ $ticket->User }}</td>
                                <td>{{ $ticket->Value }}&nbsp;€</td>
                                <td>{{ $ticket->Type }}</td>
                                <td>{{ $ticket->Comment }}</td>
                            </tr>
                        @endforeach
                    @else
                        <h3 class="alert alert-danger">No hay tickets</h3>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
