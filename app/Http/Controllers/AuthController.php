<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    // Login
    public function index()
    {
        return view('auth.login');
    }

    // Validar os dados do usuário no login
    public function loginProcess(AuthLoginRequest $request)
    {
        // Capturar possiveis exceções durante a execução
        try {
            // Validar o usuário e a senha com as informações do banco de dados
            $authenticated = Auth::attempt(['email' => $request->email, 'password' => $request->password]);

            // Verificar se o usuário foi autenticado com sucesso
            if (! $authenticated) {
                // Salvar log
                Log::notice('E-mail ou a senha inválido!', ['email' => $request->email]);

                // Redirecionar o usuário, enviar a mensagem de erro
                return back()->withInput()->with('error', 'E-mail ou a senha inválido!');
            }

            // Salvar log
            Log::info('Login!', ['action_user_id' => Auth::id()]);

            // Redicionar o usuário
            return redirect()->route('dashboard.index');
        } catch (Exception $e) {
            // Salvar log
            Log::notice('Dados do login incorreto.', ['error' => $e->getMessage()]);

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'E-mail ou a senha inválido!');
        }
    }

    // Deslogar o usuário
    public function logout()
    {
        // Salvar log
        Log::notice('Logout.', ['action_user_id' => Auth::id()]);

        // Deslogar o usuário
        Auth::logout();

        // Redirecionar o usuário, enviar a mensagem de sucesso
        return redirect()->route('login')->with('success', 'Deslogado com sucesso!');
    }

    // Formulário cadastrar novo usuário
    public function create()
    {
        // Carregar a VIEW
        return view('auth.register');
    }

    // Cadastrar no banco de dados o novo usuário
    public function store(AuthRegisterUserRequest $request)
    {
        // Capturar possíveis exceções durante a execução.
        try {
            // Cadastrar no banco de dados na tabela usuário
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);

            // Verificar se o papel "Aluno" existe antes de atribuir
            if (Role::where('name', 'Aluno')->exists()) {
                $user->assignRole('Aluno');
            }

            // Salvar log
            Log::info('Usuário cadastrado.', ['user_id' => $user->id]);

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('login')->with('success', 'Cadastrado realizado com sucesso!');
        } catch (Exception $e) {

            // Salvar log
            Log::notice('Usuário não cadastrado.', ['error' => $e->getMessage()]);

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Cadastrado não realizado com sucesso!');
        }
    }
}
