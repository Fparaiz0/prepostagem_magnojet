<?php

namespace App\Http\Controllers;

use App\Http\Requests\SenderRequest;
use App\Models\Sender;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SenderController extends Controller
{
  public function index()
  {
    $senders = Sender::orderBy('id', 'ASC')->paginate(50);

    Log::info('Listar os remetentes.', ['action_user_id' => Auth::id()]);

    return view('senders.index', ['senders' => $senders]);
  }

  public function show(Sender $sender)
  {
    Log::info('Visualizar o remetente.', ['sender_id' => $sender->id, 'action_user_id' => Auth::id()]);

    return view('senders.show', ['sender' => $sender]);
  }

  public function create()
  {
    return view('senders.create');
  }

  public function store(SenderRequest $request)
  {
    try {
      $sender = Sender::create([
        'name' => $request->name,
        'cnpj' => $request->cnpj,
        'cep' => $request->cep,
        'public_place' => $request->public_place,
        'number' => $request->number,
        'neighborhood' => $request->neighborhood,
        'city' => $request->city,
        'uf' => $request->uf,
      ]);

      Log::info('Remetente cadastrado.', ['sender_id' => $sender->id, 'action_user_id' => Auth::id()]);

      return redirect()->route('senders.show', ['sender' => $sender->id])->with('success', 'Remetente cadastrado com sucesso!');
    } catch (Exception $e) {

      Log::notice('Remetente não cadastrado.', ['error' => $e->getMessage()]);

      return back()->withInput()->with('error', 'Remetente não cadastrado!');
    }
  }

  public function edit(Sender $sender)
  {
    return view('senders.edit', ['sender' => $sender]);
  }

  public function update(SenderRequest $request, Sender $sender)
  {
    try {
      $sender->update([
        'name' => $request->name,
        'cnpj' => $request->cnpj,
        'cep' => $request->cep,
        'public_place' => $request->public_place,
        'number' => $request->number,
        'neighborhood' => $request->neighborhood,
        'city' => $request->city,
        'uf' => $request->uf,
      ]);

      Log::info('Remetente editado.', ['sender_id' => $sender->id, 'action_user_id' => Auth::id()]);

      return redirect()->route('senders.show', ['sender' => $sender->id])->with('success', 'Remetente editado com sucesso!');
    } catch (Exception $e) {

      Log::notice('Remetente não editado.', ['error' => $e->getMessage()]);

      return back()->withInput()->with('error', 'Remetente não editado!');
    }
  }

  public function destroy(Sender $sender)
  {
    try {

      $sender->delete();

      Log::info('Remetente apagado.', ['sender_id' => $sender->id, 'action_user_id' => Auth::id()]);

      return redirect()->route('senders.index')->with('success', 'Remetente apagado com sucesso!');
    } catch (Exception $e) {

      Log::notice('Remetente não apagado.', ['error' => $e->getMessage()]);

      return back()->withInput()->with('error', 'Remetente não apagado!');
    }
  }
}
