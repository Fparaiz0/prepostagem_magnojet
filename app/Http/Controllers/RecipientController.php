<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecipientRequest;
use App\Models\Recipient;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RecipientController extends Controller
{
  public function index(Request $request)
  {
    $recipients = Recipient::when($request->has('nome'), function ($whenQuery) use ($request) {
      $whenQuery->where('name', 'like', '%' . $request->nome . '%');
    })
      ->orderByDesc('created_at')
      ->paginate(50)
      ->withQueryString();

    Log::info('Listar os destinatários.', ['action_user_id' => Auth::id()]);

    return view('recipients.index', [
      'recipients' => $recipients,
      'name' => $request->nome,
    ]);
  }

  public function show(Recipient $recipient)
  {
    Log::info('Visualizar o destinatário.', ['recipient_id' => $recipient->id, 'action_user_id' => Auth::id()]);

    return view('recipients.show', ['recipient' => $recipient]);
  }

  public function create()
  {
    return view('recipients.create');
  }

  public function store(RecipientRequest $request)
  {
    try {
      $recipient = Recipient::create([
        'name' => $request->name,
        'cnpj' => $request->cnpj,
        'cep' => $request->cep,
        'public_place' => $request->public_place,
        'number' => $request->number,
        'complement' => $request->complement,
        'neighborhood' => $request->neighborhood,
        'city' => $request->city,
        'uf' => $request->uf
      ]);

      Log::info('Destinatário cadastrado.', ['recipient_id' => $recipient->id, 'action_user_id' => Auth::id()]);

      return redirect()->route('recipients.show', ['recipient' => $recipient->id])->with('success', 'Destinatário cadastrado com sucesso!');
    } catch (Exception $e) {

      Log::notice('Destinatário não cadastrado.', ['error' => $e->getMessage()]);

      return back()->withInput()->with('error', 'Destinatário não cadastrado!');
    }
  }

  public function edit(Recipient $recipient)
  {
    return view('recipients.edit', ['recipient' => $recipient]);
  }

  public function update(RecipientRequest $request, Recipient $recipient)
  {
    try {
      $recipient->update([
        'name' => $request->name,
        'cnpj' => $request->cnpj,
        'cep' => $request->cep,
        'public_place' => $request->public_place,
        'number' => $request->number,
        'complement' => $request->complement,
        'neighborhood' => $request->neighborhood,
        'city' => $request->city,
        'uf' => $request->uf
      ]);

      Log::info('Destinatário editado.', ['recipient_id' => $recipient->id, 'action_user_id' => Auth::id()]);

      return redirect()->route('recipients.show', ['recipient' => $recipient->id])->with('success', 'Destinatário editado com sucesso!');
    } catch (Exception $e) {

      Log::notice('Destinatário não editado.', ['error' => $e->getMessage()]);

      return back()->withInput()->with('error', 'Destinatário não editado!');
    }
  }

  public function destroy(Recipient $recipient)
  {
    try {

      $recipient->delete();

      Log::info('Destinatário apagado.', ['recipient_id' => $recipient->id, 'action_user_id' => Auth::id()]);

      return redirect()->route('recipients.index')->with('success', 'Destinatário apagado com sucesso!');
    } catch (Exception $e) {

      Log::notice('Destinatário não apagado.', ['error' => $e->getMessage()]);

      return back()->withInput()->with('error', 'Destinatário não apagado!');
    }
  }
}