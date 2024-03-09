<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear roles
        $rol_commerce = Role::create(['name' => 'commerce']);
        $rol_customer = Role::create(['name' => 'customer']);
        $rol_ayuntamiento = Role::create(['name' => 'ayuntamiento']);

        // Crear permisos
        $perm_ver_commerces = Permission::create(['name' => 'ver commerces']);
        $perm_editar_commerces = Permission::create(['name' => 'editar commerces']);
        $perm_ver_custommers = Permission::create(['name' => 'ver custommers']);
        $perm_editar_custommers = Permission::create(['name' => 'editar custommers']);
        $perm_ver_posts = Permission::create(['name' => 'ver posts']);
        $perm_editar_posts = Permission::create(['name' => 'editar posts']);
        $perm_ver_reviews = Permission::create(['name' => 'ver reviews']);
        $perm_editar_reviews = Permission::create(['name' => 'editar reviews']);
        $perm_ver_followers = Permission::create(['name' => 'ver followers']);
        $perm_editar_followers = Permission::create(['name' => 'editar followers']);
        $perm_ver_comment = Permission::create(['name' => 'ver comments']);
        $perm_editar_comment = Permission::create(['name' => 'editar comments']);
        $perm_verificar_commerce = Permission::create(['name' => 'verificar commerces']);

        // Asignar permisos a roles
        $rol_commerce->givePermissionTo($perm_ver_comment);
        $rol_commerce->givePermissionTo($perm_editar_comment);
        $rol_commerce->givePermissionTo($perm_ver_custommers);
        $rol_commerce->givePermissionTo($perm_ver_commerces);
        $rol_commerce->givePermissionTo($perm_editar_commerces);
        $rol_commerce->givePermissionTo($perm_ver_reviews);
        $rol_commerce->givePermissionTo($perm_editar_reviews);
        $rol_commerce->givePermissionTo($perm_ver_followers);
        $rol_commerce->givePermissionTo($perm_editar_followers);
        $rol_commerce->givePermissionTo($perm_ver_posts);
        $rol_commerce->givePermissionTo($perm_editar_posts);

        $rol_customer->givePermissionTo($perm_ver_comment);
        $rol_customer->givePermissionTo($perm_editar_comment);
        $rol_customer->givePermissionTo($perm_ver_custommers);
        $rol_customer->givePermissionTo($perm_editar_custommers);
        $rol_customer->givePermissionTo($perm_ver_commerces);
        $rol_customer->givePermissionTo($perm_ver_reviews);
        $rol_customer->givePermissionTo($perm_editar_reviews);
        $rol_customer->givePermissionTo($perm_ver_followers);
        $rol_customer->givePermissionTo($perm_editar_followers);
        $rol_customer->givePermissionTo($perm_ver_posts);

        $rol_ayuntamiento->givePermissionTo($perm_ver_comment);
        $rol_ayuntamiento->givePermissionTo($perm_editar_comment);
        $rol_ayuntamiento->givePermissionTo($perm_ver_custommers);
        $rol_ayuntamiento->givePermissionTo($perm_ver_commerces);
        $rol_ayuntamiento->givePermissionTo($perm_editar_commerces);
        $rol_ayuntamiento->givePermissionTo($perm_ver_reviews);
        $rol_ayuntamiento->givePermissionTo($perm_editar_reviews);
        $rol_ayuntamiento->givePermissionTo($perm_ver_followers);
        $rol_ayuntamiento->givePermissionTo($perm_editar_followers);
        $rol_ayuntamiento->givePermissionTo($perm_ver_posts);
        $rol_ayuntamiento->givePermissionTo($perm_editar_posts);
        $rol_ayuntamiento->givePermissionTo($perm_verificar_commerce);

    }
}
