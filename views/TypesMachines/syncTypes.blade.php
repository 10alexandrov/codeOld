@extends('plantilla.plantilla')
@section('titulo', 'Asignar tipos de máquinas a locales')
@section('contenido')

<div class="container text-center pt-5">
    <div class="col-12 text-center d-none d-md-flex justify-content-center mt-5 mb-5">
        <div class="w-50 ttl">
            <h1>Asignar tipos de máquinas a locales</h1>
        </div>
    </div>
    <div class="ttl d-flex align-items-center p-2">
        <div>
            <a href="{{ route('showTypesMachines.index', $delegation->id) }}" class="titleLink">
                <i style="font-size: 30pt" class="bi bi-arrow-bar-left"></i>
            </a>
        </div>
        <div>
            <h1>Asignar tipos de máquinas a locales</h1>
        </div>
    </div>

    <div class="container">
        @if (!$types->isEmpty())
            <div class="row mt-5">
                <div class="col-md-12">

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <input type="text" name="filter" id="typeFilter" class="form-control" placeholder="Buscar por nombre">
                        </div>
                        <div class="col-md-4 mb-3">
                            <select id="localFilter" class="form-control">
                                <option value="">Buscar por local</option>
                                @foreach($locals as $local)
                                    <option value="{{ $local->id }}">{{ $local->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-3">
                        <form action="{{ route('typeMachines.syncTypeMachines') }}" method="POST">
                            @csrf
                            @method('POST')
                            <input type="hidden" name="delegation_id" value="{{ $delegation->id }}">
                            <div class="row">
                                <!-- Tabla de tipos de máquinas -->
                                <div class="col-md-8">
                                    <table class="table" id="typesTable">
                                        <thead>
                                            <tr>
                                                <th scope="col">Tipo de máquina</th>
                                                <th scope="col"><input type="checkbox" id="selectAllTypes"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($types as $type)
                                                <tr class="type-row" data-typeName="{{ $type->name }}" data-localIds="{{ $type->locals->pluck('id')->implode(',') }}">
                                                    <td>{{ $type->name }}</td>
                                                    <td>
                                                        <input type="checkbox" class="checkbox type-checkbox" name="types[]" value="{{ $type->id }}">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Tabla de locales -->
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
            <h3 class="alert alert-danger">No hay tipos de máquinas en este local</h3>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeFilter = document.querySelector('#typeFilter');
        const localFilter = document.querySelector('#localFilter');
        const typeRows = document.querySelectorAll('.type-row');
        const selectAllTypesCheckbox = document.querySelector('#selectAllTypes');
        const selectAllLocalsCheckbox = document.querySelector('#selectAllLocals');
        const syncButton = document.querySelector('#syncButton');

        function filterTypes() {
            const typeNameValue = typeFilter.value.toLowerCase();
            const localValue = localFilter.value;

            typeRows.forEach(function(row) {
                const typeName = row.getAttribute('data-typeName').toLowerCase();
                const localIds = row.getAttribute('data-localIds').split(',');

                const matchesLocal = !localValue || localIds.includes(localValue);

                if ((typeName.includes(typeNameValue) || typeNameValue === '') &&
                    matchesLocal) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function updateSyncButtonState() {
            const typeChecked = document.querySelectorAll('.type-checkbox:checked').length > 0;
            const localChecked = document.querySelectorAll('.local-checkbox:checked').length > 0;
            syncButton.disabled = !(typeChecked && localChecked);
        }

        typeFilter.addEventListener('input', filterTypes);
        localFilter.addEventListener('change', filterTypes);

        selectAllTypesCheckbox.addEventListener('change', function() {
            typeRows.forEach(function(row) {
                if (row.style.display !== 'none') {
                    row.querySelector('.type-checkbox').checked = selectAllTypesCheckbox.checked;
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

        document.querySelectorAll('.type-checkbox, .local-checkbox').forEach(function(checkbox) {
            checkbox.addEventListener('change', updateSyncButtonState);
        });

        updateSyncButtonState();
    });
</script>

@endsection
