@extends('plantilla.plantilla')
@section('titulo', 'Local')
@section('contenido')

    <div class="container">
        <div class="col-8 offset-2 isla-list p-4 mt-5">
            <div class="ttl text-center mb-4">
                <h1>Configurar Máquina de Cambio {{ $localConfig->name }}</h1>
            </div>

            <form action="{{ route('configuration.update', $id) }}" method="POST">
                @csrf
                @method('PUT')


                <!-- Campo MoneySymbol -->
                <div class="form-floating mb-3">
                    <input value="{{ old('MoneySymbol', $localConfig->MoneySymbol) }}" type="text" name="MoneySymbol" class="form-control"
                        id="floatingInput" placeholder="Símbolo monetario">
                    <label for="floatingInput">Símbolo monetario</label>
                    @if ($errors->has('MoneySymbol'))
                        <div class="text-danger" style="color: red">{{ $errors->first('MoneySymbol') }}</div>
                    @endif
                </div>

                <!-- Campo MoneyLowLimitToCreate -->
                <!--<div class="form-floating mb-3">
                    <input value="{{ old('MoneyLowLimitToCreate', $localConfig->MoneyLowLimitToCreate) }}" type="number" step="0.01"
                        name="MoneyLowLimitToCreate" class="form-control" id="floatingInput"
                        placeholder="Valor mínimo de creación">
                    <label for="floatingInput">Valor mínimo de creación</label>
                    @if ($errors->has('MoneyLowLimitToCreate'))
                        <div class="text-danger" style="color: red">{{ $errors->first('MoneyLowLimitToCreate') }}</div>
                    @endif
                </div>-->

                <!-- Campo MoneyAdaptLowValuesOnCreation -->
                <!--<div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="MoneyAdaptLowValuesOnCreation"
                        id="MoneyAdaptLowValuesOnCreation" value="1"
                        {{ old('MoneyAdaptLowValuesOnCreation', $localConfig->MoneyAdaptLowValuesOnCreation) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="MoneyAdaptLowValuesOnCreation">Adaptar valores impagables</label>
                    @if ($errors->has('MoneyAdaptLowValuesOnCreation'))
                        <div class="text-danger" style="color: red">{{ $errors->first('MoneyAdaptLowValuesOnCreation') }}
                        </div>
                    @endif
                </div>-->

                <!-- Campo MoneyLimitThatNeedsAuthorization -->
                <!--<div class="form-floating mb-3">
                    <input value="{{ old('MoneyLimitThatNeedsAuthorization', $localConfig->MoneyLimitThatNeedsAuthorization) }}" type="number" step="0.01"
                        name="MoneyLimitThatNeedsAuthorization" class="form-control" id="floatingInput"
                        placeholder="Límite hasta autorización">
                    <label for="floatingInput">Límite hasta autorización</label>
                    @if ($errors->has('MoneyLimitThatNeedsAuthorization'))
                        <div class="text-danger" style="color: red">{{ $errors->first('MoneyLimitThatNeedsAuthorization') }}
                        </div>
                    @endif
                </div>-->

                <!-- Campo MoneyLimitAbsolute -->
                <!--<div class="form-floating mb-3">
                    <input value="{{ old('MoneyLimitAbsolute', $localConfig->MoneyLimitAbsolute) }}" type="number" step="0.01"
                        name="MoneyLimitAbsolute" class="form-control" id="floatingInput"
                        placeholder="Límite máximo (0 = sin límite)">
                    <label for="floatingInput">Límite máximo (0 = sin límite)</label>
                    @if ($errors->has('MoneyLimitAbsolute'))
                        <div class="text-danger" style="color: red">{{ $errors->first('MoneyLimitAbsolute') }}</div>
                    @endif
                </div>-->

                <!-- Campo MoneyLimitInTypeBets -->
                <!--<div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="MoneyLimitInTypeBets" id="MoneyLimitInTypeBets"
                        value="1" {{ old('MoneyLimitInTypeBets', $localConfig->MoneyLimitInTypeBets) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="MoneyLimitInTypeBets">Límite en apuestas</label>
                    @if ($errors->has('MoneyLimitInTypeBets'))
                        <div class="text-danger" style="color: red">{{ $errors->first('MoneyLimitInTypeBets') }}</div>
                    @endif
                </div>-->

                <!-- Campo MoneyDenomination -->
                <!--<div class="form-floating mb-3">
                    <input value="{{ old('$MoneyDenomination', $localConfig->MoneyDenomination) }}" type="number" step="0.01"
                        name="MoneyDenomination" class="form-control" id="floatingInput" placeholder="Denominación de pago">
                    <label for="floatingInput">Denominación de pago</label>
                    @if ($errors->has('MoneyDenomination'))
                        <div class="text-danger" style="color: red">{{ $errors->first('MoneyDenomination') }}</div>
                    @endif
                </div>-->

                <!-- Campo RoundPartialPrizes -->
                <!--<div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="RoundPartialPrizes" id="RoundPartialPrizes"
                        value="1" {{ old('RoundPartialPrizes', $localConfig->RoundPartialPrizes) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="RoundPartialPrizes">Redondear pagos parciales</label>
                    @if ($errors->has('RoundPartialPrizes'))
                        <div class="text-danger" style="color: red">{{ $errors->first('RoundPartialPrizes') }}</div>
                    @endif
                </div>-->

                <!-- Campo RoundPartialPrizesValue -->
                <!--<div class="form-floating mb-3">
                    <input value="{{ old('RoundPartialPrizesValue', $localConfig->RoundPartialPrizesValue) }}" type="number" step="0.50"
                        name="RoundPartialPrizesValue" class="form-control" id="floatingInput"
                        placeholder="Valor de redondeo de premios parciales">
                    <label for="floatingInput">Valor de redondeo de premios parciales</label>
                    @if ($errors->has('RoundPartialPrizesValue'))
                        <div class="text-danger" style="color: red">{{ $errors->first('RoundPartialPrizesValue') }}</div>
                    @endif
                </div>-->

                <!-- Campo ExpirationDate -->
                <!--<div class="form-floating mb-3">
                    <input value="{{ old('ExpirationDate', $localConfig->ExpirationDate) }}" type="datetime-local"
                        name="ExpirationDate" class="form-control" id="floatingInput" placeholder="Fecha de expiración">
                    <label for="floatingInput">Fecha de expiración</label>
                    @if ($errors->has('ExpirationDate'))
                        <div class="text-danger" style="color: red">{{ $errors->first('ExpirationDate') }}</div>
                    @endif
                </div>-->

                <!-- Campo NumberOfDigits -->
                <!--<div class="form-floating mb-3">
                    <input value="{{ old('NumberOfDigits', $localConfig->NumberOfDigits) }}" type="number" name="NumberOfDigits"
                        class="form-control" id="floatingInput" placeholder="Número de dígitos">
                    <label for="floatingInput">Número de dígitos</label>
                    @if ($errors->has('NumberOfDigits'))
                        <div class="text-danger" style="color: red">{{ $errors->first('NumberOfDigits') }}</div>
                    @endif
                </div>-->

                <!-- Campo NewTicketNumberFormat -->
                <!--<div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="NewTicketNumberFormat"
                        id="NewTicketNumberFormat" value="1"
                        {{ old('NewTicketNumberFormat', $localConfig->NewTicketNumberFormat) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="NewTicketNumberFormat">Usar nuevo formato de ticket</label>
                    @if ($errors->has('NewTicketNumberFormat'))
                        <div class="text-danger" style="color: red">{{ $errors->first('NewTicketNumberFormat') }}</div>
                    @endif
                </div>-->

                <!-- Campo HeaderOfTicketNumber -->
                <!--<div class="form-floating mb-3">
                    <input value="{{ old('HeaderOfTicketNumber', $localConfig->HeaderOfTicketNumber) }}" type="text" name="HeaderOfTicketNumber"
                        class="form-control" id="floatingInput" placeholder="Forzar cabecera del ticket">
                    <label for="floatingInput">Forzar cabecera del ticket</label>
                    @if ($errors->has('HeaderOfTicketNumber'))
                        <div class="text-danger" style="color: red">{{ $errors->first('HeaderOfTicketNumber') }}</div>
                    @endif
                </div>-->

                <!-- Campo HoursBetweenAutopurges -->
                <!--<div class="form-floating mb-3">
                    <input value="{{ old('HoursBetweenAutopurges', $localConfig->HoursBetweenAutopurges) }}" type="number" name="HoursBetweenAutopurges"
                        class="form-control" id="floatingInput" placeholder="Autopurga cada (horas; 0 para desactivar)">
                    <label for="floatingInput">Autopurga cada (horas; 0 para desactivar)</label>
                    @if ($errors->has('HoursBetweenAutopurges'))
                        <div class="text-danger" style="color: red">{{ $errors->first('HoursBetweenAutopurges') }}</div>
                    @endif
                </div>-->

                <!-- Campo NumberOfEventsToAutopurge -->
                <!--<div class="form-floating mb-3">
                    <input value="{{ old('NumberOfEventsToAutopurge', $localConfig->NumberOfEventsToAutopurge) }}" type="number"
                        name="NumberOfEventsToAutopurge" class="form-control" id="floatingInput"
                        placeholder="Autopurga si número de eventos mayor que (0 para desactivar)">
                    <label for="floatingInput">Autopurga si número de eventos mayor que (0 para desactivar)</label>
                    @if ($errors->has('NumberOfEventsToAutopurge'))
                        <div class="text-danger" style="color: red">{{ $errors->first('NumberOfEventsToAutopurge') }}
                        </div>
                    @endif
                </div>-->

                <!-- Campo DaysToAutopurgeIfEventOlderThan -->
                <!--<div class="form-floating mb-3">
                    <input value="{{ old('DaysToAutopurgeIfEventOlderThan', $localConfig->DaysToAutopurgeIfEventOlderThan) }}" type="number"
                        name="DaysToAutopurgeIfEventOlderThan" class="form-control" id="floatingInput"
                        placeholder="Autopurgar eventos con antigüedad mayor que (días; 0 para desactivar)">
                    <label for="floatingInput">Autopurgar eventos con antigüedad mayor que (días; 0 para
                        desactivar)</label>
                    @if ($errors->has('DaysToAutopurgeIfEventOlderThan'))
                        <div class="text-danger" style="color: red">
                            {{ $errors->first('DaysToAutopurgeIfEventOlderThan') }}</div>
                    @endif
                </div>-->

                <!-- Campo AvatarsCachePath -->
                <!--<div class="form-floating mb-3">
                    <input value="{{ old('AvatarsCachePath', $localConfig->AvatarsCachePath) }}" type="text" name="AvatarsCachePath"
                        class="form-control" id="floatingInput" placeholder="Directorio de cache de Avatares">
                    <label for="floatingInput">Directorio de cache de Avatares</label>
                    @if ($errors->has('AvatarsCachePath'))
                        <div class="text-danger" style="color: red">{{ $errors->first('AvatarsCachePath') }}</div>
                    @endif
                </div>-->

                <!-- Campo AdvancedGUI -->
                <!--<div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="AdvancedGUI" id="AdvancedGUI" value="1"
                        {{ old('AdvancedGUI', $localConfig->AdvancedGUI) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="AdvancedGUI">Interfaz avanzada</label>
                    @if ($errors->has('AdvancedGUI'))
                        <div class="text-danger" style="color: red">{{ $errors->first('AdvancedGUI') }}</div>
                    @endif
                </div>-->

                <!-- Campo NumberOfItemsPerPage -->
                <!--<div class="form-floating mb-3">
                    <input value="{{ old('NumberOfItemsPerPage', $localConfig->NumberOfItemsPerPage) }}" type="number" name="NumberOfItemsPerPage"
                        class="form-control" id="floatingInput"
                        placeholder="Elementos por página en listados (0 implica sin límite)">
                    <label for="floatingInput">Elementos por página en listados (0 implica sin límite)</label>
                    @if ($errors->has('NumberOfItemsPerPage'))
                        <div class="text-danger" style="color: red">{{ $errors->first('NumberOfItemsPerPage') }}</div>
                    @endif
                </div>-->

                <!-- Campo BackupDBPath -->
                <!--<div class="form-floating mb-3">
                    <input value="{{ old('BackupDBPath', $localConfig->BackupDBPath) }}" type="text" name="BackupDBPath"
                        class="form-control" id="floatingInput"
                        placeholder="Ruta de copia de seguridad de la base de datos">
                    <label for="floatingInput">Ruta de copia de seguridad de la base de datos</label>
                    @if ($errors->has('BackupDBPath'))
                        <div class="text-danger" style="color: red">{{ $errors->first('BackupDBPath') }}</div>
                    @endif
                </div>-->

                <!-- Campo HoursBetweenBackupDB -->
                <!--<div class="form-floating mb-3">
                    <input value="{{ old('HoursBetweenBackupDB', $localConfig->HoursBetweenBackupDB) }}" type="number" name="HoursBetweenBackupDB"
                        class="form-control" id="floatingInput"
                        placeholder="Horas entre copias de seguridad de la base de datos">
                    <label for="floatingInput">Horas entre copias de seguridad de la base de datos</label>
                    @if ($errors->has('HoursBetweenBackupDB'))
                        <div class="text-danger" style="color: red">{{ $errors->first('HoursBetweenBackupDB') }}</div>
                    @endif
                </div>-->

                <!-- Campo DaysToKeepBackupDB -->
                <!--<div class="form-floating mb-3">
                    <input value="{{ old('DaysToKeepBackupDB', $localConfig->DaysToKeepBackupDB) }}" type="number" name="DaysToKeepBackupDB"
                        class="form-control" id="floatingInput"
                        placeholder="Días para mantener la copia de seguridad de la base de datos">
                    <label for="floatingInput">Días para mantener la copia de seguridad de la base de datos</label>
                    @if ($errors->has('DaysToKeepBackupDB'))
                        <div class="text-danger" style="color: red">{{ $errors->first('DaysToKeepBackupDB') }}</div>
                    @endif
                </div>-->

                <!-- Campo Aux1Limit -->
                <!--<div class="form-floating mb-3">
                    <input value="{{ old('Aux1Limit', $localConfig->Aux1Limit) }}" type="number" step="0.01" name="Aux1Limit"
                        class="form-control" id="floatingInput" placeholder="Límite saldo Recarga Auxiliar 1">
                    <label for="floatingInput">Límite saldo Recarga Auxiliar 1</label>
                    @if ($errors->has('Aux1Limit'))
                        <div class="text-danger" style="color: red">{{ $errors->first('Aux1Limit') }}</div>
                    @endif
                </div>-->

                <!-- Campo Aux2Limit -->
                <!--<div class="form-floating mb-3">
                    <input value="{{ old('Aux2Limit', $localConfig->Aux2Limit) }}" type="number" step="0.01" name="Aux2Limit"
                        class="form-control" id="floatingInput" placeholder="Límite saldo Recarga Auxiliar 2">
                    <label for="floatingInput">Límite saldo Recarga Auxiliar 2</label>
                    @if ($errors->has('Aux2Limit'))
                        <div class="text-danger" style="color: red">{{ $errors->first('Aux2Limit') }}</div>
                    @endif
                </div>-->

                <!-- Campo Aux3Limit -->
                <!--<div class="form-floating mb-3">
                    <input value="{{ old('Aux3Limit', $localConfig->Aux3Limit) }}" type="number" step="0.01" name="Aux3Limit"
                        class="form-control" id="floatingInput" placeholder="Límite saldo Recarga Auxiliar 3">
                    <label for="floatingInput">Límite saldo Recarga Auxiliar 3</label>
                    @if ($errors->has('Aux3Limit'))
                        <div class="text-danger" style="color: red">{{ $errors->first('Aux3Limit') }}</div>
                    @endif
                </div>-->

                <!-- Campo Aux4Limit -->
                <!--<div class="form-floating mb-3">
                    <input value="{{ old('Aux4Limit', $localConfig->Aux4Limit) }}" type="number" step="0.01" name="Aux4Limit"
                        class="form-control" id="floatingInput" placeholder="Límite saldo Recarga Auxiliar 4">
                    <label for="floatingInput">Límite saldo Recarga Auxiliar 4</label>
                    @if ($errors->has('Aux4Limit'))
                        <div class="text-danger" style="color: red">{{ $errors->first('Aux4Limit') }}</div>
                    @endif
                </div>-->

                <!-- Campo Aux5Limit -->
                <!--<div class="form-floating mb-3">
                    <input value="{{ old('Aux5Limit', $localConfig->Aux5Limit) }}" type="number" step="0.01" name="Aux5Limit"
                        class="form-control" id="floatingInput" placeholder="Límite saldo Recarga Auxiliar 5">
                    <label for="floatingInput">Límite saldo Recarga Auxiliar 5</label>
                    @if ($errors->has('Aux5Limit'))
                        <div class="text-danger" style="color: red">{{ $errors->first('Aux5Limit') }}</div>
                    @endif
                </div>-->

                <!-- Campo Aux6Limit -->
                <!--<div class="form-floating mb-3">
                    <input value="{{ old('Aux6Limit', $localConfig->Aux6Limit) }}" type="number" step="0.01" name="Aux6Limit"
                        class="form-control" id="floatingInput" placeholder="Límite saldo Recarga Auxiliar 6">
                    <label for="floatingInput">Límite saldo Recarga Auxiliar 6</label>
                    @if ($errors->has('Aux6Limit'))
                        <div class="text-danger" style="color: red">{{ $errors->first('Aux6Limit') }}</div>
                    @endif
                </div>-->

                <!-- Campo Aux7Limit -->
                <!--<div class="form-floating mb-3">
                    <input value="{{ old('Aux7Limit', $localConfig->Aux7Limit) }}" type="number" step="0.01" name="Aux7Limit"
                        class="form-control" id="floatingInput" placeholder="Límite saldo Recarga Auxiliar 7">
                    <label for="floatingInput">Límite saldo Recarga Auxiliar 7</label>
                    @if ($errors->has('Aux7Limit'))
                        <div class="text-danger" style="color: red">{{ $errors->first('Aux7Limit') }}</div>
                    @endif
                </div>-->

                <!-- Campo Aux8Limit -->
                <!--<div class="form-floating mb-3">
                    <input value="{{ old('Aux8Limit', $localConfig->Aux8Limit) }}" type="number" step="0.01" name="Aux8Limit"
                        class="form-control" id="floatingInput" placeholder="Límite saldo Recarga Auxiliar 8">
                    <label for="floatingInput">Límite saldo Recarga Auxiliar 8</label>
                    @if ($errors->has('Aux8Limit'))
                        <div class="text-danger" style="color: red">{{ $errors->first('Aux8Limit') }}</div>
                    @endif
                </div>-->

                <!-- Campo Aux9Limit -->
                <!--<div class="form-floating mb-3">
                    <input value="{{ old('Aux9Limit', $localConfig->Aux9Limit) }}" type="number" step="0.01" name="Aux9Limit"
                        class="form-control" id="floatingInput" placeholder="Límite saldo Recarga Auxiliar 9">
                    <label for="floatingInput">Límite saldo Recarga Auxiliar 9</label>
                    @if ($errors->has('Aux9Limit'))
                        <div class="text-danger" style="color: red">{{ $errors->first('Aux9Limit') }}</div>
                    @endif
                </div>-->

                <!-- Campo Aux10Limit -->
                <!--<div class="form-floating mb-3">
                    <input value="{{ old('Aux10Limit', $localConfig->Aux10Limit) }}" type="number" step="0.01" name="Aux10Limit"
                        class="form-control" id="floatingInput" placeholder="Límite saldo Recarga Auxiliar 10">
                    <label for="floatingInput">Límite saldo Recarga Auxiliar 10</label>
                    @if ($errors->has('Aux10Limit'))
                        <div class="text-danger" style="color: red">{{ $errors->first('Aux10Limit') }}</div>
                    @endif
                </div>-->

                <!-- Campo HideOnTCFilter -->
                <!--<div class="form-floating mb-3">
                    <textarea name="HideOnTCFilter" class="form-control" id="floatingTextarea" placeholder="Filtro HideOnTC">{{ old('HideOnTCFilter', $localConfig->HideOnTCFilter) }}</textarea>
                    <label for="floatingTextarea">Filtro HideOnTC</label>
                    @if ($errors->has('HideOnTCFilter'))
                        <div class="text-danger" style="color: red">{{ $errors->first('HideOnTCFilter') }}</div>
                    @endif
                </div>-->

                <!-- Campo ShowCloseOnlyFromIPs -->
                <!--<div class="form-floating mb-3">
                    <input value="{{ old('ShowCloseOnlyFromIPs', $localConfig->ShowCloseOnlyFromIPs) }}" type="text"
                        name="ShowCloseOnlyFromIPs" class="form-control" id="floatingInput"
                        placeholder="Solo mostrar Tickets cerrados en estas direcciones (separar con comas)">
                    <label for="floatingInput">Solo mostrar Tickets cerrados en estas direcciones (separar con
                        comas)</label>
                    @if ($errors->has('ShowCloseOnlyFromIPs'))
                        <div class="text-danger" style="color: red">{{ $errors->first('ShowCloseOnlyFromIPs') }}</div>
                    @endif
                </div>-->

                <!-- Campo ForceAllowExports -->
                <!--<div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="ForceAllowExports" id="ForceAllowExports"
                        value="1" {{ old('ForceAllowExports', $localConfig->ForceAllowExports) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="ForceAllowExports">Habilitar funciones de exportado desde
                        navegador de cajero</label>
                    @if ($errors->has('ForceAllowExports'))
                        <div class="text-danger" style="color: red">{{ $errors->first('ForceAllowExports') }}</div>
                    @endif
                </div>-->

                <!-- Campo AllowIPs -->
                <!--<div class="form-floating mb-3">
                    <textarea name="AllowIPs" class="form-control" id="AllowIPsTextarea"
                        placeholder="Lista de IPs permitidas (separar con comas o salto de línea)">{{ old('AllowIPs', $localConfig->AllowIPs) }}</textarea>
                    <label for="AllowIPsTextarea">Lista de IPs permitidas (separar con comas o salto de línea)</label>
                    @if ($errors->has('AllowIPs'))
                        <div class="text-danger" style="color: red">{{ $errors->first('AllowIPs') }}</div>
                    @endif
                </div>-->

                <!-- Campo AutoAddIPsToBan -->
                <!--<div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="AutoAddIPsToBan" id="AutoAddIPsToBan"
                        value="1" {{ old('AutoAddIPsToBan', $localConfig->AutoAddIPsToBan) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="AutoAddIPsToBan">Auto añadir IPs de peticiones no validas a
                        'Lista de IPs prohibidas'</label>
                    @if ($errors->has('AutoAddIPsToBan'))
                        <div class="text-danger" style="color: red">{{ $errors->first('AutoAddIPsToBan') }}</div>
                    @endif
                </div>-->

                <!-- Campo BanIPs -->
                <!--<div class="form-floating mb-3">
                    <textarea name="BanIPs" class="form-control" id="BanIPsTextarea"
                        placeholder="Lista de IPs prohibidas (separar con comas o salto de línea)">{{ old('BanIPs', $localConfig->BanIPs) }}</textarea>
                    <label for="BanIPsTextarea">Lista de IPs prohibidas (separar con comas o salto de línea)</label>
                    @if ($errors->has('BanIPs'))
                        <div class="text-danger" style="color: red">{{ $errors->first('BanIPs') }}</div>
                    @endif
                </div>-->

                <!-- Campo AllowMACs -->
                <!--<div class="form-floating mb-3">
                    <textarea name="AllowMACs" class="form-control" id="AllowMACsTextarea"
                        placeholder="Lista de MACs permitidas (separar con comas o salto de línea)">{{ old('AllowMACs', $localConfig->AllowMACs) }}</textarea>
                    <label for="AllowMACsTextarea">Lista de MACs permitidas (separar con comas o salto de línea)</label>
                    @if ($errors->has('AllowMACs'))
                        <div class="text-danger" style="color: red">{{ $errors->first('AllowMACs') }}</div>
                    @endif
                </div>-->

                <!-- Campo AutoAddMACsToBan -->
                <!--<div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="AutoAddMACsToBan" id="AutoAddMACsToBan"
                        value="1" {{ old('AutoAddMACsToBan', $localConfig->AutoAddMACsToBan) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="AutoAddMACsToBan">Auto agregar MACs a bloqueados</label>
                    @if ($errors->has('AutoAddMACsToBan'))
                        <div class="text-danger" style="color: red">{{ $errors->first('AutoAddMACsToBan') }}</div>
                    @endif
                </div>-->

                <!-- Campo BanMACs -->
                <!--<div class="form-floating mb-3">
                    <textarea name="BanMACs" class="form-control" id="BanMACsTextarea"
                        placeholder="Lista de MACs prohibidas (separar con comas o salto de línea)">{{ old('BanMACs', $localConfig->BanMACs) }}</textarea>
                    <label for="BanMACsTextarea">Lista de MACs prohibidas (separar con comas o salto de línea)</label>
                    @if ($errors->has('BanMACs'))
                        <div class="text-danger" style="color: red">{{ $errors->first('BanMACs') }}</div>
                    @endif
                </div>-->

                <!-- Campo AllowTicketTypes -->
                <!--<div class="form-floating mb-3">
                    <textarea name="AllowTicketTypes" class="form-control" id="AllowTicketTypesTextarea"
                        placeholder="Lista de Tipos de Tickets permitidos (separar con comas o salto de línea)">{{ old('AllowTicketTypes', $localConfig->AllowTicketTypes) }}</textarea>
                    <label for="AllowTicketTypesTextarea">Lista de Tipos de Tickets permitidos (separar con comas o salto
                        de línea)</label>
                    @if ($errors->has('AllowTicketTypes'))
                        <div class="text-danger" style="color: red">{{ $errors->first('AllowTicketTypes') }}</div>
                    @endif
                </div>-->

                <!-- Campo BanTicketTypes -->
                <!--<div class="form-floating mb-3">
                    <textarea name="BanTicketTypes" class="form-control" id="BanTicketTypesTextarea"
                        placeholder="Lista de Tipos de Tickets prohibidos (separar con comas o salto de línea)">{{ old('BanTicketTypes', $localConfig->BanTicketTypes) }}</textarea>
                    <label for="BanTicketTypesTextarea">Lista de Tipos de Tickets prohibidos (separar con comas o salto de
                        línea)</label>
                    @if ($errors->has('BanTicketTypes'))
                        <div class="text-danger" style="color: red">{{ $errors->first('BanTicketTypes') }}</div>
                    @endif
                </div>-->

                <h5>Filtro 1</h5>

                <!-- Campo OnCloseTicketTypeIPCreation1 -->
                <!--<div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="OnCloseTicketTypeIPCreation1"
                        id="OnCloseTicketTypeIPCreation1" value="1"
                        {{ old('OnCloseTicketTypeIPCreation1', $localConfig->OnCloseTicketTypeIPCreation1) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label"
                        for="OnCloseTicketTypeIPCreation1">Usar IP de creación</label>
                    @if ($errors->has('OnCloseTicketTypeIPCreation1'))
                        <div class="text-danger" style="color: red">{{ $errors->first('OnCloseTicketTypeIPCreation1') }}
                        </div>
                    @endif
                </div>-->

                <!-- Campo OnCloseTicketTypeFilter1 -->
                <!--<div class="form-floating mb-3">
                    <textarea name="OnCloseTicketTypeFilter1" class="form-control" id="OnCloseTicketTypeFilter1Textarea"
                        placeholder="OnCloseTicketTypeFilter1">{{ old('OnCloseTicketTypeFilter1', $localConfig->OnCloseTicketTypeFilter1) }}</textarea>
                    <label for="OnCloseTicketTypeFilter1Textarea">Lista de tipos de tickets para este filtro (separar con comas o salto de línea)</label>
                    @if ($errors->has('OnCloseTicketTypeFilter1'))
                        <div class="text-danger" style="color: red">{{ $errors->first('OnCloseTicketTypeFilter1') }}
                        </div>
                    @endif
                </div>-->

                <!-- Campo OnCloseTicketTypeAllowIPs1 -->
                <!--<div class="form-floating mb-3">
                    <textarea name="OnCloseTicketTypeAllowIPs1" class="form-control" id="OnCloseTicketTypeAllowIPs1Textarea"
                        placeholder="OnCloseTicketTypeAllowIPs1">{{ old('OnCloseTicketTypeAllowIPs1', $localConfig->OnCloseTicketTypeAllowIPs1) }}</textarea>
                    <label for="OnCloseTicketTypeAllowIPs1Textarea">Lista de IPs permitidas (separar con comas o salto de línea)</label>
                    @if ($errors->has('OnCloseTicketTypeAllowIPs1'))
                        <div class="text-danger" style="color: red">{{ $errors->first('OnCloseTicketTypeAllowIPs1') }}
                        </div>
                    @endif
                </div>-->

                <!-- Campo OnCloseTicketTypeBanIPs1 -->
                <!--<div class="form-floating mb-3">
                    <textarea name="OnCloseTicketTypeBanIPs1" class="form-control" id="OnCloseTicketTypeBanIPs1Textarea"
                        placeholder="OnCloseTicketTypeBanIPs1">{{ old('OnCloseTicketTypeBanIPs1', $localConfig->OnCloseTicketTypeBanIPs1) }}</textarea>
                    <label for="OnCloseTicketTypeBanIPs1Textarea">Lista de IPs prohibidas (separar con comas o salto de línea)</label>
                    @if ($errors->has('OnCloseTicketTypeBanIPs1'))
                        <div class="text-danger" style="color: red">{{ $errors->first('OnCloseTicketTypeBanIPs1') }}
                        </div>
                    @endif
                </div>-->

                <h5>Filtro 2</h5>

                <!-- Campo OnCloseTicketTypeIPCreation2 -->
                <!--<div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="OnCloseTicketTypeIPCreation2"
                        id="OnCloseTicketTypeIPCreation2" value="1"
                        {{ old('OnCloseTicketTypeIPCreation2', $localConfig->OnCloseTicketTypeIPCreation2) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label"
                        for="OnCloseTicketTypeIPCreation2">Usar IP de creación</label>
                    @if ($errors->has('OnCloseTicketTypeIPCreation2'))
                        <div class="text-danger" style="color: red">{{ $errors->first('OnCloseTicketTypeIPCreation2') }}
                        </div>
                    @endif
                </div>-->

                <!-- Campo OnCloseTicketTypeFilter2 -->
                <!--<div class="form-floating mb-3">
                    <textarea name="OnCloseTicketTypeFilter2" class="form-control" id="OnCloseTicketTypeFilter2Textarea"
                        placeholder="OnCloseTicketTypeFilter2">{{ old('OnCloseTicketTypeFilter2', $localConfig->OnCloseTicketTypeFilter2) }}</textarea>
                    <label for="OnCloseTicketTypeFilter2Textarea">Lista de tipos de tickets para este filtro (separar con comas o salto de línea)</label>
                    @if ($errors->has('OnCloseTicketTypeFilter2'))
                        <div class="text-danger" style="color: red">{{ $errors->first('OnCloseTicketTypeFilter2') }}
                        </div>
                    @endif
                </div>-->

                <!-- Campo OnCloseTicketTypeAllowIPs2 -->
                <!--<div class="form-floating mb-3">
                    <textarea name="OnCloseTicketTypeAllowIPs2" class="form-control" id="OnCloseTicketTypeAllowIPs2Textarea"
                        placeholder="OnCloseTicketTypeAllowIPs2">{{ old('OnCloseTicketTypeAllowIPs2', $localConfig->OnCloseTicketTypeAllowIPs2) }}</textarea>
                    <label for="OnCloseTicketTypeAllowIPs2Textarea">Lista de IPs permitidas (separar con comas o salto de línea)</label>
                    @if ($errors->has('OnCloseTicketTypeAllowIPs2'))
                        <div class="text-danger" style="color: red">{{ $errors->first('OnCloseTicketTypeAllowIPs2') }}
                        </div>
                    @endif
                </div>-->

                <!-- Campo OnCloseTicketTypeBanIPs2 -->
                <!--<div class="form-floating mb-3">
                    <textarea name="OnCloseTicketTypeBanIPs2" class="form-control" id="OnCloseTicketTypeBanIPs2Textarea"
                        placeholder="OnCloseTicketTypeBanIPs2">{{ old('OnCloseTicketTypeBanIPs2', $localConfig->OnCloseTicketTypeBanIPs2) }}</textarea>
                    <label for="OnCloseTicketTypeBanIPs2Textarea">Lista de IPs prohibidas (separar con comas o salto de línea)</label>
                    @if ($errors->has('OnCloseTicketTypeBanIPs2'))
                        <div class="text-danger" style="color: red">{{ $errors->first('OnCloseTicketTypeBanIPs2') }}
                        </div>
                    @endif
                </div>-->

                <h5>Filtro 3</h5>

                <!-- Campo OnCloseTicketTypeIPCreation3 -->
                <!--<div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="OnCloseTicketTypeIPCreation3"
                        id="OnCloseTicketTypeIPCreation3" value="1"
                        {{ old('OnCloseTicketTypeIPCreation3', $localConfig->OnCloseTicketTypeIPCreation3) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label"
                        for="OnCloseTicketTypeIPCreation3">Usar IP de creación</label>
                    @if ($errors->has('OnCloseTicketTypeIPCreation3'))
                        <div class="text-danger" style="color: red">{{ $errors->first('OnCloseTicketTypeIPCreation3') }}
                        </div>
                    @endif
                </div>-->

                <!-- Campo OnCloseTicketTypeFilter3 -->
                <!--<div class="form-floating mb-3">
                    <textarea name="OnCloseTicketTypeFilter3" class="form-control" id="OnCloseTicketTypeFilter3Textarea"
                        placeholder="OnCloseTicketTypeFilter3">{{ old('OnCloseTicketTypeFilter3', $localConfig->OnCloseTicketTypeFilter3) }}</textarea>
                    <label for="OnCloseTicketTypeFilter3Textarea">Lista de tipos de tickets para este filtro (separar con comas o salto de línea)</label>
                    @if ($errors->has('OnCloseTicketTypeFilter3'))
                        <div class="text-danger" style="color: red">{{ $errors->first('OnCloseTicketTypeFilter3') }}
                        </div>
                    @endif
                </div>-->

                <!-- Campo OnCloseTicketTypeAllowIPs3 -->
                <!--<div class="form-floating mb-3">
                    <textarea name="OnCloseTicketTypeAllowIPs3" class="form-control" id="OnCloseTicketTypeAllowIPs3Textarea"
                        placeholder="OnCloseTicketTypeAllowIPs3">{{ old('OnCloseTicketTypeAllowIPs3', $localConfig->OnCloseTicketTypeAllowIPs3) }}</textarea>
                    <label for="OnCloseTicketTypeAllowIPs3Textarea">Lista de IPs permitidas (separar con comas o salto de línea)</label>
                    @if ($errors->has('OnCloseTicketTypeAllowIPs3'))
                        <div class="text-danger" style="color: red">{{ $errors->first('OnCloseTicketTypeAllowIPs3') }}
                        </div>
                    @endif
                </div>-->

                <!-- Campo OnCloseTicketTypeBanIPs3 -->
                <!--<div class="form-floating mb-3">
                    <textarea name="OnCloseTicketTypeBanIPs3" class="form-control" id="OnCloseTicketTypeBanIPs3Textarea"
                        placeholder="OnCloseTicketTypeBanIPs3">{{ old('OnCloseTicketTypeBanIPs3', $localConfig->OnCloseTicketTypeBanIPs3) }}</textarea>
                    <label for="OnCloseTicketTypeBanIPs3Textarea">Lista de IPs prohibidas (separar con comas o salto de línea)</label>
                    @if ($errors->has('OnCloseTicketTypeBanIPs3'))
                        <div class="text-danger" style="color: red">{{ $errors->first('OnCloseTicketTypeBanIPs3') }}
                        </div>
                    @endif
                </div>-->

                <h5>Filtro 4</h5>

                <!-- Campo OnCloseTicketTypeIPCreation4 -->
                <!--<div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="OnCloseTicketTypeIPCreation4"
                        id="OnCloseTicketTypeIPCreation4" value="1"
                        {{ old('OnCloseTicketTypeIPCreation4', $localConfig->OnCloseTicketTypeIPCreation4) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label"
                        for="OnCloseTicketTypeIPCreation4">Usar IP de creación</label>
                    @if ($errors->has('OnCloseTicketTypeIPCreation4'))
                        <div class="text-danger" style="color: red">{{ $errors->first('OnCloseTicketTypeIPCreation4') }}
                        </div>
                    @endif
                </div>-->

                <!-- Campo OnCloseTicketTypeFilter4 -->
                <!--<div class="form-floating mb-3">
                    <textarea name="OnCloseTicketTypeFilter4" class="form-control" id="OnCloseTicketTypeFilter4Textarea"
                        placeholder="OnCloseTicketTypeFilter4">{{ old('OnCloseTicketTypeFilter4', $localConfig->OnCloseTicketTypeFilter4) }}</textarea>
                    <label for="OnCloseTicketTypeFilter4Textarea">Lista de tipos de tickets para este filtro (separar con comas o salto de línea)</label>
                    @if ($errors->has('OnCloseTicketTypeFilter4'))
                        <div class="text-danger" style="color: red">{{ $errors->first('OnCloseTicketTypeFilter4') }}
                        </div>
                    @endif
                </div>-->

                <!-- Campo OnCloseTicketTypeAllowIPs4 -->
                <!--<div class="form-floating mb-3">
                    <textarea name="OnCloseTicketTypeAllowIPs4" class="form-control" id="OnCloseTicketTypeAllowIPs4Textarea"
                        placeholder="OnCloseTicketTypeAllowIPs4">{{ old('OnCloseTicketTypeAllowIPs4', $localConfig->OnCloseTicketTypeAllowIPs4) }}</textarea>
                    <label for="OnCloseTicketTypeAllowIPs4Textarea">Lista de IPs permitidas (separar con comas o salto de línea)</label>
                    @if ($errors->has('OnCloseTicketTypeAllowIPs4'))
                        <div class="text-danger" style="color: red">{{ $errors->first('OnCloseTicketTypeAllowIPs4') }}
                        </div>
                    @endif
                </div>-->

                <!-- Campo OnCloseTicketTypeBanIPs4 -->
                <!--<div class="form-floating mb-3">
                    <textarea name="OnCloseTicketTypeBanIPs4" class="form-control" id="OnCloseTicketTypeBanIPs4Textarea"
                        placeholder="OnCloseTicketTypeBanIPs4">{{ old('OnCloseTicketTypeBanIPs4', $localConfig->OnCloseTicketTypeBanIPs4) }}</textarea>
                    <label for="OnCloseTicketTypeBanIPs4Textarea">Lista de IPs prohibidas (separar con comas o salto de línea)</label>
                    @if ($errors->has('OnCloseTicketTypeBanIPs4'))
                        <div class="text-danger" style="color: red">{{ $errors->first('OnCloseTicketTypeBanIPs4') }}
                        </div>
                    @endif
                </div>-->

                <h5>Filtro 5</h5>

                <!-- Campo OnCloseTicketTypeIPCreation5 -->
                <!--<div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="OnCloseTicketTypeIPCreation5"
                        id="OnCloseTicketTypeIPCreation5" value="1"
                        {{ old('OnCloseTicketTypeIPCreation5', $localConfig->OnCloseTicketTypeIPCreation5) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label"
                        for="OnCloseTicketTypeIPCreation5">Usar IP de creación</label>
                    @if ($errors->has('OnCloseTicketTypeIPCreation5'))
                        <div class="text-danger" style="color: red">{{ $errors->first('OnCloseTicketTypeIPCreation5') }}
                        </div>
                    @endif
                </div>-->

                <!-- Campo OnCloseTicketTypeFilter5 -->
                <!--<div class="form-floating mb-3">
                    <textarea name="OnCloseTicketTypeFilter5" class="form-control" id="OnCloseTicketTypeFilter5Textarea"
                        placeholder="OnCloseTicketTypeFilter5">{{ old('OnCloseTicketTypeFilter5', $localConfig->OnCloseTicketTypeFilter5) }}</textarea>
                    <label for="OnCloseTicketTypeFilter5Textarea">Lista de tipos de tickets para este filtro (separar con comas o salto de línea)</label>
                    @if ($errors->has('OnCloseTicketTypeFilter5'))
                        <div class="text-danger" style="color: red">{{ $errors->first('OnCloseTicketTypeFilter5') }}
                        </div>
                    @endif
                </div>-->

                <!-- Campo OnCloseTicketTypeAllowIPs5 -->
                <!--<div class="form-floating mb-3">
                    <textarea name="OnCloseTicketTypeAllowIPs5" class="form-control" id="OnCloseTicketTypeAllowIPs5Textarea"
                        placeholder="OnCloseTicketTypeAllowIPs5">{{ old('OnCloseTicketTypeAllowIPs5', $localConfig->OnCloseTicketTypeAllowIPs5) }}</textarea>
                    <label for="OnCloseTicketTypeAllowIPs5Textarea">Lista de IPs permitidas (separar con comas o salto de línea)</label>
                    @if ($errors->has('OnCloseTicketTypeAllowIPs5'))
                        <div class="text-danger" style="color: red">{{ $errors->first('OnCloseTicketTypeAllowIPs5') }}
                        </div>
                    @endif
                </div>-->

                <!-- Campo OnCloseTicketTypeBanIPs5 -->
                <!--<div class="form-floating mb-3">
                    <textarea name="OnCloseTicketTypeBanIPs5" class="form-control" id="OnCloseTicketTypeBanIPs5Textarea"
                        placeholder="OnCloseTicketTypeBanIPs5">{{ old('OnCloseTicketTypeBanIPs5', $localConfig->OnCloseTicketTypeBanIPs5) }}</textarea>
                    <label for="OnCloseTicketTypeBanIPs5Textarea">Lista de IPs prohibidas (separar con comas o salto de línea)</label>
                    @if ($errors->has('OnCloseTicketTypeBanIPs5'))
                        <div class="text-danger" style="color: red">{{ $errors->first('OnCloseTicketTypeBanIPs5') }}
                        </div>
                    @endif
                </div>-->


                <!-- Botón para guardar cambios -->
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>

    </body>

    </html>


@endsection
