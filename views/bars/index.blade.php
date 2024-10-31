@extends('plantilla.plantilla')
@section('titulo', 'Zonas')
@section('style')
<link href="{{ asset('css/app.css') }}" rel="stylesheet">@endsection
@section('contenido')
    <div class="container d-none d-md-block">
        <div class="row">
            <div class="col-12 text-center d-flex justify-content-center mt-3 mb-3" id="headerAll">
                <div class="w-50 ttl">
                    <h1>Zona {{$zone->name}}</h1>
                </div>
            </div>
            <div class="col-6 offset-3">
                <div class="row">
                    <div class="col-10 offset-1 isla-list">
                        <div class="p-4">
                            <div class="row p-2">
                                @if (!auth()->user()->hasAnyRole(['Tecnico', 'Jefe Salones', 'Oficina']))
                                    <div class="col-3">
                                        <a class="btn btn-primary w-100 btn-ttl"
                                            href="{{ route('locals.createLocals', $zone->id) }}">+</a>
                                    </div>
                                    <div class="col-9">
                                        <a class="btn btn-primary w-100 btn-ttl">Local</a>
                                    </div>
                                @else
                                    <div class="col-12">
                                        <a class="btn btn-primary w-100 btn-ttl">Local</a>
                                    </div>
                                @endif
                            </div>
                            <div>
                                @foreach ($zone->locals as $local)
                                    <div class="row p-2">
                                        @if (!auth()->user()->hasAnyRole(['Tecnico', 'Jefe Salones', 'Oficina']))
                                            <div class="col-3 d-flex justify-content-center">
                                                <a class="btn btn-primary w-100 btn-inf" data-bs-toggle="modal"
                                                    data-bs-target="#modalAccionesLocal{{ $local->id }}"
                                                    style="width: 60% !important">...</a>
                                            </div>
                                            <div class="col-9 d-flex justify-content-center">
                                                <a class="btn btn-primary w-100 btn-inf"
                                                    href="{{ route('locals.show', $local->id) }}"
                                                    style="width: 80% !important">{{ $local->name }}</a>
                                            </div>
                                        @else
                                            <div class="col-12 d-flex justify-content-center">
                                                <a class="btn btn-primary w-100 btn-inf"
                                                    href="{{ route('locals.show', $local->id) }}"
                                                    style="width: 80% !important">{{ $local->name }}</a>
                                            </div>
                                        @endif
                                    </div>

                                    <!--MODAL ACCIONES-->
                                    <div class="modal fade" id="modalAccionesLocal{{ $local->id }}"
                                        data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                        aria-labelledby="modalAcciones" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="modalAccionesLabel">Acciones para el
                                                        local
                                                        {{ $local->name }}</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="text-center">
                                                        <a type="submit" class="btn btn-warning"
                                                            href="{{ route('locals.edit', $local->id) }}">Editar</a>
                                                        <a class="btn btn-danger" data-bs-toggle="modal"
                                                            data-bs-target="#eliminarModal{{ $local->id }}">
                                                            Eliminar
                                                        </a>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--Modal eliminar-->
                                    <div class="modal fade" id="eliminarModal{{ $local->id }}" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1"
                                        aria-labelledby="eliminarModal{{ $local->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">!Eliminar
                                                        {{ $local->name }}!</h1>
                                                    <a href="{{ route('zones.show', $zone->id) }}"
                                                        class="btn btn-close"></a>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Estas seguro que quieres eliminar el local {{ $local->name }}?
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="{{ route('locals.destroy', $local->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="delegation_id"
                                                            value="{{ $local->delegation_id }}">
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
        </div>
    </div>

    <div class="container d-block d-md-none text-center pt-5">

        <div class="ttl d-flex align-items-center p-2">
            <div>
                <a href="{{ route('delegations.show', $zone->delegation_id) }}" class="titleLink">
                    <i style="font-size: 30pt" class="bi bi-arrow-bar-left"></i>
                </a>
            </div>
            <div>
                <h1>Zona {{ $zone->name }}</h1>
            </div>
        </div>

        <div class="mt-5 p-3 isla-list">
            @if (count($zone->locals) != 0)
                <div class="col-12">
                    <a class="btn btn-primary w-100 btn-ttl">Local</a>
                </div>
                @foreach ($zone->locals as $local)
                    <a href="{{ route('locals.show', $local->id) }}"
                        class="btn btn-warning w-100 mt-3">{{ $local->name }}</a>
                @endforeach
            @else
                <p>No existen bares!</p>
            @endif
        </div>
    </div>
@endsection
