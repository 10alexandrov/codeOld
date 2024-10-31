<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Roles
        $superAdminDelegations = Role::firstOrCreate(['name' => 'Super Admin'],['name' => 'Super Admin']);
        $bossDelegations = Role::firstOrCreate(['name' => 'Jefe Delegacion'],['name' => 'Jefe Delegacion']);
        $TecnicsDelegation = Role::firstOrCreate(['name' => 'Tecnico'],['name' => 'Tecnico']);
        $bossSalons = Role::firstOrCreate(['name' => 'Jefe Salones'],['name' => 'Jefe Salones']);
        $office = Role::firstOrCreate(['name' => 'Oficina'],['name' => 'Oficina']);
        //$lost = Role::firstOrCreate(['name' => 'Perdidos'],['name' => 'Perdidos']);

        // Permisos para el super admin
        Permission::firstOrCreate(['name' => 'ver rolPer'],['name' => 'ver rolPer']);
        Permission::firstOrCreate(['name' => 'editar rolPer'],['name' => 'editar rolPer']);
        Permission::firstOrCreate(['name' => 'crear rolPer'],['name' => 'crear rolPer']);
        Permission::firstOrCreate(['name' => 'eliminar rolPer'],['name' => 'eliminar rolPer']);

        Permission::firstOrCreate(['name' => 'ver jefes tecnicos'],['name' => 'ver jefes tecnicos']);
        Permission::firstOrCreate(['name' => 'editar jefes tecnicos'],['name' => 'editar jefes tecnicos']);
        Permission::firstOrCreate(['name' => 'crear jefes tecnicos'],['name' => 'crear jefes tecnicos']);
        Permission::firstOrCreate(['name' => 'eliminar jefes tecnicos'],['name' => 'eliminar jefes tecnicos']);

        Permission::firstOrCreate(['name' => 'ver delegaciones'],['name' => 'ver delegaciones']);
        Permission::firstOrCreate(['name' => 'editar delegaciones'],['name' => 'editar delegaciones']);
        Permission::firstOrCreate(['name' => 'crear delegaciones'],['name' => 'crear delegaciones']);
        Permission::firstOrCreate(['name' => 'eliminar delegaciones'],['name' => 'eliminar delegaciones']);

        Permission::firstOrCreate(['name' => 'ver zonas'],['name' => 'ver zonas']);
        Permission::firstOrCreate(['name' => 'editar zonas'],['name' => 'editar zonas']);
        Permission::firstOrCreate(['name' => 'crear zonas'],['name' => 'crear zonas']);
        Permission::firstOrCreate(['name' => 'eliminar zonas'],['name' => 'eliminar zonas']);

        Permission::firstOrCreate(['name' => 'ver locales'],['name' => 'ver locales']);
        Permission::firstOrCreate(['name' => 'editar locales'],['name' => 'editar locales']);
        Permission::firstOrCreate(['name' => 'crear locales'],['name' => 'crear locales']);
        Permission::firstOrCreate(['name' => 'eliminar locales'],['name' => 'eliminar locales']);

        Permission::firstOrCreate(['name' => 'ver tecnicos'],['name' => 'ver tecnicos']);
        Permission::firstOrCreate(['name' => 'editar tecnicos'],['name' => 'editar tecnicos']);
        Permission::firstOrCreate(['name' => 'crear tecnicos'],['name' => 'crear tecnicos']);
        Permission::firstOrCreate(['name' => 'eliminar tecnicos'],['name' => 'eliminar tecnicos']);

        Permission::firstOrCreate(['name' => 'ver tickets'],['name' => 'ver tickets']);
        Permission::firstOrCreate(['name' => 'editar tickets'],['name' => 'editar tickets']);
        Permission::firstOrCreate(['name' => 'crear tickets'],['name' => 'crear tickets']);
        Permission::firstOrCreate(['name' => 'eliminar tickets'],['name' => 'eliminar tickets']);

        Permission::firstOrCreate(['name' => 'ver auxiliares'],['name' => 'ver auxiliares']);
        Permission::firstOrCreate(['name' => 'editar auxiliares'],['name' => 'editar auxiliares']);
        Permission::firstOrCreate(['name' => 'crear auxiliares'],['name' => 'crear auxiliares']);
        Permission::firstOrCreate(['name' => 'eliminar auxiliares'],['name' => 'eliminar auxiliares']);

        // Asignando permisos al rol de super admin
        $superAdminDelegations->givePermissionTo('ver rolPer');
        $superAdminDelegations->givePermissionTo('editar rolPer');
        $superAdminDelegations->givePermissionTo('crear rolPer');
        $superAdminDelegations->givePermissionTo('eliminar rolPer');

        $superAdminDelegations->givePermissionTo('ver jefes tecnicos');
        $superAdminDelegations->givePermissionTo('editar jefes tecnicos');
        $superAdminDelegations->givePermissionTo('crear jefes tecnicos');
        $superAdminDelegations->givePermissionTo('eliminar jefes tecnicos');

        $superAdminDelegations->givePermissionTo('ver delegaciones');
        $superAdminDelegations->givePermissionTo('editar delegaciones');
        $superAdminDelegations->givePermissionTo('crear delegaciones');
        $superAdminDelegations->givePermissionTo('eliminar delegaciones');

        $superAdminDelegations->givePermissionTo('ver zonas');
        $superAdminDelegations->givePermissionTo('editar zonas');
        $superAdminDelegations->givePermissionTo('crear zonas');
        $superAdminDelegations->givePermissionTo('eliminar zonas');

        $superAdminDelegations->givePermissionTo('ver locales');
        $superAdminDelegations->givePermissionTo('editar locales');
        $superAdminDelegations->givePermissionTo('crear locales');
        $superAdminDelegations->givePermissionTo('eliminar locales');

        $superAdminDelegations->givePermissionTo('ver tecnicos');
        $superAdminDelegations->givePermissionTo('editar tecnicos');
        $superAdminDelegations->givePermissionTo('crear tecnicos');
        $superAdminDelegations->givePermissionTo('eliminar tecnicos');

        $superAdminDelegations->givePermissionTo('ver tickets');
        $superAdminDelegations->givePermissionTo('editar tickets');
        $superAdminDelegations->givePermissionTo('crear tickets');
        $superAdminDelegations->givePermissionTo('eliminar tickets');

        $superAdminDelegations->givePermissionTo('ver auxiliares');
        $superAdminDelegations->givePermissionTo('editar auxiliares');
        $superAdminDelegations->givePermissionTo('crear auxiliares');
        $superAdminDelegations->givePermissionTo('eliminar auxiliares');

        //BOSSDELEGATION
        $bossDelegations->givePermissionTo('ver delegaciones');

        $bossDelegations->givePermissionTo('ver zonas');
        $bossDelegations->givePermissionTo('editar zonas');
        $bossDelegations->givePermissionTo('crear zonas');
        $bossDelegations->givePermissionTo('eliminar zonas');

        $bossDelegations->givePermissionTo('ver locales');
        $bossDelegations->givePermissionTo('editar locales');
        $bossDelegations->givePermissionTo('crear locales');
        $bossDelegations->givePermissionTo('eliminar locales');

        $bossDelegations->givePermissionTo('ver tecnicos');
        $bossDelegations->givePermissionTo('editar tecnicos');
        $bossDelegations->givePermissionTo('crear tecnicos');
        $bossDelegations->givePermissionTo('eliminar tecnicos');

        $bossDelegations->givePermissionTo('ver tickets');
        $bossDelegations->givePermissionTo('editar tickets');
        $bossDelegations->givePermissionTo('crear tickets');
        $bossDelegations->givePermissionTo('eliminar tickets');

        $bossDelegations->givePermissionTo('ver auxiliares');
        $bossDelegations->givePermissionTo('editar auxiliares');
        $bossDelegations->givePermissionTo('crear auxiliares');
        $bossDelegations->givePermissionTo('eliminar auxiliares');

        // BOSSSALONES
        $bossSalons->givePermissionTo('ver delegaciones');
        $bossSalons->givePermissionTo('ver zonas');
        $bossSalons->givePermissionTo('ver locales');

        $bossSalons->givePermissionTo('ver tickets');
        $bossSalons->givePermissionTo('editar tickets');
        $bossSalons->givePermissionTo('crear tickets');
        $bossSalons->givePermissionTo('eliminar tickets');

        $bossSalons->givePermissionTo('ver auxiliares');
        $bossSalons->givePermissionTo('crear auxiliares');

        // OFICINA
        $office->givePermissionTo('ver delegaciones');
        $office->givePermissionTo('ver zonas');
        $office->givePermissionTo('ver locales');
        $office->givePermissionTo('ver tickets');

        $office->givePermissionTo('ver auxiliares');
        $office->givePermissionTo('ver tickets');

        //TECNICOS
        $TecnicsDelegation->givePermissionTo('ver zonas');
        $TecnicsDelegation->givePermissionTo('ver locales');

        $TecnicsDelegation->givePermissionTo('ver auxiliares');
        $TecnicsDelegation->givePermissionTo('crear auxiliares');

        $TecnicsDelegation->givePermissionTo('ver tickets');
        $TecnicsDelegation->givePermissionTo('editar tickets');

        //PERDIDOS

    }
}
