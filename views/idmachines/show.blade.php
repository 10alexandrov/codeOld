@extends('plantilla.plantilla')
@section('titulo', 'All Money')
@section('style')
<link href="{{ asset('css/app.css') }}" rel="stylesheet">@endsection

@section('contenido')

    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('delegations.index') }}">Delegaciones</a></li>
                <li class="breadcrumb-item"><a href="{{ route('delegations.show', $delegation->id)}}">{{ $delegation->name }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">AllMoneys</li>
            </ol>
        </nav>

        <table class="table table-bordered border-dark">
            <thead>
                <tr>
                    <th scope="col">ID Machine</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Editar</th>
                </tr>
            </thead>
            <tbody>
                @if ($idMachines->isNotEmpty())

                    @foreach ($idMachines as $machine)
                        <tr>
                            <th scope="row">{{ $machine->id }}</th>
                            <td>
                                {{ $machine->name }}
                            </td>
                            <td>
                                <div>

                                    <button type="button" class="btn btn-success" value="{{ $machine->id }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#staticBackdrop{{ $machine->id }}EditarMachine"><i
                                            class="bi bi-pencil-fill"></i>revisar lo de editar en esta pagina</button>

                                    <!-- Modal Editar-->
                                    <div class="modal fade" id="staticBackdrop{{ $machine->id }}EditarMachine"
                                        data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                        aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Editar!
                                                        {{ $machine->name }}</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>¿Estás seguro que quieres editar la All Money de
                                                        {{ $machine->name }}?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="{{ route('machines.update', $machine->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('PUT')
                                                        <div>
                                                            <label for="name">Nombre</label>
                                                            <input type="text" name="name"
                                                                value="{{ $machine->name }}">
                                                        </div>
                                                        <div>
                                                            <label for="id">Serie/Fabricación</label>
                                                            <input type="text" name="id"
                                                                value="{{ $machine->id }}">
                                                        </div>
                                                        <input type="hidden" name="idMachines"
                                                            value="{{ $delegation->id }}">
                                                        <button type="submit" class="btn btn-success">Editar</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else

                    <h1 class="alert alert-danger">No hay Maquinas de cambio</h1>

                @endif
            </tbody>
        </table>
    </div>

@endsection
