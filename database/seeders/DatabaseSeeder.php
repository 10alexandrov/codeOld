<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\LoadSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            DelegationSeeder::class,
            ZoneSeeder::class,
            LocalSeeder::class,
            RolesTestSeeder::class,
            UserSeeder::class,
            UsersTicketServerSeeder::class,
            TypeMachinesSeeder::class,
            BarSeeder::class,
            MachinesSeeder::class,
            LoadSeeder::class
        ]);
    }
}
