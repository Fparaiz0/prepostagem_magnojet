<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
  public function index()
  {
    $roles = Role::orderBy('id', 'DESC')->paginate(10);

    Log::info('Listar os papéis.', ['action_user_id' => Auth::id()]);

    return view('roles.index', ['roles' => $roles]);
  }

  public function show(Role $role)
  {
    Log::info('Visualizar o papel.', ['role_id' => $role->id, 'action_user_id' => Auth::id()]);

    return view('roles.show', ['role' => $role]);
  }

  public function create()
  {
    return view('roles.create');
  }

  public function store(RoleRequest $request)
  {
    try {
      $role = Role::create([
        'name' => $request->name,
      ]);

      $permissions = [
        'dashboard',
        'show-profile',
        'edit-profile',
        'edit-password-profile',
      ];

      $role->givePermissionTo($permissions);

      Log::info('Papel cadastrado.', ['role_id' => $role->id, 'action_user_id' => Auth::id()]);

      return redirect()->route('roles.show', ['role' => $role->id])->with('success', 'Papel cadastrado com sucesso!');
    } catch (Exception $e) {

      Log::notice('Papel não cadastrado.', ['error' => $e->getMessage(), 'action_user_id' => Auth::id()]);

      return back()->withInput()->with('error', 'Papel não cadastrado!');
    }
  }

  public function edit(Role $role)
  {
    return view('roles.edit', ['role' => $role]);
  }

  public function update(RoleRequest $request, Role $role)
  {
    try {
      $role->update([
        'name' => $request->name,
      ]);

      Log::info('Papel editado.', ['role_id' => $role->id, 'action_user_id' => Auth::id()]);

      return redirect()->route('roles.show', ['role' => $role->id])->with('success', 'Papel editado com sucesso!');
    } catch (Exception $e) {

      Log::notice('Papel não editado.', ['error' => $e->getMessage()]);

      return back()->withInput()->with('error', 'Papel não editado!');
    }
  }

  public function destroy(Role $role)
  {
    try {

      $role->delete();

      Log::info('Papel apagado.', ['role_id' => $role->id, 'action_user_id' => Auth::id()]);

      return redirect()->route('roles.index')->with('success', 'Papel apagado com sucesso!');
    } catch (Exception $e) {

      Log::notice('Papel não apagado.', ['error' => $e->getMessage()]);

      return back()->withInput()->with('error', 'Papel não apagado!');
    }
  }
}
