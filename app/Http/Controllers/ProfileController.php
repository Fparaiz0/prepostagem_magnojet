<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    // Visualizar os detalhes do perfil
    public function show()
    {
        // Recuperar do banco de dados as informações do usuário logado
        $user = User::where('id', Auth::id())->first();

        // Salvar log
        Log::info('Visualizar o perfil.', ['action_user_id' => Auth::id()]);

        // Carregar a view 
        return view('profile.show', ['user' => $user]);
    }

    // Carregar o formulário editar perfil
    public function edit()
    {
        // Recuperar do banco de dados as informações do usuário logado
        $user = User::where('id', Auth::id())->first();

        // Salvar log
        Log::info('Formulario editar o perfil.', ['action_user_id' => Auth::id()]);

        // Carregar a view 
        return view('profile.edit', ['user' => $user]);
    }

    // Editar no banco de dados o perfil
    public function update(Request $request)
    {
        // Recuperar do banco de dados as informações do usuário logado
        $user = User::where('id', Auth::id())->first();

        // Validar o formulário
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . ($user ? $user->id : null),
            ],
            [
                'name.required' => "Campo nome é obrigatório!",
                'email.required' => "Campo e-mail é obrigatório!",
                'email.email' => "Necessário enviar e-mail válido!",
                'email.unique' => "O e-mail já está cadastrado!",
            ]
        );

        // Capturar possíveis exceções durante a execução.
        try {

            // Editar as informações do registro no banco de dados
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            // Salvar log
            Log::info('Perfil editado.', ['action_user_id' => Auth::id()]);

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('profile.show', ['user' => $user->id])->with('success', 'Perfil editado com sucesso!');
        } catch (Exception $e) {

            // Salvar log
            Log::notice('Perfil não editado.', ['error' => $e->getMessage(), 'action_user_id' => Auth::id()]);

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Perfil não editado!');
        }
    }

    // Carregar o formulário editar senha do perfil
    public function editPassword()
    {
        // Recuperar do banco de dados as informações do usuário logado
        $user = User::where('id', Auth::id())->first();

        // Carregar a view 
        return view('profile.edit_password', ['user' => $user]);
    }

    // Editar no banco de dados a senha do perfil
    public function updatePassword(Request $request)
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

            // Recuperar do banco de dados as informações do usuário logado
            $user = User::where('id', Auth::id())->first();

            // Editar as informações do registro no banco de dados
            $user->update([
                'password' => $request->password,
            ]);

            // Salvar log
            Log::info('Senha do perfil editado.', ['action_user_id' => Auth::id()]);

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('profile.show')->with('success', 'Senha do perfil editada com sucesso!');
        } catch (Exception $e) {

            // Salvar log
            Log::notice('Senha do perfil não editada.', ['error' => $e->getMessage(), 'action_user_id' => Auth::id()]);

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Senha do perfil não editada!');
        }
    }
}
