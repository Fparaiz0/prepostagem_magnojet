<?php

namespace Database\Seeders;

use App\Models\Recipient;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class RecipientSeeder extends Seeder
{
  public function run(): void
  {
    try {
      Recipient::firstOrCreate(
        [
          'name' => 'LMC PULVERIZADORES',
          'id' => 1
        ],
        [
          'id' => 1,
          'name' => 'LMC PULVERIZADORES',
          'cnpj' => '12345678000195',
          'cep' => '84900000',
          'public_place' => 'BR-153, KM 103',
          'number' => 'S/N',
          'neighborhood' => 'BR',
          'city' => 'Ibaiti',
          'uf' => 'PR'
        ],
      );
    } catch (Exception $e) {
      Log::notice('Destinatário não cadastrado.', ['error' => $e->getMessage()]);
    }
  }
}
