<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionRequest;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
  public function index()
  {
    $permissions = Permission::orderBy('title', 'ASC')->paginate(50);

    Log::info('Listar as permissões.', ['action_user_id' => Auth::id()]);

    return view('permissions.index', ['permissions' => $permissions]);
  }

  public function show(Permission $permission)
  {
    Log::info('Visualizar a permissão.', ['permission_id' => $permission->id, 'action_user_id' => Auth::id()]);

    return view('permissions.show', ['permission' => $permission]);
  }

  public function create()
  {
    return view('permissions.create');
  }

  public function store(PermissionRequest $request)
  {
    try {
      $permission = Permission::create([
        'title' => $request->title,
        'name' => $request->name,
      ]);

      Log::info('Permissão cadastrada.', ['permission_id' => $permission->id, 'action_user_id' => Auth::id()]);

      return redirect()->route('permissions.show', ['permission' => $permission->id])->with('success', 'Permissão cadastrada com sucesso!');
    } catch (Exception $e) {

      Log::notice('Permissão não cadastrada.', ['error' => $e->getMessage(), 'action_user_id' => Auth::id()]);

      return back()->withInput()->with('error', 'Permissão não cadastrada!');
    }
  }

  public function edit(Permission $permission)
  {
    return view('permissions.edit', ['permission' => $permission]);
  }

  public function update(PermissionRequest $request, Permission $permission)
  {
    try {
      $permission->update([
        'title' => $request->title,
        'name' => $request->name,
      ]);

      Log::info('Permissão editada.', ['permission_id' => $permission->id, 'action_user_id' => Auth::id()]);

      return redirect()->route('permissions.show', ['permission' => $permission->id])->with('success', 'Permissão editada com sucesso!');
    } catch (Exception $e) {

      Log::notice('Permissão não editada.', ['error' => $e->getMessage()]);

      return back()->withInput()->with('error', 'Permissão não editada!');
    }
  }

  public function destroy(Permission $permission)
  {
    try {

      $permission->delete();

      Log::info('Permissão apagada.', ['permission_id' => $permission->id, 'action_user_id' => Auth::id()]);

      return redirect()->route('permissions.index')->with('success', 'Permissão apagada com sucesso!');
    } catch (Exception $e) {

      Log::notice('Permissão não apagada.', ['error' => $e->getMessage()]);

      return back()->withInput()->with('error', 'Permissão não apagada!');
    }
  }
}
