@extends('plantilla.plantilla')
@section('titulo', 'Local')
@section('contenido')
    <div class="container">
        <div class="col-8 offset-2 isla-list p-4 mt-5">
            <div class="ttl text-center mb-4">
                <h1>Crear máquina</h1>
            </div>
            <form action="{{ route('machines.store') }}" method="POST" autocomplete="off">
                @csrf

                <!-- Delegation ID (hidden) -->
                <input type="hidden" name="delegation_id" value="{{ $delegation->id }}">

                <!-- Nombre -->
                <div class="form-floating mb-3">
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        id="floatingName" placeholder="Nombre máquina" value="{{ old('name') }}">
                    <label for="floatingName">Nombre máquina</label>
                    @error('name')
                        <div class="invalid-feedback"> {{ $message }} </div>
                    @enderror
                </div>

                <!-- Alias -->
                <div class="form-floating mb-3">
                    <input type="text" name="alias" class="form-control @error('alias') is-invalid @enderror"
                        id="floatingAlias" placeholder="Alias máquina" value="{{ old('alias') }}">
                    <label for="floatingAlias">Alias máquina</label>
                    @error('alias')
                        <div class="invalid-feedback"> {{ $message }} </div>
                    @enderror
                </div>

                <!-- Modelo -->
                <div class="col-5 d-flex justify-content-between">
                    <div>
                        <p>Tipo modelo: </p>
                    </div>
                    @foreach (['A', 'B', 'C', 'X'] as $modelType)
                        <div class="form-check">
                            <input class="form-check-input @error('model') is-invalid @enderror" type="radio"
                                name="model" id="model{{ $modelType }}" value="{{ $modelType }}"
                                {{ old('model') == $modelType ? 'checked' : '' }}>
                            <label class="form-check-label" for="model{{ $modelType }}">{{ $modelType }}</label>
                        </div>
                    @endforeach
                </div>
                @error('model')
                    <div class="invalid-feedback d-block pb-4"> {{ $message }} </div>
                @enderror

                <!-- Código -->
                <div class="form-floating mb-3">
                    <input type="text" name="codigo" class="form-control @error('codigo') is-invalid @enderror"
                        id="floatingCodigo" placeholder="Código" value="{{ old('codigo') }}">
                    <label for="floatingCodigo">Código</label>
                    @error('codigo')
                        <div class="invalid-feedback"> {{ $message }} </div>
                    @enderror
                </div>

                <!-- Serie -->
                <div class="form-floating mb-3">
                    <input type="text" name="serie" class="form-control @error('serie') is-invalid @enderror"
                        id="floatingSerie" placeholder="Serie" value="{{ old('serie') }}">
                    <label for="floatingSerie">Serie</label>
                    @error('serie')
                        <div class="invalid-feedback"> {{ $message }} </div>
                    @enderror
                </div>

                <!-- Número -->
                <div class="form-floating mb-3">
                    <input type="text" name="numero" class="form-control @error('numero') is-invalid @enderror"
                        id="floatingNumero" placeholder="Número" value="{{ old('numero') }}">
                    <label for="floatingNumero">Número</label>
                    @error('numero')
                        <div class="invalid-feedback"> {{ $message }} </div>
                    @enderror
                </div>

                <div class="mt-5">
                    <!-- Resumen locales -->
                    <p id="resumenLocales" class="mb-2">Local seleccionado: Taller</p>
                </div>
                <!-- Locales y Bares -->
                <div class="accordion" id="accordionExample">
                    @foreach ($delegation->zones as $zona)
                        @php
                            // Verificar si alguno de los locales o bares de esta zona es el seleccionado en old('local')
                            $isExpanded = old('local') && strpos(old('local'), ":{$zona->id}") !== false;
                        @endphp
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $zona->id }}">
                                <button class="accordion-button{{ $isExpanded ? '' : ' collapsed' }}" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapse{{ $zona->id }}"
                                    aria-expanded="{{ $isExpanded ? 'true' : 'false' }}"
                                    aria-controls="collapse{{ $zona->id }}">
                                    {{ $zona->name }}
                                </button>
                            </h2>
                            <div id="collapse{{ $zona->id }}"
                                class="accordion-collapse collapse{{ $isExpanded ? ' show' : '' }}"
                                aria-labelledby="heading{{ $zona->id }}" data-bs-parent="#accordionExample">
                                <div class="accordion-body row">
                                    <div class="col-6">
                                        <h4>SALONES</h4>
                                        @foreach ($zona->locals as $local)
                                            <div class="form-check">
                                                <input id="radioSalon{{ $local->id }}"
                                                    class="form-check-input @error('local') is-invalid @enderror"
                                                    type="radio" value="S:{{ $local->id }}" name="local"
                                                    {{ old('local') == "S:{$local->id}" ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="radioSalon{{ $local->id }}">{{ $local->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="col-6">
                                        <h4>BARES</h4>
                                        @foreach ($zona->bars as $bar)
                                            <div class="form-check">
                                                <input id="radioBar{{ $bar->id }}"
                                                    class="form-check-input @error('local') is-invalid @enderror"
                                                    type="radio" value="B:{{ $bar->id }}" name="local"
                                                    {{ old('local') == "B:{$bar->id}" ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="radioBar{{ $bar->id }}">{{ $bar->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @error('local')
                        <div class="invalid-feedback d-block"> {{ $message }} </div>
                    @enderror
                </div>

                <!-- Botón de Enviar -->
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Crear máquina</button>
                    <button type="reset" class="btn btn-danger">Limpiar</button>
                </div>
            </form>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const radios = document.querySelectorAll('input[name="local"]');
                    const resumen = document.getElementById('resumenLocales');

                    function updateResumen() {
                        const selectedRadio = document.querySelector('input[name="local"]:checked');
                        if (selectedRadio) {
                            const label = document.querySelector(`label[for="${selectedRadio.id}"]`);
                            resumen.textContent = `Local seleccionado: ${label.textContent}`;
                        } else {
                            resumen.textContent = 'Local seleccionado: Taller';
                        }
                    }

                    // Escuchar cambios en los radios
                    radios.forEach(radio => {
                        radio.addEventListener('change', updateResumen);
                    });

                    // Actualizar resumen al cargar la página (en caso de que haya un valor preseleccionado)
                    updateResumen();
                });
            </script>
        </div>
    </div>
@endsection
