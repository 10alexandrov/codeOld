<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Delegation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Permission\Models\Role;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*if (!Role::where('name', 'Tecnico')->exists()) {
            Role::create(['name' => 'Tecnico']);
        }*/

        $prometeo = User::factory()->create([
            'name' => 'Prometeo',
            'email' => 'prometeo@magarin.es',

            'password' => bcrypt('Admin1234'),
        ]);

        $prometeo->assignRole('Super Admin');
        $prometeo->save();

        $fran = User::factory()->create([
            'name' => 'Fran',
            'email' => 'franciscoexposito@magarin.es',
            'password' => bcrypt('Fran1234'),
        ]);

        $fran->assignRole('Jefe Delegacion');
        $fran->delegation()->attach(1);
        $fran->save();

        $Pepe = User::factory()->create([
            'name' => 'Pepe',
            'email' => 'jmpalazon@magarin.es',
            'password' => bcrypt('Magarin1234'),
        ]);

        $Pepe->assignRole('Jefe Salones');
        $Pepe->delegation()->attach(1);
        $Pepe->save();

        $Benidorm = User::factory()->create([
            'name' => 'Benidorm',
            'email' => 'Benidorm@magarin.es',
            'password' => bcrypt('Magarin1234'),
        ]);

        $Benidorm->assignRole('Oficina');
        $Benidorm->delegation()->attach(1);
        $Benidorm->save();

        $Ricardo = User::factory()->create([
            'name' => 'Ricardo',
            'email' => 'ricardogranados@magarin.es',
            'password' => bcrypt('Magarin1234'),
        ]);

        $Ricardo->assignRole('Tecnico');
        $Ricardo->delegation()->attach(1);
        $Ricardo->save();

        $Rafael = User::factory()->create([
            'name' => 'Rafael',
            'email' => 'rafaelgranados@magarin.es',
            'password' => bcrypt('Magarin1234'),
        ]);

        $Rafael->assignRole('Tecnico');
        $Rafael->delegation()->attach(1);
        $Rafael->save();

        $JF = User::factory()->create([
            'name' => 'JuanFran',
            'email' => 'juanfranciscogarcia@magarin.es',
            'password' => bcrypt('Magarin1234'),
        ]);

        $JF->assignRole('Tecnico');
        $JF->delegation()->attach(1);
        $JF->save();

        $Ramon = User::factory()->create([
            'name' => 'Ramon',
            'email' => 'ramontrujillo@magarin.es',
            'password' => bcrypt('Magarin1234'),
        ]);

        $Ramon->assignRole('Tecnico');
        $Ramon->delegation()->attach(1);
        $Ramon->save();

        $Antonio = User::factory()->create([
            'name' => 'Antonio',
            'email' => 'antoniovicens@magarin.es',
            'password' => bcrypt('Magarin1234'),
        ]);

        $Antonio->assignRole('Tecnico');
        $Antonio->delegation()->attach(1);
        $Antonio->save();

        $Daniel = User::factory()->create([
            'name' => 'Daniel',
            'email' => 'danielaguirre@magarin.es',
            'password' => bcrypt('Magarin1234'),
        ]);

        $Daniel->assignRole('Tecnico');
        $Daniel->delegation()->attach(1);
        $Daniel->save();

        $Sergio = User::factory()->create([
            'name' => 'Sergio',
            'email' => 'sergioespana@magarin.es',
            'password' => bcrypt('Magarin1234'),
        ]);

        $Sergio->assignRole('Tecnico');
        $Sergio->delegation()->attach(1);
        $Sergio->save();

        $Vicente = User::factory()->create([
            'name' => 'Vicente',
            'email' => 'vicenteferrer@magarin.es',
            'password' => bcrypt('Magarin1234'),
        ]);

        $Vicente->assignRole('Tecnico');
        $Vicente->delegation()->attach(1);
        $Vicente->save();

        $Alberto = User::factory()->create([
            'name' => 'Alberto',
            'email' => 'albertogarcia@magarin.es',
            'password' => bcrypt('Magarin1234'),
        ]);

        $Alberto->assignRole('Tecnico');
        $Alberto->delegation()->attach(1);
        $Alberto->save();

        $Ismael = User::factory()->create([
            'name' => 'Ismael',
            'email' => 'ismaelzaragoza@magarin.es',
            'password' => bcrypt('Magarin1234'),
        ]);

        $Ismael->assignRole('Tecnico');
        $Ismael->delegation()->attach(1);
        $Ismael->save();

        $Salmeron = User::factory()->create([
            'name' => 'Salmeron',
            'email' => 'antoniosalmeron@magarin.es',
            'password' => bcrypt('Magarin1234'),
        ]);

        $Salmeron->assignRole('Tecnico');
        $Salmeron->delegation()->attach(1);
        $Salmeron->save();

        $Maurico = User::factory()->create([
            'name' => 'Maurico',
            'email' => 'mauricioirady@magarin.es',
            'password' => bcrypt('Magarin1234'),
        ]);

        $Maurico->assignRole('Tecnico');
        $Maurico->delegation()->attach(1);
        $Maurico->save();

        $Carlos = User::factory()->create([
            'name' => 'Carlos',
            'email' => 'carlos@magarin.es',
            'password' => bcrypt('Magarin1234'),
        ]);

        $Carlos->assignRole('Tecnico');
        $Carlos->delegation()->attach(1);
        $Carlos->save();

        $Lucia = User::factory()->create([
            'name' => 'Lucia',
            'email' => 'luciajimenez@magarin.es',
            'password' => bcrypt('Magarin1234'),
        ]);

        $Lucia->assignRole('Tecnico');
        $Lucia->delegation()->attach(1);
        $Lucia->save();

    }
}
