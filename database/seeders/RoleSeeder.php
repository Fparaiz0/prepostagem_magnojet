<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Capturar possíveis exceções durante a execução do seeder. 
        try{
            /******* Super Admin - Tem acesso a todas as páginas *******/
            // Se não encontrar o registro, cadastra o registro no BD
            Role::firstOrCreate(
                ['name' => 'Super Admin'], 
                ['name' => 'Super Admin'], 
            );

            /*******  Admin  *******/
            // Se não encontrar o registro, cadastra o registro no BD
            $admin = Role::firstOrCreate(
                ['name' => 'Admin'], 
                ['name' => 'Admin'], 
            );

            // Cadastrar permissão para o papel 
            $admin->givePermissionTo([
                // Acesso Dashboard
                'dashboard',

                // Acesso Perfil
                'show-profile',
                'edit-profile',
                'edit-password-profile',

                // Acesso Usuários
                'index-user',
                'show-user',
                'create-user',
                'edit-user',
                'edit-password-user',
                'edit-roles-user',
                'destroy-user',

                // Acesso Status do Usuários
                'index-user-status',
                'show-user-status',
                'create-user-status',
                'edit-user-status',
                'destroy-user-status',

                // Acesso Papéis
                'index-role',
                'show-role',
                'create-role',
                'edit-role',
                'destroy-role',

                // Acesso Permissões do papel
                'index-role-permission',

                // Acesso Embalagens
                'index-packaging',
                'show-packaging',
                'create-packaging',
                'edit-packaging',
                'destroy-packaging',

                // Acesso Remetentes
                'index-sender',
                'show-sender',
                'create-sender',
                'edit-sender',
                'destroy-sender',

                // Acesso Destinatários
                'index-recipient',
                'show-recipient',
                'create-recipient',
                'edit-recipient',
                'destroy-recipient',
            ]);

            /*******  Colaborador  *******/
            // Se não encontrar o registro, cadastra o registro no BD
            $colaborador = Role::firstOrCreate(
                ['name' => 'Colaborador'], 
                ['name' => 'Colaborador'], 
            );

            // Cadastrar permissão para o papel 
            $colaborador->givePermissionTo([
                
                // Acesso Dashboard
                'dashboard',

                // Acesso Perfil
                'show-profile',
                'edit-profile',
                'edit-password-profile',

                // Acesso Embalagens
                'index-packaging',
                'show-packaging',   

                // Acesso Remetentes
                'index-sender',
                'show-sender',   

                // Acesso Destinatários
                'index-recipient',
                'show-recipient',
                'create-recipient',
                'edit-recipient',
                'destroy-recipient',
            ]);

        } catch (Exception $e){
            // Salvar log
            Log::notice('Papel não cadastrado.', ['error' => $e->getMessage()]); 
        }
    }
}
