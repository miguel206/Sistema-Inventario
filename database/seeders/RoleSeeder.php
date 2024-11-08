<?php

namespace Database\Seeders;

use GuzzleHttp\Promise\Create;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 = Role::create(['name' => 'admin']); //programador
        $role2 = Role::create(['name' => 'supervisor']); // encargado del inventario
        $role3 = Role::create(['name' => 'soporte']); // personal autorizado de soporte
        $role4 = Role::create(['name' => 'usuario']); // personal con acesso a justRead

        Permission::create(['name' => 'movimientos.alta'])->syncRoles($role1, $role2);
        Permission::create(['name' => 'movimientos.resguardo'])->syncRoles($role1, $role2, $role3);
        Permission::create(['name' => 'movimientos.devolucion'])->syncRoles($role1, $role2);
        Permission::create(['name' => 'movimientos.registro'])->syncRoles($role1, $role2);

        Permission::create(['name' => 'bienes.edit'])->syncRoles($role1, $role2);
        Permission::create(['name' => 'bienes.baja'])->syncRoles($role1, $role2);

        Permission::create(['name' => 'personal.edit'])->syncRoles($role1, $role2);
        Permission::create(['name' => 'personal.baja'])->syncRoles($role1, $role2);




    }
}
