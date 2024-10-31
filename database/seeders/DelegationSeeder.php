<?php

namespace Database\Seeders;

use App\Models\Delegation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DelegationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //DEJAR DELEGACIÓN PROMETEO PARA CREAR SUPERUSER
        Delegation::create(['id' => 0, 'name' => 'Prometeo']);

        collect([
            'Benidorm',
        ])->each(function ($delegation) {
            Delegation::factory()->create(['name' => $delegation]);
        });
    }
}
