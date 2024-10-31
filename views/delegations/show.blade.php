@extends('plantilla.plantilla')
@section('titulo', 'Zonas')
@section('style')
<link href="{{ asset('css/app.css') }}" rel="stylesheet">@endsection
@section('contenido')
    <div class="container d-none d-md-block">
        <div class="row">
            <div class="col-12 text-center d-flex justify-content-center mt-5 mb-5" id="headerAll">
                <div class="w-50 ttl">
                    <h1>Delegación {{ $delegation->name }}</h1>
                </div>
            </div>
            <div class="col-6 {{ auth()->user()->hasAnyRole(['Tecnico', 'Jefe Salones', 'Oficina'])? 'offset-3': '' }}">
                <div class="row">
                    <div class="col-8 offset-2 isla-list">
                        <div class="p-2">
                            <div class="row p-2">
                                @if (!auth()->user()->hasAnyRole(['Tecnico', 'Jefe Salones', 'Oficina']))
                                    <div class="col-3">
                                        <a class="btn btn-primary w-100 btn-ttl" data-bs-toggle="modal"
                                            data-bs-target="#modalCrearZona">+</a>
                                    </div>
                                    <div class="col-9">
                                        <a class="btn btn-primary w-100 btn-ttl">Zona</a>
                                    </div>
                                @else
                                    <div class="col-12">
                                        <a class="btn btn-primary w-100 btn-ttl">Zona</a>
                                    </div>
                                @endif
                            </div>
                            <div>
                                @foreach ($delegation->zones as $zone)
                                    <div class="row p-2">
                                        @if (!auth()->user()->hasAnyRole(['Tecnico', 'Jefe Salones', 'Oficina']))
                                            <div class="col-3 d-flex justify-content-center">
                                                <a class="btn btn-primary w-100 btn-inf" data-bs-toggle="modal"
                                                    data-bs-target="#modalAccionesZones{{ $zone->id }}"
                                                    style="width: 60% !important">...</a>
                                            </div>
                                            <div class="col-9 d-flex justify-content-center">
                                                <a class="btn btn-primary w-100 btn-inf"
                                                    href="{{ route('zones.show', $zone->id) }}"
                                                    style="width: 80% !important">{{ $zone->name }}</a>
                                            </div>
                                        @else
                                            <div class="col-12 d-flex justify-content-center">
                                                <a class="btn btn-primary w-100 btn-inf"
                                                    href="{{ route('zones.show', $zone->id) }}"
                                                    style="width: 80% !important">{{ $zone->name }}</a>
                                            </div>
                                        @endif
                                    </div>

                                    <!--MODAL ACCIONES-->
                                    <div class="modal fade" id="modalAccionesZones{{ $zone->id }}"
                                        data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                        aria-labelledby="modalAcciones" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="modalAccionesLabel">Acciones para la
                                                        zona de
                                                        {{ $zone->name }}</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('zones.update', $zone->id) }}" method="post">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="delegation_id"
                                                            value="{{ $zone->delegation_id }}">
                                                        <div class="mb-5">
                                                            <label for="name" class="form-label">Nombre
                                                                zona:</label><br>
                                                            <input type="text" name="name" class="form-control"
                                                                value="{{ $zone->name }}">
                                                        </div>
                                                        <div class="text-end">
                                                            <button type="submit" class="btn btn-warning">Editar</button>
                                                            <a class="btn btn-danger" data-bs-toggle="modal"
                                                                data-bs-target="#eliminarModal{{ $zone->id }}">
                                                                Eliminar
                                                            </a>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--Modal eliminar-->
                                    <div class="modal fade" id="eliminarModal{{ $zone->id }}" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1"
                                        aria-labelledby="eliminarModal{{ $delegation->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">¿Eliminar
                                                        {{ $zone->name }}!</h1>
                                                    <a href="{{ route('delegations.show', $delegation->id) }}"
                                                        class="btn btn-close"></a>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Estas seguro que quieres eliminar la zona de {{ $zone->name }}?
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="{{ route('zones.destroy', $zone->id) }}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="delegation_id"
                                                            value="{{ $zone->delegation_id }}">
                                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!--Modal Crear zona-->
                            <div class="modal fade" id="modalCrearZona" data-bs-backdrop="static" data-bs-keyboard="false"
                                tabindex="-1" aria-labelledby="modalCrearZona" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="modalCrearsLabel">Crear zona</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('zones.store') }}" method="POST">
                                                @csrf
                                                <div class="mb-5">
                                                    <label for="name" class="form-label">Nombre zona:</label><br>
                                                    <input type="text" name="nameZone" class="form-control">
                                                </div>
                                                <input type='hidden' name="idDelegation" value="{{ $delegation->id }}">
                                                <div class="text-end">
                                                    <input type="submit" value="Crear zona" class="btn btn-warning">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--<div class="row mt-3 d-md-none">
                                <div class="col-10 offset-1 text-center">
                                    <div class="col-10 offset-1 text-center p-3">
                                        <a href="{{ route('verMoneys', $delegation->id) }}" class="btn btn-danger">Consulta de
                                            valores mínimos</a>
                                    </div>
                                    @if (!auth()->user()->hasRole('Tecnico'))
                                        @if (auth()->user()->hasAnyRole(['Jefe Salones', 'Super Admin', 'Jefe Delegacion']))
    <div class="col-10 offset-1 text-center p-3">
                                                <a href="{{ route('usersmcdelegation.index', ['delegationId' => $delegation->id]) }}"
                                                    class="btn btn-danger w-75">Usuarios máquina de cambio</a>
                                            </div>
    @endif
                                        @if (auth()->user()->hasAnyRole(['Super Admin', 'Jefe Delegacion']))
    <div class="col-10 offset-1 text-center p-3">
                                                <a href="{{ route('showTypesMachines.index', ['id' => $delegation->id]) }}"
                                                    class="btn btn-danger w-75">Tipos de máquinas</a>
                                            </div>
                                            <div class="col-10 offset-1 text-center p-3">
                                                <a href="{{ route('usersPerdidos.index') }}" class="btn btn-danger w-75">Usuarios
                                                    perdidos</a>
                                            </div>
    @endif
                                        @if (auth()->user()->hasAnyRole(['Oficina', 'Super Admin', 'Jefe Delegacion']))
    <div class="col-10 offset-1 text-center p-3">
                                                <a href="{{ route('machines.index', $delegation->id) }}"
                                                    class="btn btn-danger w-75">Máquinas</a>
                                            </div>
    @endif
                                    @endif
                                </div>
                            </div>-->
                </div>
            </div>

            @if (!auth()->user()->hasAnyRole(['Tecnico', 'Jefe Salones', 'Oficina']))
                <div class="col-6">
                    <div class="row">
                        <div class="col-8 offset-2 isla-list">
                            <div class="p-2">
                                <div class="row p-2">
                                    <div class="col-3">
                                        <a class="btn btn-primary w-100 btn-ttl"
                                            href="{{ route('users.createUsers', $delegation->id) }}">+</a>
                                    </div>
                                    <div class="col-9">
                                        <a class="btn btn-primary w-100 btn-ttl">Técnicos</a>
                                    </div>
                                </div>
                                <div>
                                    @foreach ($delegation->users as $user)
                                        @if (!auth()->user()->hasAnyRole(['Tecnico', 'Jefe Salones', 'Oficina']))
                                            <div class="row p-2">
                                                <div class="col-3 d-flex justify-content-center">
                                                    <a class="btn btn-primary w-100 btn-inf" data-bs-toggle="modal"
                                                        data-bs-target="#modalAccionesUsers{{ $user->id }}"
                                                        style="width: 60% !important">...</a>
                                                </div>
                                                <div class="col-9 d-flex justify-content-center">
                                                    <a class="btn btn-primary w-100 btn-inf"
                                                        style="width: 80% !important">{{ $user->name }}</a>
                                                </div>
                                            </div>

                                            <!--MODAL ACCIONES-->
                                            <div class="modal fade" id="modalAccionesUsers{{ $user->id }}"
                                                data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                aria-labelledby="modalAccionesUsers" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="modalAccionesLabel">Acciones
                                                                para
                                                                el
                                                                usuario
                                                                {{ $user->name }}</h1>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="text-center">
                                                                <a href="{{ route('users.edit', $user->id) }}"
                                                                    class="btn btn-warning">Editar</a>
                                                                <a class="btn btn-danger" data-bs-toggle="modal"
                                                                    data-bs-target="#eliminarModalUser{{ $user->id }}">
                                                                    Eliminar
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <!--Modal eliminar-->
                                            <div class="modal fade" id="eliminarModalUser{{ $user->id }}"
                                                data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                aria-labelledby="eliminarModalUser{{ $user->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">
                                                                ¿Eliminar
                                                                {{ $user->name }}!</h1>
                                                            <a href="{{ route('delegations.show', $delegation->id) }}"
                                                                class="btn btn-close"></a>
                                                        </div>
                                                        <div class="modal-body">
                                                            ¿Estas seguro que quieres eliminar el usuario de
                                                            {{ $user->name }}?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form action="{{ route('users.destroy', $user->id) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-danger">Eliminar</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if ($error)
                <div class="toast-container position-fixed bottom-0 end-0 p-3" role="alert" aria-live="assertive"
                    aria-atomic="true" id="liveToast">
                    <div class="d-flex text-white p-3 rounded w-100" id="colorToast">
                        <div class="toast-body">
                            {{ $error }}
                        </div>
                    </div>
                </div>

                <script>
                    const toastLiveExample = document.getElementById('liveToast')
                    const toastBootstrap = new bootstrap.Toast(toastLiveExample)
                    toastBootstrap.show()
                </script>
            @endif

        </div>
    </div>

    <div class="container d-block d-md-none text-center pt-5">

        <div class="ttl d-flex align-items-center p-2">
            <div>
                <a href="{{ route('delegations.index') }}" class="titleLink">
                    <i style="font-size: 30pt" class="bi bi-arrow-bar-left"></i>
                </a>
            </div>
            <div>
                <h1>Delegación {{ $delegation->name }}</h1>
            </div>
        </div>

        <div class="mt-5 p-3 isla-list">
            @if (count($delegation->zones) != 0)
                <div class="col-12">
                    <a class="btn btn-primary w-100 btn-ttl">Zona</a>
                </div>
                @foreach ($delegation->zones as $zone)
                    <a href="{{ route('zones.show', $zone->id) }}"
                        class="btn btn-warning w-100 mt-3">{{ $zone->name }}</a>
                @endforeach
            @else
                <p>No existen zonas!</p>
            @endif

        </div>
        <div class="mt-5 p-3 isla-list">
            <div class="col-12">
                <a class="btn btn-primary w-100 btn-ttl">Otras opciones</a>
            </div>
            <div class="col-12 text-center mt-3">
                <a href="{{ route('verMoneys', $delegation->id) }}" class="btn btn-warning w-100">Consulta de valores
                    mínimos</a>
            </div>
            @if (!auth()->user()->hasRole('Tecnico'))
                @if (auth()->user()->hasAnyRole(['Jefe Salones', 'Super Admin', 'Jefe Delegacion']))
                    <div class="col-12 text-center mt-3">
                        <a href="{{ route('usersmcdelegation.index', ['delegationId' => $delegation->id]) }}"
                            class="btn btn-warning w-100">Usuarios máquina de cambio</a>
                    </div>
                @endif
                @if (auth()->user()->hasAnyRole(['Super Admin', 'Jefe Delegacion']))
                    <div class="col-12 text-center mt-3">
                        <a href="{{ route('showTypesMachines.index', ['id' => $delegation->id]) }}"
                            class="btn btn-warning w-100">Types</a>
                    </div>
                    <div class="col-12 text-center mt-3">
                        <a href="{{ route('usersPerdidos.index') }}" class="btn btn-warning w-100">Usuarios
                            perdidos</a>
                    </div>
                @endif
                @if (auth()->user()->hasAnyRole(['Oficina', 'Super Admin', 'Jefe Delegacion']))
                    <div class="col-12 text-center mt-3">
                        <a href="{{ route('machines.index', $delegation->id) }}" class="btn btn-warning w-100">Máquinas</a>
                    </div>
                @endif
            @endif
        </div>
    </div>

@endsection
