@extends('plantilla.plantilla')
@section('titulo', 'Local')
@section('contenido')
    <!--<div class="container d-none d-md-block">
                                                    <div class="row">
                                                        <div class="col-12 text-center d-flex justify-content-center mt-5 mb-5" id="headerAll">
                                                            <div class="w-35 ttl">
                                                                <h1>Local {{ $local->name }}</h1>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 offset-3">
                                                        <div class="row">
                                                            <div class="col-10 offset-1 isla-list">
                                                                <div class="p-4">
                                                                    <div class="row p-2">
                                                                        <div class="col-12">
                                                                            <a class="btn btn-primary w-100 btn-ttl" href="">Operaciones</a>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <a class="btn btn-primary w-100 btn-inf"
                                                                                href="{{ route('info.show', $local->id) }}">Información maquina de cambio</a>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <a class="btn btn-primary w-100 btn-inf"
                                                                                href="{{ route('arqueos.show', $local->id) }}">Arqueo</a>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <a class="btn btn-primary w-100 btn-inf"
                                                                                href="{{ route('tickets.show', $local->id) }}">Tickets</a>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <a class="btn btn-primary w-100 btn-inf"
                                                                                href="{{ route('usersmc.show', $local->id) }}">Usuarios maquina de cambio</a>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <a class="btn btn-primary w-100 btn-inf"
                                                                                href="{{ route('configuration.show', $local->id) }}">Configuración maquina de cambio</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>-->



    <div class="container d-none d-md-block">
        <div class="row">
            <div class="col-12 text-center d-flex justify-content-center mt-3 mb-3" id="headerAll">
                <div class="w-50 ttl">
                    <h1>Salón {{ $local->name }}</h1>
                </div>
            </div>
            <div class="col-6 offset-3">
                <div class="row">
                    <div class="col-10 offset-1 isla-list">
                        <div class="p-4">
                            <div class="row p-2">
                                <div class="col-12">
                                    <a class="btn btn-primary w-100 btn-ttl">Operaciones</a>
                                </div>
                            </div>
                            <div>
                                <div class="row p-2">
                                    <div class="col-12 d-flex justify-content-center">
                                        <a class="btn btn-primary w-100 btn-inf" href="{{ route('info.show', $local->id) }}"
                                            style="width: 80% !important">Información máquina de cambio</a>
                                    </div>
                                </div>
                                <div class="row p-2">
                                    <div class="col-12 d-flex justify-content-center">
                                        <a class="btn btn-primary w-100 btn-inf"
                                            href="{{ route('arqueos.show', $local->id) }}"
                                            style="width: 80% !important">Arqueos</a>
                                    </div>
                                </div>
                                <div class="row p-2">
                                    <div class="col-12 d-flex justify-content-center">
                                        <a class="btn btn-primary w-100 btn-inf"
                                            href="{{ route('tickets.show', $local->id) }}"
                                            style="width: 80% !important">Tickets</a>
                                    </div>
                                </div>
                                <div class="row p-2">
                                    <div class="col-12 d-flex justify-content-center">
                                        <a class="btn btn-primary w-100 btn-inf"
                                            href="{{ route('machines.show', $local->id) }}"
                                            style="width: 80% !important">Cargas</a>
                                    </div>
                                </div>
                                @if (auth()->user()->hasAnyRole(['Super Admin', 'Jefe Delegacion', 'Jefe Salones']))
                                    <div class="row p-2">
                                        <div class="col-12 d-flex justify-content-center">
                                            <a class="btn btn-primary w-100 btn-inf"
                                                href="{{ route('usersmc.show', $local->id) }}"
                                                style="width: 80% !important">Usuarios máquina de cambio</a>
                                        </div>
                                    </div>
                                    @if (!auth()->user()->hasRole(['Jefe Salones']))
                                        <div class="row p-2">
                                            <div class="col-12 d-flex justify-content-center">
                                                <a class="btn btn-primary w-100 btn-inf"
                                                    href="{{ route('configuration.show', $local->id) }}"
                                                    style="width: 80% !important">Configuración máquina de cambio</a>
                                            </div>
                                        </div>

                                        <div class="row p-2">
                                            <div class="col-12 d-flex justify-content-center">
                                                <a class="btn btn-danger w-100 btn-inf"
                                                    href="{{ route('SyncBlueMachine', $local->id) }}"
                                                    style="width: 80% !important">Actualizar máquinas de cambio</a>
                                            </div>
                                        </div>
                                    @endif
                                @endif

                            </div>
                        </div>
                    </div>
                    <div class="col-10 offset-1 text-center mt-4">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-center p-0">
                                <a class="btn btn-danger w-100 btn-inf " href="{{ route('actualizarLocal', $local->id) }}"
                                    style="width: 80% !important">Actualizar datos</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container d-block d-md-none text-center pt-5">

        <div class="ttl d-flex align-items-center p-2">
            <div>
                <a href="{{ route('zones.show', $local->zone_id) }}" class="titleLink">
                    <i style="font-size: 30pt" class="bi bi-arrow-bar-left"></i>
                </a>
            </div>
            <div>
                <h1>Local {{ $local->name }}</h1>
            </div>
        </div>

        <div class="mt-5 p-3 isla-list">
            <div class="col-12">
                <a class="btn btn-primary w-100 btn-ttl">Operaciones</a>
            </div>

            <a href="{{ route('info.show', $local->id) }}" class="btn btn-warning w-100 mt-3">Información máquina de
                cambio</a>
            <a href="{{ route('arqueos.show', $local->id) }}" class="btn btn-warning w-100 mt-3">Arqueos</a>
            <a href="{{ route('tickets.show', $local->id) }}" class="btn btn-warning w-100 mt-3">Tickets</a>
            <a href="{{ route('machines.show', $local->id) }}" class="btn btn-warning w-100 mt-3">Cargas</a>
            @if (auth()->user()->hasAnyRole(['Super Admin', 'Jefe Delegacion', 'Jefe Salones']))
                <a href="{{ route('usersmc.show', $local->id) }}" class="btn btn-warning w-100 mt-3">Usuarios máquina de
                    cambio</a>
                @if (!auth()->user()->hasRole(['Jefe Salones']))
                    <a href="{{ route('configuration.show', $local->id) }}"
                        class="btn btn-warning w-100 mt-3">Configuración
                        máquina de cambio</a>
                    <a href="{{ route('machines.show', $local->id) }}" class="btn btn-warning w-100 mt-3">Cargas</a>
                @endif
            @endif
        </div>
        <div class="mt-4">
            <div class="col-12 d-flex justify-content-center p-0">
                <a class="btn btn-danger w-100 btn-inf " href="{{ route('actualizarLocal', $local->id) }}"
                    style="width: 80% !important">Actualizar datos</a>
            </div>
        </div>
    </div>



@endsection
