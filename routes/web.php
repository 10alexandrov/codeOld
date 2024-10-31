<?php

use App\Http\Controllers\AllMoneysController;
use App\Http\Controllers\ArqueosController;
use App\Http\Controllers\BarsController;
use App\Http\Controllers\BossDelegationController;
use App\Http\Controllers\CollectdetailsController;
use App\Http\Controllers\CollectsController;
use App\Http\Controllers\DelegationsController;
use App\Http\Controllers\IdMachineController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\LocalsController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RolesPermissions;
use App\Http\Controllers\TicketsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ZonesController;
use App\Http\Controllers\UsersmcController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\CommandController;
use App\Http\Controllers\LoadsController;
use App\Http\Controllers\TypeMachinesController;
use App\Http\Controllers\UsersPerdidosController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\MachineController;


use App\Http\Middleware\CheckJefeDelegacionAccess;
use App\Http\Middleware\CheckTecnicoAccess;
use App\Http\Middleware\TimeoutMiddleware;
use App\Http\Middleware\CheckJefeSalonAccess;

use App\Mail\SendEmails;
use App\Models\Auxiliar;
use App\Models\Load;
use App\Models\User;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;


Auth::routes([
    'register' => false
]);
//Route::get('/', function () { return view('inicio'); });
//Route::redirect('/', '/login');

Route::get('/', function () {
    $error = session()->get('error');
    if (Auth::check()) {
        return redirect()->route('delegations.index')->with('error', $error);
    }
    return redirect('/login');
});

//Route::post('login', [LoginController::class, 'login']);

Route::resource('RolesPermissions', RolesPermissions::class);

Route::middleware(['auth',CheckTecnicoAccess::class,CheckJefeDelegacionAccess::class,CheckJefeSalonAccess::class])->group(function() {
    Route::resource('delegations', DelegationsController::class);
    Route::resource('zones', ZonesController::class)->except(['index','create','edit']);
    Route::resource('users', UsersController::class)->except(['show']);
    Route::get('/users/create/{id}', [UsersController::class, 'create'])->name('users.createUsers');
    Route::resource('locals', LocalsController::class)->except(['index']);
    Route::get('/locals/create/{id}', [LocalsController::class, 'create'])->name('locals.createLocals');
    Route::get('/locals/{local}', [LocalsController::class, 'show'])->name('locals.show')->middleware(TimeoutMiddleware::class);
    Route::resource('info', InfoController::class);
    Route::resource('arqueos', ArqueosController::class);
    Route::resource('tickets', TicketsController::class);
    Route::resource('configuration', ConfigurationController::class);
    //Route::get('/configuration/{id}', [ConfigurationController::class, 'index'])->name('configuration.index');

    Route::resource('usersmc', UsersmcController::class);
    Route::get('/usersmc/create/{id}', [UsersmcController::class, 'create'])->name('usersmcDelegation.create');
    Route::get('/usersmcdelegation/{delegationId}', [UsersmcController::class, 'showUsersmc'])->name('usersmcdelegation.index');
    Route::delete('usersmc/destroy-multiple/{id}', [UsersmcController::class, 'destroy'])->name('usersmc.destroyMultiple');
    Route::delete('usersmc/destroy-total/{id}', [UsersmcController::class, 'destroyTotal'])->name('usersmc.destroyTotal');
    Route::get('usersmc/syncUsersmc/{id}', [UsersmcController::class, 'syncUsersmcView'])->name('usersmc.syncUsersmcView');
    Route::post('usersmc/syncUsersrmc', [UsersmcController::class, 'syncUsersrmc'])->name('usersmc.syncUsersrmc');
    Route::get('/usersmc/search/{delegationId}', [UsersmcController::class, 'search'])->name('usersmc.search');

    Route::resource('machines', IdMachineController::class);
    Route::resource('collects', CollectsController::class);
    Route::resource('collectdetails', CollectdetailsController::class);
    Route::resource('bossDelegations', BossDelegationController::class)->except(['index','show']);
    Route::get('verMoneys/{id}', [AllMoneysController::class,'verMoneys'])->name('verMoneys');

    Route::post('abortTicket/{local}', [TicketsController::class,'abortTickets'])->name('abortTicket');
    Route::post('confirmTicket/{local}', [TicketsController::class,'confirmTicket'])->name('confirmTicket');
    Route::post('generarTicket/{local}', [TicketsController::class,'generarTicket'])->name('generarTicket');

    Route::post('getTicketFilter/{local}', [ArqueosController::class,'getTicketsFilter'])->name('getTicketsFilter');
    Route::post('buscarTickets/{local}', [ArqueosController::class,'getTypes'])->name('getTypes');

    Route::post('saveAuxData', [ArqueosController::class,'saveAuxData'])->name('saveAuxData');
    Route::delete('deleteAuxData/{id}', [ArqueosController::class,'deleteAuxData'])->name('deleteAuxData');
    Route::put('updateAuxData/{id}', [ArqueosController::class,'updateAuxData'])->name('updateAuxData');

    Route::get('SyncBlueMachine/{id}', [CommandController::class,'syncMachineBlue'])->name('SyncBlueMachine');
    Route::get('actualizarLocal/{id}', [CommandController::class,'actualizarLocal'])->name('actualizarLocal');

    Route::get('showTypesMachines/{id}', [TypeMachinesController::class, 'showTypesMachines'])->name('showTypesMachines.index');
    Route::resource('typeMachines', TypeMachinesController::class);
    Route::get('/typeMachines/create/{id}', [TypeMachinesController::class, 'create'])->name('typeMachinesDelegation.create');
    Route::delete('typeMachines/destroy/{id}', [TypeMachinesController::class, 'destroyAll'])->name('typeMachines.destroyAll');
    Route::get('typeMachines/showSyncTypeMachines/{id}', [TypeMachinesController::class, 'showSyncTypeMachines'])->name('typeMachines.showSyncTypeMachines');
    Route::post('typeMachines/syncTypeMachines', [TypeMachinesController::class, 'syncTypeMachines'])->name('typeMachines.syncTypeMachines');
    Route::get('/typeMachines/search/{delegationId}', [TypeMachinesController::class, 'search'])->name('typeMachines.search');

    Route::resource('usersPerdidos', UsersPerdidosController::class);

    //Route::get('bars/{delegation_id}', [BarsController::class, 'showBars'])->name('bars.showBars');
    Route::get('/bars/create/{id}', [BarsController::class, 'create'])->name('barZone.create');
    Route::resource('bars', BarsController::class);

    Route::resource('loads', LoadsController::class);

    Route::get('/local/{local_id}/machine/{machine_id}', [LoadsController::class, 'showLocal'])->name('loads.showLocal');
    Route::get('/bar/{bar_id}/machine/{machine_id}', [LoadsController::class, 'showBar'])->name('loads.showBar');


    Route::get('/exportUsers/{delegation_id}', [PDFController::class, 'exportUsers'])->name('exportUsers');
    Route::get('/exportMachinesLocals/{delegation_id}', [PDFController::class, 'exportMachinesLocals'])->name('exportMachinesLocals');
    Route::get('/exportMachinesBars/{delegation_id}', [PDFController::class, 'exportMachinesBars'])->name('exportMachinesBars');

    Route::get('machines/index/{id}', [MachineController::class, 'index'])->name('machines.index');
    Route::get('machines/delegation/{id}', [MachineController::class, 'create'])->name('machineDelegation.create');
    Route::resource('machines', MachineController::class);
    Route::get('/machines/search/{delegationId}', [MachineController::class, 'search'])->name('machines.search');
});

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        }
    );

    return $status === Password::PASSWORD_RESET
                ? redirect()->route('login')->with('status', __($status))
                : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');

Route::get('email', function(){

    Mail::to('carlos@magarin.es')->send(new SendEmails);

    return 'Mensaje enviado';

})->name('email');

Route::get('/timeout', function () {
    return view('errors/timeout');
})->name('timeout');


Route::fallback(function () {
    abort(404);
});
