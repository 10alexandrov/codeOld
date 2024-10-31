@extends('plantilla.plantilla')
@section('titulo', 'Delegations')
@section('contenido')
    <div class="container d-none d-md-block">
        <div class="row">
            <div class="col-12 text-center d-flex justify-content-center mt-3 mb-3" id="headerAll">
                <div class="w-50 ttl">
                    <h1>Tipos de tickets {{ $delegation->name }}</h1>
                </div>
            </div>
            <div class="col-6 offset-3">
                <div class="row">
                    <div class="col-10 offset-1 isla-list">
                        <div class="p-4">
                            <form action="{{ route('typeMachines.search', $delegation->id) }}" method="GET" class="mb-4" autocomplete="off">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Buscar tipos de máquinas...">
                                    <div class="input-group-append">
                                        <button class="btn btn-warning" type="submit">Buscar</button>
                                    </div>
                                </div>
                            </form>
                            <div class="col-12 mb-3">
                                <a href="{{ route('typeMachines.showSyncTypeMachines', $delegation->id) }}"
                                    class="btn btn-danger w-100">Sincronizar tipos de ticket</a>
                            </div>
                            <div class="row p-2">
                                @if (!auth()->user()->hasAnyRole(['Tecnico', 'Jefe Salones', 'Oficina']))
                                    <div class="col-3">
                                        <a class="btn btn-primary w-100 btn-ttl"
                                            href="{{ route('typeMachinesDelegation.create', $delegation->id) }}">+</a>
                                    </div>
                                    <div class="col-9">
                                        <a class="btn btn-primary w-100 btn-ttl">Tipos</a>
                                    </div>
                                @else
                                    <div class="col-12">
                                        <a class="btn btn-primary w-100 btn-ttl">Tipos</a>
                                    </div>
                                @endif
                            </div>
                            <div>
                                @include('partials.types')
                            </div>
                            <!-- Pagination Links -->
                            <div class="d-flex justify-content-center mt-4">
                                {{ $types->links('vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--<div class="col-3">-->
                <!--<div class="col-12 mb-3">
                    <input type="text" name="filter" id="typeFilter" class="form-control"
                        placeholder="Buscar tipos de máquinas...">
                </div>-->
                <!--<div class="col-12 mb-3">
                    <a href="{{ route('typeMachines.showSyncTypeMachines', $delegation->id) }}"
                        class="btn btn-danger w-100">Sincronizar tipos de ticket</a>
                </div>
            </div>-->
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
                <h1>Tipos de tickets {{ $delegation->name }}</h1>
            </div>
        </div>

        <div class="mt-5 p-3 isla-list">
            @if (count($types) != 0)
                <div class="col-12 mb-4">
                    <a class="btn btn-primary w-100 btn-ttl">Local</a>
                </div>
                <form action="{{ route('typeMachines.search', $delegation->id) }}" method="GET" class="mb-4" autocomplete="off">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control"
                            placeholder="Buscar tipos de máquinas...">
                        <div class="input-group-append">
                            <button class="btn btn-warning" type="submit">Buscar</button>
                        </div>
                    </div>
                </form>
                @foreach ($types as $type)
                    <a class="btn btn-warning w-100 mt-3">{{ $type->name }}</a>
                @endforeach
                <!-- Pagination Links for Mobile View -->
                <div class="d-flex justify-content-center">
                    {{ $types->links('vendor.pagination.bootstrap-5') }}
                </div>
            @else
                <p>No existen tipos!</p>
            @endif
        </div>
        <div class="col-12 my-4">
            <a href="{{ route('typeMachines.showSyncTypeMachines', $delegation->id) }}"
                class="btn btn-danger w-100">Sincronizar tipos de ticket</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchForm = document.querySelector('form[action$="search"]');
            const searchInput = searchForm.querySelector('input[name="search"]');
            const typesContainer = document.querySelector('.isla-list .p-4');
            const paginationContainer = document.querySelector('.d-flex.justify-content-center.mt-4');

            searchForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const searchTerm = searchInput.value;
                fetch(`${searchForm.action}?search=${searchTerm}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        typesContainer.innerHTML = data.types;
                        paginationContainer.innerHTML = data.pagination;
                    })
                    .catch(error => {
                        console.error('Error fetching search results:', error);
                    });
            });
        });
    </script>
@endsection
