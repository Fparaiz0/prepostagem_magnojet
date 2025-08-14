<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Capturar possíveis exceções durante a execução do seeder. 
        try {
            // Criar o array de páginas
            $permissions = [
                
                ['title'=> 'Dashboard', 'name' => 'dashboard'],
                
                ['title'=> 'Visualizar o perfil', 'name' => 'show-profile'],
                ['title'=> 'Editar o perfil', 'name' => 'edit-profile'],
                ['title'=> 'Editar a senha do perfil', 'name' => 'edit-password-profile'],
                
                ['title'=> 'Listar os usuários', 'name' => 'index-user'],
                ['title'=> 'Visualizar o usuário', 'name' => 'show-user'],
                ['title'=> 'Cadastrar o usuário', 'name' => 'create-user'],
                ['title'=> 'Editar o usuário', 'name' => 'edit-user'],
                ['title'=> 'Editar a senha do usuário', 'name' => 'edit-password-user'],
                ['title'=> 'Apagar o usuário', 'name' => 'destroy-user'],
                ['title'=> 'Editar papéis do usuário', 'name' => 'edit-roles-user'],

                ['title'=> 'Listar os status usuários', 'name' => 'index-user-status'],
                ['title'=> 'Visualizar o status usuário', 'name' => 'show-user-status'],
                ['title'=> 'Cadastrar o status usuário', 'name' => 'create-user-status'],
                ['title'=> 'Editar o status usuário', 'name' => 'edit-user-status'],
                ['title'=> 'Apagar o status usuário', 'name' => 'destroy-user-status'],
                
                ['title'=> 'Listar os papéis', 'name' => 'index-role'],
                ['title'=> 'Visualizar o papel', 'name' => 'show-role'],
                ['title'=> 'Cadastrar o papel', 'name' => 'create-role'],
                ['title'=> 'Editar o papel', 'name' => 'edit-role'],
                ['title'=> 'Apagar o papel', 'name' => 'destroy-role'],

                ['title'=> 'Listar as permissões do papel', 'name' => 'index-role-permission'],
                
                ['title'=> 'Listar as permissões', 'name' => 'index-permission'],
                ['title'=> 'Visualizar a permissão', 'name' => 'show-permission'],
                ['title'=> 'Cadastrar a permissão', 'name' => 'create-permission'],
                ['title'=> 'Editar a permissão', 'name' => 'edit-permission'],
                ['title'=> 'Apagar a permissão', 'name' => 'destroy-permission'],

                ['title'=> 'Listar as embalagens', 'name' => 'index-packaging'],
                ['title'=> 'Visualizar as embalagens', 'name' => 'show-packaging'],
                ['title'=> 'Cadastrar as embalagens', 'name' => 'create-packaging'],
                ['title'=> 'Editar as embalagens', 'name' => 'edit-packaging'],
                ['title'=> 'Apagar as embalagens', 'name' => 'destroy-packaging'],

                ['title'=> 'Listar os remetentes', 'name' => 'index-sender'],
                ['title'=> 'Visualizar os remetentes', 'name' => 'show-sender'],
                ['title'=> 'Cadastrar os remetentes', 'name' => 'create-sender'],
                ['title'=> 'Editar os remetentes', 'name' => 'edit-sender'],
                ['title'=> 'Apagar os remetentes', 'name' => 'destroy-sender'],

                ['title'=> 'Listar os destinatarios', 'name' => 'index-recipient'],
                ['title'=> 'Visualizar os destinatarios', 'name' => 'show-recipient'],
                ['title'=> 'Cadastrar os destinatarios', 'name' => 'create-recipient'],
                ['title'=> 'Editar os destinatarios', 'name' => 'edit-recipient'],
                ['title'=> 'Apagar os destinatarios', 'name' => 'destroy-recipient'],

                ['title'=> 'Listar as Pré-Postagem', 'name' => 'index-prepostagem'],
                ['title'=> 'Visualizar as Pré-Postagem', 'name' => 'show-prepostagem'],
                ['title'=> 'Cadastrar as Pré-Postagem', 'name' => 'create-prepostagem'],
                ['title'=> 'Editar as Pré-Postagem', 'name' => 'edit-prepostagem'],
                ['title'=> 'Apagar as Pré-Postagem', 'name' => 'destroy-prepostagem'],

                ['title'=> 'Listar as Etiquetas', 'name' => 'index-range'],
                ['title'=> 'Visualizar as Etiquetas', 'name' => 'show-range'],
                ['title'=> 'Gerar as Etiquetas', 'name' => 'create-range'],
            ];

            foreach ($permissions as $permission) {
                // Se não encontrar o registro, cadastra o registro no BD
                Permission::firstOrCreate(
                    ['title' => $permission['title'], 'name' => $permission['name']],
                    [
                        'title' => $permission['title'],
                        'name' => $permission['name'],
                        'guard_name' => 'web'
                    ],
                );
            }
        } catch (Exception $e) {
            // Salvar log
            Log::notice('Permissão não cadastrada.', ['error' => $e->getMessage()]);
        }
    }
}
