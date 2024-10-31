@extends('plantilla.plantilla')
@section('titulo', 'Delegations')
@section('contenido')
    <div class="container d-none d-md-block">
        <div class="row">
            <div class="col-12 text-center d-flex justify-content-center mt-5 mb-5" id="headerAll">
                <div class="w-35 ttl">
                    <h1>Delegaciones</h1>
                </div>
            </div>
            <div class="col-6 @if (auth()->user()->hasRole('Jefe Delegacion')) offset-3 @endif">
                <div class="row">
                    <div class="col-8 offset-2 isla-list">
                        <div class="p-2">
                            <div class="row p-2">
                                @if (auth()->user()->hasRole('Super Admin'))
                                    <div class="col-3">
                                        <a class="btn btn-primary w-100 btn-ttl" data-bs-toggle="modal"
                                            data-bs-target="#modalCrear">+</a>
                                    </div>
                                    <div class="col-9">
                                        <a class="btn btn-primary w-100 btn-ttl">Delegación</a>
                                    </div>
                                @else
                                    <div class="col-12">
                                        <a class="btn btn-primary w-100 btn-ttl">Delegación</a>
                                    </div>
                                @endif

                            </div>
                            <div>
                                @foreach ($delegations as $delegation)
                                    <div class="row p-2">
                                        @if (auth()->user()->hasRole('Super Admin'))
                                            <div class="col-3 d-flex justify-content-center">
                                                <a class="btn btn-primary w-100 btn-inf" data-bs-toggle="modal"
                                                    data-bs-target="#modalAcciones{{ $delegation->id }}"
                                                    style="width: 60% !important">...</a>
                                            </div>
                                            <div class="col-9 d-flex justify-content-center">
                                                <a class="btn btn-primary w-100 btn-inf"
                                                    href="{{ route('delegations.show', $delegation->id) }}"
                                                    style="width: 80% !important">{{ $delegation->name }}</a>
                                            </div>
                                        @else
                                            <div class="col-12 d-flex justify-content-center">
                                                <a class="btn btn-primary w-100 btn-inf"
                                                    href="{{ route('delegations.show', $delegation->id) }}"
                                                    style="width: 80% !important">{{ $delegation->name }}</a>
                                            </div>
                                        @endif
                                    </div>

                                    <!--MODAL ACCIONES-->
                                    <div class="modal fade" id="modalAcciones{{ $delegation->id }}"
                                        data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                        aria-labelledby="modalAcciones" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="modalAccionesLabel">Acciones para
                                                        {{ $delegation->name }}</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('delegations.update', $delegation->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-5">
                                                            <label for="nameDelegation" class="form-label">Nombre
                                                                delegación:</label><br>
                                                            <input type="text" name="name" class="form-control"
                                                                value="{{ $delegation->name }}">
                                                        </div>
                                                        <div class="text-end">
                                                            <button type="submit" class="btn btn-warning">Editar</button>
                                                            <a class="btn btn-danger" data-bs-toggle="modal"
                                                                data-bs-target="#eliminarModal{{ $delegation->id }}">
                                                                Eliminar
                                                            </a>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--Modal eliminar-->
                                    <div class="modal fade" id="eliminarModal{{ $delegation->id }}"
                                        data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                        aria-labelledby="eliminarModal{{ $delegation->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">¿Eliminar
                                                        {{ $delegation->name }}!</h1>
                                                    <a href="{{ route('delegations.index') }}" class="btn btn-close"></a>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Estas seguro que quieres eliminar {{ $delegation->name }}?
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="{{ route('delegations.destroy', $delegation->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if (auth()->user()->hasRole('Super Admin'))
                <div class="col-6">
                    <div class="row">
                        <div class="col-8 offset-2 isla-list">
                            <div class="p-2">
                                <div class="row p-2">
                                    <div class="col-3">
                                        <a href="{{ route('bossDelegations.create') }}"
                                            class="btn btn-primary w-100 btn-ttl">+</a>
                                    </div>
                                    <div class="col-9">
                                        <a class="btn btn-primary w-100 btn-ttl">Jefe técnico</a>
                                    </div>
                                </div>
                                <div>
                                    @foreach ($usuariosJefes as $jefe)
                                        <div class="row p-2">
                                            <div class="col-3 d-flex justify-content-center">
                                                <a class="btn btn-primary w-100 btn-inf" data-bs-toggle="modal"
                                                    data-bs-target="#modalAccionesBoss{{ $jefe->id }}"
                                                    style="width: 60% !important">...</a>
                                            </div>
                                            <div class="col-9 d-flex justify-content-center">
                                                <a class="btn btn-primary w-100 btn-inf"
                                                    style="width: 80% !important">{{ $jefe->name }}</a>
                                            </div>
                                        </div>

                                        <!--Modal acciones-->
                                        <div class="modal fade" id="modalAccionesBoss{{ $jefe->id }}"
                                            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                            aria-labelledby="modalAcciones" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="modalAccionesLabel">Acciones para
                                                            {{ $jefe->name }}</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="text-center">
                                                            <a href="{{ route('bossDelegations.edit', $jefe->id) }}"
                                                                class="btn btn-warning">Editar</a>
                                                            <a class="btn btn-danger" data-bs-toggle="modal"
                                                                data-bs-target="#eliminarModal{{ $jefe->id }}">
                                                                Eliminar
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!--Modal eliminar-->
                                        <div class="modal fade" id="eliminarModal{{ $jefe->id }}"
                                            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                            aria-labelledby="eliminarModal{{ $jefe->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">¿Eliminar
                                                            {{ $jefe->name }}!</h1>
                                                        <a href="{{ route('delegations.index') }}"
                                                            class="btn btn-close"></a>
                                                    </div>
                                                    <div class="modal-body">
                                                        ¿Estas seguro que quieres eliminar {{ $jefe->name }}?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="{{ route('bossDelegations.destroy', $jefe->id) }}"
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
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!--MODAL CREAR-->
            <div class="modal fade" id="modalCrear" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="modalCrear" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="modalCrearsLabel">Crear delegación</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('delegations.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="nameDelegation" class="form-label">Nombre de la nueva
                                        delegación:</label><br>
                                    <input type="tex" name="nameDelegation" class="form-control"
                                        value="{{ old('nameDelegation') }}">
                                </div>
                                <div class="text-end">
                                    <input type="submit" value="Crear delegación" class="btn btn-warning">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @if ($error)
                <div class="toast-container position-fixed bottom-0 end-0 p-3" role="alert"
                    aria-live="assertive" aria-atomic="true" id="liveToast">
                    <div class="d-flex text-white p-3 rounded w-100" id="colorToast">
                        <div class="toast-body">
                            {{$error}}
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
        <div class="ttl">
            <h1>Delegaciones</h1>
        </div>
        <div class="mt-5 p-3 isla-list">

            @foreach ($delegations as $delegation)
                <a href="{{ route('delegations.show', $delegation->id) }}" class="btn btn-warning w-100 mt-2 mb-2">
                    {{ $delegation->name }}</a>
            @endforeach

        </div>
    </div>
@endsection
