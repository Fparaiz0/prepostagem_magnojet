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
  public function index()
  {
    $users = User::orderBy('id', 'ASC')->paginate(10);

    Log::info('Listar os usuários.', ['action_user_id' => Auth::id()]);

    return view('users.index', ['users' => $users]);
  }

  public function show(User $user)
  {

    Log::info('Visualizar o usuário.', ['user_id' => $user->id, 'action_user_id' => Auth::id()]);

    return view('users.show', ['user' => $user]);
  }

  public function create()
  {
    $roles = Role::pluck('name')->all();

    return view('users.create', ['roles' => $roles]);
  }

  public function store(UserRequest $request)
  {
    try {
      $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => $request->password,
      ]);

      if ($request->filled('roles')) {
        $validRoles = Role::whereIn('name', $request->roles)->pluck('name')->toArray();

        $user->syncRoles($validRoles);

      }

      Log::info('Usuário cadastrado.', ['user_id' => $user->id, 'action_user_id' => Auth::id()]);

      return redirect()->route('users.show', ['user' => $user->id])->with('success', 'Usuário cadastrado com sucesso!');
    } catch (Exception $e) {

      Log::notice('Usuário não cadastrado.', ['error' => $e->getMessage()]);

      return back()->withInput()->with('error', 'Usuário não cadastrado!');
    }
  }

  public function edit(User $user)
  {
    $roles = Role::pluck('name')->all();

    $userRoles = $user->roles->pluck('name')->toArray();

    return view('users.edit', ['user' => $user, 'roles' => $roles, 'userRoles' => $userRoles]);
  }

  public function update(UserRequest $request, User $user)
  {
    try {
      $user->update([
        'name' => $request->name,
        'email' => $request->email,
      ]);

      if ($request->filled('roles')) {
        $validRoles = Role::whereIn('name', $request->roles)->pluck('name')->toArray();

        $user->syncRoles($validRoles);
      } else {
        $user->syncRoles([]);
      }

      Log::info('Usuário editado.', ['user_id' => $user->id, 'action_user_id' => Auth::id()]);

      return redirect()->route('users.show', ['user' => $user->id])->with('success', 'Usuário editado com sucesso!');
    } catch (Exception $e) {

      Log::notice('Usuário não editado.', ['error' => $e->getMessage()]);

      return back()->withInput()->with('error', 'Usuário não editado!');
    }
  }

  public function editPassword(User $user)
  {
    return view('users.edit_password', ['user' => $user]);
  }

  public function updatePassword(Request $request, User $user)
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
      $user->update([
        'password' => $request->password,
      ]);

      Log::info('Senha do usuário editado.', ['user_id' => $user->id, 'action_user_id' => Auth::id()]);

      return redirect()->route('users.show', ['user' => $user->id])->with('success', 'Senha do usuário editado com sucesso!');
    } catch (Exception $e) {

      Log::notice('Senha do usuário não editado.', ['error' => $e->getMessage()]);

      return back()->withInput()->with('error', 'Senha do usuário não editado!');
    }
  }

  public function destroy(User $user)
  {
    try {

      $user->delete();

      Log::info('Usuário apagado.', ['user_id' => $user->id, 'action_user_id' => Auth::id()]);

      return redirect()->route('users.index')->with('success', 'Usuário apagado com sucesso!');
    } catch (Exception $e) {

      Log::notice('Usuário não editado.', ['error' => $e->getMessage()]);

      return back()->withInput()->with('error', 'Usuário não apagado!');
    }
  }
}
