<?php

namespace Database\Seeders;

use App\Models\User;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class UserSeeder extends Seeder
{
  public function run(): void
  {

    try {
      if (!User::where('email', 'fparaizo3@gmail.com')->first()) {
        $superAdmin = User::create([
          'name' => 'Felipe Paraizo',
          'email' => 'fparaizo3@gmail.com',
          'password' => '123456A#',
        ]);

        $superAdmin->assignRole('Super Admin');

      }

      if (App::environment() !== 'production') {
        $admin = User::firstOrCreate(
          ['email' => 'aldaircunha@terra.com.br'],
          ['name' => 'Aldair', 'email' => 'aldaircunha@terra.com.br', 'password' => '123456A#'],
        );

        $admin->assignRole('Admin');

        $colaborador = User::firstOrCreate(
          ['email' => 'tanio@magnojet.com.br'],
          ['name' => 'Tanio', 'email' => 'tanio@magnojet.com.br', 'password' => '123456A#'],
        );

        $colaborador->assignRole('Colaborador');
      }

    } catch (Exception $e) {
      Log::notice('Usuário não cadastrado.', ['error' => $e->getMessage()]);
    }
  }
}
