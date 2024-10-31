@extends('plantilla.plantilla')
@section('titulo', 'Locales')
@section('contenido')
    <div class="container-fluid">
        <!-- <h1>Delegación de </h1>-->

        <h3>Locales de {{ $zone->name }}</h3>
        <div>
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                @foreach ($zone->locals as $local)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-{{ $local->id }}-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-{{ $local->id }}" role="tab"
                            aria-controls="pills-{{ $local->id }}" aria-selected="true">{{ $local->name }}</button>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="tab-content" id="pills-tabContent">
            @foreach ($zone->locals as $local)
                <div class="tab-pane" id="pills-{{ $local->id }}" role="tabpanel"
                    aria-labelledby="pills-{{ $local->id }}-tab" tabindex="0">
                    <div>
                        <p class="d-inline-flex gap-1">
                            <button class="btn btn-warning" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample"
                                aria-expanded="false" aria-controls="collapseExample">
                                Editar Local
                            </button>
                        </p>

                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop{{$local->id}}">
                            Eliminar Local
                        </button>
                    </div>

                    <!--EDITAR local-->
                    <div class="collapse" id="collapseExample">
                        <div class="card card-body">
                            <form action="/delegations/zones/locals/update/{{ $local->id }}" method="POST">
                                @csrf
                                <input type="text" name="name" value="{{ $local->name }}">
                                <input type="text" name="ip_address" value="{{ $local->ip_address }} IP?">
                                <input type="text" name="port" value="{{ $local->port }} puerto?">
                                <input type="text" name="dbconnection" value="{{ $local->dbconnection }} conexión?">
                                <input type="text" name="idmachine" value="{{ $local->idmachine }} idMachine?">
                                <input type="hidden" name="zone_id" value="{{ $zone->id}}">
                                <input class="btn btn-warning" type="submit" value="Editar">
                            </form>
                        </div>
                    </div>

                    <!-- Modal eliminar local-->
                    <div class="modal fade" id="staticBackdrop{{$local->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                        aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Zona {{ $zone->name }}, local de {{ $local->name }}</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    ¿Estas seguro que quieres eliminar el local {{ $local->name }} de la zona {{$zone->name}}?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <a class="btn btn-danger" href="/delegations/zones/locals/destroy/{{ $local->id }}">Eliminar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Editar zona -->
        <p class="d-inline-flex gap-1">
            <button class="btn btn-warning" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample"
                aria-expanded="false" aria-controls="collapseExample">
                Editar zona
            </button>
        </p>

        <!-- Eliminar zona -->
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            Eliminar zona
        </button>

        <div class="collapse" id="collapseExample">
            <div class="card card-body">
                <form action="/delegations/zones/update/{{ $zone->id }}" method="POST">
                    @csrf
                    <input type="text" name="name" value="{{ $zone->name }}">
                    <input type="hidden" name="delegation_id" value="{{ $zone->delegation_id }}">
                    <input class="btn btn-warning" type="submit" value="Editar">
                </form>
            </div>
        </div>

        <!-- Modal eliminar zona-->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Eliminar! la zona de {{ $zone->name }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ¿Estas seguro que quieres eliminar la zona de {{ $zone->name }}? Se eliminaran todos los locales de dicha zona
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <a class="btn btn-danger" href="/delegations/zones/destroy/{{ $zone->id }}">Eliminar</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Crear local -->
        <div>
            <form action="/delegations/zones/locals/store" method="POST">
                @csrf
                <input type="text" name="nameLocal" value="">
                <input type='hidden' name="idZona" value="{{ $zone->id }}">
                <input type="submit" value="Crear Local">
            </form>
        </div>

    </div>



@endsection
