<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStatusRequest;
use App\Models\UserStatus;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserStatusController extends Controller
{
  public function index()
  {
    $userStatuses = UserStatus::orderBy('id', 'DESC')->paginate(10);

    Log::info('Listar os status para usuário.', ['action_user_id' => Auth::id()]);

    return view('user_statuses.index', ['userStatuses' => $userStatuses]);
  }

  public function show(UserStatus $userStatus)
  {
    Log::info('Visualizar o status para usuário.', ['user_status_id' => $userStatus->id, 'action_user_id' => Auth::id()]);

    return view('user_statuses.show', ['userStatus' => $userStatus]);
  }

  public function create()
  {
    return view('user_statuses.create');
  }

  public function store(UserStatusRequest $request)
  {
    try {
      $userStatus = UserStatus::create([
        'name' => $request->name,
      ]);

      Log::info('Status para usuário cadastrado.', ['user_status_id' => $userStatus->id, 'action_user_id' => Auth::id()]);

      return redirect()->route('user_statuses.show', ['userStatus' => $userStatus->id])->with('success', 'Status para usuário cadastrado com sucesso!');
    } catch (Exception $e) {

      Log::notice('Status para usuário não cadastrado.', ['error' => $e->getMessage()]);

      return back()->withInput()->with('error', 'Status para usuário não cadastrado!');
    }
  }

  public function edit(UserStatus $userStatus)
  {
    return view('user_statuses.edit', ['userStatus' => $userStatus]);
  }

  public function update(UserStatusRequest $request, UserStatus $userStatus)
  {
    try {
      $userStatus->update([
        'name' => $request->name,
      ]);

      Log::info('Status para usuário editado.', ['user_status_id' => $userStatus->id, 'action_user_id' => Auth::id()]);

      return redirect()->route('user_statuses.show', ['userStatus' => $userStatus->id])->with('success', 'Status para usuário editado com sucesso!');
    } catch (Exception $e) {

      Log::notice('Status para usuário não editado.', ['error' => $e->getMessage()]);

      return back()->withInput()->with('error', 'Status para usuário não editado!');
    }
  }

  public function destroy(UserStatus $userStatus)
  {
    try {

      $userStatus->delete();

      Log::info('Status para usuário apagado.', ['user_status_id' => $userStatus->id, 'action_user_id' => Auth::id()]);

      return redirect()->route('user_statuses.index')->with('success', 'Status para usuário apagado com sucesso!');
    } catch (Exception $e) {

      Log::notice('Status para usuário não apagado.', ['error' => $e->getMessage()]);

      return back()->withInput()->with('error', 'Status para usuário não apagado!');
    }
  }
}
