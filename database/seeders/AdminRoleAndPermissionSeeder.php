<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class AdminRoleAndPermissionSeeder extends Seeder
{
    public function run()
    {
        DB::transaction(function () {
            // Suponiendo que todos los permisos ya están creados
            $allPermissions = Permission::all();

            // Crear el rol de admin
            $adminRole = Role::create(['name' => 'admin']);

            // Asignar todos los permisos al rol de admin
            $adminRole->syncPermissions($allPermissions);
        });
    }
}
