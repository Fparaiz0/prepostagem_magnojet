<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
  public function index(Role $role)
  {
    if ($role->name == 'Super Admin') {
      Log::info('A permissão do Super Admin não pode ser acessada.', ['role_id' => $role->id, 'action_user_id' => Auth::id()]);

      return redirect()->route('roles.index')->with('error', 'A permissão do Super Admin não pode ser acessada!');
    }

    $rolePermissions = DB::table('role_has_permissions')
      ->where('role_id', $role->id)
      ->pluck('permission_id')
      ->all();

    $permissions = Permission::orderBy('name')->get();

    Log::info('Listar as permissões do papel.', ['role_id' => $role->id, 'action_user_id' => Auth::id()]);

    return view('role_permissions.index', [
      'rolePermissions' => $rolePermissions,
      'permissions' => $permissions,
      'role' => $role,
    ]);
  }

  public function update(Role $role, Permission $permission)
  {
    try {
      $action = $role->permissions->contains($permission) ? 'bloquear' : 'liberar';

      $role->{$action === 'bloquear' ? 'revokePermissionTo' : 'givePermissionTo'}($permission);

      Log::info(ucfirst($action) . 'permissão para o papel', [
        'role_id' => $role->id,
        'permission_id' => $permission->id,
        'action_user_id' => Auth::id(),
      ]);

      return redirect()->route('role-permissions.index', ['role' => $role->id])->with('success', 'Permissão' . ($action === 'bloquear' ? ' bloqueada ' : ' liberada ') . 'com sucesso!');

    } catch (Exception $e) {
      Log::notice('Permissão para o papel não editada.', ['error' => $e->getMessage(), 'action_user_id' => Auth::id()]);

      return back()->withInput()->with('error', 'Permissão para o papel não editada!');
    }
  }
}
