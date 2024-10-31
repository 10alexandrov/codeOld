@extends('plantilla.plantilla')
@section('titulo', 'Local')
@section('contenido')
    <div class="container">
        <div class="col-8 offset-2 isla-list p-4 mt-5">
            <div class="ttl text-center mb-4">
                <h1>Editar {{ $user->User }}</h1>
            </div>
            <form action="{{ route('usersmc.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <!-- Campo oculto para el delegationId -->
                <input type="hidden" name="delegation_id" value="{{ $delegationId }}">

                <div class="form-floating mb-3">
                    <input value="{{ $user->User }}" type="text" name="name" class="form-control" id="floatingInput"
                        placeholder="nombre">
                    <label for="floatingInput">Usuario ticketserver</label>
                    @if ($errors->has('name'))
                        <div class="text-danger" style="color: red"> {{ $errors->first('name') }} </div>
                    @endif
                </div>
                <div class="form-floating mb-3">
                    <input value="{{ $user->Name }}" type="text" name="nameReal" class="form-control" id="floatingInput"
                        placeholder="nombre">
                    <label for="floatingInput">Nombre</label>
                    @if ($errors->has('nameReal'))
                        <div class="text-danger" style="color: red"> {{ $errors->first('nameReal') }} </div>
                    @endif
                </div>
                <div class="form-floating mb-3">
                    @php
                        use Illuminate\Support\Facades\Crypt;

                        if ($user->Password) {
                            $decryptedPassword = Crypt::decrypt($user->Password);
                        } else {
                            $decryptedPassword = '';
                        }
                    @endphp
                    <input type="text" name="passwd" class="form-control" id="floatingPass" placeholder="1234"
                        value="{{ $decryptedPassword }}">
                    <label for="floatingPass">Contraseña</label>
                    @if ($errors->has('passwd'))
                        <div class="text-danger" style="color: red"> {{ $errors->first('passwd') }} </div>
                    @endif
                </div>
                <div class="form-floating mb-3">
                    <select class="form-select" id="floatingSelect" aria-label="Floating label select example"
                        name="sesion">
                        <option value="-2" {{ $user->SessionType == -2 ? 'selected' : '' }}>Cap</option>
                        <option value="-1" {{ $user->SessionType == -1 ? 'selected' : '' }}>Siempre preguntar PIN
                        </option>
                        <option value="0" {{ $user->SessionType == 0 ? 'selected' : '' }}>Preguntar PIN una sola vez
                        </option>
                        <option value="1" {{ $user->SessionType == 1 ? 'selected' : '' }}>1 minuto</option>
                        <option value="2" {{ $user->SessionType == 2 ? 'selected' : '' }}>2 minutos</option>
                        <option value="5" {{ $user->SessionType == 5 ? 'selected' : '' }}>5 minutos</option>
                        <option value="10" {{ $user->SessionType == 10 ? 'selected' : '' }}>10 minutos</option>
                        <option value="20" {{ $user->SessionType == 20 ? 'selected' : '' }}>20 minutos</option>
                        <option value="30" {{ $user->SessionType == 30 ? 'selected' : '' }}>30 minutos</option>
                    </select>
                    <label for="floatingSelect">Tipo de sesión:</label>
                </div>
                <div class="form-floating mb-3">
                    @php
                        if ($user->PID) {
                            $decryptedPid = Crypt::decrypt($user->PID);
                        } else {
                            $decryptedPid = '';
                        }
                    @endphp
                    <input value="{{ $decryptedPid }}" type="name" name="pid" class="form-control"
                        id="floatingInput" placeholder="nombre">
                    <label for="floatingInput">PID</label>
                    @if ($errors->has('pid'))
                        <div class="text-danger" style="color: red"> {{ $errors->first('pid') }} </div>
                    @endif
                </div>
                <div class="mb-3">
                    <label class="form-label">Roles de usuario</label>
                    <div class="form-check-group p-3 rounded d-flex justify-content-between"
                        style="background-color: white">
                        <div class="form-check d-inline-block">
                            <input class="form-check-input" type="radio" value="Técnicos" name="rol" id="roleTécnicos"
                                @checked($user->rol == 'Técnicos')>
                            <label class="form-check-label" for="roleTécnicos">Técnicos</label>
                        </div>
                        <div class="form-check d-inline-block">
                            <input class="form-check-input" type="radio" value="Personal sala" name="rol"
                                id="rolePersonalSala" @checked($user->rol == 'Personal sala')>
                            <label class="form-check-label" for="rolePersonalSala">Personal sala</label>
                        </div>
                        <div class="form-check d-inline-block">
                            <input class="form-check-input" type="radio" value="Caja" name="rol" id="roleCaja"
                                @checked($user->rol == 'Caja')>
                            <label class="form-check-label" for="roleCaja">Caja</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" value="Desconocido" name="rol"
                                id="roleDesconocido" @checked($user->rol == 'Desconocido')>
                            <label class="form-check-label" for="roleDesconocido">Desconocido</label>
                        </div>
                        <div class="form-check d-inline-block">
                            <input class="form-check-input" type="radio" value="Otros" name="rol" id="roleOtros"
                                @checked($user->rol == 'Otros')>
                            <label class="form-check-label" for="roleOtros">Otros</label>
                        </div>
                    </div>
                    @if ($errors->has('Role'))
                        <div class="text-danger">{{ $errors->first('Role') }}</div>
                    @endif
                </div>

                @if ($delegation->zones)
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
                                                        value="{{ $local->id }}"
                                                        id="flexCheckDefault{{ $local->id }}" name="locales[]"
                                                        @if (in_array($local->id, $userLocalIds)) checked @endif
                                                        onchange="updateResumen()">
                                                    <label class="form-check-label"
                                                        for="flexCheckDefault{{ $local->id }}">
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
                        <div class="mt-3">
                            <!-- Resumen locales -->
                            <p id="resumenLocales"></p>
                        </div>
                        <script>
                            function updateResumen() {
                                // Obtén todos los checkboxes seleccionados
                                const checkboxes = document.querySelectorAll('input[name="locales[]"]:checked');
                                let resumen = [];

                                // Itera sobre los checkboxes y agrega el nombre de cada local al resumen
                                checkboxes.forEach((checkbox) => {
                                    const label = document.querySelector(`label[for="${checkbox.id}"]`);
                                    if (label) {
                                        resumen.push(label.innerText.trim());
                                    }
                                });

                                // Actualiza el contenido del elemento con id "resumenLocales"
                                document.getElementById('resumenLocales').innerText = resumen.join(', ');
                            }

                            // Llama a la función para mostrar el resumen inicial
                            updateResumen();
                        </script>
                    </div>
                @endif

                <div class="mt-5 mb-3">
                    <input type="submit" value="Editar Usuario" class="btn btn-warning">
                    <input type="reset" name="" id="" value="Limpiar" class="btn btn-danger">
                </div>

                <div class="row mt-5 text-start checkbox-div">
                    <div class="col-4">
                        <b>Derechos (separados por coma):</b>
                        <br>
                        @foreach ($allRights as $right)
                            <input type="checkbox" name="Right{{ $right }}"
                                {{ isset($userRightsArray[$right]) && $userRightsArray[$right] ? 'checked' : '' }}>
                            {{ $right }}<br>
                        @endforeach
                        <br>
                    </div>
                    <div class="col-4">
                        <b>Tipos de ticket permitidos (ninguno implica todos):</b>
                        <br>
                        @foreach ($allTicketTypes as $ticketType)
                            <input type="checkbox" name="TicketType{{ $ticketType }}"
                                {{ isset($userTicketTypesArray[$ticketType]) && $userTicketTypesArray[$ticketType] ? 'checked' : '' }}>
                            {{ $ticketType }}<br>
                        @endforeach
                        Otros tipos de ticket (separados por comas):
                        <input type="textbox" name="CustomTicketTypesToSave" size="50" value=""
                            class="w-100"><br><br>
                    </div>
                    <div class="col-4">
                        <b>Opciones Adicionales permitidas:</b>
                        <br>
                        @foreach ($allAdditionalOptions as $option)
                            <input type="checkbox" name="AdditionalOption{{ $option }}"
                                {{ isset($userAdditionalOptionsArray[$option]) && $userAdditionalOptionsArray[$option] ? 'checked' : '' }}>
                            {{ $option }}<br>
                        @endforeach
                        Otras opciones adicionales (separadas por comas):
                        <input type="textbox" name="CustomAdditionalOptionsToSave" size="50" value=""
                            class="w-100"><br><br>
                    </div>
                </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Variables del formulario de edición
                const radioButtons = document.querySelectorAll('input[name="rol"]');
                const checkboxDiv = document.querySelector('.checkbox-div');
                const passwdField = document.querySelector('input[name="passwd"]');
                const sesionField = document.querySelector('select[name="sesion"]');
                const acordeonElement = document.getElementById('accordionExample');
                const additionalOptions = document.getElementById('additionalOptions');

                function handleRoleChange() {
                    // Obtener el rol seleccionado
                    const selectedRole = document.querySelector('input[name="rol"]:checked')?.value;

                    if (selectedRole === 'Otros') {
                        // Mostrar campos adicionales y el acordeón
                        checkboxDiv.style.display = 'flex';
                        setTimeout(() => checkboxDiv.classList.replace('fade-hidden', 'fade-visible'), 10);

                        passwdField.disabled = false;
                        sesionField.disabled = false;
                        acordeonElement.style.display = 'block';
                        additionalOptions.style.display = 'block';
                    } else {
                        // Ocultar campos adicionales y el acordeón
                        checkboxDiv.classList.replace('fade-visible', 'fade-hidden');
                        setTimeout(() => checkboxDiv.style.display = 'none', 500);

                        passwdField.disabled = selectedRole === 'Desconocido';
                        sesionField.disabled = selectedRole === 'Desconocido';
                        acordeonElement.style.display = selectedRole === 'Desconocido' ? 'none' : 'block';
                        additionalOptions.style.display = 'none';
                    }
                }

                // Añadir listeners a los radio buttons
                radioButtons.forEach(button => {
                    button.addEventListener('change', handleRoleChange);
                });

                // Inicializar el estado basado en el valor seleccionado por defecto
                handleRoleChange();
            });
        </script>

        </form>
    </div>
    </div>
@endsection
