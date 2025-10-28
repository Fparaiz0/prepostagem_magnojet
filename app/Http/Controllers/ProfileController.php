<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
  public function show()
  {
    $user = User::where('id', Auth::id())->first();

    Log::info('Visualizar o perfil.', ['action_user_id' => Auth::id()]);

    return view('profile.show', ['user' => $user]);
  }

  public function edit()
  {
    $user = User::where('id', Auth::id())->first();

    Log::info('Formulario editar o perfil.', ['action_user_id' => Auth::id()]);

    return view('profile.edit', ['user' => $user]);
  }

  public function update(Request $request)
  {
    $user = User::where('id', Auth::id())->first();

    $request->validate(
      [
        'name' => 'required',
        'email' => 'required|email|unique:users,email,' . ($user ? $user->id : null),
      ],
      [
        'name.required' => 'Campo nome é obrigatório!',
        'email.required' => 'Campo e-mail é obrigatório!',
        'email.email' => 'Necessário enviar e-mail válido!',
        'email.unique' => 'O e-mail já está cadastrado!',
      ]
    );

    try {

      $user->update([
        'name' => $request->name,
        'email' => $request->email,
      ]);

      Log::info('Perfil editado.', ['action_user_id' => Auth::id()]);

      return redirect()->route('profile.show', ['user' => $user->id])->with('success', 'Perfil editado com sucesso!');
    } catch (Exception $e) {

      Log::notice('Perfil não editado.', ['error' => $e->getMessage(), 'action_user_id' => Auth::id()]);

      return back()->withInput()->with('error', 'Perfil não editado!');
    }
  }

  public function editPassword()
  {
    $user = User::where('id', Auth::id())->first();

    return view('profile.edit_password', ['user' => $user]);
  }

  public function updatePassword(Request $request)
  {

    $request->validate(
      [
        'password' => 'required|confirmed|min:6',
      ],
      [
        'password.required' => 'Campo senha é obrigatório!',
        'password.confirmed' => 'A confirmação da senha não corresponde!',
        'password.min' => 'Senha com no mínimo :min caracteres!',
      ]
    );

    try {

      $user = User::where('id', Auth::id())->first();

      $user->update([
        'password' => $request->password,
      ]);

      Log::info('Senha do perfil editado.', ['action_user_id' => Auth::id()]);

      return redirect()->route('profile.show')->with('success', 'Senha do perfil editada com sucesso!');
    } catch (Exception $e) {

      Log::notice('Senha do perfil não editada.', ['error' => $e->getMessage(), 'action_user_id' => Auth::id()]);

      return back()->withInput()->with('error', 'Senha do perfil não editada!');
    }
  }
}
