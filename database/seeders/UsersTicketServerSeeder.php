<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserTicketServer;
use Illuminate\Support\Facades\Crypt;
use App\Models\Local;

class UsersTicketServerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tecnicos = [
            ['User' => 'Vicente', 'Name' => 'Vicente', 'PID' => 'PID-3B00857DE8', 'Password' => '2909'], // confirmado
            ['User' => 'Sergio', 'Name' => 'Sergio', 'PID' => 'PID-73006CAF95', 'Password' => '5384'], // confirmado
            ['User' => 'Riki', 'Name' => 'Riki', 'PID' => 'PID-0E001EA45D', 'Password' => '9306'], // confirmado
            ['User' => 'Ramón viejo', 'Name' => 'Ramón', 'PID' => 'PID-1B0083C08C', 'Password' => '9681'], // confirmado
            ['User' => 'Ramón roto', 'Name' => 'Ramón', 'PID' => 'PID-0900DDF79B', 'Password' => '9681'], // confirmado
            ['User' => 'Ramón', 'Name' => 'Ramón', 'PID' => 'PID-3E00A9DEE4', 'Password' => '9681'], // confirmado
            ['User' => 'Rafa', 'Name' => 'Rafa', 'PID' => 'PID-0400EAADDC', 'Password' => '1137'], // confirmado
            ['User' => 'Pepe', 'Name' => 'Pepe', 'PID' => 'PID-3B008595B6', 'Password' => '1641'], // confirmado
            ['User' => 'Lucia', 'Name' => 'Lucia', 'PID' => 'PID-73006CB83A', 'Password' => '3943'], // confirmado
            ['User' => 'Mauricio', 'Name' => 'Mauricio', 'PID' => 'PID-0400E9CD99', 'Password' => '1806'], // confirmado
            ['User' => 'Juanfran', 'Name' => 'Juanfran', 'PID' => 'PID-73006C62FA', 'Password' => '1623'], // confirmado
            ['User' => 'Ismael', 'Name' => 'Ismael', 'PID' => 'PID-0E00208873', 'Password' => '2112'], // confirmado
            ['User' => 'Fran', 'Name' => 'Fran', 'PID' => 'PID-1B008C11D6', 'Password' => ''], // confirmado
            ['User' => 'Dani', 'Name' => 'Dani', 'PID' => 'PID-1B008AA1A3', 'Password' => '4497'], // confirmado
            ['User' => 'Carlos', 'Name' => 'Carlos', 'PID' => 'PID-0900E5DC9A', 'Password' => '3553'], // confirmado
            ['User' => 'ASalmerón', 'Name' => 'ASalmerón', 'PID' => 'PID-0900D36DEF', 'Password' => '2438'], // confirmado
            ['User' => 'Antonio', 'Name' => 'Antonio', 'PID' => 'PID-3B007A7084', 'Password' => '9513'], // confirmado
            ['User' => 'Alberto', 'Name' => 'Alberto', 'PID' => 'PID-0A008F7F90', 'Password' => '1981'], // confirmado


        ];

        foreach ($tecnicos as $tecnico) {
            $userTicket = UserTicketServer::create([
                'User' => $tecnico['User'],
                'Name' => $tecnico['Name'],
                'Password' => $tecnico['Password'] != '' ? Crypt::encrypt($tecnico['Password']) : $tecnico['Password'],
                'Rights' => 'CONFIRMTICKET, PRINTTICKET, LISTTICKETS, LISTTICKETSPENDING, LISTCONFIRMTICKETS, REPORTTICKETS',
                'AdditionalOptionsAllowed' => 'RecargaAuxiliar1, RecargaAuxiliar2, RecargaAuxiliar3, RecargaAuxiliar4, RecargaAuxiliar5, RecargasManuales, Recaudaciones, ResetApuestas, ResetAuxiliares, RecargaAuxiliar6, RecargaAuxiliar7, RecargaAuxiliar8, RecargaAuxiliar9, RecargaAuxiliar10',
                'PIN' => $tecnico['Password'],
                'SessionType' => '-1',
                'PID' => Crypt::encrypt($tecnico['PID']),
                'rol' => 'Técnicos',
                'updated_at' => now(),
                'created_at' => now()
            ]);

            $userTicket->delegations()->attach(1);

            $locals = Local::all();

            foreach($locals as $local){
                $userTicket->locals()->attach($local->id);
            }
        }

        $personalSala = [
            ['User' => 'Cesareo', 'Name' => 'Cesareo', 'Password' => '0412', 'locales' => ['Benisa']], // confirmado
            ['User' => 'Pedro', 'Name' => 'Pedro' , 'Password' => '1974', 'locales' => ['Benisa']], // confirmado
            ['User' => 'Katy', 'Name' => 'Katy' , 'Password' => '4812', 'locales' => ['Benisa']], // confirmado
            ['User' => 'Cristian', 'Name' => 'Cristian' , 'Password' => '101994', 'locales' => ['Benisa']],// confirmado
            ['User' => 'Ester', 'Name' => 'Ester' , 'Password' => '1308', 'locales' => ['Javea']], // confirmado
            ['User' => 'Alejandra', 'Name' => 'Alejandra' , 'Password' => '010679', 'locales' => ['Javea']], // confirmado
            ['User' => 'Marylo', 'Name' => 'Marylo' , 'Password' => '1510', 'locales' => ['Javea', 'Gata de Gorgos', 'Teulada', 'Calpe']], // confirmado
            ['User' => 'Ariana', 'Name' => 'Leonela' , 'Password' => '2001', 'locales' => ['Javea', 'Gata de Gorgos', 'Teulada', 'Calpe']], // confirmado
            ['User' => 'Norkisp', 'Name' => 'Norkis' , 'Password' => '020211', 'locales' => ['Javea']], // confirmado
            ['User' => 'Manuel', 'Name' => 'Fernanda' , 'Password' => '2021', 'locales' => ['Javea', 'Gata de Gorgos', 'Calpe']], // confirmado
            ['User' => 'Vicent', 'Name' => 'Vicente' , 'Password' => 'palomos', 'locales' => ['Gata de Gorgos', 'Calpe']], // confirmado
            ['User' => 'Mayte', 'Name' => 'Mayte' , 'Password' => 'palomas', 'locales' => ['Gata de Gorgos']], // confirmado
            ['User' => 'Fran2', 'Name' => 'Fran' , 'Password' => '5492', 'locales' => ['Gata de Gorgos']], // confirmado
            ['User' => 'Soles', 'Name' => 'Yamal' , 'Password' => '6562', 'locales' => ['Teulada']], // confirmado
            ['User' => 'Luciana', 'Name' => 'Angy' , 'Password' => '1515', 'locales' => ['Teulada']], // confirmado
            ['User' => 'Melissa', 'Name' => 'Carla' , 'Password' => '1982', 'locales' => ['Teulada']], // confirmado
            ['User' => 'Mika', 'Name' => 'Mika' , 'Password' => '101214', 'locales' => ['Calpe']], // confirmado
            ['User' => 'Jesus', 'Name' => 'Jesús' , 'Password' => '2210', 'locales' => ['La Nucia']], // confirmado
            ['User' => 'Quique', 'Name' => 'Quique' , 'Password' => '2301', 'locales' => ['La Nucia']], // confirmado
            ['User' => 'Izan', 'Name' => 'Izan' , 'Password' => '2210', 'locales' => ['La Nucia']], // confirmado
            ['User' => 'Vane', 'Name' => 'Vane' , 'Password' => '0078', 'locales' => ['Villajoyosa']], // confirmado
            ['User' => 'Luna', 'Name' => 'Luna' , 'Password' => '0080', 'locales' => ['Villajoyosa']], // confirmado
            ['User' => 'Floren', 'Name' => 'Floren' , 'Password' => '2810', 'locales' => ['Villajoyosa']], // confirmado
            ['User' => 'Paqui', 'Name' => 'Paqui' , 'Password' => '9559', 'locales' => ['Villajoyosa']], // confirmado
            ['User' => 'Julian', 'Name' => 'Julián' , 'Password' => '0079', 'locales' => ['Villajoyosa']], // confirmado
            ['User' => 'Imad', 'Name' => '' , 'Password' => '0212', 'locales' => ['Vergel']], // confirmado
            ['User' => 'Stephanie', 'Name' => 'Stephanie' , 'Password' => '1409', 'locales' => ['Vergel', 'Pego', 'Ondara']], // confirmado
            ['User' => 'Isabel', 'Name' => 'Isabel' , 'Password' => 'mama', 'locales' => ['Denia']], // confirmado
            ['User' => 'Sandra', 'Name' => 'Sandra' , 'Password' => 'jazmin16', 'locales' => ['Denia']], // confirmado
            ['User' => 'Magda', 'Name' => 'Magda' , 'Password' => 'abril', 'locales' => ['Denia']], // confirmado
            ['User' => 'Agustina', 'Name' => 'Agustina' , 'Password' => '1974', 'locales' => ['Denia']], // confirmado
            ['User' => 'Mensi', 'Name' => 'Mensi' , 'Password' => '1110', 'locales' => ['Pego']], // confirmado
            ['User' => 'Ivan', 'Name' => 'Iván' , 'Password' => '3108', 'locales' => ['Pego']], // confirmado
            ['User' => 'Marta', 'Name' => 'Marta' , 'Password' => '1403', 'locales' => ['Pego', 'Ondara']], // confirmado
            ['User' => 'Paulina', 'Name' => 'Paulina' , 'Password' => '0105', 'locales' => ['Pego', 'Ondara']], // confirmado
            ['User' => 'Mane', 'Name' => 'Mari Ángeles' , 'Password' => '1975', 'locales' => ['Muchamiel','Jaime Segarra','Florida','Pardo Gimeno','Primo de Rivera']], // confirmado
            ['User' => 'Ambarbueno', 'Name' => 'Ambar' , 'Password' => '0225', 'locales' => ['Muchamiel','Jaime Segarra','Florida','Pardo Gimeno','Primo de Rivera']], // confirmado
            ['User' => 'Maria', 'Name' => 'María Jose' , 'Password' => '2822', 'locales' => ['Muchamiel','Jaime Segarra','Florida','Pardo Gimeno','Primo de Rivera']], // confirmado
            ['User' => 'Eva', 'Name' => 'Eva' , 'Password' => '6771', 'locales' => ['Muchamiel','Jaime Segarra','Florida','Pardo Gimeno','Primo de Rivera']], // confirmado
            ['User' => 'Nbag', 'Name' => 'Mar' , 'Password' => '1711', 'locales' => ['Muchamiel','Jaime Segarra','Florida','Pardo Gimeno','Primo de Rivera']], // confirmado
            ['User' => 'Gus', 'Name' => 'Gustavo' , 'Password' => '1288', 'locales' => ['Muchamiel','Jaime Segarra','Florida','Pardo Gimeno','Primo de Rivera']], // confirmado
            ['User' => 'Juego', 'Name' => 'Marina' , 'Password' => '2468', 'locales' => ['Muchamiel','Jaime Segarra','Florida','Pardo Gimeno','Primo de Rivera']], // confirmado
            ['User' => 'Amal', 'Name' => 'Amal' , 'Password' => '4992', 'locales' => ['Muchamiel','Jaime Segarra','Florida','Pardo Gimeno','Primo de Rivera']], // confirmado
            ['User' => 'Jade', 'Name' => 'Patricia' , 'Password' => '2012', 'locales' => ['Muchamiel','Jaime Segarra','Florida','Pardo Gimeno','Primo de Rivera']], // confirmado
            ['User' => 'Alfonso', 'Name' => 'Alfonso' , 'Password' => '7890', 'locales' => ['Muchamiel','Jaime Segarra','Florida','Pardo Gimeno','Primo de Rivera']], // confirmado
            ['User' => 'Ebelliard65', 'Name' => 'Evelyn' , 'Password' => '1975', 'locales' => ['Muchamiel','Jaime Segarra','Florida','Pardo Gimeno','Primo de Rivera']], // confirmado
            ['User' => 'Andrea', 'Name' => 'Andrea' , 'Password' => '1998', 'locales' => ['Muchamiel','Jaime Segarra','Florida','Pardo Gimeno','Primo de Rivera']], // confirmado
            ['User' => 'Alba', 'Name' => 'Alba' , 'Password' => '1234', 'locales' => ['Muchamiel','Jaime Segarra','Florida','Pardo Gimeno','Primo de Rivera']], // confirmado
            ['User' => 'Ana', 'Name' => 'Ana' , 'Password' => '2424', 'locales' => ['Muchamiel','Jaime Segarra','Florida','Pardo Gimeno','Primo de Rivera']], // confirmado
            ['User' => 'Julia', 'Name' => 'Julia' , 'Password' => '7131', 'locales' => ['Muchamiel','Jaime Segarra','Florida','Pardo Gimeno','Primo de Rivera']], // confirmado
            ['User' => 'Bealove', 'Name' => 'Bea' , 'Password' => '2314', 'locales' => ['Muchamiel','Jaime Segarra','Florida','Pardo Gimeno','Primo de Rivera']], // confirmado
            ['User' => 'Marcos', 'Name' => 'Marcos' , 'Password' => 'Lopez19', 'locales' => ['Muchamiel','Jaime Segarra','Florida','Pardo Gimeno','Primo de Rivera']], // confirmado
            ['User' => 'Erica', 'Name' => 'Erica' , 'Password' => '2305', 'locales' => ['Muchamiel','Jaime Segarra','Florida','Pardo Gimeno','Primo de Rivera']], // confirmado
            ['User' => 'Ainhoa', 'Name' => 'Ainhoa' , 'Password' => '290496', 'locales' => ['Muchamiel','Jaime Segarra','Florida','Pardo Gimeno','Primo de Rivera']], // confirmado
            ['User' => 'Monica', 'Name' => 'Monica' , 'Password' => '0702', 'locales' => ['Muchamiel','Jaime Segarra','Florida','Pardo Gimeno','Primo de Rivera']], // confirmado
            ['User' => 'Javi', 'Name' => 'Javi' , 'Password' => '1243', 'locales' => ['Muchamiel','Jaime Segarra','Florida','Pardo Gimeno','Primo de Rivera']], // confirmado
            ['User' => 'Salvador', 'Name' => 'Salvador' , 'Password' => '6121', 'locales' => ['Vergel', 'Pego', 'Ondara'], 'PID' => 'PID- 3B008099D8'],// confirmado
            ['User' => 'Nadia', 'Name' => 'Nadia' , 'Password' => '1220', 'locales' => ['Vergel', 'Pego', 'Ondara'], 'PID' => 'PID-1B008BF916'],// confirmado
            ['User' => 'Anita', 'Name' => 'Anita' , 'Password' => '4212', 'locales' => ['Javea', 'Gata de Gorgos', 'Teulada','Calpe']],// confirmado

        ];

        foreach ($personalSala as $user) {
            $userTicket = UserTicketServer::create([
                'User' => $user['User'],
                'Name' => $user['Name'],
                'Password' => $user['Password'] != '' ? Crypt::encrypt($user['Password']) : $user['Password'],
                'Rights' => 'CREATETICKET, GETANDCLOSETICKET, PRINTTICKET, LISTTICKETS, LISTTICKETSPENDING, LISTCONFIRMTICKETS, REPORTTICKETS, COLLECT',
                'PIN' => $user['Password'],
                'SessionType' => '-1',
                'PID' => isset($user['PID']) ? Crypt::encrypt($user['PID']) : '',
                'rol' => 'Personal sala',
                'updated_at' => now(),
                'created_at' => now()
            ]);

            $userTicket->delegations()->attach(1);

            foreach($user['locales'] as $salon){
                $local = Local::where('name', $salon)->first();
                //dd($local);
                if ($local) {
                    $userTicket->locals()->attach($local->id);
                }
            }
        }



        $personalCaja = [
            ['User' => 'Salón Jaime', 'PID' => 'PID-73006CB83A', 'Password' => '', 'local' => 'Jaime Segarra'],
            ['User' => 'Salón Pardo', 'PID' => 'PID-1B008BBB5A', 'Password' => '', 'local' => 'Pardo Gimeno'],
            ['User' => 'Salón Muchamiel', 'PID' => 'PID-1B008A9315', 'Password' => '', 'local' => 'Muchamiel'],
            ['User' => 'Salón Florida', 'PID' => 'PID-3B0081087E', 'Password' => '', 'local' => 'Florida'],
            ['User' => 'Salón Benisa', 'PID' => 'PID-7F002AEC14', 'Password' => '', 'local' => 'Benisa'], // confirmado
            ['User' => 'Salón Jávea', 'PID' => 'PID-3800800B1A', 'Password' => '', 'local' => 'Javea'],
            ['User' => 'Salón Denia', 'PID' => 'PID-7B0077CC31', 'Password' => '', 'local' => 'Denia'],
            ['User' => 'Salón Ondara Caja', 'PID' => 'PID-010A0FD9B6', 'Password' => '', 'local' => 'Ondara'],
            ['User' => 'Salón La Nucia', 'PID' => 'PID-3B00857DE8', 'Password' => '2902', 'local' => 'La Nucia'],
            ['User' => 'Salón Villajoyosa', 'PID' => 'PID-3B007A7084', 'Password' => '', 'local' => 'Villajoyosa'],
            ['User' => 'Salón Teulada', 'PID' => 'PID-7B0077C02A', 'Password' => '', 'local' => 'Teulada'], // confirmado
            ['User' => 'Salón Calpe', 'PID' => 'PID-0200927CE9', 'Password' => '', 'local' => 'Calpe'],
            ['User' => 'Salón Vergel', 'PID' => 'PID-0E005BEE44', 'Password' => '', 'local' => 'Vergel'],
            ['User' => 'Salón Pego', 'PID' => 'PID-0E005BCCD5', 'Password' => '', 'local' => 'Pego'],
            ['User' => 'Salón Primo', 'PID' => 'PID-5500557DFC', 'Password' => '', 'local' => 'Primo de Rivera'],
            ['User' => 'Salón Gata', 'PID' => 'PID-780086A7CF', 'Password' => '', 'local' => 'Gata de Gorgos'] // confirmado
        ];


        foreach ($personalCaja as $caja) {
            $userTicket = UserTicketServer::create([
                'User' => $caja['User'],
                'Password' => $caja['Password'] != '' ? Crypt::encrypt($caja['Password']) : $caja['Password'],
                'Rights' => 'PRINTTICKET, LISTTICKETS, LISTTICKETSPENDING, LISTCONFIRMTICKETS, REPORTTICKETS, COLLECT',
                'PIN' => $caja['Password'],
                'SessionType' => '-1',
                'PID' => $caja['PID'] != '' ? Crypt::encrypt($caja['PID']) : '',
                'rol' => 'Caja',
                'updated_at' => now(),
                'created_at' => now()
            ]);

            $userTicket->delegations()->attach(1);

            $local = Local::where('name', $caja['local'])->first();
            if ($local) {
                $userTicket->locals()->attach($local->id);
            }
        }

        $usuariosPerdidos = [
            ['User' => 'Vicente Perdido', 'Name' => 'Vicente', 'PID' => 'PID-0900E7306E', 'Password' => '2909'], // confirmado
            ['User' => 'Sergio Perdido', 'Name' => 'Sergio', 'PID' => 'PID-0900D3DBBF', 'Password' => '5384'], // confirmado
            ['User' => 'Ricardo Perdido', 'Name' => 'Ricardo', 'PID' => 'PID-3B00896A60', 'Password' => '9306'], // confirmado
            ['User' => 'Rafa viejo', 'Name' => 'Rafa', 'PID' => 'PID-0E001FF70C', 'Password' => '1137'], // confirmado
            ['User' => 'Juanfran viejo', 'Name' => 'Juanfran', 'PID' => 'PID-3B0081087F', 'Password' => '1623'], // confirmado
            ['User' => 'Javi Perdido', 'Name' => 'Javi', 'PID' => 'PID-1B0086451D', 'Password' => '1243'], // confirmado
            ['User' => 'Ismael Perdido', 'Name' => 'Ismael', 'PID' => 'PID-3B007DEE83', 'Password' => '2112'], // confirmado
            ['User' => 'Duván Perdido', 'Name' => 'Duván', 'PID' => 'PID-1B008A3B19', 'Password' => '1113'], // confirmado
            ['User' => 'Alex viejo', 'Name' => 'Alex', 'PID' => 'PID-3B0075229B', 'Password' => '1989'], // confirmado
            ['User' => 'Antonio viejo', 'Name' => 'Antonio', 'PID' => 'PID-0E001E7D7B', 'Password' => '1395'], // confirmado
            ['User' => 'Antonio Perdido', 'Name' => 'Antonio', 'PID' => 'PID-3B008744C2', 'Password' => '9513'], // confirmado
            ['User' => 'Antonio roto', 'Name' => 'Antonio', 'PID' => 'PID-1B008A9315', 'Password' => '9513'], // confirmado

        ];

        foreach ($usuariosPerdidos as $perdido) {
            $userTicket = UserTicketServer::create([
                'User' => $perdido['User'],
                'Name' => $perdido['Name'],
                'Password' => $perdido['Password'] != '' ? Crypt::encrypt($perdido['Password']) : $perdido['Password'],
                'Rights' => '',
                'PID' => $perdido['PID'] != '' ? Crypt::encrypt($perdido['PID']) : '',
                'rol' => 'Desconocido',
                'updated_at' => now(),
                'created_at' => now()
            ]);

            $userTicket->delegations()->attach(1);
        }
    }
}







