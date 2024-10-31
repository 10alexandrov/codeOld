<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TypeMachines;
use App\Models\Local;
use App\Models\Delegation;


class TypeMachinesSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $typeMachines = [
            'ACTION STAR', 'ACTION STAR A', 'ACTION STAR B', 'ACTION STAR C',
            'DIAMOND', 'DIAMOND A', 'DIAMOND B', 'DIAMOND C',
            'FORTUNE', 'FORTUNE A', 'FORTUNE B', 'FORTUNE C',
            'GRAN LUX', 'GRAN LUX A', 'GRAN LUX B', 'GRAN LUX C',
            'IMPERA', 'IMPERA A', 'IMPERA B', 'IMPERA C', 'IMPERA D', 'IMPERA E', 'IMPERA F',
            'LINK ME', 'LINK ME A', 'LINK ME B', 'LINK ME C',
            'LINK MIX', 'LINK MIX A', 'LINK MIX B', 'LINK MIX C',
            'LINK OF GODS', 'LINK OF GODS A', 'LINK OF GODS B', 'LINK OF GODS C',
            'M-BOX', 'M-BOX A', 'M-BOX B', 'M-BOX C', 'M-BOX 30', 'M-BOX 31', 'M-BOX 32', 'M-BOX 40', 'M-BOX 41', 'M-BOX 42',
            'M-MAX', 'M-MAX A', 'M-MAX B', 'M-MAX C',
            'MERKUR II', 'MERKUR II A', 'MERKUR II B', 'MERKUR II C',
            'MERKUR III', 'MERKUR III A', 'MERKUR III B', 'MERKUR III C',
            'MULTILINKING', 'MULTILINKING A', 'MULTILINKING B', 'MULTILINKING C',
            'MYSTIC LINK', 'MYSTIC LINK A', 'MYSTIC LINK B', 'MYSTIC LINK C',
            'OPERA', 'OPERA A', 'OPERA B', 'OPERA C',
            'POWER LINK', 'POWER LINK A', 'POWER LINK B', 'POWER LINK C', 'POWER LINK D', 'POWER LINK E', 'POWER LINK F',
            'PYRO', 'PYRO A', 'PYRO B', 'PYRO C',
            'ROCKET LINK', 'ROCKET LINK A', 'ROCKET LINK B', 'ROCKET LINK C',
            'RULETA', 'RULETA PUESTO 1', 'RULETA PUESTO 2', 'RULETA PUESTO 3', 'RULETA PUESTO 4', 'RULETA PUESTO 5', 'RULETA PUESTO 6', 'RULETA PUESTO 7', 'RULETA PUESTO 8',
            'SOLAR LINK', 'SOLAR LINK A', 'SOLAR LINK B', 'SOLAR LINK C',
            'TECNAUSA',
            'TRIO POWER', 'TRIO POWER A', 'TRIO POWER B', 'TRIO POWER C',
            'ZITRO', 'ZITRO A', 'ZITRO B', 'ZITRO C',
            'ORGANIC','ORGANIC SAT 1', 'ORGANIC SAT 2', 'ORGANIC SAT 3', 'ORGANIC SAT 4', 'ORGANIC SAT 5', 'ORGANIC SAT 6', 'ORGANIC SAT 7', 'ORGANIC SAT 8',
            'test','APUESTA DEPORTIVA '

        ];

        foreach ($typeMachines as $name) {
            $tipo = TypeMachines::create([
                'name' => $name,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Attach delegation
            $delegation = Delegation::find(1);
            if ($delegation) {
                $tipo->delegation()->attach($delegation->id); // Ensure proper delegation ID
            }

            // Attach locals
            $locals = Local::all();
            foreach ($locals as $local) {
                $local->type_machines()->syncWithoutDetaching([$tipo->id]);
            }
        }
    }
}
