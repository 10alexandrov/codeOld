@extends('plantilla.plantilla')
@section('titulo', 'Local')
@section('contenido')
    <div class="container text-center pt-5">
        <div class="col-12 text-center d-none d-md-flex justify-content-center mt-5 mb-5">
            <div class="w-50 ttl">
                <h1>{{ $local->name }}</h1>
            </div>
        </div>

        <!-- SElect con los user de la maquina de cambio para luego mostrar los arqueos que necesitamos -->
        <!-- Mostrar el select solo si hay más de un registro en auxmoneystorageinfo -->
        @if ($countSelect)
            <form method="GET" action="{{ route('info.show', $local->id) }}">
                <div class="p-2">
                    <select name="userMoney" id="user-0" class="form-select form-select-lg mb-3"
                        aria-label=".form-select-lg example" onchange="this.form.submit()">
                        @foreach ($machines as $machine)
                            <option value="{{ $machine }}" {{ $selectedUserMoney == $machine ? 'selected' : '' }}>
                                {{ $machine }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        @endif
        <div class="d-block d-md-none text-center mb-3">
            <div class="ttl d-flex align-items-center">
                <div>
                    <a href="{{ route('locals.show', $local->id) }}" class="titleLink">
                        <i style="font-size: 30pt" class="bi bi-arrow-bar-left"></i>
                    </a>
                </div>
                <div>
                    <h1>Local {{ $local->name }}</h1>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <ul class="nav nav-tabs ul-aux border-0" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active btn-danger" id="profile-tab" data-bs-toggle="tab"
                        data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane"
                        aria-selected="false">Auxiliares</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link btn-danger" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane"
                        type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Arqueo</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link btn-danger" id="contact-tab" data-bs-toggle="tab"
                        data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane"
                        aria-selected="false">Tickets</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link btn-danger" id="moviments-tab" data-bs-toggle="tab"
                        data-bs-target="#moviments-tab-pane" type="button" role="tab"
                        aria-controls="moviments-tab-pane" aria-selected="false">Últimos movimientos</button>
                </li>
            </ul>
        </div>

        <div class="mt-2">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                    @if (!empty($updatesObject->collectUpdate))
                        <div class="row">
                            <div class="text-center p-2">
                                <p class="alert alert-info d-inline-block m-0" role="alert">
                                    {{ \Carbon\Carbon::parse($updatesObject->collectUpdate)->format('d-m-Y H:i') }}
                                </p>
                            </div>
                        </div>
                    @endif

                    <div class="d-md-flex justify-content-evenly w-100">
                        <div class="col-12 col-md-6">
                            <table class="w-100 table table-bordered">
                                <tr>
                                    <th>Localización</th>
                                    <th class="text-center">Valor</th>
                                    <th class="text-center">Cantidad</th>
                                    <th class="text-end">Dinero total</th>
                                </tr>
                                @php
                                    // Sumar todas las cantidades de 'Rechazo'
                                    $rechazoTotal = 0;
                                    foreach ($collectOrdenado as $collect) {
                                        if ($collect->LocationType === 'Rechazo') {
                                            $rechazoTotal += $collect->Quantity;
                                        }
                                    }
                                @endphp
                                @foreach ($collectOrdenado as $collect)
                                    @php
                                        // Determinar si la fila debe estar resaltada
                                        $isDanger =
                                            ($collect->LocationType === 'Multimoneda' && $collect->Quantity < 50) ||
                                            ($collect->LocationType === 'Hopper 1€' && $collect->Quantity < 1000) ||
                                            ($rechazoTotal > 10 && $collect->LocationType === 'Rechazo');
                                    @endphp
                                    <tr @if (
                                        ($collect->LocationType === 'Multimoneda' && $collect->Quantity < 50) ||
                                            ($collect->LocationType === 'Hopper 1€' && $collect->Quantity < 1000) ||
                                            ($collect->LocationType === 'Rechazo' && $collect->Quantity > 10)) class="table-danger" @endif>
                                        <td>{{ $collect->LocationType }}</td>
                                        <td class="text-center">{{ $collect->MoneyValue }}</td>
                                        <td class="text-center">{{ $collect->Quantity }}</td>
                                        <td class="text-end">{{ $collect->Amount }}€</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th colspan="3">Arqueo total:</th>
                                    <td class="text-end">{{ $collectsData->arqueoTotal }}€</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-12 col-md-4 offset-md-1">
                            <table class="w-100 table table-bordered">
                                <tr>
                                    <th colspan="2">Dinero activo</th>
                                </tr>
                                <tr>
                                    <td>Total recicladores</td>
                                    <td class="text-end">{{ $collectsData->totalRecicladores }}€</td>
                                </tr>
                                <tr>
                                    <td>Total pagadores</td>
                                    <td class="text-end">{{ $collectsData->totalPagadores }}€</td>
                                </tr>
                                <tr>
                                    <td>Total multimoneda</td>
                                    <td class="text-end">{{ $collectsData->totalMultimoneda }}€</td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td class="text-end">{{ $collectsData->dineroActivo }}€</td>
                                </tr>
                            </table>

                            <table class="w-100 table table-bordered">
                                <tr>
                                    <th colspan="2">Dinero no activo</th>
                                </tr>
                                <tr>
                                    <td>Total apiladores</td>
                                    <td class="text-end">{{ $collectsData->totalApiladores }}€</td>
                                </tr>
                                <tr>
                                    <td>Total rechazo dispensador</td>
                                    <td class="text-end">{{ $collectsData->totalRechazoDispensador }}€</td>
                                </tr>
                                <tr>
                                    <td>Total cajones</td>
                                    <td class="text-end">{{ $collectsData->totalCajones }}€</td>
                                </tr>
                                <tr>
                                    <td>Total cajones virtuales</td>
                                    <td class="text-end">{{ $collectsData->totalCajonesVirtuales }}€</td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td class="text-end">{{ $collectsData->dineroNoActivo }}€</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show active" id="profile-tab-pane" role="tabpanel"
                    aria-labelledby="profile-tab" tabindex="0">
                    @if (!empty($updatesObject->auxmoneystorageinfo))
                        <div class="row">
                            <div class="text-center p-2">
                                <p class="alert alert-info d-inline-block m-0" role="alert">
                                    {{ \Carbon\Carbon::parse($updatesObject->auxmoneystorageinfo)->format('d-m-Y H:i') }}
                                </p>
                            </div>
                        </div>
                    @endif

                    <div class="w-100 d-flex justify-content-center">
                        @if ($collectDetailsData)
                            <table class="w-50 table table-bordered text-end">
                                <tr>
                                    <td colspan="4" class="text-start">Saldo inicial</td>
                                    <td>{{ $collectDetailsData->calculoCollectDetails50->saldoInicial }}€</td>
                                </tr>
                                <tr @if ($collectDetailsData->disponible < $collectDetailsData->calculoCollectDetails50->saldoInicial) class="table-danger" @endif>
                                    <td colspan="4" class="text-start">Disponible</td>
                                    <td>{{ $collectDetailsData->calculoCollectDetails50->disponible }}€</td>
                                </tr>
                                <tr>
                                    <td colspan="5"></td>
                                </tr>
                                <tr>
                                    <th colspan="3">Entradas</th>
                                    <th>Salidas</th>
                                    <th>Balance</th>
                                </tr>
                                @foreach ($collectDetailsData->apuestas as $apuestasData)
                                    <tr>
                                        <td colspan="2" class="text-center">{{ $apuestasData->Name }}</td>
                                        <td>{{ $apuestasData->Money1 }}€</td>
                                        <td>{{ $apuestasData->Money2 }}€</td>
                                        <td>{{ $apuestasData->Money3 }}€</td>
                                    </tr>
                                @endforeach

                                <tr>
                                    <td colspan="5"></td>
                                </tr>
                                <tr>
                                    <th colspan="3">Entradas</th>
                                    <th>Salidas</th>
                                    <th>Balance</th>
                                </tr>

                                @php
                                    $typeIsAuxOrder = $local
                                        ->auxmoneystorage()
                                        ->orderByRaw('CAST(auxmoneystorage."TypeIsAux" AS INTEGER) asc')
                                        ->get();
                                    //dd($typeIsAuxOrder);
                                @endphp
                                @foreach ($typeIsAuxOrder as $auxmoneystorage)
                                    @foreach ($collectDetailsData->auxiliares as $auxiliares)
                                        @if ($auxmoneystorage->AuxName == $auxiliares->Name)
                                            <tr>
                                                <td class="text-center">{{ $auxmoneystorage->TypeIsAux }}</td>
                                                <td class="text-start">{{ $auxiliares->Name }}</td>
                                                <td>{{ $auxiliares->Money1 }}€</td>
                                                <td>{{ $auxiliares->Money2 }}€</td>
                                                <td>{{ $auxiliares->Money3 }}€</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach
                            </table>
                        @endif
                    </div>
                </div>
                <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab"
                    tabindex="0">
                    @if (!empty($ultimaModificacionTickets))
                        <div class="row">
                            <div class="text-center p-2">
                                <p class="alert alert-info d-inline-block m-0" role="alert">
                                    {{ \Carbon\Carbon::parse($ultimaModificacionTickets)->format('d-m-Y H:i') }}
                                </p>
                            </div>
                        </div>
                    @endif
                    <div >
                        @if ($ticketsFilter->isNotEmpty())
                            <table>
                                @foreach ($ticketsDataAnterior as $ticket)
                                    <tr>
                                        <th colspan="2">{{ $ticket->name }} {{ strtoupper($yesterdayName) }}</th>
                                    </tr>
                                    <tr>
                                        <td>Total:</td>
                                        <td>{{ $ticket->valor }}€</td>
                                    </tr>
                                @endforeach
                            </table>
                            <br>
                            <table>
                                @foreach ($ticketsDataActual as $ticket)
                                    <tr>
                                        <th colspan="2">{{ $ticket->name }} {{ strtoupper($todayName) }}</th>
                                    </tr>
                                    <tr>
                                        <td>Total:</td>
                                        <td>{{ $ticket->valor }}€</td>
                                    </tr>
                                @endforeach
                            </table>
                            <br>
                            <div class="table-responsive">
                                <table class="table w-xs-250">
                                    <thead>
                                        <tr>
                                            <th scope="col">Número de ticket</th>
                                            <th scope="col" class="text-center">Fecha</th>
                                            <th scope="col" class="text-center">Usuario</th>
                                            <th scope="col" class="text-center">Valor (€)</th>
                                            <th scope="col" class="text-center">Tipo</th>
                                            <th scope="col" class="text-center">Comentario</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ticketsFilter as $ticket)
                                            <tr>
                                                <td>{{ $ticket->TicketNumber }}</td>
                                                <td class="text-center">
                                                    {{ \Carbon\Carbon::parse($ticket->DateTime)->format('d-m-Y H:i') }}
                                                </td>
                                                <td class="text-center">{{ $ticket->User }}</td>
                                                <td class="text-center">{{ $ticket->Value }}€</td>
                                                <td class="text-center">{{ $ticket->Type }}</td>
                                                <td class="text-center">{{ $ticket->Comment }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <h3 class="alert alert-danger">No hay tickets</h3>
                        @endif
                        @if (!empty($ticketRarosData))
                            <div class="table-responsive mt-5">
                                <h1>Tickets metidos a mano por pantalla</h1>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Número de ticket</th>
                                            <th scope="col">Fecha</th>
                                            <th scope="col">Usuario</th>
                                            <th scope="col">Valor €</th>
                                            <th scope="col">Tipo</th>
                                            <th scope="col">Comentarios</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ticketRarosData as $ticket)
                                            <tr>
                                                <td>{{ $ticket->TicketNumber }}</td>
                                                <td>{{ \Carbon\Carbon::parse($ticket->DateTime)->format('d-m-Y H:i') }}
                                                </td>
                                                <td>{{ $ticket->User }}</td>
                                                <td>{{ $ticket->Value }}€</td>
                                                <td>{{ $ticket->Type }}</td>
                                                <td>{{ $ticket->Comment }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                    <!--<div class="d-block d-md-none">
                        @if ($local->tickets->isNotEmpty())
                            @foreach ($ticketsData as $ticket)
                                <table class="d-flex justify-content-center">
                                    <tr>
                                        <th colspan="2">{{ $ticket->name }}</th>
                                    </tr>
                                    <tr>
                                        <td>Total:</td>
                                        <td>{{ $ticket->valor }}€</td>
                                    </tr>
                                </table>
                            @endforeach
                        @else
                            <h3 class="alert alert-danger">No hay tickets</h3>
                        @endif

                        @if (!empty($ticketRarosData))
                            <div class="table-responsive mt-5">
                                <h4>Tickets metidos a mano por pantalla</h4>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Fecha</th>
                                            <th scope="col">Valor €</th>
                                            <th scope="col">Tipo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ticketRarosData as $ticket)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($ticket->DateTime)->format('d-m-Y H:i') }}
                                                </td>
                                                <td>{{ $ticket->Value }}€</td>
                                                <td>{{ $ticket->Type }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>-->
                </div>

                @php
                    use App\Models\UserTicketServer;
                    use Illuminate\Support\Facades\Crypt;
                @endphp

                <div class="tab-pane fade" id="moviments-tab-pane" role="tabpanel" aria-labelledby="moviments-tab"
                    tabindex="0">
                    @if (!empty($logs))
                        <div class="table-responsive text-start">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Tipo</th>
                                        <th scope="col">Texto</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Usuario</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($logs as $log)
                                        @php
                                            $userFind = $log->User;

                                            if (substr($userFind, 0, 3) == 'PID') {
                                                $allUsers = UserTicketServer::all();
                                                foreach ($allUsers as $user) {
                                                    try {
                                                        $pidDecrypt = Crypt::decrypt($user->PID);

                                                        if ($pidDecrypt == $userFind) {
                                                            $userFind = $user->User; // Added missing semicolon here
                                                            break; // Exit the loop once a match is found
                                                        }
                                                    } catch (\Exception $e) {
                                                        // Handle decryption failure (optional)
                                                    }
                                                }
                                            }
                                        @endphp

                                        <tr>
                                            <td>{{ $log->Type }}</td>
                                            <td>{!! $log->Text !!}</td>
                                            <td>
                                                <span
                                                    class="d-md-none">{{ \Carbon\Carbon::parse($log->DateTime)->format('d-m H:i') }}</span>
                                                <span
                                                    class="d-none d-md-inline">{{ \Carbon\Carbon::parse($log->DateTime)->format('d-m-Y H:i') }}</span>
                                            </td>
                                            <td>{{ $userFind }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <h3 class="alert alert-danger">No existen registros</h3>
                    @endif
                </div>


            </div>
        </div>

    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Decodificar JSON en objetos JavaScript
                const collectsData = @json($collectsData);
                const collectDetailsData = @json($collectDetailsData);
                const ticketsData = @json($ticketsData);
                const collectOrdenado = @json($collectOrdenado);
                const ticketRarosData = @json($ticketRarosData);
                const ticketsDataAnterior = @json($ticketsDataAnterior);
                const ticketsDataActual = @json($ticketsDataActual);
                const todayName = @json($todayName);
                const yesterdayName = @json($yesterdayName);
                // Definir selectedUserMoney solo si hay varias máquinas
                const selectedUserMoney = @json($countSelect > 1 ? $selectedMachine : null);

                // Trabaja con los datos como objetos JavaScript
                console.log('Collects Data:', collectsData);
                console.log('Collect Details Data:', collectDetailsData);
                console.log('Tickets Data:', ticketsData);
                console.log('Collect Ordenado:', collectOrdenado);
                console.log('Ticket Raros Data:', ticketRarosData);
                console.log('Tickets Data Anterior:', ticketsDataAnterior);
                console.log('Tickets Data Actual:', ticketsDataActual);
                console.log('Today Name:', todayName);
                console.log('Yesterday Name:', yesterdayName);
                console.log('Selected User Money:', selectedUserMoney);

                // Ejemplo de cómo sumar cantidades de 'Rechazo' en collectOrdenado
                let rechazoTotal = 0;
                collectOrdenado.forEach(collect => {
                    if (collect.LocationType === 'Rechazo') {
                        rechazoTotal += collect.Quantity;
                    }
                });

                console.log('Rechazo Total:', rechazoTotal);
            });
        </script>
    @endsection
@endsection
