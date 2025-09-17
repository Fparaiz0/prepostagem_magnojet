<?php

namespace App\Http\Controllers;

use App\Http\Requests\SenderRequest;
use App\Models\Sender;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SenderController extends Controller
{
    // Listar os remetentes
    public function index()
    {
        // Recuperar os registros do banco dados
        $senders = Sender::orderBy('id', 'ASC')->paginate(50);

        // Salvar log
        Log::info('Listar os remetentes.', ['action_user_id' => Auth::id()]);

        // Carregar a view
        return view('senders.index', ['senders' => $senders]);
    }

    // Visualizar os detalhes dos remetentes
    public function show(Sender $sender)
    {
        // Salvar log
        Log::info('Visualizar o remetente.', ['sender_id' => $sender->id, 'action_user_id' => Auth::id()]);

        // Carregar a view
        return view('senders.show', ['sender' => $sender]);
    }

    // Carregar o formulário cadastrar novo remetente
    public function create()
    {
        // Carregar a view
        return view('senders.create');
    }

    // Cadastrar no banco de dados um novo remetente
    public function store(SenderRequest $request)
    {
        // Capturar possíveis exceções durante a execução.
        try {
            // Cadastrar no banco de dados na tabela senders
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

            // Salvar log
            Log::info('Remetente cadastrado.', ['sender_id' => $sender->id, 'action_user_id' => Auth::id()]);

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('senders.show', ['sender' => $sender->id])->with('success', 'Remetente cadastrado com sucesso!');
        } catch (Exception $e) {

            // Salvar log
            Log::notice('Remetente não cadastrado.', ['error' => $e->getMessage()]);

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Remetente não cadastrado!');
        }
    }

    // Carregar o formulário editar remetente
    public function edit(Sender $sender)
    {
        // Carregar a view
        return view('senders.edit', ['sender' => $sender]);
    }

    // Editar no banco de dados o remetente
    public function update(SenderRequest $request, Sender $sender)
    {
        // Capturar possíveis exceções durante a execução.
        try {
            // Editar as informações do registro no banco de dados
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

            // Salvar log
            Log::info('Remetente editado.', ['sender_id' => $sender->id, 'action_user_id' => Auth::id()]);

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('senders.show', ['sender' => $sender->id])->with('success', 'Remetente editado com sucesso!');
        } catch (Exception $e) {

            // Salvar log
            Log::notice('Remetente não editado.', ['error' => $e->getMessage()]);

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Remetente não editado!');
        }
    }

    // Excluir o remetente do banco de dados
    public function destroy(Sender $sender)
    {
        // Capturar possíveis exceções durante a execução.
        try {

            // Excluir o registro do banco de dados
            $sender->delete();

            // Salvar log
            Log::info('Remetente apagado.', ['sender_id' => $sender->id, 'action_user_id' => Auth::id()]);

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('senders.index')->with('success', 'Remetente apagado com sucesso!');
        } catch (Exception $e) {

            // Salvar log
            Log::notice('Remetente não apagado.', ['error' => $e->getMessage()]);

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Remetente não apagado!');
        }
    }
}
