@extends('plantilla.plantilla')
@section('titulo', 'Local')
@section('contenido')
    @php
        use Illuminate\Support\Facades\Crypt;
        use Illuminate\Contracts\Encryption\DecryptException;
    @endphp

    <div class="container text-center pt-5">
        <div class="col-12 text-center d-none d-md-flex justify-content-center mt-5 mb-5">
            <div class="w-50 ttl">
                <h1>{{ $local->name }}</h1>
            </div>
        </div>
        <div class="d-block d-md-none text-center mb-3">
            <div class="ttl d-flex align-items-center">
                <div>
                    <a href="{{ route('locals.show', $local->id) }}" class="titleLink">
                        <i style="font-size: 30pt" class="bi bi-arrow-bar-left"></i>
                    </a>
                </div>
                <div>
                    <h1>Local {{ $local->name }}</h1>
                </div>
            </div>
        </div>
        <div>
            @if (!$local_usersmc->isEmpty())
                <div class="table-responsive mt-5">
                    <form action="{{ route('usersmc.destroyMultiple', $local->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Seleccionar</th>
                                    <th scope="col">Usuario</th>
                                    <th scope="col">PID</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($local_usersmc as $usr)
                                    @php
                                        try {
                                            $decryptedPID = Crypt::decrypt($usr->PID);
                                        } catch (DecryptException $e) {
                                            $decryptedPID = '';
                                        }
                                    @endphp
                                    <tr>
                                        <td><input type="checkbox" class="checkbox" name="usrs[]" value="{{ $usr->User }}"></td>
                                        <td>{{ $usr->User }}</td>
                                        <td>{{ $decryptedPID }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- El botón de eliminar inicialmente está oculto -->
                        <button type="button" class="btn btn-warning mt-4" data-bs-toggle="modal"
                            data-bs-target="#borrarusrModal" id="deleteButton" style="display: none;">Eliminar</button>

                        <!-- MODAL ABORTAR -->
                        <div class="modal fade" id="borrarusrModal" data-bs-backdrop="static" data-bs-keyboard="false"
                            tabindex="-1" aria-labelledby="borrarusrModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="borrarusrModalLabel">¿Seguro que quieres eliminar?</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        ¿Estás seguro que quieres eliminar todos los usuarios seleccionados?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @else
                <h3 class="alert alert-danger">No hay usuarios en este local</h3>
            @endif
        </div>

        <!-- JavaScript para mostrar/ocultar el botón de eliminar -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const checkboxes = document.querySelectorAll('.checkbox');
                const deleteButton = document.getElementById('deleteButton');

                function toggleDeleteButton() {
                    // Verifica si al menos un checkbox está marcado
                    const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
                    // Muestra u oculta el botón según la selección
                    deleteButton.style.display = anyChecked ? 'inline-block' : 'none';
                }

                // Añade un evento a cada checkbox
                checkboxes.forEach(checkbox => checkbox.addEventListener('change', toggleDeleteButton));

                // Inicializa el estado del botón en caso de que se haya pre-seleccionado algún checkbox
                toggleDeleteButton();
            });
        </script>
    </div>
@endsection
