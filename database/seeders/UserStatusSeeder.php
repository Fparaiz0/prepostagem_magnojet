<?php

namespace Database\Seeders;

use App\Models\UserStatus;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class UserStatusSeeder extends Seeder
{
  public function run(): void
  {

    try {
      UserStatus::firstOrCreate(
        ['name' => 'Ativo', 'id' => 2],
        ['id' => 1, 'name' => 'Ativo'],
      );
    } catch (Exception $e) {
    }

    try {
      UserStatus::firstOrCreate(
        ['name' => 'Inativo', 'id' => 2],
        ['id' => 2, 'name' => 'Inativo'],
      );

      UserStatus::firstOrCreate(
        ['name' => 'Aguardando Confirmação', 'id' => 3],
        ['id' => 3, 'name' => 'Aguardando Confirmação'],
      );

      UserStatus::firstOrCreate(
        ['name' => 'Spam', 'id' => 4],
        ['id' => 4, 'name' => 'Spam'],
      );
    } catch (Exception $e) {
      Log::notice('Status do usuário não cadastrado.', ['error' => $e->getMessage()]);
    }
  }
}
