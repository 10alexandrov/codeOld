@extends('plantilla.plantilla')
@section('titulo', 'Local')
@section('contenido')
    <div class="container">
        <div class="col-8 offset-2 isla-list p-4 mt-5">
            <div class="ttl text-center mb-4">
                <h1>Crear nuevo tipo</h1>
            </div>
            <form action="{{ route('typeMachines.store') }}" method="POST">
                @csrf
                @method('POST')
                <div class="form-floating mb-3">
                    <input type="text" name="name" class="form-control" id="floatingName" placeholder="name">
                    <label for="floatingName">Tipo</label>
                </div>
                <div>
                    <div class="accordion" id="accordionExample">
                        @foreach ($delegation->zones as $zona)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $zona->id }}">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{ $zona->id }}" aria-expanded="true"
                                        aria-controls="collapse{{ $zona->id }}">
                                        {{ $zona->name }}
                                    </button>
                                </h2>
                                <div id="collapse{{ $zona->id }}" class="accordion-collapse collapse"
                                    aria-labelledby="heading{{ $zona->id }}" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        @foreach ($zona->locals as $local)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    value="{{ $local->id }}" id="flexCheckDefault{{ $local->id }}" name="locales[]">
                                                <label class="form-check-label" for="flexCheckDefault{{ $local->id }}">
                                                    {{ $local->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <input type="hidden" name="delegation_id" value="{{ $delegation->id }}">
                </div>

                <div class="mt-5 mb-3">
                    <input type="submit" value="Crear Tipo Máquina" class="btn btn-warning">
                    <input type="reset" name="" id="" value="Limpiar" class="btn btn-danger">
                </div>
            </form>
        </div>
        @if ($errors->any())
            <div id="error-alert" class="alert alert-danger mt-5">
                @foreach ($errors->all() as $error)
                    <span>{{ $error }}</span>
                @endforeach
            </div>
        @endif
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const errorAlert = document.getElementById('error-alert');
                if (errorAlert) {
                    // Espera 5 segundos antes de empezar la animación de desaparición
                    setTimeout(() => {
                        errorAlert.classList.add('fade-out');
                    }, 5000);

                    // Remueve el elemento del DOM después de que la animación termine (1 segundos)
                    setTimeout(() => {
                        errorAlert.remove();
                    }, 6000);
                }
            });
        </script>

    </div>
@endsection
