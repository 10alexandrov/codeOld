@extends('plantilla.plantilla')
@section('titulo', 'Local')
@section('contenido')

    <style>
        /* Estilo para redondear bordes */
        .border-radius {
            border: 1px solid #000; /* Define el color y el grosor del borde */
            border-radius: 50px; /* Ajusta el valor para el redondeo deseado */
            padding: 10px; /* Espaciado interno */
        }
    </style>

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
                    <button class="nav-link btn-danger" id="localAux-tab" data-bs-toggle="tab"
                        data-bs-target="#localAux-tab-pane" type="button" role="tab" aria-controls="localAux-tab-pane"
                        aria-selected="false">{{ $local->name }} auxiliares</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link btn-danger" id="arqMaq-tab" data-bs-toggle="tab"
                        data-bs-target="#arqMaq-tab-pane" type="button" role="tab" aria-controls="arqMaq-tab-pane"
                        aria-selected="false">Arqueo máquina</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link btn-danger" id="recTri-tab" data-bs-toggle="tab"
                        data-bs-target="#recTri-tab-pane" type="button" role="tab" aria-controls="recTri-tab-pane"
                        aria-selected="false">Recaudar trío</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link btn-danger" id="newTab-tab" data-bs-toggle="tab"
                        data-bs-target="#newTab-tab-pane" type="button" role="tab" aria-controls="newTab-tab-pane"
                        aria-selected="false">Arqueo por contadores</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link btn-danger" id="summaryTab-tab" data-bs-toggle="tab"
                        data-bs-target="#summaryTab-tab-pane" type="button" role="tab" aria-controls="summaryTab-pane"
                        aria-selected="false">Resumen de Auxiliares</button>
                </li>
            </ul>
        </div>

        <div class="mt-2">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade" id="recTri-tab-pane" role="tabpanel" aria-labelledby="recTri-tab" tabindex="0">
                    <div class="d-flex flex-column align-items-center">
                        <div class="wrapper">
                            <div id="maquinaA">
                                <h4>Máquina A</h2>
                                    <div class="izquierda" id="recaudacion1">Recaudación <br>Gestimaq: </div>
                                    <div class="derecha" id="valorRecaudacion1" contenteditable="true">0</div>
                                    <div class="izquierda" id="cargas1">Cargas<br>circulantes:</div>
                                    <div class="derecha" id="valorCargas1" contenteditable="true">0</div>
                                    <div class="izquierda" id="fectivo1">Efectivo: </div>
                                    <div class="derecha" id="valorEfectivo1" contenteditable="true">0</div>
                                    <div class="izquierda" id="averias1">P. Avería: </div>
                                    <div class="derecha" id="valorAverias1" contenteditable="true">0</div>
                            </div>
                            <div id="maquinaB">
                                <h4>Máquina B</h4>
                                <div class="izquierda" id="recaudacion2">Recaudación <br>Gestimaq: </div>
                                <div class="derecha" id="valorRecaudacion2" contenteditable="true">0</div>
                                <div class="izquierda" id="cargas2">Cargas<br>circulantes:</div>
                                <div class="derecha" id="valorCargas2" contenteditable="true">0</div>
                                <div class="izquierda" id="efectivo2">Efectivo: </div>
                                <div class="derecha" id="valorEfectivo2" contenteditable="true">0</div>
                                <div class="izquierda" id="averias2">P. Avería: </div>
                                <div class="derecha" id="valorAverias2" contenteditable="true">0</div>
                            </div>
                            <div id="maquinaC">
                                <h4>Máquina C</h4>
                                <div class="izquierda" id="recaudacion3">Recaudación <br>Gestimaq: </div>
                                <div class="derecha" id="valorRecaudacion3" contenteditable="true">0</div>
                                <div class="izquierda" id="cargas3">Cargas<br>circulantes:</div>
                                <div class="derecha" id="valorCargas3" contenteditable="true">0</div>
                                <div class="izquierda" id="efectivo3">Efectivo: </div>
                                <div class="derecha" id="valorEfectivo3" contenteditable="true">0</div>
                                <div class="izquierda" id="averias3">P. Avería: </div>
                                <div class="derecha" id="valorAverias3" contenteditable="true">0</div>
                            </div>

                            <div id="escribe">
                                Recarga auxiliar máquina A: <div id="resultado1"></div>
                                Recarga auxiliar máquina B: <div id="resultado2"></div>
                                Recarga auxiliar máquina C: <div id="resultado3"></div>
                                <div id="resGlobal"></div>
                            </div>
                        </div>
                        <div id="global">
                            <div class="izquierda" id="hopper">Hopper de una máquina:</div>
                            <div class="derecha" id="valorHopper" contenteditable="true">0</div>
                            <div class="izquierda" id="recarga">Balance R. Auxiliar:</div>
                            <div class="derecha" id="valorRecarga" contenteditable="true">0</div>
                            <div class="text-center">
                                <input type="button" value="Calcular" onclick="auxiliar()"
                                    class="btn btn-warning w-50 btn-sm">
                            </div>
                            <div class="text-center">
                                <input type="button" value="Limpiar" onclick="limpiar()"
                                    class="btn btn-danger w-50 btn-sm">
                            </div>
                        </div>
                        <footer id="footercalc">
                            <p>&copy 2024 Ramón Trujillo Visuete</p>
                            <p>Versión 1.1</p>
                        </footer>


                        <!--script ramon-->
                        <script>
                            let reca1 = document.querySelector("#valorRecaudacion1");
                            let cargas1 = document.querySelector("#valorCargas1");
                            let efec1 = document.querySelector("#valorEfectivo1");
                            let ave1 = document.querySelector("#valorAverias1");

                            //Máquina B
                            let reca2 = document.querySelector("#valorRecaudacion2");
                            let cargas2 = document.querySelector("#valorCargas2");
                            let efec2 = document.querySelector("#valorEfectivo2");
                            let ave2 = document.querySelector("#valorAverias2");

                            //Máquina C
                            let reca3 = document.querySelector("#valorRecaudacion3");
                            let cargas3 = document.querySelector("#valorCargas3");
                            let efec3 = document.querySelector("#valorEfectivo3");
                            let ave3 = document.querySelector("#valorAverias3");

                            //Variables comunes
                            let hopper = document.querySelector("#valorHopper");
                            let rec = document.querySelector("#valorRecarga");

                            //Aquí se capturan los datos

                            //Máquina A
                            reca1.addEventListener("keydown", function() {});
                            cargas1.addEventListener("keydown", function() {});
                            efec1.addEventListener("keydown", function() {});
                            ave1.addEventListener("keydown", function() {});
                            //Máquina B
                            reca2.addEventListener("keydown", function() {});
                            cargas2.addEventListener("keydown", function() {});
                            efec2.addEventListener("keydown", function() {});
                            ave2.addEventListener("keydown", function() {});
                            //Máquina C
                            reca3.addEventListener("keydown", function() {});
                            cargas3.addEventListener("keydown", function() {});
                            efec3.addEventListener("keydown", function() {});
                            ave3.addEventListener("keydown", function() {});
                            //Datos comunes
                            hopper.addEventListener("keydown", function() {});
                            rec.addEventListener("keydown", function() {});

                            //Esta es la función que realiza los cálculos

                            function auxiliar() {

                                let recAuxiliar1 = (parseFloat(reca1.textContent) + parseFloat(cargas1.textContent) + parseFloat(hopper
                                    .textContent) - parseFloat(efec1.textContent) - parseFloat(ave1.textContent)).toFixed(1);
                                let res1 = document.querySelector("#resultado1");
                                let recAuxiliar2 = (parseFloat(reca2.textContent) + parseFloat(cargas2.textContent) + parseFloat(hopper
                                    .textContent) - parseFloat(efec2.textContent) - parseFloat(ave2.textContent)).toFixed(1);
                                let res2 = document.querySelector("#resultado2");
                                let recAuxiliar3 = (parseFloat(reca3.textContent) + parseFloat(cargas3.textContent) + parseFloat(hopper
                                    .textContent) - parseFloat(efec3.textContent) - parseFloat(ave3.textContent)).toFixed(1);
                                let res3 = document.querySelector("#resultado3");
                                let resultado = parseFloat(valorRecarga.textContent - recAuxiliar1 - recAuxiliar2 - recAuxiliar3).toFixed(1);
                                let resGlobal = document.querySelector("#resGlobal");

                                res1.textContent = recAuxiliar1 + " €";
                                res2.textContent = recAuxiliar2 + " €";
                                res3.textContent = recAuxiliar3 + " €";
                                if (resultado == 0) {
                                    resGlobal.textContent = `La recarga auxiliar es correcta`;
                                    resGlobal.style.backgroundColor = "rgb(161, 148, 132)";
                                    resGlobal.style.fontWeight = 800;
                                } else if (resultado >= 0) {
                                    resGlobal.textContent = `Sobran: ${resultado} € en la recarga auxiliar`;
                                    resGlobal.style.backgroundColor = "green";
                                    resGlobal.style.fontWeight = 800;
                                } else if (resultado <= 0) {
                                    resGlobal.textContent = `Faltan: ${Math.abs(resultado)} € en la recarga auxiliar`;
                                    resGlobal.style.backgroundColor = "red";
                                    resGlobal.style.fontWeight = 800;
                                }
                            };

                            function limpiar() {
                                //let total = document.querySelector("#escribe");
                                //total.textContent="v";
                                let entradas = document.querySelectorAll(".derecha");
                                for (i = 0; i <= (entradas.length) - 1; i++) {
                                    entradas[i].textContent = 0;
                                };
                                auxiliar();
                            }
                        </script>
                    </div>
                </div>

                <!-- ------------------------------------------------------------------------------------------------- -->

                <div class="tab-pane fade" id="localAux-tab-pane" role="tabpanel" aria-labelledby="localAux-tab"
                    tabindex="0">
                    <form id="recargas-form" action="{{ route('arqueos.store') }}" method="POST">
                        <div class="overflow-auto">
                            @csrf
                            <input type="hidden" name="local_id" value="{{ $local->id }}">
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            <table id="contabilidad-table" class="table overflow-auto">
                                <thead>
                                    <tr>
                                        <th scope="col">Máquina</th>
                                        <th scope="col">1€</th>
                                        <th scope="col">10€</th>
                                        <th scope="col">20€</th>
                                        <th scope="col">50€</th>
                                        <th scope="col" class="border border-dark">Carga</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="machine-row">
                                        <td class="p-2">
                                            <select name="maquina[]" id="maquina-0">
                                                @foreach ($machines as $machine)
                                                    <option value="{{ $machine->id }}">{{ $machine->alias }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="p-2"><input type="number" min="" name="coin1[]"
                                                class="small-input coin-input" value="0"></td>
                                        <td class="p-2"><input type="number" min="0" name="coin10[]"
                                                class="small-input coin-input" value="0"></td>
                                        <td class="p-2"><input type="number" min="0" name="coin20[]"
                                                class="small-input coin-input" value="0"></td>
                                        <td class="p-2"><input type="number" min="0" name="coin50[]"
                                                class="small-input coin-input" value="0"></td>
                                        <td class="p-2 border border-dark">
                                            <div class="carga-container">
                                                <span class="carga-text">1€</span>
                                                <input type="number" min="0" name="carga1[]"
                                                    class="small-input carga-input" value="0">
                                                <span class="carga-text">10€</span>
                                                <input type="number" min="0" name="carga10[]"
                                                    class="small-input carga-input" value="0">
                                                <span class="carga-text">20€</span>
                                                <input type="number" min="0" name="carga20[]"
                                                    class="small-input carga-input" value="0">
                                                <span class="carga-text">50€</span>
                                                <input type="number" min="0" name="carga50[]"
                                                    class="small-input carga-input" value="0">
                                            </div>
                                        </td>
                                        <td class="p-2"><input type="text" name="total" value="0€" disabled
                                                class="small-input total-input"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex flex-column d-md-block pb-5">
                            <button type="button" id="remove-machine-btn" class="btn btn-danger mt-3">Eliminar
                                línea</button>
                            <button type="button" id="add-machine-btn" class="btn btn-warning mt-3">Añadir
                                línea</button>
                            <button type="button" class="btn btn-dark mt-3" data-bs-toggle="modal"
                                data-bs-target="#secureModalInsert">Guardar recargas</button>
                        </div>
                    </form>

                    <!-- Modal insert -->
                    <div class="modal fade" id="secureModalInsert" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="secureModalInsert" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- Formulario para enviar los datos al controlador -->
                                <form id="recarga-form" action="{{ route('arqueos.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="local_id" value="{{ $local->id }}">
                                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Resumen de datos a insertar
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>¿Estas seguro que quieres insertar estos datos?</p>
                                        <div class="overflow-auto">
                                            <table id="summary-table" class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Máquina</th>
                                                        <th scope="col">1€</th>
                                                        <th scope="col">10€</th>
                                                        <th scope="col">20€</th>
                                                        <th scope="col">50€</th>
                                                        <th scope="col">Carga 1€</th>
                                                        <th scope="col">Carga 10€</th>
                                                        <th scope="col">Carga 20€</th>
                                                        <th scope="col">Carga 50€</th>
                                                        <th scope="col">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                        <!-- Campos ocultos para enviar los datos de la tabla -->
                                        <input type="hidden" name="maquinas" id="hidden-maquinas">
                                        <input type="hidden" name="coin1" id="hidden-coin1">
                                        <input type="hidden" name="coin10" id="hidden-coin10">
                                        <input type="hidden" name="coin20" id="hidden-coin20">
                                        <input type="hidden" name="coin50" id="hidden-coin50">
                                        <input type="hidden" name="carga1" id="hidden-carga1">
                                        <input type="hidden" name="carga10" id="hidden-carga10">
                                        <input type="hidden" name="carga20" id="hidden-carga20">
                                        <input type="hidden" name="carga50" id="hidden-carga50">
                                        <input type="hidden" name="total" id="hidden-total" class='total-input'>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-dark mt-3" id="submitBtnRecarga">Guardar
                                            recargas</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <!--editar-->
                <div class="mt-5">
                    @if (!$auxData->isEmpty())
                        <h1 style="font-size: 20pt">Recargas últimos 10 días</h1>
                        <div class="overflow-auto">
                            <table id="contabilidad-table" class="table overflow-auto w-250">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Usuario</th>
                                        <th scope="col">Máquina</th>
                                        <th scope="col">1€</th>
                                        <th scope="col">10€</th>
                                        <th scope="col">20€</th>
                                        <th scope="col">50€</th>
                                        <th scope="col" class="border-top border-start border-dark">Carga 1€</th>
                                        <th scope="col" class="border-top border-dark ">Carga 10€</th>
                                        <th scope="col" class="border-top border-dark">Carga 20€</th>
                                        <th scope="col" class="border-top border-end border-dark">Carga 50€</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($auxData as $data)
                                        <tr id="row-{{ $data->id }}">
                                            <td class='p-3'>
                                                @if ($data->created_at != $data->updated_at)
                                                    <i class="bi bi-check-lg"></i>
                                                @endif
                                            </td>
                                            <td class='p-3'>
                                                <span
                                                    class="d-md-none">{{ \Carbon\Carbon::parse($data->created_at)->format('d-m H:i') }}</span>
                                                <span
                                                    class="d-none d-md-inline">{{ \Carbon\Carbon::parse($data->created_at)->format('d-m-Y H:i') }}</span>
                                            </td>
                                            <td class='p-3'>{{ $data->user->name }}</td>
                                            <td class='p-3'>
                                                <span class="machine-name">{{ $data->machine->alias }}</span>
                                                <select class="d-none machine-select form-control" name="machine_id">
                                                    @foreach ($machines as $machine)
                                                        <option value="{{ $machine->id }}"
                                                            {{ $machine->id == $data->machine_id ? 'selected' : '' }}>
                                                            {{ $machine->alias }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class='p-2'><input type="number" min=''
                                                    class="value1-input small-input coin-input"
                                                    value="{{ $data->value1 }}" disabled></td>
                                            <td class='p-2'><input type="number" min='0'
                                                    class="value10-input small-input coin-input"
                                                    value="{{ $data->value10 }}" disabled></td>
                                            <td class='p-2'><input type="number" min='0'
                                                    class="value20-input small-input coin-input"
                                                    value="{{ $data->value20 }}" disabled></td>
                                            <td class='p-2'><input type="number" min='0'
                                                    class="value50-input small-input coin-input"
                                                    value="{{ $data->value50 }}" disabled></td>
                                            <td class='p-2 border-start border-dark'><input type="number" min='0'
                                                    class="carga1-input small-input coin-input "
                                                    value="{{ $data->carga1 }}" disabled></td>
                                            <td class='p-2 border-dark'><input type="number" min='0'
                                                    class="carga10-input small-input coin-input "
                                                    value="{{ $data->carga10 }}" disabled></td>
                                            <td class='p-2 border-dark'><input type="number" min='0'
                                                    class="carga20-input small-input coin-input "
                                                    value="{{ $data->carga20 }}" disabled></td>
                                            <td class='p-2 border-end border-dark'><input type="number" min='0'
                                                    class="carga50-input small-input coin-input "
                                                    value="{{ $data->carga50 }}" disabled></td>
                                            <td class='p-2 total-cell'>{{ $data->total }}€</td>
                                            <td class='p-2'>
                                                @if (auth()->user()->hasRole('Tecnico') && auth()->id() == $data->user_id)
                                                    <!-- Botón de Editar -->
                                                    <button class="btn btn-warning btn-sm edit-btn">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                    <!-- Botón de Cancelar -->
                                                    <button class="btn btn-secondary btn-sm cancel-btn d-none">
                                                        <i class="bi bi-x-circle"></i>
                                                    </button>
                                                    <!-- Formulario para guardar -->
                                                    <form action="{{ route('arqueos.update', $data->id) }}"
                                                        method="POST" class="d-inline save-form d-none">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="id"
                                                            value="{{ $data->id }}">
                                                        <input type="hidden" name="machine_id" id="hidden-machine-id"
                                                            value="{{ $data->machine_id }}">
                                                        <input type="hidden" name="user_id"
                                                            value="{{ auth()->id() }}">
                                                        <input type="hidden" name="coin1" id="hidden-coin1">
                                                        <input type="hidden" name="coin10" id="hidden-coin10">
                                                        <input type="hidden" name="coin20" id="hidden-coin20">
                                                        <input type="hidden" name="coin50" id="hidden-coin50">
                                                        <input type="hidden" name="carga1" id="hidden-carga1">
                                                        <input type="hidden" name="carga10" id="hidden-carga10">
                                                        <input type="hidden" name="carga20" id="hidden-carga20">
                                                        <input type="hidden" name="carga50" id="hidden-carga50">
                                                        <input type="hidden" name="total" id="hidden-total"
                                                            class='total-input'>
                                                        <button type="submit" class="btn btn-primary btn-sm">
                                                            <i class="bi bi-check-lg"></i>
                                                        </button>
                                                    </form>
                                                @elseif(auth()->user()->hasRole('Jefe Delegación') || auth()->user()->hasRole('Super Admin'))
                                                    <!-- Botón de Editar -->
                                                    <button class="btn btn-warning btn-sm edit-btn">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                    <!-- Botón de Cancelar -->
                                                    <button class="btn btn-secondary btn-sm cancel-btn d-none">
                                                        <i class="bi bi-x-circle"></i>
                                                    </button>
                                                    <!-- Formulario para guardar -->
                                                    <form action="{{ route('arqueos.update', $data->id) }}"
                                                        method="POST" class="d-inline save-form d-none">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="id"
                                                            value="{{ $data->id }}">
                                                        <input type="hidden" name="machine_id" id="hidden-machine-id"
                                                            value="{{ $data->machine_id }}">
                                                        <input type="hidden" name="user_id"
                                                            value="{{ auth()->id() }}">
                                                        <input type="hidden" name="coin1" id="hidden-coin1">
                                                        <input type="hidden" name="coin10" id="hidden-coin10">
                                                        <input type="hidden" name="coin20" id="hidden-coin20">
                                                        <input type="hidden" name="coin50" id="hidden-coin50">
                                                        <input type="hidden" name="carga1" id="hidden-carga1">
                                                        <input type="hidden" name="carga10" id="hidden-carga10">
                                                        <input type="hidden" name="carga20" id="hidden-carga20">
                                                        <input type="hidden" name="carga50" id="hidden-carga50">
                                                        <input type="hidden" name="total" id="hidden-total"
                                                            class='total-input'>
                                                        <button type="submit" class="btn btn-primary btn-sm">
                                                            <i class="bi bi-check-lg"></i>
                                                        </button>
                                                    </form>
                                                    <!-- Botón de Eliminar -->
                                                    <button class="btn btn-danger btn-sm trash-btn" data-bs-toggle="modal"
                                                        data-bs-target="#eliminarRecargaModal{{ $data->id }}">
                                                        <i class="bi bi-trash3"></i>
                                                    </button>
                                                @endif
                                            </td>
                                            <!-- Modal de confirmación de eliminación de recarga auxiliar -->
                                            <div class="modal fade" id="eliminarRecargaModal{{ $data->id }}"
                                                data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                aria-labelledby="eliminarRecargaModalLabel{{ $data->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5"
                                                                id="eliminarRecargaModalLabel{{ $data->id }}">
                                                                ¡Eliminar Recarga Auxiliar!</h1>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>¿Estás seguro que deseas eliminar esta recarga auxiliar?</p>
                                                            <ul style="text-align: left;">
                                                                <!-- Asegúrate de que este estilo esté presente -->
                                                                @if ($data->user->name)
                                                                    <li><strong>Creado por:</strong>
                                                                        {{ $data->user->name }}</li> <!-- Cambiado aquí -->
                                                                @endif
                                                                @if ($data->machine->alias)
                                                                    <li><strong>Máquina:</strong>
                                                                        {{ $data->machine->alias }}</li>
                                                                @endif
                                                                @if ($data->value1)
                                                                    <li><strong>Recarga 1€:</strong> {{ $data->value1 }}
                                                                    </li>
                                                                @endif
                                                                @if ($data->value10)
                                                                    <li><strong>Recarga de 10€:</strong>
                                                                        {{ $data->value10 }}</li>
                                                                @endif
                                                                @if ($data->value20)
                                                                    <li><strong>Recarga de 20€:</strong>
                                                                        {{ $data->value20 }}</li>
                                                                @endif
                                                                @if ($data->value50)
                                                                    <li><strong>Recarga de 50€:</strong>
                                                                        {{ $data->value50 }}</li>
                                                                @endif
                                                                @if ($data->carga1)
                                                                    <li><strong>Carga 1€:</strong> {{ $data->carga1 }}</li>
                                                                @endif
                                                                @if ($data->carga10)
                                                                    <li><strong>Carga 10€:</strong> {{ $data->carga10 }}
                                                                    </li>
                                                                @endif
                                                                @if ($data->carga20)
                                                                    <li><strong>Carga 20€:</strong> {{ $data->carga20 }}
                                                                    </li>
                                                                @endif
                                                                @if ($data->carga50)
                                                                    <li><strong>Carga 50€:</strong> {{ $data->carga50 }}
                                                                    </li>
                                                                @endif
                                                                @if ($data->total)
                                                                    <li><strong>Total:</strong> {{ $data->total }} €
                                                                    </li>
                                                                @endif
                                                                @if ($data->created_at)
                                                                    <li><strong>Fecha de creación:</strong>
                                                                        {{ \Carbon\Carbon::parse($data->created_at)->format('d-m-Y H:i') }}
                                                                    </li>
                                                                @endif
                                                                @if ($data->updated_at)
                                                                    <li><strong>Última actualización:</strong>
                                                                        {{ \Carbon\Carbon::parse($data->updated_at)->format('d-m-Y H:i') }}
                                                                    </li>
                                                                @endif
                                                            </ul>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <form action="{{ route('arqueos.destroy', $data->id) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-danger">Eliminar</button>
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancelar</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {

                        // Parte con la que trabaja el STORE de las cargas auxiliares

                        // Asociar eventos de clic a los botones
                        document.getElementById('add-machine-btn').addEventListener('click', addMachineRow);
                        document.getElementById('remove-machine-btn').addEventListener('click', deleteRecarga);

                        // Asociar eventos de input a los campos de la tabla
                        const tableBody = document.querySelector('#contabilidad-table tbody');
                        tableBody.addEventListener('input', function(event) {
                            if (event.target.matches(
                                    'input[name="coin1[]"], input[name="coin10[]"], input[name="coin20[]"], input[name="coin50[]"], input[name="carga1[]"], input[name="carga10[]"], input[name="carga20[]"], input[name="carga50[]"]'
                                )) {
                                actualizarTotal();
                            }
                        });

                        // Función para clonar la fila de máquina y agregarla a la tabla
                        function addMachineRow() {
                            var table = document.getElementById('contabilidad-table').getElementsByTagName('tbody')[0];
                            var lastRow = table.rows[table.rows.length - 1];
                            var newRow = lastRow.cloneNode(true);

                            // Obtener el número actual de máquinas
                            var currentMachineNumber = table.rows.length;

                            // Limpiar los valores de los inputs clonados y establecer nuevos IDs y nombres
                            var inputs = newRow.getElementsByTagName('input');
                            for (var i = 0; i < inputs.length; i++) {
                                inputs[i].value = ''; // Limpiar el valor
                                inputs[i].disabled = false; // Habilitar el input
                                if (inputs[i].type !== 'date' && inputs[i].type !== 'text') {
                                    inputs[i].value = '0';
                                }
                                var name = inputs[i].name;
                                if (name) {
                                    inputs[i].name = name.replace(/\[\d+\]/, '[' + currentMachineNumber + ']');
                                    if (inputs[i].id) {
                                        inputs[i].id = inputs[i].id.replace(/-\d+$/, '-' + currentMachineNumber);
                                    }
                                }
                            }

                            // Habilitar todos los selects del formulario
                            var selects = newRow.getElementsByTagName('select');
                            for (var i = 0; i < selects.length; i++) {
                                selects[i].disabled = false;
                            }

                            // Deshabilitar y establecer valor por defecto en el campo de total para la nueva fila
                            var newTotalInput = newRow.querySelector('.total-input');
                            newTotalInput.disabled = true; // Total debe ser de solo lectura
                            newTotalInput.value = '0€';

                            // Añadir la nueva fila a la tabla
                            table.appendChild(newRow);

                            // Actualizar ID del select para evitar duplicados
                            var newSelect = newRow.querySelector('select');
                            newSelect.id = 'maquina-' + currentMachineNumber;

                            comprobarchilds();
                            actualizarTotal(); // Llamar para actualizar los totales después de agregar la fila
                        }

                        // Función para eliminar la última fila de la tabla
                        function deleteRecarga() {
                            var table = document.getElementById('contabilidad-table').getElementsByTagName('tbody')[0];
                            // Solo eliminar si hay más de una fila
                            if (table.rows.length > 1) {
                                table.deleteRow(-1); // Eliminar la última fila
                                comprobarchilds();
                                actualizarTotal(); // Llamar para actualizar los totales después de eliminar la fila
                            } else {
                                alert("Debe haber al menos una fila en la tabla.");
                            }
                        }

                        function comprobarchilds() {
                            var table = document.getElementById('contabilidad-table').getElementsByTagName('tbody')[0];
                            const deleteBtn = document.getElementById('remove-machine-btn');

                            if (table.rows.length > 1) {
                                deleteBtn.disabled = false;
                            } else {
                                deleteBtn.disabled = true;
                            }
                        }
                        /*

                        En este momento es cuando envia los datos de editar duplicados


                        */
                        // Evento que se dispara cuando se abre el modal
                        document.querySelector('#secureModalInsert').addEventListener('show.bs.modal', function() {
                            console.log('Modal abierto');
                            const summaryTableBody = document.querySelector('#summary-table tbody');
                            clearInsertModal();
                            // Llama a la función para actualizar la tabla de resumen y los campos ocultos
                            updateSummaryTable();
                        });

                        // Función para limpiar el modal de inserción
                        function clearInsertModal() {
                            console.log('Limpiando el modal de inserción');

                            const summaryTableBody = document.querySelector('#summary-table tbody');
                            summaryTableBody.innerHTML = ''; // Limpiar la tabla de resumen

                            // Limpiar campos ocultos
                            document.getElementById('hidden-maquinas').value = '';
                            document.getElementById('hidden-coin1').value = '';
                            document.getElementById('hidden-coin10').value = '';
                            document.getElementById('hidden-coin20').value = '';
                            document.getElementById('hidden-coin50').value = '';
                            document.getElementById('hidden-carga1').value = '';
                            document.getElementById('hidden-carga10').value = '';
                            document.getElementById('hidden-carga20').value = '';
                            document.getElementById('hidden-carga50').value = '';
                            document.getElementById('hidden-total').value = '';

                            // Limpiar inputs del modal (si hay inputs que necesitan ser limpiados)
                            const modalInputs = document.querySelectorAll(
                                '#secureModalInsert input, #secureModalInsert select');
                            modalInputs.forEach(input => {
                                if (input && input.type !==
                                    'hidden') { // Asegúrate de que no limpies los campos ocultos
                                    input.value = ''; // Limpiar el valor
                                    input.removeAttribute('disabled'); // Asegúrate de habilitar los inputs
                                }
                            });
                        }

                        function clearHiddenFields() {
                            document.getElementById('hidden-maquinas').value = '';
                            document.getElementById('hidden-coin1').value = '';
                            document.getElementById('hidden-coin10').value = '';
                            document.getElementById('hidden-coin20').value = '';
                            document.getElementById('hidden-coin50').value = '';
                            document.getElementById('hidden-carga1').value = '';
                            document.getElementById('hidden-carga10').value = '';
                            document.getElementById('hidden-carga20').value = '';
                            document.getElementById('hidden-carga50').value = '';
                            document.getElementById('hidden-total').value = '';
                        }


                        /*





                        */




                        // Función para actualizar la tabla de resumen con los datos del formulario principal
                        function updateSummaryTable() {
                            console.log('Actualizando la tabla de resumen');
                            const summaryTableBody = document.querySelector('#summary-table tbody');
                            const rows = document.querySelectorAll('#contabilidad-table tbody tr');

                            // Limpiar el contenido previo de la tabla de resumen
                            summaryTableBody.innerHTML = '';

                            // Arrays para almacenar los valores de los inputs
                            let maquinas = [];
                            let coin1Arr = [];
                            let coin10Arr = [];
                            let coin20Arr = [];
                            let coin50Arr = [];
                            let carga1Arr = [];
                            let carga10Arr = [];
                            let carga20Arr = [];
                            let carga50Arr = [];
                            let totalArr = [];

                            rows.forEach(row => {
                                // Asegúrate de que la fila no esté en modo de edición
                                if (row !== currentEditingRow) {
                                    // Obtener el valor de la máquina desde el select
                                    const selectElement = row.querySelector('select[name="maquina[]"]');
                                    const machineValue = selectElement ? selectElement.options[selectElement
                                        .selectedIndex]?.value : '';
                                    const machineName = selectElement ? selectElement.options[selectElement
                                        .selectedIndex]?.text : '';

                                    // Obtener los valores de cada input, asegurándonos de que no sean nulos
                                    const coin1 = row.querySelector('input[name="coin1[]"]')?.value || '0';
                                    const coin10 = row.querySelector('input[name="coin10[]"]')?.value || '0';
                                    const coin20 = row.querySelector('input[name="coin20[]"]')?.value || '0';
                                    const coin50 = row.querySelector('input[name="coin50[]"]')?.value || '0';
                                    const carga1 = row.querySelector('input[name="carga1[]"]')?.value || '0';
                                    const carga10 = row.querySelector('input[name="carga10[]"]')?.value || '0';
                                    const carga20 = row.querySelector('input[name="carga20[]"]')?.value || '0';
                                    const carga50 = row.querySelector('input[name="carga50[]"]')?.value || '0';
                                    const total = row.querySelector('.total-input')?.value.replace('€', '') || '0';

                                    console.log(
                                        `Fila - Máquina total updateSummary: ${machineValue}, 1€: ${coin1}, 10€: ${coin10}, 20€: ${coin20}, 50€: ${coin50}, Carga 1€: ${carga1}, Carga 10€: ${carga10}, Carga 20€: ${carga20}, Carga 50€: ${carga50}, Total: ${total}`
                                    );

                                    // Validar que solo se agregue una fila si hay datos presentes
                                    if (machineValue.trim() || coin1 !== '0' || coin10 !== '0' || coin20 !== '0' ||
                                        coin50 !== '0' || carga1 !== '0' || carga10 !== '0' || carga20 !== '0' ||
                                        carga50 !== '0') {
                                        // Añadir los valores a los arrays
                                        maquinas.push(machineValue);
                                        coin1Arr.push(coin1);
                                        coin10Arr.push(coin10);
                                        coin20Arr.push(coin20);
                                        coin50Arr.push(coin50);
                                        carga1Arr.push(carga1);
                                        carga10Arr.push(carga10);
                                        carga20Arr.push(carga20);
                                        carga50Arr.push(carga50);
                                        totalArr.push(total);

                                        // Crear una nueva fila para la tabla de resumen
                                        const newRow = `
                    <tr>
                        <td>${machineName}</td>
                        <td>${coin1}</td>
                        <td>${coin10}</td>
                        <td>${coin20}</td>
                        <td>${coin50}</td>
                        <td>${carga1}</td>
                        <td>${carga10}</td>
                        <td>${carga20}</td>
                        <td>${carga50}</td>
                        <td>${total}</td>
                    </tr>
                `;
                                        summaryTableBody.insertAdjacentHTML('beforeend', newRow);
                                    }
                                }
                            });

                            // Pasar los valores a los campos ocultos del modal
                            document.getElementById('hidden-maquinas').value = JSON.stringify(maquinas);
                            document.getElementById('hidden-coin1').value = JSON.stringify(coin1Arr);
                            document.getElementById('hidden-coin10').value = JSON.stringify(coin10Arr);
                            document.getElementById('hidden-coin20').value = JSON.stringify(coin20Arr);
                            document.getElementById('hidden-coin50').value = JSON.stringify(coin50Arr);
                            document.getElementById('hidden-carga1').value = JSON.stringify(carga1Arr);
                            document.getElementById('hidden-carga10').value = JSON.stringify(carga10Arr);
                            document.getElementById('hidden-carga20').value = JSON.stringify(carga20Arr);
                            document.getElementById('hidden-carga50').value = JSON.stringify(carga50Arr);
                            document.getElementById('hidden-total').value = JSON.stringify(totalArr);

                            console.log("Campos ocultos actualizados:", {
                                maquinas,
                                coin1Arr,
                                coin10Arr,
                                coin20Arr,
                                coin50Arr,
                                carga1Arr,
                                carga10Arr,
                                carga20Arr,
                                carga50Arr,
                                totalArr
                            });
                        }



                        // Evento para validar y enviar el formulario desde el modal
                        document.getElementById('submitBtnRecarga').addEventListener('click', function(event) {
                            console.log('Botón de guardar clickeado');
                            updateSummaryTable(); // Asegúrate de que la tabla se actualice antes de enviar
                            // Envía el formulario
                            document.querySelector('#recarga-form').submit();
                        });

                        // Función para actualizar el total de cada fila
                        function actualizarTotal() {
                            var rows = document.querySelectorAll('#contabilidad-table tbody tr');
                            rows.forEach(function(row, index) {
                                var coin1 = parseInt(row.querySelector('input[name="coin1[]"]').value) || 0;
                                var coin10 = parseInt(row.querySelector('input[name="coin10[]"]').value) || 0;
                                var coin20 = parseInt(row.querySelector('input[name="coin20[]"]').value) || 0;
                                var coin50 = parseInt(row.querySelector('input[name="coin50[]"]').value) || 0;
                                var carga1 = parseInt(row.querySelector('input[name="carga1[]"]').value) || 0;
                                var carga10 = parseInt(row.querySelector('input[name="carga10[]"]').value) || 0;
                                var carga20 = parseInt(row.querySelector('input[name="carga20[]"]').value) || 0;
                                var carga50 = parseInt(row.querySelector('input[name="carga50[]"]').value) || 0;


                                var total = coin1 * 1 + coin10 * 10 + coin20 * 20 + coin50 * 50 + carga1 * 1 + carga10 *
                                    10 + carga20 *
                                    20 + carga50 * 50;

                                var totalInput = row.querySelector('.total-input');
                                if (totalInput) {
                                    totalInput.disabled = true; // El campo total es de solo lectura
                                    totalInput.value = total + '€';
                                }
                            });
                        }

                        // Parte con la que trabaja el EDITAR de las cargas auxiliares

                        // Mantener el seguimiento de la fila actualmente en edición
                        let currentEditingRow = null;

                        // para meter los valores de la linea a la hora de editarlos, para poder mostrasrlos cuando usemos el boton cancelar
                        let originalValues = {};

                        function addInputListeners(row) {
                            const inputs = row.querySelectorAll('input');
                            inputs.forEach(input => {
                                input.addEventListener('input', () => {
                                    updateHiddenFields(row);
                                });
                            });
                        }

                        // Llamar a esta función cuando habilites la edición
                        function enableEdit(rowId) {
                            console.log('enableEdit fue llamada con rowId:',
                                rowId); // Comprobar si enableEdit se está llamando correctamente

                            const row = document.getElementById(rowId);
                            console.log('Elemento fila encontrado:', row); // Verificar si la fila fue encontrada

                            if (!row) {
                                console.error(`Fila con ID ${rowId} no encontrada.`);
                                return;
                            }

                            if (currentEditingRow && currentEditingRow !== row) {
                                cancelEdit(currentEditingRow);
                            }

                            // Almacenar los valores originales
                            originalValues = {
                                value1: row.querySelector('.value1-input').value,
                                value10: row.querySelector('.value10-input').value,
                                value20: row.querySelector('.value20-input').value,
                                value50: row.querySelector('.value50-input').value,
                                carga1: row.querySelector('.carga1-input').value,
                                carga10: row.querySelector('.carga10-input').value,
                                carga20: row.querySelector('.carga20-input').value,
                                carga50: row.querySelector('.carga50-input').value,
                                total: row.querySelector('.total-cell').textContent
                            };

                            // Verificar si los inputs y botones existen en la fila antes de modificarlos
                            const inputs = row.querySelectorAll('input');
                            console.log('Inputs en la fila:', inputs); // Log de los inputs encontrados

                            inputs.forEach(input => {
                                if (input) {
                                    input.removeAttribute('disabled');
                                } else {
                                    console.error('Input no encontrado.');
                                }
                            });

                            // Deshabilitar el select de creación
                            const machineSelectCreator = document.getElementById(
                                'maquina-0'); // Cambia esto si el ID es diferente
                            if (machineSelectCreator) {
                                machineSelectCreator.setAttribute('disabled', 'true'); // Deshabilitar el select
                            } else {
                                console.error('Select de máquina no encontrado.');
                            }

                            // Deshabilitar botones "Eliminar línea", "Añadir línea" y "Guardar recargas"
                            const removeBtn = document.getElementById('remove-machine-btn');
                            const addBtn = document.getElementById('add-machine-btn');
                            const saveBtn = document.querySelector(
                                'button[data-bs-toggle="modal"][data-bs-target="#secureModalInsert"]');

                            if (removeBtn) {
                                removeBtn.setAttribute('disabled', 'true');
                            } else {
                                console.error('Botón "Eliminar línea" no encontrado.');
                            }

                            if (addBtn) {
                                addBtn.setAttribute('disabled', 'true');
                            } else {
                                console.error('Botón "Añadir línea" no encontrado.');
                            }

                            if (saveBtn) {
                                saveBtn.setAttribute('disabled', 'true');
                            } else {
                                console.error('Botón "Guardar recargas" no encontrado.');
                            }


                            const machineSpan = row.querySelector('.machine-name');
                            const machineSelect = row.querySelector('.machine-select');

                            console.log('machineSpan:', machineSpan);
                            console.log('machineSelect:', machineSelect);

                            if (machineSpan && machineSelect) {
                                machineSelect.classList.remove('d-none');
                                machineSpan.classList.add('d-none');
                                machineSelect.value = row.querySelector('.machine-select').value;
                            } else {
                                console.error('machineSpan o machineSelect no encontrados.');
                            }

                            const editBtn = row.querySelector('.edit-btn');
                            const trashBtn = row.querySelector('.trash-btn');
                            const cancelBtn = row.querySelector('.cancel-btn');
                            const saveForm = row.querySelector('.save-form');

                            console.log('Botones encontrados:', {
                                editBtn,
                                trashBtn,
                                cancelBtn,
                                saveForm
                            }); // Verificar si los botones existen

                            if (editBtn && trashBtn && cancelBtn && saveForm) {
                                editBtn.classList.add('d-none');
                                trashBtn.classList.add('d-none');
                                cancelBtn.classList.remove('d-none');
                                saveForm.classList.remove('d-none');
                            } else if (editBtn && cancelBtn && saveForm) {
                                editBtn.classList.add('d-none');
                                cancelBtn.classList.remove('d-none');
                                saveForm.classList.remove('d-none');
                            } else {
                                console.error('Algunos botones no fueron encontrados correctamente.');
                            }

                            document.querySelectorAll('#contabilidad-table tbody tr').forEach(tr => {
                                if (tr !== row) {
                                    const inputs = tr.querySelectorAll('input');
                                    inputs.forEach(input => {
                                        if (input) {
                                            input.setAttribute('disabled', 'true');
                                        } else {
                                            console.error('Input no encontrado en fila de otras filas.');
                                        }
                                    });

                                    const editBtn = tr.querySelector('.edit-btn');
                                    const trashBtn = tr.querySelector('.trash-btn');
                                    const cancelBtn = tr.querySelector('.cancel-btn');
                                    const saveForm = tr.querySelector('.save-form');

                                    if (editBtn) editBtn.classList.remove('d-none');
                                    if (trashBtn) trashBtn.classList.remove('d-none');
                                    if (cancelBtn) cancelBtn.classList.add('d-none');
                                    if (saveForm) saveForm.classList.add('d-none');
                                }
                            });

                            // Deshabilitar los botones de otras filas
                            document.querySelectorAll('#contabilidad-table tbody tr').forEach(tr => {
                                if (tr !== row) {
                                    const inputs = tr.querySelectorAll('input');
                                    inputs.forEach(input => {
                                        if (input) {
                                            input.setAttribute('disabled', 'true');
                                        } else {
                                            console.error('Input no encontrado en fila de otras filas.');
                                        }
                                    });

                                    const editBtn = tr.querySelector('.edit-btn');
                                    const trashBtn = tr.querySelector('.trash-btn');
                                    const cancelBtn = tr.querySelector('.cancel-btn');
                                    const saveForm = tr.querySelector('.save-form');

                                    if (editBtn) {
                                        editBtn.setAttribute('disabled', 'true');
                                    }
                                    if (trashBtn) {
                                        trashBtn.setAttribute('disabled', 'true');
                                    }
                                    if (cancelBtn) {
                                        cancelBtn.classList.add('d-none');
                                    }
                                    if (saveForm) {
                                        saveForm.classList.add('d-none');
                                    }
                                }
                            });


                            console.log('Fila actual en edición:', row);

                            // Actualizar valores en campos ocultos
                            updateHiddenFields(row);

                            // Agregar listeners a los inputs para actualizar los campos ocultos en tiempo real
                            addInputListeners(row);

                            clearInsertModal();

                            currentEditingRow = row;
                        }


                        function updateHiddenFields(row) {
                            // Obtener el formulario
                            const form = row.querySelector('.save-form');

                            if (!form) {
                                console.error('Formulario no encontrado en la fila.');
                                return; // Asegurarse de que el formulario exista
                            }

                            // Obtener los valores actuales de los inputs editables
                            const machineSelect = row.querySelector('.machine-select').value;
                            const coin1 = parseInt(row.querySelector('.value1-input').value) || 0;
                            const coin10 = parseInt(row.querySelector('.value10-input').value) || 0;
                            const coin20 = parseInt(row.querySelector('.value20-input').value) || 0;
                            const coin50 = parseInt(row.querySelector('.value50-input').value) || 0;
                            const carga1 = parseInt(row.querySelector('.carga1-input').value) || 0;
                            const carga10 = parseInt(row.querySelector('.carga10-input').value) || 0;
                            const carga20 = parseInt(row.querySelector('.carga20-input').value) || 0;
                            const carga50 = parseInt(row.querySelector('.carga50-input').value) || 0;

                            // Calcular el total
                            const total = coin1 * 1 + coin10 * 10 + coin20 * 20 + coin50 * 50 + carga1 * 1 + carga10 * 10 +
                                carga20 * 20 +
                                carga50 * 50;

                            // Actualizar el campo de total en la fila
                            const totalInput = row.querySelector('.total-cell');
                            if (totalInput) {
                                totalInput.textContent = total + '€'; // Actualizar la celda total
                            }

                            // Console log de los valores actualizados
                            console.log('Valores actualizados:', {
                                machineSelect,
                                coin1,
                                coin10,
                                coin20,
                                coin50,
                                carga1,
                                carga10,
                                carga20,
                                carga50,
                                total
                            });

                            // Actualizar los campos ocultos con los valores actuales de los inputs editables
                            form.querySelector('input[name="machine_id"]').value = machineSelect;
                            form.querySelector('input[name="coin1"]').value = coin1;
                            form.querySelector('input[name="coin10"]').value = coin10;
                            form.querySelector('input[name="coin20"]').value = coin20;
                            form.querySelector('input[name="coin50"]').value = coin50;
                            form.querySelector('input[name="carga1"]').value = carga1;
                            form.querySelector('input[name="carga10"]').value = carga10;
                            form.querySelector('input[name="carga20"]').value = carga20;
                            form.querySelector('input[name="carga50"]').value = carga50;
                            form.querySelector('input[name="total"]').value = total;
                        }


                        function cancelEdit(row) {
                            if (!row) return; // Asegurarse de que la fila no sea null

                            console.log('Cancelando edición para la fila:', row.id);

                            // Restaurar los valores originales
                            row.querySelector('.value1-input').value = originalValues.value1;
                            row.querySelector('.value10-input').value = originalValues.value10;
                            row.querySelector('.value20-input').value = originalValues.value20;
                            row.querySelector('.value50-input').value = originalValues.value50;
                            row.querySelector('.carga1-input').value = originalValues.carga1;
                            row.querySelector('.carga10-input').value = originalValues.carga10;
                            row.querySelector('.carga20-input').value = originalValues.carga20;
                            row.querySelector('.carga50-input').value = originalValues.carga50;
                            const totalInput = row.querySelector('.total-cell');
                            if (totalInput) {
                                totalInput.textContent = originalValues.total; // Restaurar el total
                            }

                            // Limpiar campos ocultos
                            clearHiddenFields(); // Limpia los campos ocultos

                            // Cambiar los botones
                            const editBtn = row.querySelector('.edit-btn');
                            if (editBtn) {
                                editBtn.classList.remove('d-none');
                            }

                            const cancelBtn = row.querySelector('.cancel-btn');
                            if (cancelBtn) {
                                cancelBtn.classList.add('d-none');
                            }

                            const saveForm = row.querySelector('.save-form');
                            if (saveForm) {
                                saveForm.classList.add('d-none');
                            }

                            const trashBtn = row.querySelector('.trash-btn');
                            if (trashBtn) {
                                trashBtn.classList.remove('d-none'); // Solo se ejecutará si trashBtn existe
                            }

                            // Hacer los campos no editables
                            row.querySelectorAll('input').forEach(input => input.setAttribute('disabled', 'true'));

                            // Habilitar botones "Eliminar línea", "Añadir línea" y "Guardar recargas"
                            const removeBtn = document.getElementById('remove-machine-btn');
                            const addBtn = document.getElementById('add-machine-btn');
                            const saveBtn = document.querySelector(
                                'button[data-bs-toggle="modal"][data-bs-target="#secureModalInsert"]');

                            if (removeBtn) {
                                removeBtn.removeAttribute('disabled');
                            } else {
                                console.error('Botón "Eliminar línea" no encontrado.');
                            }

                            if (addBtn) {
                                addBtn.removeAttribute('disabled');
                            } else {
                                console.error('Botón "Añadir línea" no encontrado.');
                            }

                            if (saveBtn) {
                                saveBtn.removeAttribute('disabled');
                            } else {
                                console.error('Botón "Guardar recargas" no encontrado.');
                            }

                            // Obtener el select de machines y el span que muestra el nombre
                            const machineSelect = row.querySelector('.machine-select');
                            const machineSpan = row.querySelector('.machine-name');

                            // Deshabilitar el select y restaurar el texto
                            if (machineSelect) {
                                machineSelect.classList.add('d-none'); // Ocultar el select
                                machineSpan.classList.remove('d-none'); // Mostrar el span
                                machineSpan.textContent = machineSelect.options[machineSelect.selectedIndex]
                                    .text; // Restaurar el texto
                                machineSelect.value = machineSelect.options[machineSelect.selectedIndex]
                                    .value; // Asegurarse de que el select tenga el valor correcto
                            }

                            // Limpiar el modal de inserción
                            clearInsertModal(); // Asegúrate de que esto se llama para limpiar el modal

                            // Habilitar botones de las otras filas
                            document.querySelectorAll('#contabilidad-table tbody tr').forEach(tr => {
                                const editBtn = tr.querySelector('.edit-btn');
                                const trashBtn = tr.querySelector('.trash-btn');

                                if (editBtn) {
                                    editBtn.removeAttribute('disabled'); // Habilitar el botón de editar
                                }
                                if (trashBtn) {
                                    trashBtn.removeAttribute('disabled'); // Habilitar el botón de eliminar
                                }
                            });

                            // Limpiar la fila actualmente editada
                            currentEditingRow = null;

                            // Habilitar los campos de crear una recarga auxiliar
                            enableCreateFields();
                        }

                        // Función para limpiar los campos ocultos
                        function clearHiddenFields() {
                            document.getElementById('hidden-maquinas').value = '';
                            document.getElementById('hidden-coin1').value = '';
                            document.getElementById('hidden-coin10').value = '';
                            document.getElementById('hidden-coin20').value = '';
                            document.getElementById('hidden-coin50').value = '';
                            document.getElementById('hidden-carga1').value = '';
                            document.getElementById('hidden-carga10').value = '';
                            document.getElementById('hidden-carga20').value = '';
                            document.getElementById('hidden-carga50').value = '';
                            document.getElementById('hidden-total').value = '';
                        }


                        // Función para habilitar los campos de crear una recarga auxiliar
                        function enableCreateFields() {
                            // Habilitar todos los inputs y selects en la sección de creación
                            const creationInputs = document.querySelectorAll('#recargas-form input, #recargas-form select');
                            creationInputs.forEach(input => {
                                // Habilitar cada input, excepto el de total
                                if (!input.classList.contains(
                                        'total-input')) { // Suponiendo que el campo de total tiene esta clase
                                    input.removeAttribute('disabled'); // Habilitar el input
                                }
                            });


                        }


                        // Event listener para los botones de editar
                        document.querySelectorAll('.edit-btn').forEach(button => {
                            button.addEventListener('click', function() {
                                const row = this.closest('tr');
                                enableEdit(row.id);
                            });
                        });

                        // Event listener para los botones de cancelar
                        document.querySelectorAll('.cancel-btn').forEach(button => {
                            button.addEventListener('click', function() {
                                cancelEdit(currentEditingRow);
                            });
                        });
                    });
                </script>

                <div class="tab-pane fade" id="arqMaq-tab-pane" role="tabpanel" aria-labelledby="arqMaq-tab"
                    tabindex="0">
                    <div class="d-flex flex-column align-items-center">
                        <div class="d-flex justify-content-center p-1 w-md-50">
                            <form action="{{ route('getTicketsFilter', $local->id) }}" method="POST"
                                class="d-flex flex-column justify-content-center w-100 d-md-block w-md-100">
                                @csrf
                                @method('POST')

                                <input type="datetime-local" name="dateInicio" class="mb-2 h-xs-75 w-xs-100 form-control"
                                    oninput="cargarTypes()" id="fechaInicioFilter">
                                <input type="datetime-local" name="fin" class="mb-2 h-xs-75 w-xs-100 form-control"
                                    oninput="cargarTypes()" id="fechaFinFilter">
                                <select name="maquinaSelect" class="mb-2 h-xs-75 w-xs-100 form-select"
                                    id="maquinaSelect">
                                    @foreach ($machines as $machine)
                                        <option value="{{ $machine->id }}">{{ $machine->alias }}</option>
                                    @endforeach
                                </select>

                                <input type="submit" value="Filtrar" class="btn btn-warning h-xs-75 w-xs-100" disabled
                                    id="btn-filtrar">
                            </form>
                        </div>
                        <div class="text-center" style="visibility: hidden;" id="divDateError">
                            <p style="color: red;">Fecha no válida</p>
                        </div>
                    </div>

                    <div class="mt-5">
                        @if (!$ticketsFilter->isEmpty())
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th colspan="6">{{ $ticketsFilter->first()->Type }} pagos manuales</th>
                                        </tr>
                                        <tr>
                                            <th>Valor</th>
                                            <th>Máquina</th>
                                            <th>Comment</th>
                                            <th>Recarga Auxiliar</th>
                                            <th>Estado</th>
                                            <th>Fecha</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalFilter = 0;
                                        @endphp
                                        @foreach ($ticketsFilter as $ticket)
                                            <tr>
                                                <td>{{ $ticket->Value }}€</td>
                                                <td>{{ $ticket->Type }}</td>
                                                <td>
                                                    @if (!in_array($ticket->User, $usersRoot))
                                                        {{ $ticket->Comment }}
                                                    @endif
                                                </td>
                                                <td>{{ $ticket->TypeIsAux }}</td>
                                                @if ($ticket->Command == 'CLOSE')
                                                    <td>Cobrado</td>
                                                @elseif ($ticket->Command == 'OPEN' || $ticket->Command == 'PRINTED' || $ticket->Command == 'AUTHREQ')
                                                    <td>No cobrado</td>
                                                @endif
                                                <td>{{ \Carbon\Carbon::parse($ticket->DateTime)->format('d-m-Y H:i') }}
                                                </td>
                                            </tr>
                                            @php
                                                $totalFilter = $totalFilter + $ticket->Value;
                                            @endphp
                                        @endforeach
                                        <tr>
                                            <td colspan="6" class="text-start">Total: {{ $totalFilter }}€</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endif

                        @if (!empty($recargas))
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th colspan="9">{{ $recargas->first()->machine }} recargas auxiliares</th>
                                        </tr>
                                        <tr>
                                            <th scope="col">Fecha</th>
                                            <th scope="col">Usuario</th>
                                            <th scope="col">Máquina</th>
                                            <th scope="col">1€</th>
                                            <th scope="col">10€</th>
                                            <th scope="col">20€</th>
                                            <th scope="col">50€</th>
                                            <th scope="col">Carga</th>
                                            <th scope="col">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalRecargas = 0;
                                        @endphp
                                        @foreach ($recargas as $recarga)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($recarga->created_at)->format('d-m-Y H:i') }}
                                                </td>
                                                <td>{{ $recarga->usuario->name }}</td>
                                                <td>{{ $recarga->machine }}</td>
                                                <td>{{ $recarga->value1 }}</td>
                                                <td>{{ $recarga->value10 }}</td>
                                                <td>{{ $recarga->value20 }}</td>
                                                <td>{{ $recarga->value50 }}</td>
                                                <td>{{ $recarga->carga }}</td>
                                                <td>{{ $recarga->total }}€</td>
                                            </tr>
                                            @php
                                                $totalRecargas = $totalRecargas + $recarga->total;
                                            @endphp
                                        @endforeach
                                        <tr>
                                            <td colspan="9" class="text-start">Total: {{ $totalRecargas }}€</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endif


                        <!--@if (!empty($recargas))
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <div class="table-responsive">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <table class="table">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <thead>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <th colspan="9">{{ $recargas->first()->machine }} recargas auxiliares</th>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <th scope="col">Fecha</th>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <th scope="col">Usuario</th>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <th scope="col">Máquina</th>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <th scope="col">1€</th>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <th scope="col">10€</th>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <th scope="col">20€</th>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <th scope="col">50€</th>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <th scope="col">Carga</th>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <th scope="col">Total</th>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </thead>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <tbody>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                @php
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    $totalRecargas = 0;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                @endphp
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                @foreach ($recargas as $recarga)
    <tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td>{{ \Carbon\Carbon::parse($recarga->created_at)->format('d-m-Y H:i') }}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td>{{ $recarga->usuario->name }}</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td>{{ $recarga->machine }}</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td>{{ $recarga->value1 }}</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td>{{ $recarga->value10 }}</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td>{{ $recarga->value20 }}</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td>{{ $recarga->value50 }}</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td>{{ $recarga->carga }}</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td>{{ $recarga->total }}€</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    @php
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $totalRecargas =
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            $totalRecargas +
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            $recarga->total;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    @endphp
    @endforeach
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <td colspan="9" class="text-start">Total: {{ $totalRecargas }}€</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </tbody>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </table>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                @endif-->
                    </div>
                    <div class="mt-3 d-md-flex justify-content-center">
                        <div class="p-3 w-md-50" style="border: 2px solid rgb(207, 15, 15); border-radius:5px;">
                            <div class="d-flex flex-column mb-3">
                                <div>
                                    <label for="pman">Pagos manuales</label>
                                    <i class="bi bi-pencil-square" onclick="editarPmanual()"></i>
                                </div>
                                <input type="number" name="pman" disabled value="{{ $totalFilter ?? 0 }}"
                                    id="p_manual" class="form-control">
                            </div>
                            <div class="d-flex flex-column mb-3">
                                <div>
                                    <label for="raux">Recargas auxiliar</label>
                                    <i class="bi bi-pencil-square" onclick="editarRauxiliar()"></i>
                                </div>
                                <input type="number" name="raux" id="r_auxiliar" value="{{ $totalSumAux ?? 0 }}"
                                    disabled class="form-control">
                            </div>
                            <div class="d-flex flex-column mb-3">
                                <label for="gestimaq">Recaudación Gestimaq</label>
                                <input type="number" name="gestimaq" id="gestimaq" value="0"
                                    class="form-control">
                            </div>
                            <div class="d-flex flex-column mb-3">
                                <label for="ccir">Cargas circulantes</label>
                                <input type="number" name="ccir" id="c_circular" value="0"
                                    class="form-control">
                            </div>
                            <div class="d-flex flex-column mb-3">
                                <label for="efectivo">Efectivo</label>
                                <input type="number" name="efectivo" id="efectivo" value="0"
                                    class="form-control">
                            </div>
                            <div class="d-flex flex-column mb-3">
                                <label for="hopmaq">Hopper inicial</label>
                                <input type="number" name="hopmaq" id="h_inicial" value="0"
                                    class="form-control">
                            </div>
                            <hr>
                            <div>
                                <span>Revisar partes de averia si falta dinero.</span>
                            </div>
                            <input type="button" value="Calcular" onclick="calcular()"
                                class="btn btn-warning w-50 btn-sm mb-3">
                            <div id="result" style="visibility: hidden"
                                class="d-flex align-items-center justify-content-center"></div>

                            <script>
                                let p_manual = document.querySelector("#p_manual");
                                let r_auxiliar = document.querySelector("#r_auxiliar");
                                let gestimaq = document.querySelector("#gestimaq");
                                let c_circular = document.querySelector("#c_circular");
                                let efectivo = document.querySelector("#efectivo");
                                let h_inicial = document.querySelector("#h_inicial");

                                const result = document.querySelector("#result");
                                let resultText = result.firstChild

                                function calcular() {
                                    if (p_manual.value == "") {
                                        p_manual.value = 0
                                    }
                                    if (r_auxiliar.value == "") {
                                        r_auxiliar.value = 0
                                    }
                                    if (gestimaq.value == "") {
                                        gestimaq.value = 0
                                    }
                                    if (c_circular.value == "") {
                                        c_circular.value = 0
                                    }
                                    if (efectivo.value == "") {
                                        efectivo.value = 0
                                    }
                                    if (h_inicial.value == "") {
                                        h_inicial.value = 0
                                    }


                                    let balance = parseFloat(r_auxiliar.value) - parseFloat(p_manual.value)

                                    let resta = parseFloat(c_circular.value) + parseFloat(h_inicial.value)
                                    let suma = parseFloat(efectivo.value) + parseFloat(balance)

                                    let total = suma - resta

                                    let all = total - parseFloat(gestimaq.value)

                                    result.style.height = "50px"
                                    result.style.visibility = "visible"
                                    result.style.fontWeight = "800"
                                    if (all > 0) {
                                        result.style.backgroundColor = "green"
                                        result.textContent = "Te sobran: " + all.toFixed(2) + "€"
                                    } else if (all < 0) {
                                        result.style.backgroundColor = "red"
                                        result.textContent = "Te faltan: " + all.toFixed(2) + "€"
                                    } else if (all == 0) {
                                        result.style.backgroundColor = "gray"
                                        result.textContent = "Máquina cuadrada: " + all.toFixed(2) + "€"
                                    }
                                }

                                function editarPmanual() {
                                    if (p_manual.disabled) {
                                        p_manual.disabled = false
                                    } else {
                                        p_manual.disabled = true
                                    }
                                }

                                function editarRauxiliar() {
                                    if (r_auxiliar.disabled) {
                                        r_auxiliar.disabled = false
                                    } else {
                                        r_auxiliar.disabled = true
                                    }
                                }

                                let fechaInicio = document.querySelector("#fechaInicioFilter")
                                let fechaFin = document.querySelector("#fechaFinFilter")
                                const allTypes = @json($machines);
                                const btnFiltrar = document.querySelector("#btn-filtrar")
                                const diverror = document.querySelector("#divDateError")
                                let maquinaSelect = document.querySelector("#maquinaSelect");

                                function cargarTypes() {
                                    if (fechaInicio.value != "" && fechaFin.value != "") {
                                        if (fechaInicio.value < fechaFin.value) {
                                            btnFiltrar.disabled = false
                                            diverror.style.visibility = "hidden";
                                            fetchTypes(fechaInicio.value, fechaFin.value);
                                        } else {
                                            btnFiltrar.disabled = true
                                            diverror.style.visibility = "visible";

                                            maquinaSelect.innerHTML = ""; // Clear previous options
                                            allTypes.forEach(type => {
                                                let option = document.createElement("option");
                                                option.value = type;
                                                option.text = type;
                                                maquinaSelect.add(option);
                                            })
                                        }
                                    } else {
                                        btnFiltrar.disabled = true
                                    }
                                }

                                /*function fetchTypes(startDate, endDate) {
                                    const localId = '{{ $local->id }}'; // Asegúrate de tener la variable $local disponible en tu vista
                                    fetch(`{{ url('buscarTickets') }}/${localId}`, {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                            },
                                            body: JSON.stringify({
                                                dateInicio: startDate,
                                                fin: endDate
                                            })
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            maquinaSelect.innerHTML = ""; // Clear previous options
                                            data.forEach(type => {
                                                let option = document.createElement("option");
                                                option.value = type;
                                                option.text = type;
                                                maquinaSelect.add(option);
                                            })
                                        })
                                        .catch(error => console.error('Error:', error));
                                }*/
                            </script>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="newTab-tab-pane" role="tabpanel" aria-labelledby="newTab-tab"
                    tabindex="0">
                    <div class="d-flex flex-column align-items-center">
                        <div class="w-md-50">
                            <div>
                                <h3>CONTADORES ANTERIORES</h3>
                                <hr>
                                <div class="d-flex flex-column flex-md-row justify-content-md-between">
                                    <div class="col-12 col-md-3">
                                        <input type="date" class="mb-3 form-control ">
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <input type="number" id="antA" value="0" min="0"
                                            class="mb-3 form-control">
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <input type="number" id="antB" value="0" min="0"
                                            class="mb-3 form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5">
                                <h3>CONTADORES ACTUALES</h3>
                                <hr>
                                <div class="d-flex flex-column flex-md-row justify-content-md-between">
                                    <div class="col-12 col-md-3">
                                        <input type="date" class="mb-3 form-control">
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <input type="number" id="actC" value="0" min="0"
                                            class="mb-3 form-control">
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <input type="number" id="actD" value="0" min="0"
                                            class="mb-3 form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5">
                                <button class="btn btn-warning w-100" onclick="calcularContadores()">CALCULAR</button>

                                <div class="d-flex flex-column align-items-center mt-4" id="lastbLock">
                                    <p>RESULTADO</p>
                                    <div class="w-100 w-md-50 mb-3 d-flex justify-content-between">
                                        <span>x 0.01€ = </span><input type="text" disabled id="res001">
                                    </div>
                                    <div class="w-100 w-md-50 mb-3 d-flex justify-content-between">
                                        <span>x 0.2€ = </span><input type="text" disabled id="res02">
                                    </div>
                                    <div class="w-100 w-md-50 mb-3 d-flex justify-content-between">
                                        <span>x 1€ = </span><input type="text" disabled id="res1">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            let a = document.getElementById("antA");
                            let b = document.getElementById("antB");
                            let c = document.getElementById("actC");
                            let d = document.getElementById("actD");

                            let res001 = document.getElementById("res001");
                            let res02 = document.getElementById("res02");
                            let res1 = document.getElementById("res1");

                            function calcularContadores() {
                                let resultado = (c.value - a.value) - (d.value - b.value)


                                res001.value = (resultado * 0.01).toFixed(2) + "€"
                                res02.value = (resultado * 0.2).toFixed(2) + "€"
                                res1.value = (resultado * 1).toFixed(2) + "€"

                                let existingAlert = document.getElementById("alertMessage");

                                if (existingAlert) {
                                    lastBlock.removeChild(existingAlert);
                                }

                                if (a.value > c.value || b.value > d.value) {
                                    let lastBlock = document.getElementById("lastbLock");

                                    let alert = document.createElement("p");

                                    alert.setAttribute("id", "alertMessage")
                                    alert.classList.add("alert", "alert-info");
                                    alert.textContent = "Es raro que el contador anterior sea mayor que el actual!";

                                    lastBlock.appendChild(alert);
                                }
                            }
                        </script>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="summaryTab-tab-pane" role="tabpanel" aria-labelledby="summaryTab-tab"
                tabindex="0">
                <div class="d-flex flex-column align-items-center">
                    <div class="w-md-50">
                        @if ($machines)
                            <table class="w-50 table table-bordered text-end">
                                <thead>
                                    <tr>
                                        <th class="text-start">Máquina</th>
                                        <th class="text-start">Identificador</th>
                                        <th class="text-end">Entradas</th>
                                        <th class="text-end">Salidas</th>
                                        <th class="text-end">Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($machines as $machine)
                                        <tr>
                                            <td class="text-start">{{ $machine->alias }}</td>
                                            <td class="text-start">{{ $machine->identificador }}</td>
                                            <td class="text-end">
                                                <!-- Campo vacío, se llenará luego con los datos de la otra consulta -->
                                                ---
                                            </td>
                                            <td class="text-end">
                                                <!-- Campo vacío, se llenará luego con los datos de la otra consulta -->
                                                ---
                                            </td>
                                            <td class="text-end">
                                                <!-- Campo vacío, se llenará luego con los datos de la otra consulta -->
                                                ---
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
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

        <style>
            .carga-container {
                display: flex;
                justify-content: center;
                /* Centra los elementos horizontalmente */
                gap: 5px;
                /* Ajusta el espacio entre los inputs según sea necesario */
                align-items: center;
                /* Alinea los inputs y textos verticalmente */
            }

            .carga-input {
                width: 50px;
                /* Ajusta el tamaño del input */
                text-align: center;
                /* Centra el texto dentro del input */
            }

            .carga-text {
                font-size: 12px;
                /* Hace que el texto sea pequeño */
                color: #black;
                /* Color discreto para el texto */
                margin-right: 2px;
                /* Espacio pequeño antes del input */
            }
        </style>


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
