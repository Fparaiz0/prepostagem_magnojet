<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
  public function run(): void
  {
    try {
      Role::firstOrCreate(
        ['name' => 'Super Admin'],
        ['name' => 'Super Admin'],
      );

      $admin = Role::firstOrCreate(
        ['name' => 'Admin'],
        ['name' => 'Admin'],
      );

      $admin->givePermissionTo([

        'dashboard',

        'show-profile',
        'edit-profile',
        'edit-password-profile',

        'index-user',
        'show-user',
        'create-user',
        'edit-user',
        'edit-password-user',
        'edit-roles-user',
        'destroy-user',

        'index-user-status',
        'show-user-status',
        'create-user-status',
        'edit-user-status',
        'destroy-user-status',

        'index-role',
        'show-role',
        'create-role',
        'edit-role',
        'destroy-role',

        'index-role-permission',

        'index-packaging',
        'show-packaging',
        'create-packaging',
        'edit-packaging',
        'destroy-packaging',

        'index-sender',
        'show-sender',
        'create-sender',
        'edit-sender',
        'destroy-sender',

        'index-recipient',
        'show-recipient',
        'create-recipient',
        'edit-recipient',
        'destroy-recipient',

        'index-prepostagem',
        'show-prepostagem',
        'create-prepostagem',
        'canceled-prepostagem',
        'posted-prepostagem',
        'destroy-prepostagem',

        'index-range',
        'show-range',
        'create-range',
      ]);

      $colaborador = Role::firstOrCreate(
        ['name' => 'Colaborador'],
        ['name' => 'Colaborador'],
      );

      $colaborador->givePermissionTo([

        'dashboard',

        'show-profile',
        'edit-profile',
        'edit-password-profile',

        'index-packaging',
        'show-packaging',

        'index-sender',
        'show-sender',

        'index-recipient',
        'show-recipient',
        'create-recipient',
        'edit-recipient',
        'destroy-recipient',

        'index-prepostagem',
        'show-prepostagem',
        'create-prepostagem',
        'canceled-prepostagem',
        'posted-prepostagem',
        'destroy-prepostagem',


        'index-range',
        'show-range',
      ]);

    } catch (Exception $e) {
      Log::notice('Papel não cadastrado.', ['error' => $e->getMessage()]);
    }
  }
}
