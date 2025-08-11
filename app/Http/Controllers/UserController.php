<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    // Listar os usuários
    public function index()
    {
        // Recuperar os registros do banco dados
        // $users = User::where('id', 1000)->get();
        // $users = User::orderBy('id', 'DESC')->get();
        $users = User::orderBy('id', 'DESC')->paginate(10);

        // Salvar log
        Log::info('Listar os usuários.', ['action_user_id' => Auth::id()]);

        // Carregar a view 
        return view('users.index', ['users' => $users]);
    }

    // Visualizar os detalhes do usuário
    public function show(User $user)
    {

        // Salvar log
        Log::info('Visualizar o usuário.', ['user_id' => $user->id, 'action_user_id' => Auth::id()]);

        // Carregar a view 
        return view('users.show', ['user' => $user]);
    }

    // Carregar o formulário cadastrar novo usuário
    public function create()
    {
        // Recuperar os papéis
        $roles = Role::pluck('name')->all(); 

        // Carregar a view 
        return view('users.create', ['roles' => $roles]);
    }

    // Cadastrar no banco de dados o novo usuário
    public function store(UserRequest $request)
    {
        // Capturar possíveis exceções durante a execução.
        try {
            // Cadastrar no banco de dados na tabela usuário
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);

            // Verificar se veio algum papel selecionado
            if($request->filled('roles')){
                // Verificar se todos os papéis existem 
                $validRoles = Role::whereIn('name', $request->roles)->pluck('name')->toArray();

                // Atribui os papéis válidos ao usuário 
                $user->syncRoles($validRoles); // Se for apenas um papel coloque assignRole() no lugar de syncRoles que serve para vários papéis 
                
            }

            // Salvar log
            Log::info('Usuário cadastrado.', ['user_id' => $user->id, 'action_user_id' => Auth::id()]);

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('users.show', ['user' => $user->id])->with('success', 'Usuário cadastrado com sucesso!');
        } catch (Exception $e) {

            // Salvar log
            Log::notice('Usuário não cadastrado.', ['error' => $e->getMessage()]);

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Usuário não cadastrado!');
        }
    }

    // Carregar o formulário editar usuário
    public function edit(User $user)
    {
        // Recuperar os papéis 
        $roles = Role::pluck('name')->all();

        // Recuperar os papéis do usuário
        $userRoles = $user->roles->pluck('name')->toArray(); 

        // Carregar a view 
        return view('users.edit', ['user' => $user, 'roles' => $roles, 'userRoles' => $userRoles]);
    }

    // Editar no banco de dados o usuário
    public function update(UserRequest $request, User $user)
    {
        // Capturar possíveis exceções durante a execução.
        try {
            // Editar as informações do registro no banco de dados
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            // Se houver papéis enviados no request, sincroniza-os com o usuário
            if($request->filled('roles')){
                // Verificar se todos os papéis existem 
                $validRoles = Role::whereIn('name', $request->roles)->pluck('name')->toArray();

                // Atribui os papéis válidos ao usuário 
                $user->syncRoles($validRoles); // Se for apenas um papel coloque assignRole() no lugar de syncRoles que serve para vários papéis 
            }else{
                // Se nenhum papel for enviado, remove todos os papéis do usuário
                $user->syncRoles([]); 
            }

            // Salvar log
            Log::info('Usuário editado.', ['user_id' => $user->id, 'action_user_id' => Auth::id()]);

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('users.show', ['user' => $user->id])->with('success', 'Usuário editado com sucesso!');
        } catch (Exception $e) {

            // Salvar log
            Log::notice('Usuário não editado.', ['error' => $e->getMessage()]);

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Usuário não editado!');
        }
    }

    // Carregar o formulário editar senha do usuário
    public function editPassword(User $user)
    {
        // Carregar a view 
        return view('users.edit_password', ['user' => $user]);
    }

    // Editar no banco de dados a senha do usuário
    public function updatePassword(Request $request, User $user)
    {
        // Validar o formulário
        $request->validate(
            [
                'password' => 'required|confirmed|min:6',
            ],
            [
                'password.required' => "Campo senha é obrigatório!",
                'password.confirmed' => 'A confirmação da senha não corresponde!',
                'password.min' => "Senha com no mínimo :min caracteres!",
            ]
        );

        // Capturar possíveis exceções durante a execução.
        try {
            // Editar as informações do registro no banco de dados
            $user->update([
                'password' => $request->password,
            ]);

            // Salvar log
            Log::info('Senha do usuário editado.', ['user_id' => $user->id, 'action_user_id' => Auth::id()]);

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('users.show', ['user' => $user->id])->with('success', 'Senha do usuário editado com sucesso!');
        } catch (Exception $e) {

            // Salvar log
            Log::notice('Senha do usuário não editado.', ['error' => $e->getMessage()]);

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Senha do usuário não editado!');
        }
    }

    // Excluir o curso do banco de dados
    public function destroy(User $user)
    {
        // Capturar possíveis exceções durante a execução.
        try {

            // Excluir o registro do banco de dados
            $user->delete();

            // Salvar log
            Log::info('Usuário apagado.', ['user_id' => $user->id, 'action_user_id' => Auth::id()]);

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('users.index')->with('success', 'Usuário apagado com sucesso!');
        } catch (Exception $e) {

            // Salvar log
            Log::notice('Usuário não editado.', ['error' => $e->getMessage()]);

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Usuário não apagado!');
        }
    }
}
