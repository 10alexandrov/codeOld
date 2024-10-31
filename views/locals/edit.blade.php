@extends('plantilla.plantilla')

@section('titulo', 'Editar Local')
@section('style')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
@endsection

@section('contenido')
    <div class="container">
        <div class="col-8 offset-2 isla-list p-4 mt-5">
            <div class="ttl text-center mb-4">
                <h1>Editar local {{ $local['name'] }}</h1>
            </div>

            <form id="edit-form" action="{{ route('locals.update', $local['id']) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Nombre del local -->
                <div class="form-floating mb-3">
                    <input value="{{ old('nameLocal', $local['name']) }}" type="text" name="nameLocal" class="form-control"
                        id="floatingInput" placeholder="Nombre">
                    <label for="floatingInput">Nombre</label>
                    @if ($errors->has('nameLocal'))
                        <div class="text-danger">{{ $errors->first('nameLocal') }}</div>
                    @endif
                </div>

                <!-- ID de la máquina -->
                <div class="form-floating mb-3">
                    <input value="{{ old('machine_id', $local['idMachines']) }}" type="text" name="machine_id"
                        class="form-control" id="floatingInputMachine" placeholder="Serie/Fabricación">
                    <label for="floatingInputMachine">Serie/Fabricación</label>
                    @if ($errors->has('machine_id'))
                        <div class="text-danger">{{ $errors->first('machine_id') }}</div>
                    @endif
                </div>

                <!-- Sección de conexiones -->
                <div id="connection-sections">
                    @foreach ($local['dbconection'] as $index => $connection)
                        <div class="connection-section" data-index="{{ $index }}">
                            <legend>Conexión {{ $index === 0 ? 'principal' : $index + 1 }}</legend>

                            <!-- Nombre de la conexión principal como solo lectura -->
                            @if ($index === 0)
                                <div class="form-floating mb-3">
                                    <input type="hidden" name="dbConexion[{{ $index }}][name]"
                                        value="{{ $connection['name'] ?? '' }}">
                                    <input type="text" class="form-control" value="{{ $connection['name'] ?? '' }}"
                                        readonly>
                                    <label for="floatingInput{{ $index }}Name">Nombre</label>
                                </div>
                            @else
                                <div class="form-floating mb-3">
                                    <input value="{{ old("dbConexion.$index.name", $connection['name'] ?? '') }}"
                                        type="text" name="dbConexion[{{ $index }}][name]" class="form-control"
                                        id="floatingInput{{ $index }}Name" placeholder="Nombre">
                                    <label for="floatingInput{{ $index }}Name">Nombre</label>
                                </div>
                            @endif

                            <div class="form-floating mb-3">
                                <input value="{{ old("dbConexion.$index.ip", $connection['ip'] ?? '') }}" type="text"
                                    name="dbConexion[{{ $index }}][ip]" class="form-control"
                                    id="floatingInput{{ $index }}Ip" placeholder="IP">
                                <label for="floatingInput{{ $index }}Ip">IP</label>
                                @if ($errors->has("dbConexion.$index.ip"))
                                    <div class="text-danger">{{ $errors->first("dbConexion.$index.ip") }}</div>
                                @endif
                            </div>

                            <div class="form-floating mb-3">
                                <input value="{{ old("dbConexion.$index.port", $connection['port'] ?? '') }}"
                                    type="text" name="dbConexion[{{ $index }}][port]" class="form-control"
                                    id="floatingInput{{ $index }}Port" placeholder="Puerto">
                                <label for="floatingInput{{ $index }}Port">Puerto</label>
                                @if ($errors->has("dbConexion.$index.port"))
                                    <div class="text-danger">{{ $errors->first("dbConexion.$index.port") }}</div>
                                @endif
                            </div>

                            <div class="form-floating mb-3">
                                <input value="{{ old("dbConexion.$index.database", $connection['database'] ?? '') }}"
                                    type="text" name="dbConexion[{{ $index }}][database]" class="form-control"
                                    id="floatingInput{{ $index }}Database" placeholder="Base de datos">
                                <label for="floatingInput{{ $index }}Database">Nombre de la base de datos</label>
                                @if ($errors->has("dbConexion.$index.database"))
                                    <div class="text-danger">{{ $errors->first("dbConexion.$index.database") }}</div>
                                @endif
                            </div>

                            <div class="form-floating mb-3">
                                <input value="{{ old("dbConexion.$index.username", $connection['username'] ?? '') }}"
                                    type="text" name="dbConexion[{{ $index }}][username]" class="form-control"
                                    id="floatingInput{{ $index }}Username" placeholder="Usuario">
                                <label for="floatingInput{{ $index }}Username">Usuario</label>
                                @if ($errors->has("dbConexion.$index.username"))
                                    <div class="text-danger">{{ $errors->first("dbConexion.$index.username") }}</div>
                                @endif
                            </div>

                            <div class="form-floating mb-3">
                                <input value="{{ old("dbConexion.$index.password", $connection['password'] ?? '') }}"
                                    type="text" name="dbConexion[{{ $index }}][password]" class="form-control"
                                    id="floatingInput{{ $index }}Password" placeholder="Contraseña">
                                <label for="floatingInput{{ $index }}Password">Contraseña</label>
                                @if ($errors->has("dbConexion.$index.password"))
                                    <div class="text-danger">{{ $errors->first("dbConexion.$index.password") }}</div>
                                @endif
                            </div>

                            <!-- Campo oculto para ID de conexión -->
                            <input type="hidden" name="dbConexion[{{ $index }}][id]"
                                value="{{ $connection['id'] ?? '' }}">

                            <!-- Botón para eliminar conexiones adicionales -->
                            @if ($index > 0)
                                <button type="button" class="remove-connection-btn"
                                    onclick="removeConnection(this)">✖</button>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Botón para añadir una nueva conexión -->
                <div class="text-end mb-3 position-relative">
                    <button type="button" class="btn btn-primary" onclick="addConnection()">Añadir Conexión</button>
                    <div id="tooltip" class="tooltip-alert" role="tooltip">Completa la conexión anterior antes de
                        agregar
                        otra.</div>
                </div>

                <!-- Campo oculto para las conexiones a eliminar -->
                <input type="hidden" id="connections-to-delete" name="connections_to_delete" value="">

                <!-- Hidden para zone_id -->
                <input type="hidden" name="zone_id" value="{{ $local['zone_id'] }}">

                <div class="text-end position-relative">
                    <a href="{{ route('zones.show', $local['zone_id']) }}" class="btn btn-danger">Cancelar</a>
                    <button type="submit" class="btn btn-success" onclick="return validateForm()">Guardar Cambios</button>
                    <div id="save-tooltip" class="tooltip-alert" role="tooltip">Completa todos los campos de la última conexión antes de guardar.</div>
                </div>
            </form>
        </div>
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

        #save-tooltip {
            top: -80px;
            right: 10px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let connectionIndex = {{ count($local['dbconection']) }};
            let connectionsToDelete = [];

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

            // Función para validar el formulario
            window.validateForm = function() {
                const lastConnectionIndex = connectionIndex - 1;
                if (lastConnectionIndex >= 0 && !validateConnection(lastConnectionIndex)) {
                    const tooltip = document.getElementById('save-tooltip');
                    tooltip.style.display = 'block';
                    setTimeout(() => {
                        tooltip.style.display = 'none';
                    }, 2000);
                    return false; // No enviar el formulario
                }
                return true; // Enviar el formulario
            };

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
            window.addConnection = function() {
                const lastConnection = document.querySelector(
                    `.connection-section[data-index="${connectionIndex - 1}"]`);

                if (lastConnection && !validateConnection(connectionIndex - 1)) {
                    const tooltip = document.getElementById('tooltip');
                    tooltip.style.display = 'block';
                    setTimeout(() => {
                        tooltip.style.display = 'none';
                    }, 2000);
                    return;
                }

                const section = document.createElement('div');
                section.className = 'connection-section';
                section.dataset.index = connectionIndex;
                section.innerHTML = `
                    <legend>Conexión ${connectionIndex + 1}</legend>
                    <div class="form-floating mb-3">
                        <input type="text" name="dbConexion[${connectionIndex}][name]" class="form-control"
                            placeholder="Nombre">
                        <label>Nombre</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="dbConexion[${connectionIndex}][ip]" class="form-control"
                            placeholder="IP">
                        <label>IP</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="dbConexion[${connectionIndex}][port]" class="form-control"
                            placeholder="Puerto">
                        <label>Puerto</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="dbConexion[${connectionIndex}][database]" class="form-control"
                            placeholder="Base de datos">
                        <label>Nombre de la base de datos</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="dbConexion[${connectionIndex}][username]" class="form-control"
                            placeholder="Usuario">
                        <label>Usuario</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="dbConexion[${connectionIndex}][password]" class="form-control"
                            placeholder="Contraseña">
                        <label>Contraseña</label>
                    </div>
                    <button type="button" class="remove-connection-btn" onclick="removeConnection(this)">✖</button>
                `;
                document.getElementById('connection-sections').appendChild(section);
                connectionIndex++;
                reindexConnections();
            };

            // Función para eliminar una conexión
            window.removeConnection = function(button) {
                const section = button.closest('.connection-section');
                const connectionIdInput = section.querySelector('input[type="hidden"][name*="[id]"]');
                if (connectionIdInput && connectionIdInput.value) {
                    connectionsToDelete.push(connectionIdInput.value);
                    document.getElementById('connections-to-delete').value = connectionsToDelete.join(',');
                }
                section.remove();
                reindexConnections();
                connectionIndex--;
            };
        });
    </script>
@endsection
