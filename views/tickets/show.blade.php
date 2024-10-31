@extends('plantilla.plantilla')
@section('titulo', 'Local')
@section('contenido')

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
        <div class="d-flex justify-content-center">
            <ul class="nav nav-tabs ul-aux border-0 flex-nowrap" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link btn-danger" id="confTick-tab" data-bs-toggle="tab"
                        data-bs-target="#confTick-tab-pane" type="button" role="tab" aria-controls="confTick-tab-pane"
                        aria-selected="false">Confirmar tickets</button>
                </li>
                @if (!auth()->user()->hasRole(['Tecnico', 'Oficina']))
                    <li class="nav-item" role="presentation">
                        <button class="nav-link btn-danger" id="abort-tab" data-bs-toggle="tab"
                            data-bs-target="#abort-tab-pane" type="button" role="tab" aria-controls="abort-tab-pane"
                            aria-selected="false">Abortar
                            tickets</button>
                    </li>
                @endif
                @if (!auth()->user()->hasRole(['Tecnico', 'Oficina']))
                    <li class="nav-item" role="presentation">
                        <button class="nav-link btn-danger" id="creatTick-tab" data-bs-toggle="tab"
                            data-bs-target="#creatTick-tab-pane" type="button" role="tab"
                            aria-controls="creatTick-tab-pane" aria-selected="false">Crear tickets</button>
                    </li>
                @endif
            </ul>
        </div>

        <div class="mt-2">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade" id="abort-tab-pane" role="tabpanel" aria-labelledby="abort-tab" tabindex="0">
                    <div class="d-none d-md-block">
                        @if (!$abortTicket->isEmpty())
                            <div class="table-responsive mt-5">
                                <form action="{{ route('abortTicket', $local->id) }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Borrar</th>
                                                <th scope="col">Número de ticket</th>
                                                <th scope="col">Fecha</th>
                                                <th scope="col">Usuario</th>
                                                <th scope="col">Valor €</th>
                                                <th scope="col">Tipo</th>
                                                <th scope="col">Comentarios</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($abortTicket as $ticket)
                                                <tr>
                                                    <td><input type="checkbox" class="checkboxpc" name="tickets[]"
                                                            value="{{ $ticket->TicketNumber }}"></td>
                                                    <td>{{ $ticket->TicketNumber }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($ticket->DateTime)->format('d-m-Y H:i') }}
                                                    </td>
                                                    <td>{{ $ticket->User }}</td>
                                                    <td>{{ $ticket->Value }}€</td>
                                                    <td>{{ $ticket->Type }}</td>
                                                    <td>{{ $ticket->Comment }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <button type="button" class="btn btn-warning mt-4" data-bs-toggle="modal"
                                        data-bs-target="#eliminarModalAbort" id="abortarBtnPc">Abortar</button>

                                    <!--MODAL ABORTAR-->
                                    <div class="modal fade" id="eliminarModalAbort" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="eliminarModalAbort"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">¿Seguro que
                                                        quieres abortar?</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Estas seguro que quieres abortar todos los tickets seleccionados?
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="submit" value="Abortar" class="btn btn-danger mt-4"
                                                        id="abortarBtnPc">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @else
                            <h3 class="alert alert-danger">No hay tickets para abortar</h3>
                        @endif
                    </div>
                    <div class="d-block d-md-none">
                        @if (!$abortTicket->isEmpty())
                            <div class="table-responsive mt-5">
                                <form action="{{ route('abortTicket', $local->id) }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Borrar</th>
                                                <th scope="col">Fecha</th>
                                                <th scope="col">Valor €</th>
                                                <th scope="col">Tipo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($abortTicket as $ticket)
                                                <tr>
                                                    <td><input type="checkbox" class="checkboxtlf" name="tickets[]"
                                                            value="{{ $ticket->TicketNumber }}"></td>
                                                    <td>{{ \Carbon\Carbon::parse($ticket->DateTime)->format('d-m-Y H:i') }}
                                                    </td>
                                                    <td>{{ $ticket->Value }}€</td>
                                                    <td>{{ $ticket->Type }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <input type="submit" value="Abortar" class="btn btn-warning mt-4"
                                        id="abortarBtnTlf">
                                </form>
                            </div>
                        @else
                            <h3 class="alert alert-danger">No hay tickets para abortar</h3>
                        @endif
                    </div>
                </div>
                <div class="tab-pane fade" id="confTick-tab-pane" role="tabpanel" aria-labelledby="confTick-tab"
                    tabindex="0">
                    <!--CONFIRMAR-->
                    <div class="d-none d-md-block">
                        @if (!$confirmTicket->isEmpty())
                            <div class="table-responsive mt-5">
                                <form action="{{ route('confirmTicket', $local->id) }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Confirmar</th>
                                                <th scope="col">Número de ticket</th>
                                                <th scope="col">Fecha</th>
                                                <th scope="col">Usuario</th>
                                                <th scope="col">Valor €</th>
                                                <th scope="col">Tipo</th>
                                                <th scope="col">Comentarios</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($confirmTicket as $ticket)
                                                <tr>
                                                    <td><input type="checkbox" class="checkboxConfpc" name="tickets[]"
                                                            value="{{ $ticket->TicketNumber }}"></td>
                                                    <td>{{ $ticket->TicketNumber }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($ticket->DateTime)->format('d-m-Y H:i') }}
                                                    </td>
                                                    <td>{{ $ticket->User }}</td>
                                                    <td>{{ $ticket->Value }}€</td>
                                                    <td>{{ $ticket->Type }}</td>
                                                    <td>{{ $ticket->Comment }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <button type="button" class="btn btn-warning mt-4" data-bs-toggle="modal"
                                        data-bs-target="#ConfirmarModal" id="confirmarBtnPc">Confirmar</button>

                                    <!--MODAL CONFIRMAR-->
                                    <div class="modal fade" id="ConfirmarModal" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="ConfirmarModal"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">¿Seguro que
                                                        quieres confirmar?</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Estas seguro que quieres confirmar todos los tickets seleccionados?
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="submit" value="Confirmar" class="btn btn-warning mt-4"
                                                        id="confirmarBtnPc">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @else
                            <h3 class="alert alert-danger">No hay tickets por confirmar</h3>
                        @endif
                    </div>
                    <div class="d-block d-md-none">
                        @if (!$confirmTicket->isEmpty())
                            <div class="table-responsive mt-5">
                                <form action="{{ route('confirmTicket', $local->id) }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Confirmar</th>
                                                <th scope="col">Fecha</th>
                                                <th scope="col">Valor €</th>
                                                <th scope="col">Tipo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($confirmTicket as $ticket)
                                                <tr>
                                                    <td><input type="checkbox" class="checkboxConftlf" name="tickets[]"
                                                            value="{{ $ticket->TicketNumber }}"></td>
                                                    <td>{{ \Carbon\Carbon::parse($ticket->DateTime)->format('d-m-Y H:i') }}
                                                    </td>
                                                    <td>{{ $ticket->Value }}€</td>
                                                    <td>{{ $ticket->Type }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <input type="submit" value="Confirmar" class="btn btn-warning mt-4"
                                        id="confirmarBtnTlf">
                                </form>
                            </div>
                        @else
                            <h3 class="alert alert-danger">No hay tickets por confirmar</h3>
                        @endif
                    </div>

                    <script>
                        let estatuspc = 0;
                        let checkspc = document.getElementsByClassName("checkboxpc");
                        const abortarbtnpc = document.getElementById("abortarBtnPc");

                        let estatustlf = 0;
                        let checkstlf = document.getElementsByClassName("checkboxtlf");
                        const abortarBtnTlf = document.getElementById("abortarBtnTlf");

                        function countSelectedCheckboxes() {
                            let selectedCount = 0;
                            for (let i = 0; i < checkspc.length; i++) {
                                if (checkspc[i].checked) {
                                    selectedCount++;
                                }
                            }
                            return selectedCount;
                        }

                        for (let i = 0; i < checkspc.length; i++) {
                            checkspc[i].addEventListener("change", function() {
                                estatuspc = countSelectedCheckboxes();

                                if (estatuspc <= 0) {
                                    abortarbtnpc.style.visibility = "hidden";
                                } else {
                                    abortarbtnpc.style.visibility = "visible";
                                }
                            });
                        }

                        if (countSelectedCheckboxes() <= 0) {
                            abortarbtnpc.style.visibility = "hidden";
                        }

                        function countSelectedCheckboxestlf() {
                            let selectedCount = 0;
                            for (let i = 0; i < checkstlf.length; i++) {
                                if (checkstlf[i].checked) {
                                    selectedCount++;
                                }
                            }
                            return selectedCount;
                        }

                        for (let i = 0; i < checkstlf.length; i++) {
                            checkstlf[i].addEventListener("change", function() {
                                estatustlf = countSelectedCheckboxestlf();
                                if (estatustlf <= 0) {
                                    abortarBtnTlf.style.visibility = "hidden";
                                } else {
                                    abortarBtnTlf.style.visibility = "visible";
                                }
                            });
                        }

                        if (countSelectedCheckboxestlf() <= 0) {
                            abortarBtnTlf.style.visibility = "hidden";
                        }

                        // Script for confirm button visibility
                        let estatusConfPc = 0;
                        let checksConfPc = document.getElementsByClassName("checkboxConfpc");
                        const confirmarBtnPc = document.getElementById("confirmarBtnPc");

                        let estatusConfTlf = 0;
                        let checksConfTlf = document.getElementsByClassName("checkboxConftlf");
                        const confirmarBtnTlf = document.getElementById("confirmarBtnTlf");

                        function countSelectedCheckboxesConfPc() {
                            let selectedCount = 0;
                            for (let i = 0; i < checksConfPc.length; i++) {
                                if (checksConfPc[i].checked) {
                                    selectedCount++;
                                }
                            }
                            return selectedCount;
                        }

                        for (let i = 0; i < checksConfPc.length; i++) {
                            checksConfPc[i].addEventListener("change", function() {
                                estatusConfPc = countSelectedCheckboxesConfPc();

                                if (estatusConfPc <= 0) {
                                    confirmarBtnPc.style.visibility = "hidden";
                                } else {
                                    confirmarBtnPc.style.visibility = "visible";
                                }
                            });
                        }

                        if (countSelectedCheckboxesConfPc() <= 0) {
                            confirmarBtnPc.style.visibility = "hidden";
                        }

                        function countSelectedCheckboxesConfTlf() {
                            let selectedCount = 0;
                            for (let i = 0; i < checksConfTlf.length; i++) {
                                if (checksConfTlf[i].checked) {
                                    selectedCount++;
                                }
                            }
                            return selectedCount;
                        }

                        for (let i = 0; i < checksConfTlf.length; i++) {
                            checksConfTlf[i].addEventListener("change", function() {
                                estatusConfTlf = countSelectedCheckboxesConfTlf();
                                if (estatusConfTlf <= 0) {
                                    confirmarBtnTlf.style.visibility = "hidden";
                                } else {
                                    confirmarBtnTlf.style.visibility = "visible";
                                }
                            });
                        }

                        if (countSelectedCheckboxesConfTlf() <= 0) {
                            confirmarBtnTlf.style.visibility = "hidden";
                        }
                    </script>
                </div>

                <div class="tab-pane fade" id="creatTick-tab-pane" role="tabpanel" aria-labelledby="creatTick-tab"
                    tabindex="0">
                    <div class="col-12">
                        <form action="{{ route('generarTicket', $local->id) }}" method="POST">
                            @csrf
                            @method('POST')

                            <div class="row">
                                <div class="col-12 col-md-3 offset-md-3 mb-3">
                                    <label for="">Valor del ticket (€)</label>
                                    <input type="hidden" name="Mode" value="webPost">
                                    <input type="number" name="Value" value="0.0" size="12"
                                        class="w-100 form-control">
                                </div>
                                <div class="col-12 col-md-3 mb-md-3">
                                    <label for="">Forzar número de ticket:</label>
                                    <input type="text" name="TicketNumber" value="" size="32"
                                        class="w-100 form-control">
                                </div>
                                <div class="col-12 col-md-3 offset-md-3 mb-3">
                                    <label>Tipo ticket: </label><br>
                                    <select name="TicketTypeSelect" id="ticketTypeSelect" class="w-100 form-select">
                                        <option value="" disabled selected>Selecciona un tipo</option>
                                        <option value="null">Otro...</option>
                                        @foreach ($allTypes as $type)
                                            <option value="{{ $type->name }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="TicketTypeText" value="" size="32"
                                        class="w-100 mt-3 form-control" placeholder="Nuevo tipo de ticket"> <br>
                                </div>
                                <div class="col-12 col-md-3 mb-3">
                                    <label>Tipo ticket recarga auxiliar:</label><br>
                                    <select name="TicketTypeIsAux" class="w-100 form-select">
                                        <option value="0">No</option>
                                        @foreach ($auxiliaresName as $auxiliar)
                                            <option value="{{ $auxiliar->TypeIsAux }}">{{ $auxiliar->AuxName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-md-6 offset-md-3 text-end mb-5 form-switch">
                                    <label>Tipo ticket apuesta:</label><br>
                                    <input type="checkbox" name="TicketTypeIsBets" class="form-check-input"
                                        role="switch"><br>

                                    <label>Cobrar al momento:</label><br>
                                    <input type="checkbox" name="expired" class="form-check-input" role="switch">
                                </div>
                            </div>

                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#CrearModal">Generar ticket</button>
                            <input type="reset" class="btn btn-danger" value="Limpiar">

                            <!--MODAL CREAR-->
                            <div class="modal fade" id="CrearModal" data-bs-backdrop="static" data-bs-keyboard="false"
                                tabindex="-1" aria-labelledby="CrearModal" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">¿Seguro que quieres
                                                generar el ticket?</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>¿Estas seguro que quieres generar el siguiente ticket?</p>
                                            <table class="table">
                                                <tr>
                                                    <td>Cantidad</td>
                                                    <td id="summaryValue"></td>
                                                </tr>
                                                <tr>
                                                    <td>Número de Ticket</td>
                                                    <td id="summaryTicketNumber"></td>
                                                </tr>
                                                <tr>
                                                    <td>Tipo Ticket</td>
                                                    <td id="summaryTicketType"></td>
                                                </tr>
                                                <tr>
                                                    <td>Ticket de Apuesta</td>
                                                    <td id="summaryTicketTypeIsBets"></td>
                                                </tr>
                                                <tr>
                                                    <td>Tipo Ticket Recarga Auxiliar</td>
                                                    <td id="summaryTicketTypeIsAux"></td>
                                                </tr>
                                                <tr>
                                                    <td>Cobrar al momento</td>
                                                    <td id="summaryExpired"></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="submit" value="Generar" class="btn btn-warning">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <script>
                            document.querySelector('[data-bs-target="#CrearModal"]').addEventListener('click', function() {
                                // Capturar los valores del formulario
                                const value = document.querySelector('input[name="Value"]').value;
                                let ticketNumber = document.querySelector('input[name="TicketNumber"]').value;
                                const ticketTypeSelect = document.querySelector('select[name="TicketTypeSelect"] option:checked')
                                    .textContent;
                                const ticketTypeText = document.querySelector('input[name="TicketTypeText"]').value;
                                const ticketType = ticketTypeSelect === "Otro..." ? ticketTypeText : ticketTypeSelect;
                                const ticketTypeIsBets = document.querySelector('input[name="TicketTypeIsBets"]').checked ? 'Sí' : 'No';
                                const ticketTypeIsAux = document.querySelector('select[name="TicketTypeIsAux"] option:checked')
                                    .textContent;
                                const expired = document.querySelector('input[name="expired"]').checked ? 'Sí' : 'No';

                                // Verificar si el número de ticket está vacío
                                if (ticketNumber.trim() === '') {
                                    ticketNumber = 'Aleatorio';
                                }

                                // Actualizar el contenido del modal
                                document.getElementById('summaryValue').textContent = value + " €";
                                document.getElementById('summaryTicketNumber').textContent = ticketNumber;
                                document.getElementById('summaryTicketType').textContent = ticketType;
                                document.getElementById('summaryTicketTypeIsBets').textContent = ticketTypeIsBets;
                                document.getElementById('summaryTicketTypeIsAux').textContent = ticketTypeIsAux;
                                document.getElementById('summaryExpired').textContent = expired;
                            });

                            document.addEventListener('DOMContentLoaded', function() {
                                const ticketTypeSelect = document.querySelector('select[name="TicketTypeSelect"]');
                                const ticketTypeText = document.querySelector('input[name="TicketTypeText"]');

                                const check = document.querySelector('input[name="TicketTypeIsBets"]');
                                const selectAux = document.querySelector('select[name="TicketTypeIsAux"]');

                                const reset = document.querySelector('input[type="reset"]');

                                ticketTypeSelect.addEventListener('change', function() {
                                    if (ticketTypeSelect.value === "null") {
                                        ticketTypeText.type = 'text';
                                    } else {
                                        ticketTypeText.type = 'hidden';
                                    }
                                });

                                check.addEventListener('change', function() {
                                    if (check.checked) {
                                        selectAux.value = 0;
                                        selectAux.disabled = true;
                                    } else {
                                        selectAux.disabled = false;
                                    }
                                });

                                reset.addEventListener('click', function() {
                                    selectAux.disabled = false;
                                });
                            });
                        </script>
                    </div>
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

                            // Remueve el elemento del DOM después de que la animación termine (2 segundos)
                            setTimeout(() => {
                                errorAlert.remove();
                            }, 7000);
                        }
                    });
                </script>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get all tab buttons
            const tabs = document.querySelectorAll('button[data-bs-toggle="tab"]');

            tabs.forEach(tab => {
                tab.addEventListener('shown.bs.tab', function(e) {
                    localStorage.setItem('activeTab', e.target.id);
                });
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const activeTab = localStorage.getItem('activeTab');
            if (activeTab) {
                const tab = document.getElementById(activeTab);
                const bsTab = new bootstrap.Tab(tab);
                bsTab.show();
            }
        });
    </script>
@endsection
