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
    // Listar os destinatários
    public function index(Request $request)
    {
        // Recuperar os registros do banco dados
        $recipients = Recipient::when($request->has('nome'), function ($whenQuery) use ($request){
            $whenQuery->where('name', 'like', '%' . $request->nome . '%');
        })
        ->orderByDesc('created_at')
        ->paginate(50)
        ->withQueryString();

        // Carregar a VIEW
        return view('recipients.index', [
            'recipients' => $recipients,
            'name' => $request->nome,
        ]);

        // Salvar log
        Log::info('Listar os destinatários.', ['action_user_id' => Auth::id()]);
    }

    // Visualizar os detalhes dos destinatários
    public function show(Recipient $recipient)
    {
        // Salvar log
        Log::info('Visualizar o destinatário.', ['recipient_id' => $recipient->id, 'action_user_id' => Auth::id()]);

        // Carregar a view 
        return view('recipients.show', ['recipient' => $recipient]);
    }

    // Carregar o formulário cadastrar novo destinatário
    public function create()
    {
        // Carregar a view 
        return view('recipients.create');
    }

    // Cadastrar no banco de dados um novo destinatário
    public function store(RecipientRequest $request)
    {
        // Capturar possíveis exceções durante a execução.
        try {
            // Cadastrar no banco de dados na tabela recipients
            $recipient = Recipient::create([
                'name' => $request->name, 
                'cnpj' => $request->cnpj,  
                'cep'=> $request->cep,
                'public_place' => $request->public_place,
                'number' => $request->number, 
                'complement' => $request->complement, 
                'neighborhood'=> $request->neighborhood,
                'city' => $request->city, 
                'uf' => $request->uf
            ]);

            // Salvar log
            Log::info('Destinatário cadastrado.', ['recipient_id' => $recipient->id, 'action_user_id' => Auth::id()]);

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('recipients.show', ['recipient' => $recipient->id])->with('success', 'Destinatário cadastrado com sucesso!');
        } catch (Exception $e) {

            // Salvar log
            Log::notice('Destinatário não cadastrado.', ['error' => $e->getMessage()]);

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Destinatário não cadastrado!');
        }
    }

     // Carregar o formulário editar destinatário
    public function edit(Recipient $recipient)
    {
        // Carregar a view 
        return view('recipients.edit', ['recipient' => $recipient]);
        }

        // Editar no banco de dados o destinatário
        public function update(RecipientRequest $request, Recipient $recipient)
        {
            // Capturar possíveis exceções durante a execução.
            try {
            // Editar as informações do registro no banco de dados
            $recipient->update([
                'name' => $request->name, 
                'cnpj' => $request->cnpj,  
                'cep'=> $request->cep,
                'public_place' => $request->public_place,
                'number' => $request->number, 
                'complement' => $request->complement, 
                'neighborhood'=> $request->neighborhood,
                'city' => $request->city, 
                'uf' => $request->uf
            ]);

            // Salvar log
            Log::info('Destinatário editado.', ['recipient_id' => $recipient->id, 'action_user_id' => Auth::id()]);

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('recipients.show', ['recipient' => $recipient->id])->with('success', 'Destinatário editado com sucesso!');
        } catch (Exception $e) {

            // Salvar log
            Log::notice('Destinatário não editado.', ['error' => $e->getMessage()]);

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Destinatário não editado!');
        }
    }

    // Excluir o Destinatário do banco de dados
    public function destroy(Recipient $recipient)
    {
        // Capturar possíveis exceções durante a execução.
        try {

            // Excluir o registro do banco de dados
            $recipient->delete();

            // Salvar log
            Log::info('Destinatário apagado.', ['recipient_id' => $recipient->id, 'action_user_id' => Auth::id()]);

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('recipients.index')->with('success', 'Destinatário apagado com sucesso!');
        } catch (Exception $e) {

            // Salvar log
            Log::notice('Destinatário não apagado.', ['error' => $e->getMessage()]);

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Destinatário não apagado!');
        }
    }
}