@extends('plantilla.plantilla')
@section('titulo', 'Delegations')
@section('contenido')

    <div class="container ">
        <div class="row">
            <div class="col-12 text-center d-none d-md-flex justify-content-center mt-3 mb-3" id="headerAll">
                <div class="w-50 ttl">
                    <h1>Usuarios perdidos</h1>
                </div>
            </div>
            <div class="w-100 pt-5">
                <div class="ttl d-flex d-md-none align-items-center p-2">
                    <div>
                        <a href="{{url()->previous()}}" class="titleLink">
                            <i style="font-size: 30pt" class="bi bi-arrow-bar-left"></i>
                        </a>
                    </div>
                    <div class="text-center">
                        <h1>Usuarios perdidos</h1>
                    </div>
                </div>
            </div>

            <!-- VERSION TABLE A FALTA DE COMPROBAR FRAN -->

            <div class="col-12 col-md-8 offset-md-2 mt-5">
                <div class="row">
                    <div class="col-10 offset-1 isla-list">
                        <div class="p-md-4">
                            <div class="row p-2">
                                <div class="col-12">
                                    <a class="btn btn-primary w-100 btn-ttl">Usuarios</a>
                                </div>
                            </div>
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th scope="col" class="d-none d-md-table-cell">Acciones</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">PID</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr class="user-row" data-username="{{ $user->User }}" data-role="{{ $user->rol }}">
                                        @if (!auth()->user()->hasAnyRole(['Tecnico', 'Jefe Salones', 'Oficina']))
                                        <td class="d-none d-md-table-cell">
                                            <a class="btn btn-primary btn-inf w-50" data-bs-toggle="modal"
                                                data-bs-target="#eliminarModal{{ $user->id }}"><i class="bi bi-trash"></i></a>
                                        </td>
                                        <td>{{ $user->User }}</td>
                                        <td>{{ $user->decryptedPID }}</td>
                                        @else
                                        <td colspan="3" class="text-center">{{ $user->User }}</td>
                                        @endif
                                    </tr>

                                    <!--Modal eliminar-->
                                    <div class="modal fade" id="eliminarModal{{ $user->id }}" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="eliminarModal{{ $user->id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">!Eliminar {{ $user->name }}!
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Estas seguro que quieres eliminar el usuario {{ $user->User }}?
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="{{ route('usersPerdidos.destroy', $user->id) }}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>





        </div>
    </div>

@endsection
