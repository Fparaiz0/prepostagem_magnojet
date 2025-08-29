<?php

namespace Database\Seeders;

use App\Models\User;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Capturar possíveis exceções durante a execução do seeder. 
        try {
            // Verificar se o usuário está cadastrado no banco de dados
            if (!User::where('email', 'fparaizo3@gmail.com')->first()) {
                // Cadastrar o usuário
                $superAdmin = User::create([
                    'name' => 'Felipe Paraizo',
                    'email' => 'fparaizo3@gmail.com',
                    'password' => '123456A#',
                ]);

                // Atribuir papel para o usuário
                $superAdmin->assignRole('Super Admin');

            }

            if (App::environment() !== 'production') {
                // Se não encontrar o registro com o e-mail, cadastra o registro no BD
                $admin = User::firstOrCreate(
                    ['email' => 'aldaircunha@terra.com.br'],
                    ['name' => 'Aldair', 'email' => 'aldaircunha@terra.com.br', 'password' => '123456A#'],
                );

                // Atribuir papel para o usuário
                $admin->assignRole('Admin');

                // Se não encontrar o registro com o e-mail, cadastra o registro no BD
                $colaborador = User::firstOrCreate(
                    ['email' => 'tanio@magnojet.com.br'],
                    ['name' => 'Tanio', 'email' => 'tanio@magnojet.com.br', 'password' => '123456A#'],
                );

                // Atribuir papel para o usuário
                $colaborador->assignRole('Colaborador');
            }

        } catch (Exception $e) {
            Log::notice('Usuário não cadastrado.', ['error' => $e->getMessage()]);
        }
    }
}
