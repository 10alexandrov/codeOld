@extends('plantilla.plantilla')
@section('titulo', 'Local')
@section('contenido')

<div class="container text-center pt-5">
    <div class="col-12 text-center d-none d-md-flex justify-content-center mt-5 mb-5">
        <div class="w-50 ttl">
            <h1>Asignar usuarios ticketserver a locales</h1>
        </div>
    </div>
    <div class="ttl d-flex align-items-center p-2">
        <div>
            <a href="{{ route('usersmcdelegation.index', $delegation->id) }}" class="titleLink">
                <i style="font-size: 30pt" class="bi bi-arrow-bar-left"></i>
            </a>
        </div>
        <div>
            <h1>Asignar usuarios ticketserver a locales</h1>
        </div>
    </div>
    <div class="container">
        @if (!$usersmc->isEmpty())
            <div class="row mt-5">
                <div class="col-md-12">

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <!--<label for="userFilter">Seleccionar por nombre:</label>-->
                            <input type="text" name="filter" id="userFilter" class="form-control" placeholder="Buscar por nombre">
                        </div>
                        <div class="col-md-4 mb-3">
                            <!--<label for="roleFilter">Seleccionar rol:</label>-->
                            <select id="roleFilter" class="form-control">
                                <option value="">Buscar por rol</option>
                                <option value="Técnicos">Técnicos</option>
                                <option value="Caja">Caja</option>
                                <option value="Personal sala">Personal de sala</option>
                                <option value="Desconocido">Desconocido</option>
                                <option value="Otros">Otros...</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <!--<label for="localFilter">Seleccionar local:</label>-->
                            <select id="localFilter" class="form-control">
                                <option value="">Buscar por local</option>
                                @foreach($locals as $local)
                                    <option value="{{ $local->id }}">{{ $local->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-3">
                        <form action="{{ route('usersmc.syncUsersrmc') }}" method="POST">
                            @csrf
                            @method('POST')
                            <input type="hidden" name="delegation_id" value="{{ $delegation->id }}">
                            <div class="row">
                                <!-- Primera tabla -->
                                <div class="col-md-8">
                                    <table class="table" id="usersTable">
                                        <thead>
                                            <tr>
                                                <th scope="col">Usuario</th>
                                                <th scope="col">Locales asociados</th>
                                                <th scope="col"><input type="checkbox" id="selectAllUsers"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($usersmc as $usr)
                                                <tr class="user-row" data-username="{{ $usr->User }}" data-role="{{ $usr->rol }}" data-locals="{{ $usr->locals->pluck('id')->implode(',') }}">
                                                    <td>{{ $usr->User }}</td>
                                                    <td>
                                                        <!-- Mostrar los locales asociados al usuario -->
                                                        @if($usr->locals->isNotEmpty())
                                                            {{ $usr->locals->pluck('name')->implode(', ') }}
                                                        @else
                                                            Sin locales
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class="checkbox user-checkbox" name="users[]" value="{{ $usr->id }}">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Segunda tabla -->
                                <div class="col-md-4">
                                    <table class="table" id="localsTable">
                                        <thead>
                                            <tr>
                                                <th scope="col"><input type="checkbox" id="selectAllLocals"></th>
                                                <th scope="col">Local</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($delegation->zones as $zone)
                                                @foreach ($zone->locals as $local)
                                                    <tr>
                                                        <td><input type="checkbox" class="checkbox local-checkbox" name="locals[]" value="{{ $local->id }}"></td>
                                                        <td>{{ $local->name }}</td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary" id="syncButton" disabled>Asignar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <h3 class="alert alert-danger">No hay usuarios en este local</h3>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filtro = document.querySelector('#userFilter');
        const roleFiltro = document.querySelector('#roleFilter');
        const localFiltro = document.querySelector('#localFilter');
        const userRows = document.querySelectorAll('.user-row');
        const selectAllUsersCheckbox = document.querySelector('#selectAllUsers');
        const selectAllLocalsCheckbox = document.querySelector('#selectAllLocals');
        const syncButton = document.querySelector('#syncButton');

        function filterUsers() {
            const usernameValue = filtro.value.toLowerCase();
            const roleValue = roleFiltro.value.toLowerCase();
            const localValue = localFiltro.value;

            userRows.forEach(function(row) {
                const username = row.getAttribute('data-username').toLowerCase();
                const role = row.getAttribute('data-role').toLowerCase();
                const locals = row.getAttribute('data-locals').split(',');

                const matchesLocal = !localValue || locals.includes(localValue);

                if ((username.includes(usernameValue) || usernameValue === '') &&
                    (role.includes(roleValue) || roleValue === '') &&
                    matchesLocal) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function updateSyncButtonState() {
            const userChecked = document.querySelectorAll('.user-checkbox:checked').length > 0;
            const localChecked = document.querySelectorAll('.local-checkbox:checked').length > 0;
            syncButton.disabled = !(userChecked && localChecked);
        }

        filtro.addEventListener('input', filterUsers);
        roleFiltro.addEventListener('change', filterUsers);
        localFiltro.addEventListener('change', filterUsers);

        selectAllUsersCheckbox.addEventListener('change', function() {
            userRows.forEach(function(row) {
                if (row.style.display !== 'none') {
                    row.querySelector('.user-checkbox').checked = selectAllUsersCheckbox.checked;
                }
            });
            updateSyncButtonState();
        });

        selectAllLocalsCheckbox.addEventListener('change', function() {
            document.querySelectorAll('.local-checkbox').forEach(function(checkbox) {
                checkbox.checked = selectAllLocalsCheckbox.checked;
            });
            updateSyncButtonState();
        });

        document.querySelectorAll('.user-checkbox, .local-checkbox').forEach(function(checkbox) {
            checkbox.addEventListener('change', updateSyncButtonState);
        });

        updateSyncButtonState();
    });
</script>

@endsection
