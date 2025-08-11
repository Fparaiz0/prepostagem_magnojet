<?php

namespace Database\Seeders;

use App\Models\Sender;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class SenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Capturar possíveis exceções durante a execução do código.
        try {
            // Se não encontrar o registro com o nome, cadastra o registro no BD
            Sender::firstOrCreate(
                [
                'name' => 'MAGNO JET INDUSTRIA LTDA', 
                'id' => 1
                ],
                [
                'id' => 1, 
                'name' => 'MAGNO JET INDUSTRIA LTDA',
                'cnpj' => '06092428000198', 
                'cep' => '84900000',
                'public_place' => 'Avenida Governador Paulo Cruz Pimentel',
                'number' => '1051', 
                'neighborhood' => 'Centro', 
                'city' => 'Ibaiti', 
                'uf' => 'PR'
                ],
            );
        }catch (Exception $e) {
            Log::notice('Remetente não cadastrado.', ['error' => $e->getMessage()]);
        }
    }
}