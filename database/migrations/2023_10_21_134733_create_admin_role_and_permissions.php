<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\User;

class CreateAdminRoleAndPermissions extends Migration
{
    public function up()
    {
        // Crear el rol 'admin'
        $admin = Role::create(['name' => 'admin', 'guard_name' => 'api']);

        // Crear los permisos. Por ejemplo:
        $permissions = [
            'view users',
            'edit users',
            'delete users',
            // ... (otros permisos que quieras agregar)
        ];

        foreach ($permissions as $permissionName) {
            $permission = Permission::create(['name' => $permissionName, 'guard_name' => 'api']);
            $admin->givePermissionTo($permission);  // Asigna el permiso al rol 'admin'
        }

        // O, si prefieres darle todos los permisos posibles al admin:
         $admin->givePermissionTo(Permission::all());

        // #################### PASO 3 ###############################
        $user = User::create([
            'name' => 'Admin Name',
            'email' => 'admin@example.com',
            'password' => bcrypt('password_secure')  // Cambia 'password_secure' a una contraseña segura de tu elección
        ]);

        // Asigna el rol 'admin' al usuario
        $user->assignRole('admin');
    }

    public function down()
    {
        $admin = Role::findByName('admin', 'api');
        $admin->delete();

        // Opcionalmente, también puedes eliminar los permisos si ya no los necesitas
        // Permission::whereIn('name', ['view users', 'edit users', 'delete users'])->delete();
    }
}
