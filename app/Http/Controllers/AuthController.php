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
  public function index()
  {
    return view('auth.login');
  }

  public function loginProcess(AuthLoginRequest $request)
  {
    try {
      $authenticated = Auth::attempt(['email' => $request->email, 'password' => $request->password]);

      if (!$authenticated) {
        Log::notice('E-mail ou a senha inválido!', ['email' => $request->email]);

        return back()->withInput()->with('error', 'E-mail ou a senha inválido!');
      }

      Log::info('Login!', ['action_user_id' => Auth::id()]);

      return redirect()->route('dashboard.index');
    } catch (Exception $e) {
      Log::notice('Dados do login incorreto.', ['error' => $e->getMessage()]);

      return back()->withInput()->with('error', 'E-mail ou a senha inválido!');
    }
  }

  public function logout()
  {
    Log::notice('Logout.', ['action_user_id' => Auth::id()]);

    Auth::logout();

    return redirect()->route('login')->with('success', 'Deslogado com sucesso!');
  }

  public function create()
  {
    return view('auth.register');
  }

  public function store(AuthRegisterUserRequest $request)
  {
    try {
      $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => $request->password,
      ]);

      if (Role::where('name', 'Aluno')->exists()) {
        $user->assignRole('Aluno');
      }

      Log::info('Usuário cadastrado.', ['user_id' => $user->id]);

      return redirect()->route('login')->with('success', 'Cadastrado realizado com sucesso!');
    } catch (Exception $e) {

      Log::notice('Usuário não cadastrado.', ['error' => $e->getMessage()]);

      return back()->withInput()->with('error', 'Cadastrado não realizado com sucesso!');
    }
  }
}
