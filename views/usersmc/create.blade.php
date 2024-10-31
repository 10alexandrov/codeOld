@extends('plantilla.plantilla')
@section('titulo', 'Local')
@section('contenido')
    <div class="container">
        <div class="col-8 offset-2 isla-list p-4 mt-5">
            <div class="ttl text-center mb-4">
                <h1>Crear usuario ticketserver</h1>
            </div>
            <form action="{{ route('usersmc.store') }}" method="POST">
                @csrf
                @method('POST')
                <div class="form-floating mb-3">
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        id="floatingName" placeholder="name" value="{{ old('name') }}">
                    <label for="floatingName">Usuario ticketserver</label>
                    @error('name')
                        <div class="invalid-feedback"> {{ $message }} </div>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="nameReal" class="form-control @error('nameReal') is-invalid @enderror"
                        id="floatingNameReal" placeholder="nameReal" value="{{ old('nameReal') }}">
                    <label for="floatingNameReal">Nombre</label>
                    @error('nameReal')
                        <div class="invalid-feedback"> {{ $message }} </div>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input type="password" name="passwd" class="form-control @error('passwd') is-invalid @enderror"
                        id="floatingPass" placeholder="1234" disabled value="{{ old('passwd') }}">
                    <label for="floatingPass">Contraseña</label>
                    @error('passwd')
                        <div class="invalid-feedback"> {{ $message }} </div>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <select class="form-select @error('sesion') is-invalid @enderror" id="floatingSelect"
                        aria-label="Floating label select example" name="sesion" disabled value="{{ old('sesion') }}">
                        <option value="-2">CAP</option>
                        <option value="-1" selected>Siempre preguntar PIN</option>
                        <option value="0">Preguntar PIN una sola vez</option>
                        <option value="1">1 minuto</option>
                        <option value="2">2 minutos</option>
                        <option value="5">5 minutos</option>
                        <option value="10">10 minutos</option>
                    </select>
                    <label for="floatingSelect">Tipo de sesión:</label>
                    @error('sesion')
                        <div class="invalid-feedback"> {{ $message }} </div>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="PID" class="form-control @error('PID') is-invalid @enderror"
                        id="floatingPID" placeholder="PID-1234" value="{{ old('PID') }}">
                    <label for="floatingPID">Codigo identificador de tarjeta:</label>
                    @error('PID')
                        <div class="invalid-feedback"> {{ $message }} </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="form-check-inline">
                        <label class="form-check-label" for="inlineRadio1">Tipo de usuario: </label>
                    </div>
                    <div class="form-check-inline">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input @error('permisosTipo') is-invalid @enderror" type="radio"
                                name="permisosTipo" id="inlineRadio1" value="Tecnico" checked>
                            <label class="form-check-label" for="inlineRadio1">Tecnico</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input @error('permisosTipo') is-invalid @enderror" type="radio"
                                name="permisosTipo" id="inlineRadio2" value="Caja">
                            <label class="form-check-label" for="inlineRadio2">Caja</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input @error('permisosTipo') is-invalid @enderror" type="radio"
                                name="permisosTipo" id="inlineRadio3" value="Personal de sala">
                            <label class="form-check-label" for="inlineRadio3">Personal de sala</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input @error('permisosTipo') is-invalid @enderror" type="radio"
                                name="permisosTipo" id="inlineRadio4" value="Desconocido">
                            <label class="form-check-label" for="inlineRadio4">Desconocido</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input @error('permisosTipo') is-invalid @enderror" type="radio"
                                name="permisosTipo" id="inlineRadio5" value="Otros">
                            <label class="form-check-label" for="inlineRadio5">Otros</label>
                        </div>
                        @error('permisosTipo')
                            <div class="invalid-feedback"> {{ $message }} </div>
                        @enderror
                    </div>
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
                                                    value="{{ $local->id }}" id="flexCheckDefault{{ $local->id }}"
                                                    name="locales[]" onchange="updateResumen()">
                                                <label class="form-check-label"
                                                    for="flexCheckDefault{{ $local->id }}">{{ $local->name }}</label>
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
                </div>

                <div id="additionalOptions" style="display: flex;" class="row mt-5">
                    <!-- Checkboxes for rights -->
                    <div class="col-md-4">
                        <b>Derechos (separados por coma):</b>
                        <br>
                        <input type="checkbox" name="RightALL">ALL<br><input type="checkbox"
                            name="RightCREATETICKET">CREATETICKET<br><input type="checkbox"
                            name="RightGETANDCLOSETICKET">GETANDCLOSETICKET<br><input type="checkbox"
                            name="RightCONFIRMTICKET">CONFIRMTICKET<br><input type="checkbox"
                            name="RightPRINTTICKET">PRINTTICKET<br><input type="checkbox"
                            name="RightABORTTICKET">ABORTTICKET<br><input type="checkbox"
                            name="RightEXPIRETICKET">EXPIRETICKET<br><input type="checkbox"
                            name="RightDELETETICKET">DELETETICKET<br><input type="checkbox"
                            name="RightLISTTICKETS">LISTTICKETS<br><input type="checkbox"
                            name="RightLISTTICKETSPENDING">LISTTICKETSPENDING<br><input type="checkbox"
                            name="RightLISTCONFIRMTICKETS">LISTCONFIRMTICKETS<br><input type="checkbox"
                            name="RightREPORTTICKETS">REPORTTICKETS<br><input type="checkbox"
                            name="RightPURGETICKETS">PURGETICKETS<br><input type="checkbox"
                            name="RightEXPORTTICKETS">EXPORTTICKETS<br><input type="checkbox"
                            name="RightCOLLECT">COLLECT<br><input type="checkbox"
                            name="RightUPDATECOLLECT">UPDATECOLLECT<br><input type="checkbox"
                            name="RightDELETECOLLECT">DELETECOLLECT<br><input type="checkbox"
                            name="RightACCOUNTING">ACCOUNTING<br><input type="checkbox"
                            name="RightUPDATEACCOUNTING">UPDATEACCOUNTING<br><input type="checkbox"
                            name="RightDELETEACCOUNTING">DELETEACCOUNTING<br><input type="checkbox"
                            name="RightADDUSER">ADDUSER<br><input type="checkbox"
                            name="RightDELETEUSER">DELETEUSER<br><input type="checkbox"
                            name="RightEDITUSER">EDITUSER<br><input type="checkbox" name="RightGETUSER">GETUSER<br><input
                            type="checkbox" name="RightLISTUSERS">LISTUSERS<br><input type="checkbox"
                            name="RightEXPORTUSERS">EXPORTUSERS<br><input type="checkbox"
                            name="RightIMPORTUSERS">IMPORTUSERS<br><input type="checkbox"
                            name="RightEDITCONFIG">EDITCONFIG<br><input type="checkbox" name="RightLOGS">LOGS<br><input
                            type="checkbox" name="RightLISTLOGS">LISTLOGS<br><input type="checkbox"
                            name="RightPURGUELOGS">PURGUELOGS<br><input type="checkbox"
                            name="RightEXPORTLOGS">EXPORTLOGS<br><input type="checkbox"
                            name="RightUSETICKET">USETICKET<br><input type="checkbox"
                            name="RightLISTTICKETSUSED">LISTTICKETSUSED<br><input type="checkbox"
                            name="RightBACKUPDB">BACKUPDB<br><input type="checkbox"
                            name="RightRESTOREDB">RESTOREDB<br><input type="checkbox"
                            name="RightEDITUSERBALANCE">EDITUSERBALANCE<br><input type="checkbox"
                            name="RightRESETUSERBALANCE">RESETUSERBALANCE<br><input type="checkbox"
                            name="RightLISTUSERBALANCE">LISTUSERBALANCE<br><input type="checkbox"
                            name="RightADDPLAYER">ADDPLAYER<br><input type="checkbox"
                            name="RightDELETEPLAYER">DELETEPLAYER<br><input type="checkbox"
                            name="RightEDITPLAYER">EDITPLAYER<br><input type="checkbox"
                            name="RightLISTPLAYERS">LISTPLAYERS<br><input type="checkbox"
                            name="RightSTATISTICS">STATISTICS<br><input type="checkbox"
                            name="RightAUXMONEYSTORAGE">AUXMONEYSTORAGE<br><input type="checkbox"
                            name="RightUPDATEAUXMONEYSTORAGE">UPDATEAUXMONEYSTORAGE<br><input type="checkbox"
                            name="RightDELETEAUXMONEYSTORAGE">DELETEAUXMONEYSTORAGE<br><input type="checkbox"
                            name="RightLISTHIDDENTICKETS">LISTHIDDENTICKETS<br><input type="checkbox"
                            name="RightBETMONEYSTORAGE">BETMONEYSTORAGE<br><input type="checkbox"
                            name="RightUPDATEBETMONEYSTORAGE">UPDATEBETMONEYSTORAGE<br><input type="checkbox"
                            name="RightDELETEBETMONEYSTORAGE">DELETEBETMONEYSTORAGE<br><input type="checkbox"
                            name="RightPURGEDB">PURGEDB<br><input type="checkbox"
                            name="RightUPDATETICKETSSTATUS">UPDATETICKETSSTATUS<br><input type="checkbox"
                            name="RightUPDATETICKETSAUX">UPDATETICKETSAUX<br><input type="checkbox"
                            name="RightHIDEONTC">HIDEONTC<br><input type="checkbox" name="RightCASHLESS">CASHLESS<br><br>
                    </div>

                    <!-- Checkboxes for ticket types -->
                    <div class="col-md-4">
                        <b>Tipos de ticket permitidos (ninguno implica todos):</b>
                        <br>
                        <input type="checkbox" name="TicketTypeALL">ALL<br><input type="checkbox"
                            name="TicketTypeCCMCODERE">CCMCODERE<br><input type="checkbox"
                            name="TicketTypeCODERE">CODERE<br><input type="checkbox"
                            name="TicketTypeCODERE TicketController">CODERE TicketController<br><input type="checkbox"
                            name="TicketTypeCCMBWIN">CCMBWIN<br><input type="checkbox"
                            name="TicketTypeBWIN">BWIN<br><input type="checkbox"
                            name="TicketTypeBWIN TicketController">BWIN TicketController<br><input type="checkbox"
                            name="TicketTypeCCMORENES">CCMORENES<br><input type="checkbox"
                            name="TicketTypeORENES">ORENES<br><input type="checkbox"
                            name="TicketTypeORENES TicketController">ORENES TicketController<br><input type="checkbox"
                            name="TicketTypeCCMKIROLSOFT">CCMKIROLSOFT<br><input type="checkbox"
                            name="TicketTypeKIROLSOFT">KIROLSOFT<br><input type="checkbox"
                            name="TicketTypeKIROLSOFT TicketController">KIROLSOFT
                        TicketController<br><input type="checkbox" name="TicketTypeCCMRETA">CCMRETA<br><input
                            type="checkbox" name="TicketTypeRETA">RETA<br><input type="checkbox"
                            name="TicketTypeRETA TicketController">RETA TicketController<br><input type="checkbox"
                            name="TicketTypeCCMEGASA">CCMEGASA<br><input type="checkbox"
                            name="TicketTypeEGASA">EGASA<br><input type="checkbox"
                            name="TicketTypeEGASA TicketController">EGASA TicketController<br><input type="checkbox"
                            name="TicketTypeCCMIPS">CCMIPS<br><input type="checkbox" name="TicketTypeIPS">IPS<br><input
                            type="checkbox" name="TicketTypeIPS TicketController">IPS TicketController<br><input
                            type="checkbox" name="TicketTypeIPSServer">IPSServer<br><input type="checkbox"
                            name="TicketTypeIPXServer">IPXServer<br><input type="checkbox"
                            name="TicketTypeMGA">MGA<br><input type="checkbox" name="TicketTypeSMC">SMC<br><input
                            type="checkbox" name="TicketTypeNEMESYS">NEMESYS<br><input type="checkbox"
                            name="TicketTypeSQL">SQL<br><input type="checkbox"
                            name="TicketTypeTECNAUSA">TECNAUSA<br><input type="checkbox"
                            name="TicketTypeTEYSA">TEYSA<br><input type="checkbox" name="TicketTypeVAN">VAN<br><input
                            type="checkbox" name="TicketTypeCCMGTECH">CCMGTECH<br><input type="checkbox"
                            name="TicketTypeGTECH">GTECH<br><input type="checkbox"
                            name="TicketTypeGTECH TicketController">GTECH TicketController<br><input type="checkbox"
                            name="TicketTypeCCMGTECH2">CCMGTECH2<br><input type="checkbox"
                            name="TicketTypeGTECH2">GTECH2<br><input type="checkbox"
                            name="TicketTypeGTECH2 TicketController">GTECH2 TicketController<br><input type="checkbox"
                            name="TicketTypeCCMSPORTIUM">CCMSPORTIUM<br><input type="checkbox"
                            name="TicketTypeSPORTIUM">SPORTIUM<br><input type="checkbox"
                            name="TicketTypeSPORTIUM TicketController">SPORTIUM TicketController<br><input type="checkbox"
                            name="TicketTypeCCMSPORTIUMBGT">CCMSPORTIUMBGT<br><input type="checkbox"
                            name="TicketTypeSPORTIUMBGT">SPORTIUMBGT<br><input type="checkbox"
                            name="TicketTypeSPORTIUMBGT TicketController">SPORTIUMBGT
                        TicketController<br><input type="checkbox" name="TicketTypeCCMSASAFT">CCMSASAFT<br><input
                            type="checkbox" name="TicketTypeSASAFT TicketController">SASAFT TicketController<br><input
                            type="checkbox" name="TicketTypeCCMSASTITO">CCMSASTITO<br><input type="checkbox"
                            name="TicketTypeSASTITO TicketController">SASTITO
                        TicketController<br><input type="checkbox"
                            name="TicketTypeCCMTicketServer">CCMTicketServer<br><input type="checkbox"
                            name="TicketTypeTicketServerAPI">TicketServerAPI<br><input type="checkbox"
                            name="TicketTypeManual">Manual<br><input type="checkbox"
                            name="TicketTypeCCMLUCKIA1">CCMLUCKIA1<br><input type="checkbox"
                            name="TicketTypeLUCKIA1">LUCKIA1<br><input type="checkbox"
                            name="TicketTypeLUCKIA1 TicketController">LUCKIA1 TicketController<br><input type="checkbox"
                            name="TicketTypeCCMLUCKIA2">CCMLUCKIA2<br><input type="checkbox"
                            name="TicketTypeLUCKIA2">LUCKIA2<br><input type="checkbox"
                            name="TicketTypeLUCKIA2 TicketController">LUCKIA2 TicketController<br><input type="checkbox"
                            name="TicketTypeCCMLUCKIA3">CCMLUCKIA3<br><input type="checkbox"
                            name="TicketTypeLUCKIA3">LUCKIA3<br><input type="checkbox"
                            name="TicketTypeLUCKIA3 TicketController">LUCKIA3 TicketController<br><input type="checkbox"
                            name="TicketTypeCCMLUCKIA4">CCMLUCKIA4<br><input type="checkbox"
                            name="TicketTypeLUCKIA4">LUCKIA4<br><input type="checkbox"
                            name="TicketTypeLUCKIA4 TicketController">LUCKIA4 TicketController<br><input type="checkbox"
                            name="TicketTypeCCMLUCKIAOnline">CCMLUCKIAOnline<br><input type="checkbox"
                            name="TicketTypeLUCKIAOnline">LUCKIAOnline<br><input type="checkbox"
                            name="TicketTypeLUCKIAOnline TicketController">LUCKIAOnline
                        TicketController<br><input type="checkbox" name="TicketTypeCCMBWINBGT">CCMBWINBGT<br><input
                            type="checkbox" name="TicketTypeBWINBGT">BWINBGT<br><input type="checkbox"
                            name="TicketTypeBWINBGT TicketController">BWINBGT TicketController<br><input type="checkbox"
                            name="TicketTypeCCMGBG">CCMGBG<br><input type="checkbox" name="TicketTypeGBG">GBG<br><input
                            type="checkbox" name="TicketTypeGBG TicketController">GBG TicketController<br><input
                            type="checkbox" name="TicketTypeCCMFORWARDSYSTEMS">CCMFORWARDSYSTEMS<br><input
                            type="checkbox" name="TicketTypeFORWARDSYSTEMS">FORWARDSYSTEMS<br><input type="checkbox"
                            name="TicketTypeFORWARDSYSTEMS TicketController">FORWARDSYSTEMS
                        TicketController<br><input type="checkbox" name="TicketTypeCCMWIGOS">CCMWIGOS<br><input
                            type="checkbox" name="TicketTypeWIGOS">WIGOS<br><input type="checkbox"
                            name="TicketTypeWIGOS TicketController">WIGOS TicketController<br><input type="checkbox"
                            name="TicketTypeCCMONLINEGAMES">CCMONLINEGAMES<br><input type="checkbox"
                            name="TicketTypeONLINEGAMES">ONLINEGAMES<br><input type="checkbox"
                            name="TicketTypeONLINEGAMES TicketController">ONLINEGAMES
                        TicketController<br>Otros tipos de ticket (separados por comas):
                        <input type="textbox" name="CustomTicketTypesToSave" size="50" value=""
                            class="w-100"><br><br>
                    </div>

                    <!-- Checkboxes for additional options -->
                    <div class="col-md-4">
                        <b>Opciones Adicionales permitidas:</b>
                        <br>
                        <input type="checkbox" name="AdditionalOptionRecargaAuxiliar1">RecargaAuxiliar1<br><input
                            type="checkbox" name="AdditionalOptionRecargaAuxiliar2">RecargaAuxiliar2<br><input
                            type="checkbox" name="AdditionalOptionRecargaAuxiliar3">RecargaAuxiliar3<br><input
                            type="checkbox" name="AdditionalOptionRecargaAuxiliar4">RecargaAuxiliar4<br><input
                            type="checkbox" name="AdditionalOptionRecargaAuxiliar5">RecargaAuxiliar5<br><input
                            type="checkbox" name="AdditionalOptionPrestamoAuxiliar1">PrestamoAuxiliar1<br><input
                            type="checkbox" name="AdditionalOptionPrestamoAuxiliar2">PrestamoAuxiliar2<br><input
                            type="checkbox" name="AdditionalOptionPrestamoAuxiliar3">PrestamoAuxiliar3<br><input
                            type="checkbox" name="AdditionalOptionPrestamoAuxiliar4">PrestamoAuxiliar4<br><input
                            type="checkbox" name="AdditionalOptionPrestamoAuxiliar5">PrestamoAuxiliar5<br><input
                            type="checkbox" name="AdditionalOptionRecargasManuales">RecargasManuales<br><input
                            type="checkbox" name="AdditionalOptionRecaudaciones">Recaudaciones<br><input type="checkbox"
                            name="AdditionalOptionResetApuestas">ResetApuestas<br><input type="checkbox"
                            name="AdditionalOptionResetAuxiliares">ResetAuxiliares<br><input type="checkbox"
                            name="AdditionalOptionResetCajonVirtual">ResetCajonVirtual<br><input type="checkbox"
                            name="AdditionalOptionRecargaCajonVirtual1">RecargaCajonVirtual1<br><input type="checkbox"
                            name="AdditionalOptionRecargaCajonVirtual2">RecargaCajonVirtual2<br><input type="checkbox"
                            name="AdditionalOptionRecargaCajonVirtual3">RecargaCajonVirtual3<br><input type="checkbox"
                            name="AdditionalOptionRecargaCajonVirtual4">RecargaCajonVirtual4<br><input type="checkbox"
                            name="AdditionalOptionRecargaCajonVirtual5">RecargaCajonVirtual5<br><input type="checkbox"
                            name="AdditionalOptionRecargaAuxiliar6">RecargaAuxiliar6<br><input type="checkbox"
                            name="AdditionalOptionRecargaAuxiliar7">RecargaAuxiliar7<br><input type="checkbox"
                            name="AdditionalOptionRecargaAuxiliar8">RecargaAuxiliar8<br><input type="checkbox"
                            name="AdditionalOptionRecargaAuxiliar9">RecargaAuxiliar9<br><input type="checkbox"
                            name="AdditionalOptionRecargaAuxiliar10">RecargaAuxiliar10<br><input type="checkbox"
                            name="AdditionalOptionPrestamoAuxiliar6">PrestamoAuxiliar6<br><input type="checkbox"
                            name="AdditionalOptionPrestamoAuxiliar7">PrestamoAuxiliar7<br><input type="checkbox"
                            name="AdditionalOptionPrestamoAuxiliar8">PrestamoAuxiliar8<br><input type="checkbox"
                            name="AdditionalOptionPrestamoAuxiliar9">PrestamoAuxiliar9<br><input type="checkbox"
                            name="AdditionalOptionPrestamoAuxiliar10">PrestamoAuxiliar10<br><input type="checkbox"
                            name="AdditionalOptionTransferencias">Transferencias<br><input type="checkbox"
                            name="AdditionalOptionTransferenciaAuxiliar1">TransferenciaAuxiliar1<br><input type="checkbox"
                            name="AdditionalOptionTransferenciaAuxiliar2">TransferenciaAuxiliar2<br><input type="checkbox"
                            name="AdditionalOptionTransferenciaAuxiliar3">TransferenciaAuxiliar3<br><input type="checkbox"
                            name="AdditionalOptionTransferenciaAuxiliar4">TransferenciaAuxiliar4<br><input type="checkbox"
                            name="AdditionalOptionTransferenciaAuxiliar5">TransferenciaAuxiliar5<br><input type="checkbox"
                            name="AdditionalOptionTransferenciaAuxiliar6">TransferenciaAuxiliar6<br><input type="checkbox"
                            name="AdditionalOptionTransferenciaAuxiliar7">TransferenciaAuxiliar7<br><input type="checkbox"
                            name="AdditionalOptionTransferenciaAuxiliar8">TransferenciaAuxiliar8<br><input type="checkbox"
                            name="AdditionalOptionTransferenciaAuxiliar9">TransferenciaAuxiliar9<br><input type="checkbox"
                            name="AdditionalOptionTransferenciaAuxiliar10">TransferenciaAuxiliar10<br>Otras
                        opciones adicionales (separadas por comas): <input type="textbox"
                            name="CustomAdditionalOptionsToSave" size="50" value="" class="w-100"><br><br>
                    </div>
                </div>


                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Crear usuario</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const radioButtons = document.querySelectorAll('input[name="permisosTipo"]');
            const passwdField = document.querySelector('input[name="passwd"]');
            const sesionField = document.querySelector('select[name="sesion"]');
            const acordeonElement = document.getElementById('accordionExample');
            const additionalOptions = document.getElementById('additionalOptions');

            function handleRadioChange() {
                const selectedValue = document.querySelector('input[name="permisosTipo"]:checked').value;

                if (selectedValue === 'Otros') {
                    passwdField.disabled = false;
                    sesionField.disabled = false;
                    acordeonElement.style.display = 'block';
                    additionalOptions.style.display = 'flex';
                } else if (selectedValue === 'Desconocido') {
                    passwdField.disabled = true;
                    sesionField.disabled = true;
                    acordeonElement.style.display = 'none';
                    additionalOptions.style.display = 'none';
                } else {
                    passwdField.disabled = false;
                    sesionField.disabled = false;
                    acordeonElement.style.display = 'block';
                    additionalOptions.style.display = 'none';
                }
            }

            radioButtons.forEach(button => {
                button.addEventListener('change', handleRadioChange);
            });

            // Initialize the state based on the default selected value
            handleRadioChange();
        });
    </script>
@endsection
