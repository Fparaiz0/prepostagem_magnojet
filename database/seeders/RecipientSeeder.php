<?php

namespace Database\Seeders;

use App\Models\Recipient;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class RecipientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Capturar possíveis exceções durante a execução do código.
        try {
            // Se não encontrar o registro com o nome, cadastra o registro no BD
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
        }catch (Exception $e) {
            Log::notice('Destinatário não cadastrado.', ['error' => $e->getMessage()]);
        }
    }
}
