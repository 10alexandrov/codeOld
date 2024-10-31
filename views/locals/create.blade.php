@extends('plantilla.plantilla')
@section('titulo', 'Crear Local')
@section('contenido')
    <div class="container">
        <div class="col-8 offset-2 isla-list p-4 mt-5">
            <div class="ttl text-center mb-4">
                <h1>Crear local</h1>
            </div>
            <form id="create-local-form" action="{{ route('locals.store') }}" method="POST">
                @csrf

                <!-- Nombre del local -->
                <div class="form-floating mb-3">
                    <input value="{{ old('nameLocal') }}" type="text" name="nameLocal" class="form-control"
                        id="floatingInput" placeholder="Nombre">
                    <label for="floatingInput">Nombre</label>
                    @if ($errors->has('nameLocal'))
                        <div class="text-danger">{{ $errors->first('nameLocal') }}</div>
                    @endif
                </div>

                <!-- ID de la máquina -->
                <div class="form-floating mb-3">
                    <input value="{{ old('machine_id') }}" type="text" name="machine_id" class="form-control"
                        id="floatingInput" placeholder="Serie/Fabricación">
                    <label for="floatingInput">Serie/Fabricación</label>
                    @if ($errors->has('machine_id'))
                        <div class="text-danger">{{ $errors->first('machine_id') }}</div>
                    @endif
                </div>

                <!-- Conexión principal -->
                <div id="connection-sections">
                    <div class="connection-section" data-index="0">
                        <legend>Conexión principal</legend>

                        <div class="form-floating mb-3">
                            <input type="hidden" name="dbConexion[0][name]" value="conexion principal">
                            <input value="{{ old('dbConexion.0.ip') }}" type="text" name="dbConexion[0][ip]"
                                class="form-control" id="floatingInput0" placeholder="IP">
                            <label for="floatingInput0">IP</label>
                            @if ($errors->has('dbConexion.0.ip'))
                                <div class="text-danger">{{ $errors->first('dbConexion.0.ip') }}</div>
                            @endif
                        </div>

                        <div class="form-floating mb-3">
                            <input value="{{ old('dbConexion.0.port') }}" type="text" name="dbConexion[0][port]"
                                class="form-control" id="floatingInput1" placeholder="Puerto">
                            <label for="floatingInput1">Puerto</label>
                            @if ($errors->has('dbConexion.0.port'))
                                <div class="text-danger">{{ $errors->first('dbConexion.0.port') }}</div>
                            @endif
                        </div>

                        <div class="form-floating mb-3">
                            <input value="{{ old('dbConexion.0.database') }}" type="text" name="dbConexion[0][database]"
                                class="form-control" id="floatingInput2" placeholder="Base de datos">
                            <label for="floatingInput2">Nombre de la base de datos</label>
                            @if ($errors->has('dbConexion.0.database'))
                                <div class="text-danger">{{ $errors->first('dbConexion.0.database') }}</div>
                            @endif
                        </div>

                        <div class="form-floating mb-3">
                            <input value="{{ old('dbConexion.0.username') }}" type="text" name="dbConexion[0][username]"
                                class="form-control" id="floatingInput3" placeholder="Usuario">
                            <label for="floatingInput3">Usuario</label>
                            @if ($errors->has('dbConexion.0.username'))
                                <div class="text-danger">{{ $errors->first('dbConexion.0.username') }}</div>
                            @endif
                        </div>

                        <div class="form-floating mb-3">
                            <input value="{{ old('dbConexion.0.password') }}" type="text" name="dbConexion[0][password]"
                                class="form-control" id="floatingInput4" placeholder="Contraseña">
                            <label for="floatingInput4">Contraseña</label>
                            @if ($errors->has('dbConexion.0.password'))
                                <div class="text-danger">{{ $errors->first('dbConexion.0.password') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Botón para añadir una nueva conexión -->
                <div class="text-end mb-3 position-relative">
                    <button type="button" class="btn btn-primary" onclick="addConnection()">Añadir Conexión</button>
                    <div id="connection-tooltip" class="tooltip-alert" role="tooltip">Completa la conexión anterior antes de agregar otra.</div>
                </div>

                <!-- Hidden para zone_id -->
                <input type="hidden" name="zone_id" value="{{ $zone->id }}">

                <!-- Botón de Enviar -->
                <div class="text-end position-relative">
                    <button type="submit" class="btn btn-warning">Crear Local</button>
                    <div id="form-tooltip" class="tooltip-alert" role="tooltip">Completa todas las conexiones antes de enviar el formulario.</div>
                </div>

                <style>
                    .connection-section {
                        background-color: #fab8b0;
                        border: 1px solid #ccc;
                        border-radius: 8px;
                        padding: 15px;
                        margin-bottom: 20px;
                        position: relative;
                    }

                    .remove-connection-btn {
                        position: absolute;
                        top: 10px;
                        right: 10px;
                        background-color: transparent;
                        color: white;
                        border: none;
                        border-radius: 50%;
                        width: 30px;
                        height: 30px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    }

                    .tooltip-alert {
                        display: none;
                        position: absolute;
                        top: -40px;
                        right: 0;
                        background-color: #ffdddd;
                        border: 1px solid #ff5c5c;
                        border-radius: 4px;
                        padding: 8px;
                        color: #d8000c;
                        font-size: 0.9rem;
                        z-index: 10;
                    }
                </style>
            </form>
        </div>
    </div>

    <script>
        let connectionIndex = 1; // Empezamos en 1 porque la conexión principal ya es 0

        // Función para validar si una conexión está completa
        function validateConnection(index) {
            const section = document.querySelector(`.connection-section[data-index="${index}"]`);
            const inputs = section.querySelectorAll('input[type="text"]');
            for (let input of inputs) {
                if (input.value === '') {
                    return false;
                }
            }
            return true;
        }

        // Función para reindexar las conexiones
        function reindexConnections() {
            const sections = document.querySelectorAll('.connection-section');
            sections.forEach((section, index) => {
                section.dataset.index = index;
                section.querySelector('legend').textContent =
                    `Conexión ${index === 0 ? 'principal' : index + 1}`;
                const inputs = section.querySelectorAll('input');
                inputs.forEach(input => {
                    const nameAttr = input.getAttribute('name');
                    if (nameAttr) {
                        input.setAttribute('name', nameAttr.replace(/\[\d+\]/, `[${index}]`));
                    }
                });
            });
        }

        // Función para añadir una nueva conexión
        function addConnection() {
            const tooltip = document.getElementById('connection-tooltip');

            if (!validateConnection(connectionIndex - 1)) {
                tooltip.style.display = 'block';
                setTimeout(() => {
                    tooltip.style.display = 'none';
                }, 3000);
                return;
            }

            const container = document.getElementById('connection-sections');
            const newConnection = document.createElement('div');
            newConnection.className = 'connection-section';
            newConnection.dataset.index = connectionIndex;
            newConnection.innerHTML = `
                <legend>Conexión ${connectionIndex + 1}</legend>

                <div class="form-floating mb-3">
                    <input type="text" name="dbConexion[${connectionIndex}][name]" class="form-control"
                        id="floatingInput${connectionIndex}name" placeholder="Nombre de la conexión">
                    <label for="floatingInput${connectionIndex}name">Nombre de la conexión</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" name="dbConexion[${connectionIndex}][ip]" class="form-control"
                        id="floatingInput${connectionIndex}0" placeholder="IP">
                    <label for="floatingInput${connectionIndex}0">IP</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" name="dbConexion[${connectionIndex}][port]" class="form-control"
                        id="floatingInput${connectionIndex}1" placeholder="Puerto">
                    <label for="floatingInput${connectionIndex}1">Puerto</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" name="dbConexion[${connectionIndex}][database]" class="form-control"
                        id="floatingInput${connectionIndex}2" placeholder="Base de datos">
                    <label for="floatingInput${connectionIndex}2">Base de datos</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" name="dbConexion[${connectionIndex}][username]" class="form-control"
                        id="floatingInput${connectionIndex}3" placeholder="Usuario">
                    <label for="floatingInput${connectionIndex}3">Usuario</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" name="dbConexion[${connectionIndex}][password]" class="form-control"
                        id="floatingInput${connectionIndex}4" placeholder="Contraseña">
                    <label for="floatingInput${connectionIndex}4">Contraseña</label>
                </div>

                <button type="button" class="remove-connection-btn" onclick="removeConnection(this)">✖</button>
            `;
            container.appendChild(newConnection);
            connectionIndex++;
            reindexConnections();
        }

        // Función para eliminar una conexión
        function removeConnection(button) {
            const section = button.closest('.connection-section');
            section.remove();
            reindexConnections();
            connectionIndex--;
        }

        // Manejo del evento de envío del formulario para validación final
        document.getElementById('create-local-form').addEventListener('submit', function(event) {
            const tooltip = document.getElementById('form-tooltip');
            const sections = document.querySelectorAll('.connection-section');
            let isValid = true;

            sections.forEach((section, index) => {
                if (!validateConnection(index)) {
                    isValid = false;
                    section.style.borderColor = '#ff5c5c'; // Resalta la sección con borde rojo
                } else {
                    section.style.borderColor = '#ccc'; // Normal
                }
            });

            if (!isValid) {
                event.preventDefault(); // Previene el envío del formulario
                tooltip.style.display = 'block';
                setTimeout(() => {
                    tooltip.style.display = 'none';
                }, 3000);
            }
        });
    </script>
@endsection
