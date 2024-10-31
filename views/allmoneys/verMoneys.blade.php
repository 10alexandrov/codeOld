@extends('plantilla.plantilla')
@section('titulo', 'Delegations')
@section('contenido')

    @php
        use App\Models\Collect;
        use App\Models\Collectdetail;
        use App\Models\Ticket;
        use Carbon\Carbon;
    @endphp

    <div class="container">

        <div class="row">
            <div class="col-lg-12 col-md-12 mx-auto">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th scope="col">Local</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Última actualización</th>
                        </tr>
                    </thead>
                    <tbody>

                        <h4 class="mx-auto text-center">Estado de las conexiones</h4>
                        {{-- Iterar sobre todos los locales --}}
                        @foreach ($delegation->zones as $zone)
                            @foreach ($zone->locals as $local)
                                {{-- Verificar si existen registros de syncLogsLocals para este local --}}
                                @if ($local->syncLogsLocals->isNotEmpty())
                                    {{-- Mostrar datos del local y de syncLogsLocals --}}
                                    @foreach ($local->syncLogsLocals as $syncLog)
                                        <tr
                                            @if ($syncLog->status === 'Ok') class="table-success" @else class="table-danger" @endif>
                                            <td>{{ $local->name }}</td>
                                            <td>{{ $syncLog->status }}</td>
                                            {{-- Mostrar la fecha en formato español --}}
                                            <td>{{ \Carbon\Carbon::parse($syncLog->updated_at)->format('d-m-Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @php
            $localNameDisplayed = false;
        @endphp

        @forelse ($delegation->zones as $zone)
            @foreach ($zone->locals as $local)
                @php
                    $displayLocalName = false;
                @endphp

                {{-- Verificar si hay collects --}}
                @if ($local->collects->isNotEmpty())
                    {{-- Variables para mostrar información de los COLLECTS --}}
                    @php
                        $collectsData = Collect::colocarCampos($local->collects);
                        $collects = json_decode($collectsData);
                        $collectsDisplayed = false; // Variable para controlar si se muestran los collects

                        // Variables para mostrar informacion de los TICKETS
                        $ticketsFilter = Ticket::where('local_id', $local->id)
                            ->where('Command', 'CLOSE')
                            ->where('TypeIsAux', 0)
                            ->where('TypeIsBets', '!=', 1)
                            ->where('Status', 'IN STACKER')
                            ->whereBetween('LastCommandChangeDateTime', [
                                DB::raw('NOW() - INTERVAL \'15 DAYS\''),
                                DB::raw('NOW()'),
                            ])
                            ->get();

                        $ticketsAbort = Ticket::where('local_id', $local->id)
                            ->where(function ($query) {
                                $query
                                    ->where('Command', 'OPEN')
                                    ->where('Type', '!=', 'ZITRO')
                                    ->where('Type', '!=', 'BRYKE')
                                    ->orWhere('Command', 'PRINTED')
                                    ->orWhere('Command', 'AUTHREQ');
                            })
                            ->get();

                        $ticketsRaros = Ticket::where('local_id', $local->id)
                            ->where('Command', 'CLOSE')
                            ->where('Status', 'MANUALLY VALIDATED')
                            ->where('Type', '!=', 'ZITRO')
                            ->where('Type', '!=', 'BRYKE')
                            ->whereBetween('LastCommandChangeDateTime', [
                                DB::raw('NOW() - INTERVAL \'15 DAYS\''),
                                DB::raw('NOW()'),
                            ])
                            ->get();

                        $totalTicketsSegunTipo = Ticket::totalTickectsSegunTipo($ticketsFilter);
                        $ticketsData = json_decode($totalTicketsSegunTipo);

                        $ticketsDataAbort = json_decode($ticketsAbort);
                        $ticketsDataRaros = json_decode($ticketsRaros);
                        //dd($ticketsDataAbort);

                        // Sumar todas las cantidades de 'Rechazo'
                        $rechazoTotal = 0;
                        foreach ($collects as $collect) {
                            if ($collect->LocationType === 'Rechazo') {
                                $rechazoTotal += $collect->Quantity;
                            }
                        }
                    @endphp

                    {{-- Iterar sobre los datos de $collects --}}
                    @foreach ($collects as $collect)
                        @php

                            // Determinar si la fila debe estar resaltada
                            $isDanger =
                                ($collect->LocationType === 'Multimoneda' && $collect->Quantity < 50) ||
                                ($collect->LocationType === 'Hopper 1€' && $collect->Quantity < 1000) ||
                                ($rechazoTotal > 10 && $collect->LocationType === 'Rechazo');
                        @endphp

                        {{-- Verificar si el collect cumple con las condiciones --}}
                        @if (
                            ($collect->LocationType == 'Multimoneda' && $collect->Quantity < 50) ||
                                ($collect->LocationType == 'Pagador 2' && $collect->Quantity < 1000) ||
                                ($collect->LocationType == 'Rechazo' && $collect->Quantity > 10))
                            {{-- Mostrar el nombre del local y el encabezado de la tabla --}}
                            @if (!$collectsDisplayed)
                                @if (!$localNameDisplayed)
                                    @php $localNameDisplayed = true; @endphp
                                    <div class="col-12 mt-5">
                                        <h4 class="mx-auto text-center">{{ $local->name }}</h4>
                                    </div>
                                @endif
                                <div class="col-lg-12 col-md-12 mx-auto">
                                    <div class="w-100 text-center">
                                        <p>Valores mínimos</p>
                                    </div>
                                    <table class="table table-bordered text-start">
                                        <thead>
                                            <tr class="text-start">
                                                <th>Localización</th>
                                                <th class="text-center">Valor</th>
                                                <th class="text-center">Cantidad</th>
                                                <th class="text-end">Total (€)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $collectsDisplayed = true; @endphp
                            @endif
                            {{-- Detalles del collect --}}
                            <tr class="table-danger text-start">
                                <td>{{ $collect->LocationType }}</td>
                                <td class="text-center">{{ $collect->MoneyValue }}€</td>
                                <td class="text-center">{{ $collect->Quantity }}</td>
                                <td class="text-end">{{ $collect->Amount }}€</td>
                            </tr>
                        @endif
                    @endforeach
                    {{-- Cerrar la tabla si se han mostrado collects --}}
                    @if ($collectsDisplayed)
                        </tbody>
                        </table>
    </div>
    @endif
    @endif

    {{-- Lógica para mostrar collectdetails --}}
    @if ($local->collectdetails->isNotEmpty())
        @php
            $disponibleAux = Collectdetail::disponibleAllMoneys($local->collectdetails);
            $valores50CollDetalaux = Collectdetail::valoresParaCollectDetails50($local->collectdetails);
            $disponible = json_decode($disponibleAux);
        @endphp

        @if ($valores50CollDetalaux->disponible < $valores50CollDetalaux->x50saldoInicial)
            @if (!$localNameDisplayed)
                @php $localNameDisplayed = true; @endphp
                <div class="col-12 mt-5">
                    <h4 class="mx-auto text-center">{{ $local->name }}</h4>
                </div>
            @endif
            <div class="col-lg-12 col-md-12 mx-auto">
                <div class="w-100 text-center">
                    <p>Saldo inicial</p>
                </div>
                <table class="table table-bordered">
                    <tr>
                        <th colspan="3" class="text-start">Saldo inicial Asignado</th>
                        <th class="text-end">{{ $valores50CollDetalaux->saldoInicial }}€</th>
                    </tr>
                    <tr class="table-danger">
                        <td colspan="3">Disponible</td>
                        <td class="text-end">{{ $valores50CollDetalaux->disponible }}€</td>
                    </tr>
                </table>
            </div>
        @endif
    @endif

    {{-- Verificar si hay tickets y si hay valores en $ticketsData --}}
    @if ($local->tickets->isNotEmpty() && !empty($ticketsData))
        @if (!$localNameDisplayed)
            @php $localNameDisplayed = true; @endphp
            <div class="col-12 mt-5">
                <h4 class="mx-auto text-center">{{ $local->name }}</h4>
            </div>
        @endif

        {{-- Mostrar los tickets en una tabla con dos columnas --}}
        <div class="col-lg-12 col-md-12 mx-auto">
            <div class="w-100 text-center">
                <p>Tickets pagados por la máquina de cambio</p>
            </div>
            <table class="table table-bordered text-start">
                <thead>
                    <tr class="text-start">
                        <th>Tipo del Ticket</th>
                        <th class="text-end">Valor (€)</th>
                    </tr>
                </thead>
                <tbody>

                    @php
                        // Calculo del total de los tickets según el tipo
                        $ticketsFilter = Ticket::where('local_id', $local->id)
                            ->where('Type', '!=', 'ZITRO')
                            ->where('Type', '!=', 'BRYKE')
                            ->where('Command', 'CLOSE')
                            ->where('TypeIsAux', 0)
                            ->where('TypeIsBets', '!=', 1)
                            ->where('Status', 'IN STACKER')
                            ->whereBetween('LastCommandChangeDateTime', [
                                DB::raw('NOW() - INTERVAL \'10 DAYS\''),
                                DB::raw('NOW()'),
                            ])
                            ->get();

                        $ticketsRaros = Ticket::where('local_id', $local->id)
                            ->where('Type', '!=', 'ZITRO')
                            ->where('Type', '!=', 'BRYKE')
                            ->where('Command', 'CLOSE')
                            ->where('Status', 'MANUALLY VALIDATED')
                            ->whereBetween('LastCommandChangeDateTime', [
                                DB::raw('NOW() - INTERVAL \'10 DAYS\''),
                                DB::raw('NOW()'),
                            ])
                            ->get();

                        $ticketsAbort = Ticket::where('local_id', $local->id)
                            ->where(function ($query) {
                                $query
                                    ->where('Type', '!=', 'ZITRO')
                                    ->where('Type', '!=', 'BRYKE')
                                    ->where('Command', 'OPEN')
                                    ->orWhere('Command', 'PRINTED')
                                    ->orWhere('Command', 'AUTHREQ');
                            })
                            ->get();

                        $totalTicketsSegunTipo = Ticket::totalTickectsSegunTipo($ticketsFilter);

                        // Tickets días anteriores a hoy
                        $ticketsFilterAnterior = Ticket::where('local_id', $local->id)
                            ->where('Command', 'CLOSE')
                            ->where('TypeIsAux', 0)
                            ->where('TypeIsBets', '!=', 1)
                            ->where('Status', 'IN STACKER')
                            ->where('Type', '!=', 'ZITRO')
                            ->where('Type', '!=', 'BRYKE')
                            ->whereBetween('LastCommandChangeDateTime', [
                                DB::raw('CURRENT_DATE - INTERVAL \'10 days\''),
                                DB::raw('CURRENT_DATE - INTERVAL \'1 second\''),
                            ])
                            ->get();

                        $totalTicketsSegunTipoDiaAnterior = Ticket::totalTickectsSegunTipo($ticketsFilterAnterior);

                        // Obtenemos el tiempo actual y el inicio del día actual
                        $now = Carbon::now();
                        $startOfDay = $now->copy()->startOfDay();

                        // Obtenemos los tickets de los últimos 15 días, pero solo los del día de hoy desde las 00:00
                        $ticketsFilterActual = Ticket::where('local_id', $local->id)
                            ->where('Command', 'CLOSE')
                            ->where('TypeIsAux', 0)
                            ->where('TypeIsBets', '!=', 1)
                            ->where('Status', 'IN STACKER')
                            ->where('Type', '!=', 'ZITRO')
                            ->where('Type', '!=', 'BRYKE')
                            ->whereBetween('LastCommandChangeDateTime', [$startOfDay, $now])
                            ->get();

                        $totalTicketsSegunTipoDiaActual = Ticket::totalTickectsSegunTipo($ticketsFilterActual);

                        $ticketsData = json_decode($totalTicketsSegunTipo);
                        $ticketRarosData = json_decode($ticketsRaros);

                        $ticketsDataAnterior = json_decode($totalTicketsSegunTipoDiaAnterior);
                        $ticketsDataActual = json_decode($totalTicketsSegunTipoDiaActual);

                        // Obtener el nombre del día de la semana
                        $todayName = __('days.' . strtolower(Carbon::today()->format('l')));
                        $yesterdayName = __('days.' . strtolower(Carbon::yesterday()->format('l')));

                    @endphp

                    @foreach ($ticketsDataAnterior as $item)
                        <tr>
                            <td class="text-start">{{ $item->name }} {{ $yesterdayName }}</td>
                            <td class="text-end">{{ $item->valor }}€</td>
                        </tr>
                    @endforeach

                    @foreach ($ticketsDataActual as $item)
                        <tr>
                            <td class="text-start">{{ $item->name }} {{ $todayName }}</td>
                            <td class="text-end">{{ $item->valor }}€</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    @endif

    @if ($local->tickets->isNotEmpty() && !empty($ticketsDataAbort))
        @if (!$localNameDisplayed)
            @php $localNameDisplayed = true; @endphp
            <div class="col-12 mt-5">
                <h4 class="mx-auto text-center">{{ $local->name }}</h4>
            </div>
        @endif
        <div class="col-lg-12 col-md-12 mx-auto">
            <div class="w-100 text-center">
                <p>Tickets por cobrar</p>
            </div>
            <div class="table-responsive mb-4 overflow-auto">
                <table class="table table-bordered text-start w-xs-200">
                    <thead>
                        <tr class="text-start">
                            <th scope="col">Número de ticket</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Usuario</th>
                            <th scope="col">Valor (€)</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ticketsDataAbort as $ticket)
                            <tr>
                                <td>{{ $ticket->TicketNumber }}</td>
                                <td>{{ \Carbon\Carbon::parse($ticket->DateTime)->format('d-m-Y H:i') }}
                                </td>
                                <td>{{ $ticket->User }}</td>
                                <td>{{ $ticket->Value }}€</td>
                                <td>{{ $ticket->Type }}</td>
                                <td>{{ $ticket->Command }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    @if ($local->tickets->isNotEmpty() && !empty($ticketsDataRaros))
        @if (!$localNameDisplayed)
            @php $localNameDisplayed = true; @endphp
            <div class="col-12 mt-5">
                <h4 class="mx-auto text-center">{{ $local->name }}</h4>
            </div>
        @endif
        <div class="col-lg-12 col-md-12 mx-auto">
            <div class="w-100 text-center">
                <p>Tickets metidos a mano por pantalla</p>
            </div>
            <div class="table-responsive mb-4 overflow-auto">
                <table class="table table-bordered text-start w-xs-200">
                    <thead>
                        <tr class="text-start">
                            <th scope="col">Número de ticket</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Usuario</th>
                            <th scope="col">Valor (€)</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ticketsDataRaros as $ticket)
                            <tr>
                                <td>{{ $ticket->TicketNumber }}</td>
                                <td>{{ \Carbon\Carbon::parse($ticket->DateTime)->format('d-m-Y H:i') }}
                                </td>
                                <td>{{ $ticket->User }}</td>
                                <td>{{ $ticket->Value }}€</td>
                                <td>{{ $ticket->Type }}</td>
                                <td>{{ $ticket->Command }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    @php $localNameDisplayed = false; @endphp
    @endforeach
@empty
    <h3 class="alert alert-danger">No hay datos disponibles</h3>
    @endforelse

    <div class="row">
        <div class="col-12 text-center">
            <a class="btn btn-dark btn-sm small" href="{{ route('delegations.show', $delegation->id) }}">Volver</a>
        </div>
    </div>
    </div>

@endsection
