@extends('plantilla.plantilla')
@section('titulo', 'Cargas de la Máquina')
@section('contenido')

    <div class="container">

        <div class="col-12 text-center d-flex justify-content-center mt-3 mb-3" id="headerAll">
            <div class="w-50 ttl">
                <h1>Cargas de la Máquina: {{ $machine->name }}</h1>
            </div>
        </div>

        <!-- Verificar si hay cargas iniciales -->
        @if ($loads->where('Initial', true)->isNotEmpty())
            <div class="row">
                <div class="col-12">
                    <h3>Carga Inicial</h3>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Fecha de creación</th>
                                <th>Número</th>
                                <th>Cantidad</th>
                                <th>Creado por</th>
                                <th>Cerrado por</th>
                                <th>Fecha de recuperación</th>
                                <th>Cantidad parcial</th>
                                <th>Irrecuperable</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>



                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @foreach ($loads->where('Initial', true) as $load)
                                @php
                                    // Determinar la clase CSS según el estado
                                    $rowClass = '';
                                    switch ($load->State) {
                                        case 'PAID':
                                            $rowClass = 'table-primary';
                                            break;
                                        case 'RECOVERED':
                                            $rowClass = 'table-success';
                                            break;
                                        case 'PARTIAL':
                                            $rowClass = 'table-danger red-line';
                                            break;
                                        case 'CLOSED':
                                            $rowClass = 'table-warning red-line';
                                            break;
                                    }
                                @endphp
                                <tr data-id="{{ $load->id }}" id="{{ $load->id }}" class="{{ $rowClass }}">
                                    <td>
                                        <input type="date" class="form-control form-control-sm created-at-input"
                                            value="{{ $load->created_at ? \Carbon\Carbon::parse($load->created_at)->format('Y-m-d') : '' }}"
                                            disabled>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm number-input"
                                            value="{{ $load->Number }}" disabled>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm quantity-input"
                                            value="{{ $load->Quantity }}" disabled>
                                    </td>
                                    <td data-created-for="{{ $load->userCreated }}">
                                        {{ $load->userCreated ? $load->userCreated->name : '' }}</td>
                                    <td class="closed-for-container">
                                        {{ $load->State === 'RECOVERED' || $load->State === 'PARTIAL' || $load->State === 'CLOSED' ? ($load->userClosed ? $load->userClosed->name : '') : '' }}
                                    </td>
                                    <td>
                                        <input type="date" class="form-control form-control-sm date-recovered-input"
                                            value="{{ in_array($load->State, ['RECOVERED', 'PARTIAL', 'CLOSED']) ? \Carbon\Carbon::parse($load->date_recovered)->format('Y-m-d') : '' }}"
                                            disabled>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm partial-quantity-input"
                                            value="{{ $load->Partial_quantity }}" disabled>
                                    </td>
                                    <td>
                                        <input type="checkbox" class="irrecoverable-checkbox"
                                            {{ $load->Irrecoverable ? 'checked' : '' }} disabled>
                                    </td>
                                    <td>
                                        <!-- Texto del estado mostrado por defecto -->
                                        <span class="state-text">{{ translateState($load->State) }}</span>
                                        <div class="state-checkboxes d-none">
                                            <label><input type="radio" name="State" value="OPEN"
                                                    {{ $load->State == 'OPEN' ? 'checked' : '' }}> ABIERTO</label>
                                            <label><input type="radio" name="State" value="PAID"
                                                    {{ $load->State == 'PAID' ? 'checked' : '' }}> PAGADO</label>
                                            <label><input type="radio" name="State" value="RECOVERED"
                                                    {{ $load->State == 'RECOVERED' ? 'checked' : '' }}> RECUPERADO</label>
                                            <label><input type="radio" name="State" value="PARTIAL"
                                                    {{ $load->State == 'PARTIAL' ? 'checked' : '' }}> PARCIAL</label>
                                            <label><input type="radio" name="State" value="CLOSED"
                                                    {{ $load->State == 'CLOSED' ? 'checked' : '' }}> CERRADO</label>

                                            <input type="hidden" class="state-hidden" value="{{ $load->State }}">
                                        </div>
                                        <div id="alert-container" class="alert-container"></div>
                                    </td>
                                    <td>
                                        <button class="btn btn-warning btn-sm edit-btn"><i class="bi bi-pencil-square"></i></button>
                                        <button class="btn btn-secondary btn-sm cancel-btn d-none"><i class="bi bi-x-circle"></i></button>

                                        <form action="{{ route('loads.update', $load->id) }}" method="POST"
                                            class="d-inline save-form d-none">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="id" value="{{ $load->id }}">
                                            <input type="hidden" name="Number" class="number-hidden">
                                            <input type="hidden" name="Quantity" class="quantity-hidden">
                                            <input type="hidden" name="Partial_quantity" class="partial-quantity-hidden">
                                            <input type="hidden" name="Irrecoverable" class="irrecoverable-hidden">
                                            <input type="hidden" name="State" class="state-hidden">
                                            <input type="hidden" name="created_at" class="created-at-hidden">
                                            <input type="hidden" name="date_recovered" class="date-recovered-hidden">
                                            <input type="hidden" name="created_for" class="created-for-hidden">
                                            <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check-lg"></i></button>
                                        </form>

                                        <!--<form action="{{ route('loads.destroy', $load->id) }}" method="POST"
                                                                                                                                                                                                                                                                                                                            class="d-inline delete-form">
                                                                                                                                                                                                                                                                                                                            @csrf
                                                                                                                                                                                                                                                                                                                            @method('DELETE')
                                                                                                                                                                                                                                                                                                                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                                                                                                                                                                                                                                                                                                        </form>--
                                                                                                                                                                                                                                                                                                                        <!-- Botón para abrir el modal de eliminación -->
                                        <button type="button" class="btn btn-danger btn-sm delete-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $load->id }}"><i class="bi bi-trash3"></i></button>

                                        <!-- Modal de eliminación -->
                                        <div class="modal fade" id="deleteModal{{ $load->id }}" tabindex="-1"
                                            aria-labelledby="deleteModalLabel{{ $load->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel{{ $load->id }}">
                                                            Eliminar Carga</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>¿Estás seguro de que deseas eliminar esta carga?</p>
                                                        <ul style="text-align: left;">
                                                            @if ($load->Number)
                                                                <li><strong>Número:</strong> {{ $load->Number }}</li>
                                                            @endif
                                                            @if ($load->Quantity)
                                                                <li><strong>Cantidad:</strong> {{ $load->Quantity }}</li>
                                                            @endif
                                                            @if ($load->userCreated)
                                                                <li><strong>Creado por:</strong>
                                                                    {{ $load->userCreated->name }}</li>
                                                            @endif
                                                            @if ($load->userClosed)
                                                                <li><strong>Cerrado por:</strong>
                                                                    {{ $load->userClosed->name }}</li>
                                                            @endif
                                                            @if ($load->Partial_quantity)
                                                                <li><strong>Cantidad parcial:</strong>
                                                                    {{ $load->Partial_quantity }}</li>
                                                            @endif
                                                            @if ($load->Irrecoverable)
                                                                <li><strong>Irrecuperable:</strong> Sí</li>
                                                            @endif
                                                            @if ($load->Initial)
                                                                <li><strong>Inicial:</strong> Sí</li>
                                                            @endif
                                                            @if ($load->State)
                                                                <li><strong>Estado:</strong>
                                                                    {{ translateState($load->State) }}</li>
                                                            @endif
                                                            @if ($load->machine)
                                                                <li><strong>Nombre de la Máquina:</strong>
                                                                    {{ $load->machine->alias }}</li>
                                                            @endif
                                                            @if ($load->date_recovered)
                                                                <li><strong>Fecha de recuperación:</strong>
                                                                    {{ \Carbon\Carbon::parse($load->date_recovered)->format('d-m-Y H:i') }}
                                                                </li>
                                                            @endif
                                                            @if ($load->created_at)
                                                                <li><strong>Fecha de creación:</strong>
                                                                    {{ \Carbon\Carbon::parse($load->created_at)->format('d-m-Y H:i') }}
                                                                </li>
                                                            @endif
                                                            @if ($load->updated_at)
                                                                <li><strong>Última actualización:</strong>
                                                                    {{ \Carbon\Carbon::parse($load->updated_at)->format('d-m-Y H:i') }}
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cerrar</button>
                                                        <form action="{{ route('loads.destroy', $load->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-danger">Eliminar</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <div class="container">
            <div class="row justify-content-center" style="background: rgb(131, 131, 133); padding: 20px;">
                <form id="create-load-form" action="{{ route('loads.store') }}" method="POST" class="col-md-8">
                    @csrf

                    <div class="row mb-3">
                        <!-- Número de carga -->
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input value="{{ old('Number') }}" type="number" name="Number" class="form-control"
                                    id="floatingNumber" placeholder="Número de carga">
                                <label for="floatingNumber">Número de carga</label>
                                @if ($errors->has('Number'))
                                    <div class="text-danger">{{ $errors->first('Number') }}</div>
                                @endif
                            </div>
                        </div>

                        <!-- Cantidad -->
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input value="{{ old('Quantity') }}" type="number" name="Quantity"
                                    class="form-control" id="floatingQuantity" placeholder="Cantidad">
                                <label for="floatingQuantity">Cantidad</label>
                                @if ($errors->has('Quantity'))
                                    <div class="text-danger">{{ $errors->first('Quantity') }}</div>
                                @endif
                            </div>
                        </div>

                        <!-- ID de la máquina -->
                        <input type="hidden" name="machine_id" value="{{ $machine->id }}">

                        <!-- ID del local -->
                        <input type="hidden" name="local_id" value="{{ $machine->local_id }}">
                    </div>

                    <!-- Botón de Enviar -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-warning">Crear Carga</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <p>Cargas pendientes de recuperar: {{ $totalQuantity }}</p>
        </div>
        <div class="row">
            <p>Cargas pendientes de recuperar parciales: {{ $totalPartial }}</p>
        </div>
        <div class="row">
            <p>Cargas irrecuperables: {{ $totalIrrecoverable }}</p>
        </div>

        <!-- Verificar si hay cargas adicionales -->
        @if ($loads->where('Initial', false)->isNotEmpty())
            <div class="row">
                <div class="col-12">
                    <h3>Cargas Adicionales</h3>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Fecha de creación</th>
                                <th>Número</th>
                                <th>Cantidad</th>
                                <th>Creado por</th>
                                <th>Cerrado por</th>
                                <th>Fecha de recuperación</th>
                                <th>Cantidad parcial</th>
                                <th>Irrecuperable</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($loads->where('Initial', false) as $load)
                                @php
                                    // Determinar la clase CSS según el estado
                                    $rowClass = '';
                                    switch ($load->State) {
                                        case 'PAID':
                                            $rowClass = 'table-primary';
                                            break;
                                        case 'RECOVERED':
                                            $rowClass = 'table-success';
                                            break;
                                        case 'PARTIAL':
                                            $rowClass = 'table-danger red-line';
                                            break;
                                        case 'CLOSED':
                                            $rowClass = 'table-warning red-line';
                                            break;
                                    }
                                @endphp
                                <tr data-id="{{ $load->id }}" id="{{ $load->id }}"
                                    class="{{ $rowClass }}">
                                    <td>
                                        <input type="date" class="form-control form-control-sm created-at-input"
                                            value="{{ $load->created_at ? \Carbon\Carbon::parse($load->created_at)->format('Y-m-d') : '' }}"
                                            disabled>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm number-input"
                                            value="{{ $load->Number }}" disabled>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm quantity-input"
                                            value="{{ $load->Quantity }}" disabled>
                                    </td>
                                    <td data-created-for="{{ $load->userCreated }}">
                                        {{ $load->userCreated ? $load->userCreated->name : '' }}</td>
                                    <td class="closed-for-container">
                                        {{ $load->State === 'RECOVERED' || $load->State === 'PARTIAL' || $load->State === 'CLOSED' ? ($load->userClosed ? $load->userClosed->name : '') : '' }}
                                    </td>
                                    <td>
                                        <input type="date" class="form-control form-control-sm date-recovered-input"
                                            value="{{ in_array($load->State, ['RECOVERED', 'PARTIAL', 'CLOSED']) ? \Carbon\Carbon::parse($load->date_recovered)->format('Y-m-d') : '' }}"
                                            disabled>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm partial-quantity-input"
                                            value="{{ $load->Partial_quantity }}" disabled>
                                    </td>
                                    <td>
                                        <input type="checkbox" class="irrecoverable-checkbox"
                                            {{ $load->Irrecoverable ? 'checked' : '' }} disabled>
                                    </td>
                                    <td>
                                        <!-- Texto del estado mostrado por defecto -->
                                        <span class="state-text">{{ translateState($load->State) }}</span>
                                        <!-- Radio buttons ocultos por defecto -->
                                        <div class="state-checkboxes d-none">
                                            <label><input type="radio" name="State_{{ $load->id }}" value="OPEN"
                                                    {{ $load->State == 'OPEN' ? 'checked' : '' }}> ABIERTO</label>
                                            <label><input type="radio" name="State_{{ $load->id }}" value="PAID"
                                                    {{ $load->State == 'PAID' ? 'checked' : '' }}> PAGADO</label>
                                            <label><input type="radio" name="State_{{ $load->id }}"
                                                    value="RECOVERED" {{ $load->State == 'RECOVERED' ? 'checked' : '' }}>
                                                RECUPERADO</label>
                                            <label><input type="radio" name="State_{{ $load->id }}"
                                                    value="PARTIAL" {{ $load->State == 'PARTIAL' ? 'checked' : '' }}>
                                                PARCIAL</label>
                                            <label><input type="radio" name="State_{{ $load->id }}" value="CLOSED"
                                                    {{ $load->State == 'CLOSED' ? 'checked' : '' }}> CERRADO</label>
                                            <input type="hidden" class="state-hidden" value="{{ $load->State }}">
                                        </div>
                                        <div id="alert-container" class="alert-container"></div>
                                    </td>
                                    <td>
                                        <button class="btn btn-warning btn-sm edit-btn"><i class="bi bi-pencil-square"></i></button>
                                        <button class="btn btn-secondary btn-sm cancel-btn d-none"><i class="bi bi-x-circle"></i></button>

                                        <form action="{{ route('loads.update', $load->id) }}" method="POST"
                                            class="d-inline save-form d-none">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="id" value="{{ $load->id }}">
                                            <input type="hidden" name="Number" class="number-hidden">
                                            <input type="hidden" name="Quantity" class="quantity-hidden">
                                            <input type="hidden" name="Partial_quantity"
                                                class="partial-quantity-hidden">
                                            <input type="hidden" name="Irrecoverable" class="irrecoverable-hidden">
                                            <input type="hidden" name="State" class="state-hidden">
                                            <input type="hidden" name="created_at" class="created-at-hidden">
                                            <input type="hidden" name="date_recovered" class="date-recovered-hidden">
                                            <input type="hidden" name="created_for" class="created-for-hidden">
                                            <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check-lg"></i></button>
                                        </form>

                                        <!--<form action="{{ route('loads.destroy', $load->id) }}" method="POST"
                                                                                                                                                                                                                                                                                                                        class="d-inline delete-form">
                                                                                                                                                                                                                                                                                                                        @csrf
                                                                                                                                                                                                                                                                                                                        @method('DELETE')
                                                                                                                                                                                                                                                                                                                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                                                                                                                                                                                                                                                                                                    </form>-->
                                        <!-- Botón para abrir el modal de eliminación -->
                                        <button type="button" class="btn btn-danger btn-sm delete-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $load->id }}"><i class="bi bi-trash3"></i></button>

                                        <!-- Modal de eliminación -->
                                        <div class="modal fade" id="deleteModal{{ $load->id }}" tabindex="-1"
                                            aria-labelledby="deleteModalLabel{{ $load->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel{{ $load->id }}">
                                                            Eliminar Carga</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>¿Estás seguro de que deseas eliminar esta carga?</p>
                                                        <ul>
                                                            @if ($load->Number)
                                                                <li><strong>Número:</strong> {{ $load->Number }}</li>
                                                            @endif
                                                            @if ($load->Quantity)
                                                                <li><strong>Cantidad:</strong> {{ $load->Quantity }}</li>
                                                            @endif
                                                            @if ($load->userCreated)
                                                                <li><strong>Creado por:</strong>
                                                                    {{ $load->userCreated->name }}</li>
                                                            @endif
                                                            @if ($load->userClosed)
                                                                <li><strong>Cerrado por:</strong>
                                                                    {{ $load->userClosed->name }}</li>
                                                            @endif
                                                            @if ($load->Partial_quantity)
                                                                <li><strong>Cantidad parcial:</strong>
                                                                    {{ $load->Partial_quantity }}</li>
                                                            @endif
                                                            @if ($load->Irrecoverable)
                                                                <li><strong>Irrecuperable:</strong> Sí</li>
                                                            @endif
                                                            @if ($load->Initial)
                                                                <li><strong>Inicial:</strong> Sí</li>
                                                            @endif
                                                            @if ($load->State)
                                                                <li><strong>Estado:</strong>
                                                                    {{ translateState($load->State) }}</li>
                                                            @endif
                                                            @if ($load->machine)
                                                                <li><strong>Nombre de la Máquina:</strong>
                                                                    {{ $load->machine->name }}</li>
                                                            @endif
                                                            @if ($load->date_recovered)
                                                                <li><strong>Fecha de recuperación:</strong>
                                                                    {{ \Carbon\Carbon::parse($load->date_recovered)->format('d-m-Y H:i') }}
                                                                </li>
                                                            @endif
                                                            @if ($load->created_at)
                                                                <li><strong>Fecha de creación:</strong>
                                                                    {{ \Carbon\Carbon::parse($load->created_at)->format('d-m-Y H:i') }}
                                                                </li>
                                                            @endif
                                                            @if ($load->updated_at)
                                                                <li><strong>Última actualización:</strong>
                                                                    {{ \Carbon\Carbon::parse($load->updated_at)->format('d-m-Y H:i') }}
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cerrar</button>
                                                        <form action="{{ route('loads.destroy', $load->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-danger">Eliminar</i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- Modal eliminar carga -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Eliminar Carga</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>¿Estás seguro de que deseas eliminar la siguiente carga?</p>
                        <table class="table">
                            <tbody id="deleteModalBody">
                                <!-- La información del registro se añadirá aquí dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <form id="deleteForm" action="" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <style>
        .table-primary {
            background-color: blue !important;
        }

        .table-success {
            background-color: green !important;
        }

        .table-danger {
            background-color: red !important;
            position: relative;
        }

        .table-danger::after {
            content: "";
            position: absolute;
            left: 0;
            top: 50%;
            width: 100%;
            height: 2px;
            background-color: red;
            z-index: 1;
        }

        .table-warning {
            background-color: yellow !important;
            position: relative;
        }

        .table-warning::after {
            content: "";
            position: absolute;
            left: 0;
            top: 50%;
            width: 100%;
            height: 2px;
            background-color: red;
            z-index: 1;
        }

        .form-control-sm {
            width: 100px;
        }

        .state-text {
            display: inline;
        }



        .state-text.hidden {
            display: none;
        }

        .alert-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            /* Para que se vea por encima de otros elementos */
        }

        .btn-none {
            display: none;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Variable para rastrear la fila actualmente en edición
            let currentEditingRow = null;

            window.user = @json($user);
            window.userRole = @json($user->roles->first()->name);
            console.log('Usuario ', window.user, ' Rol del usuario ', window.userRole);

            // Aplicar la lógica para deshabilitar botones de eliminar si el rol es Técnico
            if (window.userRole === 'Tecnico') {
                document.querySelectorAll('.delete-btn').forEach(button => {
                    button.classList.add('btn-none');
                });
            }

            // Función para deshabilitar todas las demás filas
            function disableOtherRows(currentRow) {
                document.querySelectorAll('tr').forEach(row => {
                    if (row !== currentRow) {
                        row.querySelectorAll('button').forEach(button => button.disabled = true);
                    }
                });
            }

            // Función para habilitar todas las filas
            function enableAllRows() {
                document.querySelectorAll('tr').forEach(row => {
                    row.querySelectorAll('button').forEach(button => button.disabled = false);
                });
            }

            //  Event listener para el botón de editar
            document.querySelectorAll('.edit-btn').forEach(button => {
                button.addEventListener('click', function() {

                    const tr = this.closest('tr');
                    const state = tr.querySelector('.state-hidden').value;

                    // Si ya hay una fila en edición, cancelarla
                    if (currentEditingRow) {
                        cancelEdit(currentEditingRow);
                    }

                    // Verificar si el estado es 'Irrecoverable'
                    const isIrrecoverable = tr.querySelector('.irrecoverable-checkbox').checked;

                    if (isIrrecoverable) {
                        // Mostrar un mensaje de error y evitar la edición
                        showAlert('No puedes editar una carga Irrecuperable.', 'danger');
                        return; // Evitar el resto del código
                    }

                    // Verificar el rol del usuario y el estado del load para permitir la edición
                    if (window.userRole === 'Tecnico') {
                        if (['OPEN', 'PAID'].includes(state)) {
                            tr.querySelectorAll('input').forEach(input => input.removeAttribute(
                                'disabled'));
                            tr.querySelectorAll('.state-checkboxes').forEach(checkboxes =>
                                checkboxes.classList.remove('d-none'));
                            tr.querySelectorAll('.state-text').forEach(text => text.classList.add(
                                'd-none'));
                            tr.querySelector('.edit-btn').classList.add('d-none');
                            tr.querySelector('.cancel-btn').classList.remove('d-none');
                            tr.querySelector('.save-form').classList.remove('d-none');
                            updateStateOptions(tr);

                            // Deshabilitar todas las demás filas
                            disableOtherRows(tr);

                            // Establecer la fila actual como la fila en edición
                            currentEditingRow = tr;
                        } else {
                            showAlert('No tienes permisos para editar esta carga.', 'danger');
                        }
                    } else {
                        // Para otros roles (Super Admin, Jefe Delegacion, Oficina), permitir la edición en cualquier estado
                        tr.querySelectorAll('input').forEach(input => input.removeAttribute(
                            'disabled'));
                        tr.querySelectorAll('.state-checkboxes').forEach(checkboxes => checkboxes
                            .classList.remove('d-none'));
                        tr.querySelectorAll('.state-text').forEach(text => text.classList.add(
                            'd-none'));
                        tr.querySelector('.edit-btn').classList.add('d-none');
                        tr.querySelector('.cancel-btn').classList.remove('d-none');
                        tr.querySelector('.save-form').classList.remove('d-none');
                        updateStateOptions(tr);

                        // Ocultar el botón de eliminar
                        tr.querySelector('.delete-btn').classList.add('d-none');

                        // Deshabilitar todas las demás filas
                        disableOtherRows(tr);

                        // Establecer la fila actual como la fila en edición
                        currentEditingRow = tr;
                    }
                });
            });

            // Event listener para el botón de cancelar
            document.querySelectorAll('.cancel-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const tr = this.closest('tr');
                    cancelEdit(tr);

                    // Mostrar el botón de eliminar
                    tr.querySelector('.delete-btn').classList.remove('d-none');

                    // Habilitar todas las filas
                    enableAllRows();

                    // Reiniciar la variable de la fila en edición
                    currentEditingRow = null;
                });
            });

            // Función para cancelar la edición de una fila
            function cancelEdit(tr) {
                tr.querySelectorAll('input').forEach(input => input.setAttribute('disabled', 'disabled'));
                tr.querySelectorAll('.state-checkboxes').forEach(checkboxes => checkboxes.classList.add('d-none'));
                tr.querySelectorAll('.state-text').forEach(text => text.classList.remove('d-none'));
                tr.querySelector('.edit-btn').classList.remove('d-none');
                tr.querySelector('.cancel-btn').classList.add('d-none');
                tr.querySelector('.save-form').classList.add('d-none');
            }

            // Manejar el evento submit de los formularios de eliminación con confirmación
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    const confirmation = confirm(
                        '¿Estás seguro de que deseas eliminar este registro? Esta acción no se puede deshacer.'
                    );
                    if (confirmation) {
                        form.submit();
                    }
                });
            });

            // Manejar la edición y envío de campos
            document.querySelectorAll('.save-form').forEach(form => {
                form.addEventListener('submit', function(event) {
                    const tr = this.closest('tr');
                    const partialQuantityInput = tr.querySelector('.partial-quantity-input');
                    const selectedState = Array.from(tr.querySelectorAll(
                        '.state-checkboxes input[type="radio"]')).find(radio => radio.checked);

                    // Validación: Mostrar alert si se selecciona 'PARTIAL' y no se ha rellenado el campo de cantidad parcial o su valor es 0
                    if (selectedState && selectedState.value === 'PARTIAL' && (!partialQuantityInput
                            .value.trim() || partialQuantityInput.value == 0)) {
                        event.preventDefault(); // Evita el envío del formulario
                        showAlert(
                            'Debes rellenar el campo "Cantidad parcial" con un valor antes de seleccionar el estado "PARCIAL".',
                            'danger');
                        return;
                    }

                    // Nueva validación: Mostrar alert si el checkbox "Irrecuperable" está marcado pero no se ha seleccionado un técnico
                    const irrecoverableCheckbox = tr.querySelector('.irrecoverable-checkbox');
                    const closedForSelect = tr.querySelector('.closed-for-select');

                    if (irrecoverableCheckbox.checked && (!closedForSelect || !closedForSelect
                            .value)) {
                        event.preventDefault(); // Evita el envío del formulario
                        showAlert(
                            'Debes seleccionar un técnico para el campo "Cerrado por" cuando se marca "Irrecuperable".',
                            'danger');
                        return;
                    }

                    form.querySelector('.number-hidden').value = tr.querySelector('.number-input')
                        .value;
                    form.querySelector('.quantity-hidden').value = tr.querySelector(
                        '.quantity-input').value;
                    form.querySelector('.partial-quantity-hidden').value = partialQuantityInput
                        .value;
                    form.querySelector('.irrecoverable-hidden').value = irrecoverableCheckbox
                        .checked ? 1 : 0;
                    form.querySelector('.created-at-hidden').value = tr.querySelector(
                        '.created-at-input').value;
                    form.querySelector('.date-recovered-hidden').value = tr.querySelector(
                        '.date-recovered-input').value;

                    if (selectedState) {
                        form.querySelector('.state-hidden').value = selectedState.value;
                    }

                    // Añadir el valor del select al campo oculto si se seleccionó un técnico
                    if (closedForSelect) {
                        const closedForHidden = document.createElement('input');
                        closedForHidden.type = 'hidden';
                        closedForHidden.name = 'closed_for';
                        closedForHidden.value = closedForSelect.value;
                        form.appendChild(closedForHidden);
                    }



                    // Habilitar todas las filas después de guardar
                    enableAllRows();

                    // Reiniciar la variable de la fila en edición
                    currentEditingRow = null;
                });
            });

            function updateStateOptions(tr) {
                const state = tr.querySelector('.state-hidden').value; // Obtener el estado actual
                const radios = tr.querySelectorAll('.state-checkboxes input[type="radio"]');
                const currentUserId = window.user.id; // ID del usuario autenticado
                const createdForAttr = tr.querySelector('td[data-created-for]')?.getAttribute('data-created-for');
                window.technicians = @json($userTecnicos); // Lista de técnicos
                let createdForId;

                try {
                    // Intentar parsear el atributo data-created-for como JSON
                    const createdForObject = JSON.parse(createdForAttr);
                    createdForId = createdForObject.id;
                } catch (e) {
                    console.error('Error al parsear data-created-for:', e);
                    createdForId = null;
                }

                console.log(currentUserId, '-----', createdForId);
                console.log('data-created-for attribute:', createdForAttr);

                radios.forEach(radio => {
                    radio.disabled = false; // Habilitar todos los radios por defecto
                    radio.parentElement.style.display = 'none'; // Ocultar todos los radios por defecto
                });

                // Deshabilitar el checkbox irrecoverable en todos los estados por defecto
                const irrecoverableCheckbox = tr.querySelector('.irrecoverable-checkbox');
                irrecoverableCheckbox.setAttribute('disabled', 'disabled');

                // Crear el select para Closed_for con los técnicos
                let closedForSelect = tr.querySelector('.closed-for-select');
                if (!closedForSelect) {
                    closedForSelect = document.createElement('select');
                    closedForSelect.classList.add('closed-for-select', 'form-select', 'mt-2');
                    closedForSelect.innerHTML = `<option value="">Seleccionar Técnico</option>`;
                    window.technicians.forEach(tech => {
                        closedForSelect.innerHTML += `<option value="${tech.id}">${tech.name}</option>`;
                    });
                    tr.querySelector('.closed-for-container').appendChild(closedForSelect);
                    closedForSelect.style.display = 'none'; // Inicialmente oculto
                }

                switch (state) {
                    case 'OPEN':
                        radios.forEach(radio => {
                            if (radio.value === 'PAID') {
                                radio.parentElement.style.display = 'inline'; // Mostrar "PAID"
                                if (window.userRole === 'Tecnico') {
                                    radio.disabled = true;
                                    tr.querySelector('.partial-quantity-input').setAttribute('disabled',
                                        'disabled');
                                    irrecoverableCheckbox.setAttribute('disabled', 'disabled');
                                }
                            }
                        });

                        if (window.userRole === 'Tecnico') {
                            if (currentUserId === createdForId) {
                                tr.querySelector('.number-input').removeAttribute('disabled');
                                tr.querySelector('.quantity-input').removeAttribute('disabled');
                            } else {
                                tr.querySelector('.number-input').setAttribute('disabled', 'disabled');
                                tr.querySelector('.quantity-input').setAttribute('disabled', 'disabled');
                            }
                        }
                        break;
                    case 'PAID':
                        radios.forEach(radio => {
                            // Mostrar los radios con valores 'RECOVERED', 'PARTIAL' y 'CLOSED'
                            if (radio.value === 'RECOVERED') {
                                radio.parentElement.style.display = 'inline';

                                // Deshabilitar radios con valor 'PARTIAL' y 'CLOSED' si el rol es 'Tecnico'
                                if (window.userRole === 'Tecnico' && (radio.value === 'PARTIAL' || radio
                                        .value === 'CLOSED')) {
                                    radio.setAttribute('disabled', 'disabled');
                                }
                            }
                        });

                        // Deshabilitar los elementos con clase '.partial-quantity' si el rol es 'Tecnico'
                        if (window.userRole === 'Tecnico') {
                            const partialQuantityElements = tr.querySelectorAll('.partial-quantity-input');
                            partialQuantityElements.forEach(element => {
                                element.setAttribute('disabled', 'disabled');
                            });

                            // Deshabilitar los inputs '.number-input' y '.quantity-input'
                            tr.querySelector('.number-input').setAttribute('disabled', 'disabled');
                            tr.querySelector('.quantity-input').setAttribute('disabled', 'disabled');
                        }

                        irrecoverableCheckbox.removeAttribute('disabled');
                        break;

                    case 'RECOVERED':
                        radios.forEach(radio => {
                            if (radio.value === 'PARTIAL' || radio.value === 'CLOSED') {
                                radio.parentElement.style.display = 'inline';
                            }
                        });

                        // Poner Partial_quantity en 0 si el estado cambia a RECOVERED
                        tr.querySelector('.partial-quantity-input').value = '0';
                        break;

                    case 'PARTIAL':
                        radios.forEach(radio => {
                            if (radio.value === 'CLOSED' || radio.value === 'RECOVERED') {
                                radio.parentElement.style.display = 'inline';
                            }
                        });
                        break;

                    case 'CLOSED':
                        radios.forEach(radio => {
                            if (radio.value === 'RECOVERED') {
                                radio.parentElement.style.display = 'inline';
                            }
                        });
                        break;

                    default:
                        radios.forEach(radio => {
                            radio.parentElement.style.display = 'inline';
                        });
                        break;
                }

                // Manejar el evento de cambio del checkbox irrecoverable
                irrecoverableCheckbox.addEventListener('change', function() {
                    radios.forEach(radio => {
                        if (radio.value === 'RECOVERED') {
                            radio.disabled = this.checked;
                        }
                    });

                    // Mostrar el select de técnicos cuando se marca el checkbox irrecoverable
                    if (this.checked) {
                        closedForSelect.style.display = 'inline';
                    } else {
                        closedForSelect.style.display = 'none';
                    }
                });

                // Añadir un event listener al select para actualizar el valor del campo oculto
                if (closedForSelect) {
                    closedForSelect.addEventListener('change', function() {
                        const closedForHidden = tr.querySelector('.save-form').querySelector(
                            'input[name="closed_for"]');
                        if (closedForHidden) {
                            closedForHidden.value = this.value;
                        }
                    });
                }

                // Deshabilitar los campos de fecha si el rol es Técnico
                if (window.userRole === 'Tecnico') {
                    tr.querySelector('.created-at-input').setAttribute('disabled', 'disabled');
                    tr.querySelector('.date-recovered-input').setAttribute('disabled', 'disabled');
                }
            }

            // Función para mostrar un alert de Bootstrap
            function showAlert(message, type) {
                const alertContainer = document.getElementById('alert-container');
                const alert = document.createElement('div');
                alert.className = `alert alert-${type} alert-dismissible fade show`;
                alert.setAttribute('role', 'alert');
                alert.innerHTML =
                    `${message}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>`;

                // Añadir el alert al contenedor
                alertContainer.appendChild(alert);

                // Remover el alert después de 5 segundos
                setTimeout(() => {
                    alert.classList.remove('show');
                    alert.classList.add('fade');
                    setTimeout(() => alert.remove(), 150);
                }, 5000);
            }
        });
    </script>

@endsection
