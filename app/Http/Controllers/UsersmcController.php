<?php

namespace App\Http\Controllers;

use App\Models\Delegation;
use App\Models\Local;
use App\Models\UserTicketServer;
use App\Models\lastUserMcDate;

use App\Models\Zone;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UsersmcController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showUsersmc($delegationId)
    {
        $delegation = Delegation::with('zones.locals.usersTicketServer')->find($delegationId);
        $usersmc = $delegation->usersTicketServer()->orderBy('User', 'ASC')->paginate(16);

        $lastFecha = lastUserMcDate::where('delegation_id', $delegationId)->first();
        //dd($usersmc);
        //$usersmc = $usersmc->sortBy('User');
        return view('usersmc.index', compact('usersmc', 'delegation', 'lastFecha'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $delegation = Delegation::with('zones.locals')->find($id);
        return view('usersmc.create', compact('delegation'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());

        $request->validate([
            'name' => ['required'],
            'nameReal' => ['required'],
            'PID' => ['required'],
            'permisosTipo' => ['required'],
            'delegation_id' => ['required'],
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'nameReal.required' => 'El nombre real es obligatorio.',
            'PID.required' => 'El PID es obligatorio.',
            'permisosTipo.required' => 'El tipo de permiso es obligatorio.',
            'delegation_id.required' => 'La delegación es obligatoria.',
        ]);



        // Validar si el PID ya existe en la base de datos local
        if ($request->filled('PID')) {
            $allUsers = UserTicketServer::all();

            foreach ($allUsers as $user) {
                if ($user->PID != '') {
                    $decryptPid = Crypt::decrypt($user->PID);
                    if ($decryptPid == $request->input('PID') && $request->input('PID') != '') {
                        return redirect()->back()->withErrors(['PID' => 'El PID ya está en uso.'])->withInput();
                    }
                }
            }
        }

        //try {
        $data = [
            'User' => $request->name,
            'Password' => $request->passwd,
            'PIN' => $request->passwd,
            'SessionType' => $request->sesion
        ];

        if ($request->permisosTipo == "Desconocido") {

            $data = [
                'User' => $request->name,
                'Password' => '1234',
                'PIN' => '1234',
                'SessionType' => -1
            ];
        }

        if ($request->filled('PID')) {
            $data['PID'] = $request->PID;
        }


        // Derechos disponibles
        $allPermisos = "ALL, CONFIRMTICKET, PRINTTICKET, LISTTICKETS, LISTTICKETSPENDING, LISTCONFIRMTICKETS, REPORTTICKETS, COLLECT, CREATETICKET, GETANDCLOSETICKET, ABORTTICKET, EXPIRETICKET, DELETETICKET, PURGETICKETS, EXPORTTICKETS, UPDATECOLLECT, DELETECOLLECT, ACCOUNTING, UPDATEACCOUNTING, DELETEACCOUNTING, ADDUSER, DELETEUSER, EDITUSER, GETUSER, LISTUSERS, EXPORTUSERS, IMPORTUSERS, EDITCONFIG, LOGS, LISTLOGS, PURGUELOGS, EXPORTLOGS, USETICKET, LISTTICKETSUSED, BACKUPDB, RESTOREDB, EDITUSERBALANCE, RESETUSERBALANCE, LISTUSERBALANCE, ADDPLAYER, DELETEPLAYER, EDITPLAYER, LISTPLAYERS, STATISTICS, AUXMONEYSTORAGE, UPDATEAUXMONEYSTORAGE, DELETEAUXMONEYSTORAGE, LISTHIDDENTICKETS, BETMONEYSTORAGE, UPDATEBETMONEYSTORAGE, DELETEBETMONEYSTORAGE, PURGEDB, UPDATETICKETSSTATUS, UPDATETICKETSAUX, HIDEONTC, CASHLESS";
        $allPermisosArray = explode(", ", $allPermisos);

        // Procesar derechos seleccionados
        $permisosUser = "";
        foreach ($allPermisosArray as $permiso) {
            $p = $request->input('Right' . $permiso);
            if ($p == "on") {
                if ($permisosUser != "") {
                    $permisosUser .= ", ";
                }
                $permisosUser .= $permiso;
            }
        }

        // Derechos disponibles
        $allTypes = "ALL, CCMCODERE, CODERE, CODERE_TicketController, CCMBWIN, BWIN, BWIN_TicketController, CCMORENES, ORENES, ORENES_TicketController, CCMKIROLSOFT, KIROLSOFT, KIROLSOFT_TicketController, CCMRETA, RETA, RETA_TicketController, CCMEGASA, EGASA, EGASA_TicketController, CCMIPS, IPS, IPS_TicketController, IPSServer, IPXServer, MGA, SMC, NEMESYS, SQL, TECNAUSA, TEYSA, VAN, CCMGTECH, GTECH, GTECH_TicketController, CCMGTECH2, GTECH2, GTECH2_TicketController, CCMSPORTIUM, SPORTIUM, SPORTIUM_TicketController, CCMSPORTIUMBGT, SPORTIUMBGT, SPORTIUMBGT_TicketController, CCMSASAFT, SASAFT_TicketController, CCMSASTITO, SASTITO_TicketController, CCMTicketServer, TicketServerAPI, Manual, CCMLUCKIA1, LUCKIA1, LUCKIA1_TicketController, CCMLUCKIA2, LUCKIA2, LUCKIA2_TicketController, CCMLUCKIA3, LUCKIA3, LUCKIA3_TicketController, CCMLUCKIA4, LUCKIA4, LUCKIA4_TicketController, CCMLUCKIAOnline, LUCKIAOnline, LUCKIAOnline_TicketController, CCMBWINBGT, BWINBGT, BWINBGT_TicketController, CCMGBG, GBG, GBG_TicketController, CCMFORWARDSYSTEMS, FORWARDSYSTEMS, FORWARDSYSTEMS_TicketController, CCMWIGOS, WIGOS, WIGOS_TicketController, CCMONLINEGAMES, ONLINEGAMES, ONLINEGAMES_TicketController";
        $allTypesArray = explode(", ", $allTypes);

        // Procesar derechos seleccionados
        $typesUser = "";
        foreach ($allTypesArray as $type) {
            $p = $request->input('TicketType' . $type);
            if ($p == "on") {
                if ($typesUser != "") {
                    $typesUser .= ", ";
                }
                $typesUser .= $type;
            }
        }


        // Derechos disponibles
        $allAditionalOptions = "RecargaAuxiliar1, RecargaAuxiliar2, RecargaAuxiliar3, RecargaAuxiliar4, RecargaAuxiliar5, PrestamoAuxiliar1, PrestamoAuxiliar2, PrestamoAuxiliar3, PrestamoAuxiliar4, PrestamoAuxiliar5, RecargasManuales, Recaudaciones, ResetApuestas, ResetAuxiliares, ResetCajonVirtual, RecargaCajonVirtual1, RecargaCajonVirtual2, RecargaCajonVirtual3, RecargaCajonVirtual4, RecargaCajonVirtual5, RecargaAuxiliar6, RecargaAuxiliar7, RecargaAuxiliar8, RecargaAuxiliar9, RecargaAuxiliar10, PrestamoAuxiliar6, PrestamoAuxiliar7, PrestamoAuxiliar8, PrestamoAuxiliar9, PrestamoAuxiliar10, Transferencias, TransferenciaAuxiliar1, TransferenciaAuxiliar2, TransferenciaAuxiliar3, TransferenciaAuxiliar4, TransferenciaAuxiliar5, TransferenciaAuxiliar6, TransferenciaAuxiliar7, TransferenciaAuxiliar8, TransferenciaAuxiliar9, TransferenciaAuxiliar10";
        $allAditionalOptionsArray = explode(", ", $allAditionalOptions);

        // Procesar derechos seleccionados
        $aditionalOptionsUser = "";
        foreach ($allAditionalOptionsArray as $option) {
            $p = $request->input('AdditionalOption' . $option);
            if ($p == "on") {
                if ($aditionalOptionsUser != "") {
                    $aditionalOptionsUser .= ", ";
                }
                $aditionalOptionsUser .= $option;
            }
        }


        // Asignar derechos según el tipo de permiso
        if ($request->permisosTipo == "Tecnico") {
            $data['Rights'] = "CONFIRMTICKET, PRINTTICKET, LISTTICKETS, LISTTICKETSPENDING, LISTCONFIRMTICKETS, REPORTTICKETS";
            $data['AdditionalOptionsAllowed'] = "RecargaAuxiliar1, RecargaAuxiliar2, RecargaAuxiliar3, RecargaAuxiliar4, RecargaAuxiliar5, RecargasManuales, Recaudaciones, ResetApuestas, ResetAuxiliares, RecargaAuxiliar6, RecargaAuxiliar7, RecargaAuxiliar8, RecargaAuxiliar9, RecargaAuxiliar10";
        } else if ($request->permisosTipo == "Caja") {
            $data['Rights'] = "PRINTTICKET, LISTTICKETS, LISTTICKETSPENDING, LISTCONFIRMTICKETS, REPORTTICKETS, COLLECT";
        } else if ($request->permisosTipo == "Personal de sala") {
            $data['Rights'] = "CREATETICKET, GETANDCLOSETICKET, PRINTTICKET, LISTTICKETS, LISTTICKETSPENDING, LISTCONFIRMTICKETS, REPORTTICKETS, COLLECT";
        } else if ($request->permisosTipo == "Otros") {
            $data['Rights'] = $permisosUser;
            $data['TicketTypesAllowed'] = $typesUser;
            $data['AdditionalOptionsAllowed'] = $aditionalOptionsUser;
        } else if ($request->permisosTipo == "Desconocido") {
            $data['Rights'] = '';
            $data['TicketTypesAllowed'] = '';
            $data['AdditionalOptionsAllowed'] = '';
        } else {
            throw new Exception();
        }


        //dd($data);
        if ($request->locales) {
            foreach ($request->locales as $id) {
                DB::connection(nuevaConexion($id))->table('users')->insert($data);
            }
        }


        $user = new UserTicketServer();
        $user->User = $data['User'];
        $user->Name = $request->nameReal;
        $user->Password = Crypt::encrypt($data['Password']);
        $user->PIN = $data['PIN'];
        $user->SessionType = $data['SessionType'];
        $user->Rights = $data['Rights'];
        if (isset($data['PID'])) {
            $user->PID = Crypt::encrypt($data['PID']);
        }
        if (isset($data['TicketTypesAllowed'])) {
            $user->TicketTypesAllowed = $data['TicketTypesAllowed'];
        }
        if (isset($data['AdditionalOptionsAllowed'])) {
            $user->AdditionalOptionsAllowed = $data['AdditionalOptionsAllowed'];
        }

        if ($request->permisosTipo == "Tecnico") {
            $user->rol = "Técnicos";
        } else if ($request->permisosTipo == "Caja") {
            $user->rol = "Caja";
        } else if ($request->permisosTipo == "Personal de sala") {
            $user->rol = "Personal sala";
        } else if ($request->permisosTipo == "Desconocido") {
            $user->rol = "Desconocido";
        } else if ($request->permisosTipo == "Otros") {
            $user->rol = "Otros";
        } else {
            throw new Exception();
        }

        $user->created_at = now();
        $user->updated_at = now();
        $user->save();

        if ($request->locales) {
            foreach ($request->locales as $id) {
                $user->locals()->sync($id);
            }
        }

        $user->delegations()->sync($request->delegation_id);

        //Actualizar fecha última modificación
        lastUsermcUpdate($request->delegation_id);

        return redirect()->route('usersmcdelegation.index', ['delegationId' => $request->delegation_id]);
        //return redirect()->route("usersmc.index",['delegationId' => 1]);
        /*} catch (\Exception $e) {
            dd('falla');
            //return redirect()->route('usersmcDelegation.create', $request->delegation_id)->withErrors(['error' => 'Ocurrió un error al crear el usuario']);
            //return redirect()->route("usersmc")->withErrors(['error' => 'Ocurrió un error al crear el usuario']);
        }*/
    }

    /*$delegation = Delegation::with('zones.locals.usersTicketServer')->find($delegationId);
        $usersmc = UserTicketServer::whereHas('locals.zone.delegation', function ($query) use ($delegationId) {
            $query->where('id', $delegationId);
        })->with('locals.zone.delegation')->get();

        return view('usersmc.index', compact('usersmc', 'delegation'));
*/

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $local = Local::find($id);

        $local_usersmc = $local->usersTicketServer()->get();

        return view("usersmc.show", compact('local', 'local_usersmc'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = UserTicketServer::find($id);
        //dd($user->delegations);
        // Verificar si el usuario existe
        if (!$user) {
            return redirect()->route('users.index')->with('error', 'User not found.');
        }

        // Obtener el delegationId a partir de las relaciones
        //$delegation = Delegation::with('zones.locals')->find($delegationId);
        $delegation = $user->delegations->first();
        //dd($delegation);
        $delegationId = $delegation->id;

        // Lista de todos los posibles derechos
        $allRights = [
            "ALL",
            "CREATETICKET",
            "GETANDCLOSETICKET",
            "CONFIRMTICKET",
            "PRINTTICKET",
            "ABORTTICKET",
            "EXPIRETICKET",
            "DELETETICKET",
            "LISTTICKETS",
            "LISTTICKETSPENDING",
            "LISTCONFIRMTICKETS",
            "REPORTTICKETS",
            "PURGETICKETS",
            "EXPORTTICKETS",
            "COLLECT",
            "UPDATECOLLECT",
            "DELETECOLLECT",
            "ACCOUNTING",
            "UPDATEACCOUNTING",
            "DELETEACCOUNTING",
            "ADDUSER",
            "DELETEUSER",
            "EDITUSER",
            "GETUSER",
            "LISTUSERS",
            "EXPORTUSERS",
            "IMPORTUSERS",
            "EDITCONFIG",
            "LOGS",
            "LISTLOGS",
            "PURGUELOGS",
            "EXPORTLOGS",
            "USETICKET",
            "LISTTICKETSUSED",
            "BACKUPDB",
            "RESTOREDB",
            "EDITUSERBALANCE",
            "RESETUSERBALANCE",
            "LISTUSERBALANCE",
            "ADDPLAYER",
            "DELETEPLAYER",
            "EDITPLAYER",
            "LISTPLAYERS",
            "STATISTICS",
            "AUXMONEYSTORAGE",
            "UPDATEAUXMONEYSTORAGE",
            "DELETEAUXMONEYSTORAGE",
            "LISTHIDDENTICKETS",
            "BETMONEYSTORAGE",
            "UPDATEBETMONEYSTORAGE",
            "DELETEBETMONEYSTORAGE",
            "PURGEDB",
            "UPDATETICKETSSTATUS",
            "UPDATETICKETSAUX",
            "HIDEONTC",
            "CASHLESS"
        ];

        // Dividir los derechos del usuario en un array
        $userRights = array_map('trim', explode(',', $user->Rights));

        // Crear un array asociativo para los derechos del usuario
        $userRightsArray = array_fill_keys($allRights, false);
        foreach ($userRights as $right) {
            if (array_key_exists($right, $userRightsArray)) {
                $userRightsArray[$right] = true;
            }
        }

        // Lista de todos los posibles tipos de ticket
        $allTicketTypes = [
            "ALL",
            "CCMCODERE",
            "CODERE",
            "CODERE TicketController",
            "CCMBWIN",
            "BWIN",
            "BWIN TicketController",
            "CCMORENES",
            "ORENES",
            "ORENES TicketController",
            "CCMKIROLSOFT",
            "KIROLSOFT",
            "KIROLSOFT TicketController",
            "CCMRETA",
            "RETA",
            "RETA TicketController",
            "CCMEGASA",
            "EGASA",
            "EGASA TicketController",
            "CCMIPS",
            "IPS",
            "IPS TicketController",
            "IPSServer",
            "IPXServer",
            "MGA",
            "SMC",
            "NEMESYS",
            "SQL",
            "TECNAUSA",
            "TEYSA",
            "VAN",
            "CCMGTECH",
            "GTECH",
            "GTECH TicketController",
            "CCMGTECH2",
            "GTECH2",
            "GTECH2 TicketController",
            "CCMSPORTIUM",
            "SPORTIUM",
            "SPORTIUM TicketController",
            "CCMSPORTIUMBGT",
            "SPORTIUMBGT",
            "SPORTIUMBGT TicketController",
            "CCMSASAFT",
            "SASAFT TicketController",
            "CCMSASTITO",
            "SASTITO TicketController",
            "CCMTicketServer",
            "TicketServerAPI",
            "Manual",
            "CCMLUCKIA1",
            "LUCKIA1",
            "LUCKIA1 TicketController",
            "CCMLUCKIA2",
            "LUCKIA2",
            "LUCKIA2 TicketController",
            "CCMLUCKIA3",
            "LUCKIA3",
            "LUCKIA3 TicketController",
            "CCMLUCKIA4",
            "LUCKIA4",
            "LUCKIA4 TicketController",
            "CCMLUCKIAOnline",
            "LUCKIAOnline",
            "LUCKIAOnline TicketController",
            "CCMBWINBGT",
            "BWINBGT",
            "BWINBGT TicketController",
            "CCMGBG",
            "GBG",
            "GBG TicketController",
            "CCMFORWARDSYSTEMS",
            "FORWARDSYSTEMS",
            "FORWARDSYSTEMS TicketController",
            "CCMWIGOS",
            "WIGOS",
            "WIGOS TicketController",
            "CCMONLINEGAMES",
            "ONLINEGAMES",
            "ONLINEGAMES TicketController"
        ];

        // Dividir los tipos de tickets del usuario en un array
        $userTicketTypes = array_map('trim', explode(',', $user->TicketTypesAllowed));

        // Crear un array asociativo para los tipos de tickets del usuario
        $userTicketTypesArray = array_fill_keys($allTicketTypes, false);
        foreach ($userTicketTypes as $ticketType) {
            if (array_key_exists($ticketType, $userTicketTypesArray)) {
                $userTicketTypesArray[$ticketType] = true;
            }
        }

        // Lista de todas las opciones adicionales
        $allAdditionalOptions = [
            "RecargaAuxiliar1",
            "RecargaAuxiliar2",
            "RecargaAuxiliar3",
            "RecargaAuxiliar4",
            "RecargaAuxiliar5",
            "PrestamoAuxiliar1",
            "PrestamoAuxiliar2",
            "PrestamoAuxiliar3",
            "PrestamoAuxiliar4",
            "PrestamoAuxiliar5",
            "RecargasManuales",
            "Recaudaciones",
            "ResetApuestas",
            "ResetAuxiliares",
            "ResetCajonVirtual",
            "RecargaCajonVirtual1",
            "RecargaCajonVirtual2",
            "RecargaCajonVirtual3",
            "RecargaCajonVirtual4",
            "RecargaCajonVirtual5",
            "RecargaAuxiliar6",
            "RecargaAuxiliar7",
            "RecargaAuxiliar8",
            "RecargaAuxiliar9",
            "RecargaAuxiliar10",
            "PrestamoAuxiliar6",
            "PrestamoAuxiliar7",
            "PrestamoAuxiliar8",
            "PrestamoAuxiliar9",
            "PrestamoAuxiliar10",
            "Transferencias",
            "TransferenciaAuxiliar1",
            "TransferenciaAuxiliar2",
            "TransferenciaAuxiliar3",
            "TransferenciaAuxiliar4",
            "TransferenciaAuxiliar5",
            "TransferenciaAuxiliar6",
            "TransferenciaAuxiliar7",
            "TransferenciaAuxiliar8",
            "TransferenciaAuxiliar9",
            "TransferenciaAuxiliar10"
        ];

        // Dividir las opciones adicionales del usuario en un array
        $userAdditionalOptions = array_map('trim', explode(',', $user->AdditionalOptionsAllowed));

        // Crear un array asociativo para las opciones adicionales del usuario
        $userAdditionalOptionsArray = array_fill_keys($allAdditionalOptions, false);
        foreach ($userAdditionalOptions as $option) {
            if (array_key_exists($option, $userAdditionalOptionsArray)) {
                $userAdditionalOptionsArray[$option] = true;
            }
        }
        //dd($delegation);
        // de esta manera conseguimos todos los locales asociados al usuario que estamos editando
        $userLocalIds = $user->locals->pluck('id')->toArray();
        //dd($userLocalIds);
        return view('usersmc.edit', compact('user', 'delegationId', 'allRights', 'userRightsArray', 'allTicketTypes', 'userTicketTypesArray', 'allAdditionalOptions', 'userAdditionalOptionsArray', 'delegation', 'userLocalIds'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //dd($request->all());
        $request->validate([
            'name' => ['required'],
            'nameReal' => ['required'],
            'pid' => ['required'],
            'rol' => ['required'],
            'delegation_id' => ['required'],
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'nameReal.required' => 'El nombre real es obligatorio.',
            'pid.required' => 'El PID es obligatorio.',
            'rol.required' => 'El tipo de permiso es obligatorio.',
            'delegation_id.required' => 'La delegación es obligatoria.',
        ]);
        //dd('entra');

        // Inicializar variables para permisos, tipos de ticket y opciones adicionales
        $permisosUser = '';
        $typesUser = '';
        $aditionalOptionsUser = '';

        // Obtener el usuario de la base de datos local
        $userLocal = UserTicketServer::with('locals')->find($id);
        if (!$userLocal) {
            throw new \Exception("Usuario no encontrado en la base de datos local");
        }

        // Validar si el PID ya existe en la base de datos y no corresponde al usuario actual
        if ($request->pid) {
            $allUsers = UserTicketServer::where('id', '!=', $id)->get();  // Excluir el usuario actual
            foreach ($allUsers as $user) {
                if ($user->PID != '') {
                    $decryptPid = Crypt::decrypt($user->PID);
                    if ($decryptPid == $request->input('pid') && $request->input('pid') != '') {
                        return redirect()->back()->withErrors(['pid' => 'El PID ya está en uso por otro usuario.'])->withInput();
                    }
                }
            }
        }

        $localesAntAsoc = $userLocal->locals->pluck('id')->toArray();

        // Inicializar los datos para actualizar
        $data = [
            'User' => $request->input('name', $userLocal->User),
            'Name' => $request->input('nameReal', $userLocal->Name),
            'SessionType' => $request->input('sesion', $userLocal->SessionType),
            'Password' => $userLocal->Password,
            'PIN' => $userLocal->PIN,
            'Rights' => '',
            'TicketTypesAllowed' => '',
            'AdditionalOptionsAllowed' => '',
            'rol' => $userLocal->rol
        ];

        if ($request->permisosTipo == "Desconocido") {

            $data = [
                'User' => $request->input('name', $userLocal->User),
                'Name' => $request->input('nameReal', $userLocal->Name),
                'SessionType' => $request->input('sesion', $userLocal->SessionType),
                'Password' => '1234',
                'PIN' => '1234',
                'Rights' => '',
                'TicketTypesAllowed' => '',
                'AdditionalOptionsAllowed' => '',
                'rol' => $userLocal->rol
            ];
        }
        //dd($data);

        // Verificar si la contraseña ha cambiado
        if ($request->filled('new_passwrd')) {
            $data['Password'] = Crypt::encrypt($request->input('new_passwrd'));
            $data['PIN'] = $request->input('new_passwrd'); // Nota: Cambia esta lógica si es necesario
        }
        //dd($data);
        // Procesar permisos
        $allPermisos = "ALL, CONFIRMTICKET, PRINTTICKET, LISTTICKETS, LISTTICKETSPENDING, LISTCONFIRMTICKETS, REPORTTICKETS, COLLECT, CREATETICKET, GETANDCLOSETICKET, ABORTTICKET, EXPIRETICKET, DELETETICKET, PURGETICKETS, EXPORTTICKETS, UPDATECOLLECT, DELETECOLLECT, ACCOUNTING, UPDATEACCOUNTING, DELETEACCOUNTING, ADDUSER, DELETEUSER, EDITUSER, GETUSER, LISTUSERS, EXPORTUSERS, IMPORTUSERS, EDITCONFIG, LOGS, LISTLOGS, PURGUELOGS, EXPORTLOGS, USETICKET, LISTTICKETSUSED, BACKUPDB, RESTOREDB, EDITUSERBALANCE, RESETUSERBALANCE, LISTUSERBALANCE, ADDPLAYER, DELETEPLAYER, EDITPLAYER, LISTPLAYERS, STATISTICS, AUXMONEYSTORAGE, UPDATEAUXMONEYSTORAGE, DELETEAUXMONEYSTORAGE, LISTHIDDENTICKETS, BETMONEYSTORAGE, UPDATEBETMONEYSTORAGE, DELETEBETMONEYSTORAGE, PURGEDB, UPDATETICKETSSTATUS, UPDATETICKETSAUX, HIDEONTC, CASHLESS";
        $allPermisosArray = explode(", ", $allPermisos);

        // Construir la lista de permisos seleccionados
        $permisosUser = implode(', ', array_filter($allPermisosArray, function ($permiso) use ($request) {
            return $request->input('Right' . $permiso) == "on" ? $permiso : null;
        }));

        // Procesar tipos de ticket permitidos
        $allTypes = "ALL, CCMCODERE, CODERE, CODERE_TicketController, CCMBWIN, BWIN, BWIN_TicketController, CCMORENES, ORENES, ORENES_TicketController, CCMKIROLSOFT, KIROLSOFT, KIROLSOFT_TicketController, CCMRETA, RETA, RETA_TicketController, CCMEGASA, EGASA, EGASA_TicketController, CCMIPS, IPS, IPS_TicketController, IPSServer, IPXServer, MGA, SMC, NEMESYS, SQL, TECNAUSA, TEYSA, VAN, CCMGTECH, GTECH, GTECH_TicketController, CCMGTECH2, GTECH2, GTECH2_TicketController, CCMSPORTIUM, SPORTIUM, SPORTIUM_TicketController, CCMSPORTIUMBGT, SPORTIUMBGT_TicketController, CCMSASAFT, SASAFT_TicketController, CCMSASTITO, SASTITO_TicketController, CCMTicketServer, TicketServerAPI, Manual, CCMLUCKIA1, LUCKIA1, LUCKIA1_TicketController, CCMLUCKIA2, LUCKIA2, LUCKIA2_TicketController, CCMLUCKIA3, LUCKIA3, LUCKIA3_TicketController, CCMLUCKIA4, LUCKIA4, LUCKIA4_TicketController, CCMLUCKIAOnline, LUCKIAOnline, LUCKIAOnline_TicketController, CCMBWINBGT, BWINBGT, BWINBGT_TicketController, CCMGBG, GBG, GBG_TicketController, CCMFORWARDSYSTEMS, FORWARDSYSTEMS, FORWARDSYSTEMS_TicketController, CCMWIGOS, WIGOS, WIGOS_TicketController, CCMONLINEGAMES, ONLINEGAMES, ONLINEGAMES_TicketController";
        $allTypesArray = explode(", ", $allTypes);

        // Construir la lista de tipos de ticket permitidos
        $typesUser = implode(', ', array_filter($allTypesArray, function ($type) use ($request) {
            return $request->input('TicketType' . $type) == "on" ? $type : null;
        }));

        // Procesar opciones adicionales permitidas
        $allAditionalOptions = "RecargaAuxiliar1, RecargaAuxiliar2, RecargaAuxiliar3, RecargaAuxiliar4, RecargaAuxiliar5, PrestamoAuxiliar1, PrestamoAuxiliar2, PrestamoAuxiliar3, PrestamoAuxiliar4, PrestamoAuxiliar5, RecargasManuales, Recaudaciones, ResetApuestas, ResetAuxiliares, ResetCajonVirtual, RecargaCajonVirtual1, RecargaCajonVirtual2, RecargaCajonVirtual3, RecargaCajonVirtual4, RecargaCajonVirtual5, RecargaAuxiliar6, RecargaAuxiliar7, RecargaAuxiliar8, RecargaAuxiliar9, RecargaAuxiliar10, PrestamoAuxiliar6, PrestamoAuxiliar7, PrestamoAuxiliar8, PrestamoAuxiliar9, PrestamoAuxiliar10, Transferencias, TransferenciaAuxiliar1, TransferenciaAuxiliar2, TransferenciaAuxiliar3, TransferenciaAuxiliar4, TransferenciaAuxiliar5, TransferenciaAuxiliar6, TransferenciaAuxiliar7, TransferenciaAuxiliar8, TransferenciaAuxiliar9, TransferenciaAuxiliar10";
        $allAditionalOptionsArray = explode(", ", $allAditionalOptions);

        // Construir la lista de opciones adicionales permitidas
        $aditionalOptionsUser = implode(', ', array_filter($allAditionalOptionsArray, function ($option) use ($request) {
            return $request->input('AdditionalOption' . $option) == "on" ? $option : null;
        }));

        // Asignar derechos según el rol
        switch ($request->rol) {
            case 'Técnicos':
                $data['Rights'] = "CONFIRMTICKET, PRINTTICKET, LISTTICKETS, LISTTICKETSPENDING, LISTCONFIRMTICKETS, REPORTTICKETS";
                $data['AdditionalOptionsAllowed'] = "RecargaAuxiliar1, RecargaAuxiliar2, RecargaAuxiliar3, RecargaAuxiliar4, RecargaAuxiliar5, RecargasManuales, Recaudaciones, ResetApuestas, ResetAuxiliares, RecargaAuxiliar6, RecargaAuxiliar7, RecargaAuxiliar8, RecargaAuxiliar9, RecargaAuxiliar10";
                break;
            case 'Caja':
                $data['Rights'] = "PRINTTICKET, LISTTICKETS, LISTTICKETSPENDING, LISTCONFIRMTICKETS, REPORTTICKETS, COLLECT";
                break;
            case 'Personal sala':
                $data['Rights'] = "CREATETICKET, GETANDCLOSETICKET, PRINTTICKET, LISTTICKETS, LISTTICKETSPENDING, LISTCONFIRMTICKETS, REPORTTICKETS, COLLECT";
                break;
            case 'Otros':
                $data['Rights'] = $permisosUser;
                $data['TicketTypesAllowed'] = $typesUser;
                $data['AdditionalOptionsAllowed'] = $aditionalOptionsUser;
                break;
            case 'Desconocido':
                $data['Rights'] = '';
                $data['TicketTypesAllowed'] = '';
                $data['AdditionalOptionsAllowed'] = '';
                break;
            default:
                throw new \Exception("Tipo de permisos inválido");
        }
        //dd($data);

        if (!$request->permisosTipo == "Desconocido") {

            // Obtener los IDs de los locales seleccionados desde la solicitud
            $localesSeleccionados = $request->input('locales', []);

            // Sincronizar la relación entre el usuario y los locales
            $userLocal->locals()->sync($localesSeleccionados);

            // Locales de los que se desasoció el usuario (estaban antes pero no ahora)
            $localesDesasociados = array_diff($localesAntAsoc, $localesSeleccionados);

            // Locales que coinciden (estaban antes y siguen estando)
            $localesCoincidentes = array_intersect($localesAntAsoc, $localesSeleccionados);
            foreach ($localesCoincidentes as $local_id) {
                DB::connection(nuevaConexion($local_id))->table('users')->where('User', $userLocal->User)->update([
                    'User' => $data['User'],
                    //'Name' => $data['Name'],
                    'SessionType' => $data['SessionType'],
                    'Password' => $data['Password'] != '' ? Crypt::decrypt($data['Password']) : "",
                    'PIN' => $data['PIN'],
                    'Rights' => $data['Rights'],
                    'TicketTypesAllowed' => $data['TicketTypesAllowed'],
                    'AdditionalOptionsAllowed' => $data['AdditionalOptionsAllowed']
                ]);
            }

            foreach ($localesDesasociados as $local_id) {
                DB::connection(nuevaConexion($local_id))->table('users')->where('User', $userLocal->User)->delete();
            }
            //dd($data['Name']);
            $userLocal->update($data);
            //dd($userLocal);
            // Locales a los que se ha asociado el usuario (no estaban antes, pero sí ahora)
            $localesAsociados = array_diff($localesSeleccionados, $localesAntAsoc);
            foreach ($localesAsociados as $local_id) {
                DB::connection(nuevaConexion($local_id))->table('users')->insert([
                    'User' => $userLocal->User,
                    //'Name' => $userLocal->Name,
                    'Password' => $userLocal->Password != '' ? Crypt::decrypt($userLocal->Password) : "",
                    'Rights' => $userLocal->Rights,
                    'IsRoot' => $userLocal->IsRoot,
                    'RightsCanBeModified' => $userLocal->RightsCanBeModified,
                    'CurrentBalance' => $userLocal->CurrentBalance,
                    'ReloadBalance' => $userLocal->ReloadBalance,
                    'ReloadEveryXMinutes' => $userLocal->ReloadEveryXMinutes,
                    'LastReloadDate' => $userLocal->LastReloadDate,
                    'ResetBalance' => $userLocal->ResetBalance,
                    'ResetAtHour' => $userLocal->ResetAtHour,
                    'LastResetDate' => $userLocal->LastResetDate,
                    'MaxBalance' => $userLocal->MaxBalance,
                    'TicketTypesAllowed' => $userLocal->TicketTypesAllowed,
                    'PID' => $userLocal->PID,
                    'NickName' => $userLocal->NickName,
                    'Avatar' => $userLocal->Avatar,
                    'PIN' => $userLocal->PIN,
                    'SessionType' => $userLocal->SessionType,
                    'AdditionalOptionsAllowed' => $userLocal->AdditionalOptionsAllowed
                ]);
            }
        }

        //Actualizar fecha última modificación
        lastUsermcUpdate($request->input('delegation_id'));

        // Redirigir a la vista actualizada
        return redirect()->route('usersmcdelegation.index', ['delegationId' => $request->delegation_id]);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        try {
            $usernames = $request->input('usrs');

            //Actualizar fecha última modificación
            $local = Local::findOrFail($id);
            lastUsermcUpdate($local->zone->delegation->id);

            foreach ($usernames as $user) {
                $userOb = UserTicketServer::where('User', $user)->first();
                $userOb->locals()->detach($id);
                DB::connection(nuevaConexion($id))->table('users')->where('User', $user)->delete();
            }

            return redirect()->route("usersmc.show", $id);
        } catch (\Exception $e) {
            return redirect()->route("usersmc.show", $id)->withErrors(['error' => 'Ocurrió un error al eliminar los usuarios']);
        }
    }


    public function destroyTotal(Request $request, $id)
    {
        $usuario = UserTicketServer::find($id);
        //$delegation = Delegation::with('zones.locals')->find($request->delegation_id);
        $locales = $usuario->locals;
        //Actualizar fecha última modificación
        lastUsermcUpdate($request->delegation_id);
        /*if ($fecha = lastUserMcDate::where('delegation_id', $delegation->id)->first()) {
            // Si existe el registro, actualiza la fecha
            $fecha->update([
                'lastDate' => now()
            ]);
        } else {
            // Si no existe el registro, crea uno nuevo
            $newFecha = new lastUserMcDate();
            $newFecha->delegation_id = $delegation->id;
            $newFecha->lastDate = now();
            $newFecha->save();
        }*/


        /*foreach ($delegation->zones as $zone) {
            foreach ($zone->locals as $locale) {
                $locales[] = $locale;
            }
        }*/

        $errores = [];
        foreach ($locales as $local) {
            try {
                DB::connection(nuevaConexion($local->id))->table('users')->where('User', $usuario->User)->delete();
            } catch (\Exception $e) {
                $errores[] = "Error al eliminar en la conexión {$local->name}";
            }
        }
        try {
            $usuario->delete();
        } catch (\Exception $e) {
            $errores[] = "Error al eliminar el usuario local: " . $e->getMessage();
        }
        if (count($errores) > 0) {
            return redirect()->route("usersmcdelegation.index", $request->delegation_id)->withErrors(['error' => implode(", ", $errores)]);
        }
        return redirect()->route("usersmcdelegation.index", $request->delegation_id);
    }

    /*public function syncUsersmcView($id)
    {
        $delegation = Delegation::with('zones.locals.usersTicketServer')->find($id);
        $usersmc = $delegation->usersTicketServer;
        $usersmc = $usersmc->sortBy('User');
        return view("usersmc.syncUsersmc", compact('delegation', 'usersmc'));
    }*/

    public function syncUsersmcView($id)
    {
        $delegation = Delegation::with('zones.locals.usersTicketServer')->find($id);
        // Filtramos los usuarios que no tienen el rol de 'Desconocido'
        $usersmc = $delegation->usersTicketServer->filter(function ($user) {
            return $user->rol !== 'Desconocido';
        })->sortBy('User');
        $locals = $delegation->zones->flatMap(function ($zone) {
            return $zone->locals;
        });

        return view("usersmc.syncUsersmc", compact('delegation', 'usersmc', 'locals'));
    }

    public function syncUsersrmc(Request $request)
    {
        // Descomentar para depurar
        // dd($request->all());

        try {
            foreach ($request->locals as $local_id) {
                $local = Local::find($local_id);

                foreach ($request->users as $user_id) {
                    $usuario = UserTicketServer::find($user_id);
                    $local->usersTicketServer()->syncWithoutDetaching([$user_id]);

                    $existUser = DB::connection(nuevaConexion($local_id))->table('users')->where('User', $usuario->User)->first();
                    if (!$existUser) {
                        //dd($usuario);
                        DB::connection(nuevaConexion($local_id))->table('users')->insert([
                            'User' => $usuario->User,
                            //'Name' => $usuario->Name,
                            'Password' => $usuario->Password != '' ? Crypt::decrypt($usuario->Password) : "",
                            'Rights' => $usuario->Rights,
                            'IsRoot' => $usuario->IsRoot,
                            'RightsCanBeModified' => $usuario->RightsCanBeModified,
                            'CurrentBalance' => $usuario->CurrentBalance,
                            'ReloadBalance' => $usuario->ReloadBalance,
                            'ReloadEveryXMinutes' => $usuario->ReloadEveryXMinutes,
                            'LastReloadDate' => $usuario->LastReloadDate,
                            'ResetBalance' => $usuario->ResetBalance,
                            'ResetAtHour' => $usuario->ResetAtHour,
                            'LastResetDate' => $usuario->LastResetDate,
                            'MaxBalance' => $usuario->MaxBalance,
                            'TicketTypesAllowed' => $usuario->TicketTypesAllowed,
                            'PID' => $usuario->PID,
                            'NickName' => $usuario->NickName,
                            'Avatar' => $usuario->Avatar,
                            'PIN' => $usuario->PIN,
                            'SessionType' => $usuario->SessionType,
                            'AdditionalOptionsAllowed' => $usuario->AdditionalOptionsAllowed
                        ]);
                    }
                }
            }

            return redirect()->route('usersmcdelegation.index', ['delegationId' => $request->delegation_id]);
        } catch (\Exception $e) {
            return redirect()->route('usersmcdelegation.index', ['delegationId' => $request->delegation_id]);
        }
    }

    public function search(Request $request, $delegationId)
    {
        // Obtiene el término de búsqueda del input
        $searchTerm = $request->input('search');
        $searchTerm = '%' . $searchTerm . '%'; // Ajuste para búsqueda parcial

        // Obtiene el rol del input, si existe
        $rol = $request->input('rol');

        // Obtiene la delegación por su ID
        $delegation = Delegation::find($delegationId);

        // Construye la consulta de búsqueda
        $query = $delegation->usersTicketServer()
            ->where('delegation_id', $delegationId)
            ->where(function ($query) use ($searchTerm) {
                // Condición de búsqueda por término (User o Name)
                $query->where('users_ticket_server.User', 'Ilike', $searchTerm)
                    ->orWhere('users_ticket_server.Name', 'Ilike', $searchTerm);
            });

        // Condición de filtrado por rol, solo si $rol no es null
        if (!is_null($rol)) {
            $query->where('users_ticket_server.rol', $rol);
        }

        // Ordena los resultados por "User" y pagina
        $usersmc = $query->orderBy('User', 'ASC')
            ->paginate(16)
            ->appends(['search' => $request->input('search'), 'rol' => $rol]); // Asegura que los parámetros de búsqueda se mantengan en la paginación

        // Obtiene la última fecha relacionada con la delegación
        $lastFecha = lastUserMcDate::where('delegation_id', $delegationId)->first();

        // Retorna la vista con los resultados de la búsqueda
        return view("usersmc.index", compact("usersmc", "delegation", "lastFecha"));
    }
}
