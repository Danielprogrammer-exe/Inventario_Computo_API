<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateRolesAndPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Asegurarse de que las tablas existan
        if (Schema::hasTable('roles') && Schema::hasTable('permissions')) {

            // Crear permisos
            Permission::create(['name' => 'listar mantenimientos']);
            Permission::create(['name' => 'modificar mantenimientos']);

            // Crear rol y asignar permisos
            $techRole = Role::create(['name' => 'tecnico']);
            $techRole->givePermissionTo('listar mantenimientos');
            $techRole->givePermissionTo('modificar mantenimientos');

            // Crear rol de admin
            $adminRole = Role::create(['name' => 'admin']);
            $adminRole->givePermissionTo(Permission::all());
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Eliminar roles y permisos creados (opcional)
        $techRole = Role::where('name', 'tecnico')->first();
        $adminRole = Role::where('name', 'admin')->first();

        if ($techRole) $techRole->delete();
        if ($adminRole) $adminRole->delete();

        Permission::where('name', 'listar mantenimientos')->delete();
        Permission::where('name', 'modificar mantenimientos')->delete();
    }
}
