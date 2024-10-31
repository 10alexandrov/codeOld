@extends('plantilla.plantilla')
@section('titulo', 'Delegations')
@section('contenido')
    <!--<div class="container d-none d-md-block">
                                        <div class="row">
                                            <div class="col-12 text-center d-flex justify-content-center mt-5 mb-5" id="headerAll">
                                                <div class="w-35 ttl">
                                                    <h1>Usuarios maquina de cambio</h1>
                                                </div>
                                            </div>
                                            <div class="col-6 @if (auth()->user()->hasRole('Jefe Delegacion')) offset-3 @endif">
                                                <div class="row">
                                                    <div class="col-8 offset-2 isla-list">
                                                        <div class="p-2">

                                                            @if (!auth()->user()->hasAnyRole(['Tecnico', 'Jefe Salones', 'Oficina']))
    <div class="col-3">
                                                                    <a class="btn btn-primary w-100 btn-ttl" href="{{ route('usersmcDelegation.create', $delegation->id) }}">+</a>
                                                                </div>
                                                                <div class="col-12">
                                                                    <a class="btn btn-primary w-100 btn-ttl">Usuarios</a>
                                                                </div>
    @endif

                                                                @foreach ($usersmc as $user)
    @if (!auth()->user()->hasAnyRole(['Tecnico', 'Jefe Salones', 'Oficina']))
    <div class="row p-2">
                                                                            <div class="col-3 d-flex justify-content-center">
                                                                                <a class="btn btn-primary w-100 btn-inf" data-bs-toggle="modal"
                                                                                    data-bs-target="#modalAccionesUsers{{ $user->id }}"
                                                                                    style="width: 60% !important">...</a>
                                                                            </div>
                                                                            <div class="col-9 d-flex justify-content-center">
                                                                                <a class="btn btn-primary w-100 btn-inf"
                                                                                    style="width: 80% !important">{{ $user->User }}</a>
                                                                            </div>
                                                                        </div>-->

    <!--MODAL ACCIONES-->
    <!--<div class="modal fade" id="modalAccionesUsers{{ $user->id }}"
                                                                            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                                            aria-labelledby="modalAccionesUsers" aria-hidden="true">
                                                                            <div class="modal-dialog">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h1 class="modal-title fs-5" id="modalAccionesLabel">Acciones
                                                                                            para el usuario {{ $user->User }}</h1>
                                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                                            aria-label="Close"></button>
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
                                                                        </div>-->

    <!--Modal eliminar-->
    <!--<div class="modal fade" id="eliminarModalUser{{ $user->id }}"
                                                                            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                                            aria-labelledby="eliminarModalUser{{ $user->id }}" aria-hidden="true">
                                                                            <div class="modal-dialog">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">
                                                                                            ¿Eliminar {{ $user->User }}!</h1>
                                                                                        <a href="{{ route('delegations.show', $delegation->id) }}"
                                                                                            class="btn btn-close"></a>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        ¿Estas seguro que quieres eliminar el usuario de
                                                                                        {{ $user->User }}?
                                                                                    </div>
                                                                                    <div class="modal-footer">

                                                                                        <form action="{{ route('usersmc.destroyTotal', $user->id) }}"
                                                                                            method="post">
                                                                                            @csrf
                                                                                            @method('DELETE')
                                                                                            <input type="hidden" name="delegation_id" value="{{ $delegation->id }}">
                                                                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
@else
    <div class="row p-2">
                                                                            <div class="col-12 d-flex justify-content-center">
                                                                                <a class="btn btn-primary w-100 btn-inf" style="width: 80% !important">
                                                                                    {{ $user->User }}
                                                                                </a>
                                                                            </div>
                                                                        </div>
    @endif
    @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="container d-block d-md-none text-center pt-5">
                                        <div class="ttl">
                                            <h1>Delegaciones</h1>
                                        </div>
                                        <div class="mt-5 p-3 isla-list">



                                        </div>
                                    </div>-->


    <div class="container d-none d-md-block">
        <div class="row">
            <div class="col-12 text-center d-flex justify-content-center mt-3 mb-3" id="headerAll">
                <div class="w-50 ttl">
                    <h1>Usuarios ticketserver {{ $delegation->name }}</h1>
                </div>
            </div>
            @if ($lastFecha)
                <div class="row">
                    <div class="text-center p-2">
                        <p class="alert alert-info d-inline-block m-0 mb-4" role="alert">
                            {{ \Carbon\Carbon::parse($lastFecha->lastDate)->format('d-m-Y H:i') }}
                        </p>
                    </div>
                </div>
            @endif

            <div class="col-6 offset-3">
                <div class="row">
                    <div class="col-10 offset-1 isla-list">
                        <div class="p-4">

                            <!-- Primera opcion -->
                            <div class="row">
                                <form action="{{ route('usersmc.search', $delegation->id) }}" method="GET" class="mb-4"
                                    autocomplete="off">
                                    <div class="col-12 mb-3">
                                        <!--<input type="text" name="filter" id="userFilter" class="form-control"
                                                                        placeholder="Buscar usuarios...">-->
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Buscar usuarios...">
                                        </div>

                                        <div class="col-12 mb-3 mt-2">
                                            <select id="roleFilter" class="form-control" name="rol">
                                                <option value="">Todos los roles</option>
                                                <option value="Técnicos">Técnicos</option>
                                                <option value="Caja">Caja</option>
                                                <option value="Personal sala">Personal de sala</option>
                                                <option value="Desconocido">Desconocidos</option>
                                                <option value="Otros">Otros...</option>
                                            </select>
                                        </div>
                                        <div class="">
                                            <button class="btn btn-warning w-100 p-0" type="submit">Buscar</button>
                                        </div>
                                </form>
                            </div>

                            <div class="row p-2">
                                @if (!auth()->user()->hasAnyRole(['Tecnico', 'Jefe Salones', 'Oficina']))
                                    <div class="col-3">
                                        <a class="btn btn-primary w-100 btn-ttl"
                                            href="{{ route('usersmcDelegation.create', $delegation->id) }}">+</a>
                                    </div>
                                    <div class="col-9">
                                        <a class="btn btn-primary w-100 btn-ttl">Usuarios</a>
                                    </div>
                                @else
                                    <div class="col-12">
                                        <a class="btn btn-primary w-100 btn-ttl">Usuarios</a>
                                    </div>
                                @endif
                            </div>
                            <div>
                                @foreach ($usersmc as $user)
                                    <div class="row p-2 user-row" data-username="{{ $user->User }}"
                                        data-role="{{ $user->rol }}">
                                        @if (!auth()->user()->hasAnyRole(['Tecnico', 'Jefe Salones', 'Oficina']))
                                            <div class="col-3 d-flex justify-content-center">
                                                <a class="btn btn-primary w-100 btn-inf" data-bs-toggle="modal"
                                                    data-bs-target="#modalAccionesLocal{{ $user->id }}"
                                                    style="width: 60% !important">...</a>
                                            </div>
                                            <div class="col-9 d-flex justify-content-center">
                                                <a class="btn btn-primary w-100 btn-inf"
                                                    style="width: 80% !important">{{ $user->User }}</a>
                                            </div>
                                        @else
                                            <div class="col-12 d-flex justify-content-center">
                                                <a class="btn btn-primary w-100 btn-inf"
                                                    style="width: 80% !important">{{ $user->User }}</a>
                                            </div>
                                        @endif
                                    </div>

                                    <!--MODAL ACCIONES-->
                                    <div class="modal fade" id="modalAccionesLocal{{ $user->id }}"
                                        data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                        aria-labelledby="modalAcciones" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="modalAccionesLabel">Acciones para el
                                                        usuario
                                                        {{ $user->User }}</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="text-center">
                                                        <a type="submit" class="btn btn-warning"
                                                            href="{{ route('usersmc.edit', $user->id) }}">Editar</a>
                                                        <a class="btn btn-danger" data-bs-toggle="modal"
                                                            data-bs-target="#eliminarModal{{ $user->id }}">
                                                            Eliminar
                                                        </a>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--Modal eliminar-->
                                    <div class="modal fade" id="eliminarModal{{ $user->id }}"
                                        data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                        aria-labelledby="eliminarModal{{ $user->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">!Eliminar
                                                        {{ $user->name }}!</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Estas seguro que quieres eliminar el usuario {{ $user->User }}?
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="{{ route('usersmc.destroyTotal', $user->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="delegation_id"
                                                            value="{{ $delegation->id }}">
                                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="d-flex justify-content-center mt-4">
                                {{ $usersmc->links('vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-10 offset-1 mt-5">
                <div class="row">
                    <div class="col-12 isla-list">
                        <div class="p-4">
                            <!-- Botón Usuarios -->
                            <div class="row mb-3">
                                <div class="col-12 d-flex justify-content-center">
                                    <a class="btn btn-primary w-100 btn-ttl">Funcionalidades</a>
                                </div>
                            </div>

                            <!-- Botón Sincronizar Usuarios ticketServer -->
                            <div class="row mb-3">
                                <div class="col-12 d-flex justify-content-center">
                                    <a href="{{ route('usersmc.syncUsersmcView', $delegation->id) }}"
                                        class="btn btn-warning w-100">Sincronizar Usuarios ticketServer</a>
                                </div>
                            </div>

                            <!-- Botón Exportar usuarios ticketServer -->
                            <div class="row mb-3">
                                <div class="col-12 d-flex justify-content-center">
                                    <a href="{{ route('exportUsers', $delegation->id) }}"
                                        class="btn btn-warning w-100">Exportar usuarios ticketserver</a>
                                </div>
                            </div>
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
                <a href="{{ route('delegations.show', $delegation->id) }}" class="titleLink">
                    <i style="font-size: 30pt" class="bi bi-arrow-bar-left"></i>
                </a>
            </div>
            <div>
                <h1>Usuarios Ticket Server {{ $delegation->name }}</h1>
            </div>
        </div>

        <div class="mt-5 p-3 isla-list">
            @if (count($usersmc) != 0)

                @if (count($usersmc) != 0)
                    <div class="col-12 mt-4">
                        <form action="{{ route('usersmc.search', $delegation->id) }}" method="GET" class="mb-4"
                            autocomplete="off">
                            <div class="col-12 mb-3">
                                <!--<input type="text" name="filter" id="userFilter" class="form-control"
                                            placeholder="Buscar usuarios...">-->
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Buscar usuarios...">
                                </div>

                                <div class="col-12 mb-3 mt-2">
                                    <select id="roleFilter" class="form-control" name="rol">
                                        <option value="">Todos los roles</option>
                                        <option value="Técnicos">Técnicos</option>
                                        <option value="Caja">Caja</option>
                                        <option value="Personal sala">Personal de sala</option>
                                        <option value="Desconocido">Desconocidos</option>
                                        <option value="Otros">Otros...</option>
                                    </select>
                                </div>
                                <div class="">
                                    <button class="btn btn-warning w-100 btn-sm" type="submit">Buscar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif

                <div class="col-12">
                    <a class="btn btn-primary w-100 btn-ttl">Local</a>
                </div>
                @foreach ($usersmc as $user)
                    <a class="btn btn-warning w-100 mt-3">{{ $user->User }}</a>
                @endforeach
                <div class="d-flex justify-content-center mt-4">
                    {{ $usersmc->links('vendor.pagination.bootstrap-5') }}
                </div>
            @else
                <p>No existen locales!</p>
            @endif
        </div>

        <div class="col-12 mt-5">
            <div class="col-12 isla-list">
                <div class="p-4">
                    <!-- Botón Usuarios -->
                    <div class="row mb-3">
                        <div class="col-12 d-flex justify-content-center">
                            <a class="btn btn-primary w-100 btn-ttl">Funcionalidades</a>
                        </div>
                    </div>

                    <!-- Botón Sincronizar Usuarios ticketServer -->
                    <div class="row mb-3">
                        <div class="col-12 d-flex justify-content-center">
                            <a href="{{ route('usersmc.syncUsersmcView', $delegation->id) }}"
                                class="btn btn-warning w-100">Sincronizar Usuarios ticketServer</a>
                        </div>
                    </div>

                    <!-- Botón Exportar usuarios ticketServer -->
                    <div class="row mb-3">
                        <div class="col-12 d-flex justify-content-center">
                            <a href="{{ route('exportUsers', $delegation->id) }}" class="btn btn-warning w-100">Exportar
                                usuarios ticketserver</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filtro = document.querySelector('#userFilter');
            const roleFiltro = document.querySelector('#roleFilter');
            const userRows = document.querySelectorAll('.user-row');

            function filterUsers() {
                const usernameValue = filtro.value.toLowerCase();
                const roleValue = roleFiltro.value.toLowerCase();

                userRows.forEach(function(row) {
                    const username = row.getAttribute('data-username').toLowerCase();
                    const role = row.getAttribute('data-role').toLowerCase();

                    if ((username.includes(usernameValue) || usernameValue === '') &&
                        (role.includes(roleValue) || roleValue === '')) {
                        row.style.display = 'flex';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }

            filtro.addEventListener('input', filterUsers);
            roleFiltro.addEventListener('change', filterUsers);
        });
    </script>


@endsection
