<!-- resources/views/partials/types.blade.php -->
@foreach ($types as $type)
    <div class="row p-2 user-row" data-typename="{{ $type->name }}">
        @if (!auth()->user()->hasAnyRole(['Tecnico', 'Jefe Salones', 'Oficina']))
            <div class="col-3 d-flex justify-content-center">
                <a class="btn btn-primary w-100 btn-inf" data-bs-toggle="modal"
                    data-bs-target="#modalAccionesLocal{{ $type->id }}"
                    style="width: 60% !important">...</a>
            </div>
            <div class="col-9 d-flex justify-content-center">
                <a class="btn btn-primary w-100 btn-inf"
                    style="width: 80% !important">{{ $type->name }}</a>
            </div>
        @else
            <div class="col-12 d-flex justify-content-center">
                <a class="btn btn-primary w-100 btn-inf"
                    style="width: 80% !important">{{ $type->name }}</a>
            </div>
        @endif
    </div>

    <!--MODAL ACCIONES-->
    <div class="modal fade" id="modalAccionesLocal{{ $type->id }}"
        data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalAcciones" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalAccionesLabel">Acciones para el
                        usuario
                        {{ $type->name }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <a type="submit" class="btn btn-warning"
                            href="{{ route('typeMachines.edit', $type->id) }}">Editar</a>
                        <a class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#eliminarModal{{ $type->id }}">
                            Eliminar
                        </a>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--Modal eliminar-->
    <div class="modal fade" id="eliminarModal{{ $type->id }}" data-bs-backdrop="static"
        data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="eliminarModal{{ $type->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">!Eliminar
                        {{ $type->name }}!</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estas seguro que quieres eliminar el usuario {{ $type->name }}?
                </div>
                <div class="modal-footer">
                    <form action="{{ route('typeMachines.destroyAll', $type->id) }}"
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
