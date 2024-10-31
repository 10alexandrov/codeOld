<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserTicketServer;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class UsersPerdidosController extends Controller
{
    public function index(){
        $users = UserTicketServer::where('rol','Desconocido')->get();

        foreach ($users as $user) {
            try {
                $user->decryptedPID = Crypt::decrypt($user->PID);
            } catch (DecryptException $e) {
                $user->decryptedPID = 'Error al desencriptar';
            }
        }

        return view('perdidos.index',compact('users'));
    }

    public function destroy($id){
        $usuario = UserTicketServer::find($id);
        $usuario->delete();
        return redirect()->back();
    }


}
