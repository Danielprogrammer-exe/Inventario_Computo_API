<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class TechnicianRoleAndPermissionSeeder extends Seeder
{
    public function run()
    {
        DB::transaction(function () {
            $listPermission = Permission::create(['name' => 'listar mantenimientos']);
            $modifyPermission = Permission::create(['name' => 'modificar mantenimientos']);

            $techRole = Role::create(['name' => 'tecnico']);
            $techRole->syncPermissions([$listPermission, $modifyPermission]);
        });
    }
}
