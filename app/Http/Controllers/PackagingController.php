<?php

namespace App\Http\Controllers;

use App\Models\Packaging;
use Exception;
use App\Http\Requests\PackagingRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PackagingController extends Controller
{
    // Listar as embalagens
    public function index()
    {
        // Recuperar os registros do banco dados
        $packagings = Packaging::orderBy('id', 'ASC')->paginate(50);

        // Salvar log
        Log::info('Listar as embalagens.', ['action_user_id' => Auth::id()]);

        // Carregar a view 
        return view('packagings.index', ['packagings' => $packagings]);
    }

    // Visualizar os detalhes das embalagens
    public function show(Packaging $packaging)
    {
        // Salvar log
        Log::info('Visualizar a embalagem.', ['packaging_id' => $packaging->id, 'action_user_id' => Auth::id()]);

        // Carregar a view 
        return view('packagings.show', ['packaging' => $packaging]);
    }

    // Carregar o formulário cadastrar nova embalagem
    public function create()
    {
        // Carregar a view 
        return view('packagings.create');
    }

    // Cadastrar no banco de dados a nova embalagem
    public function store(PackagingRequest $request)
    {
        // Capturar possíveis exceções durante a execução.
        try {
            // Cadastrar no banco de dados na tabela packagings
            $packaging = Packaging::create([
                'name' => $request->name, 
                'height' => $request->height,  
                'width'=> $request->width,
                'length' => $request->length,
                'diameter' => $request->diameter, 
                'weight'=> $request->weight,
                'active' => $request->active
            ]);

            // Salvar log
            Log::info('Embalagem cadastrada.', ['packaging_id' => $packaging->id, 'action_user_id' => Auth::id()]);

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('packagings.show', ['packaging' => $packaging->id])->with('success', 'Embalagem cadastrada com sucesso!');
        } catch (Exception $e) {

            // Salvar log
            Log::notice('Embalagem não cadastrada.', ['error' => $e->getMessage()]);

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Embalagem não cadastrada!');
        }
    }

    // Carregar o formulário editar embalagem
    public function edit(Packaging $packaging)
    {
        // Carregar a view 
        return view('packagings.edit', ['packaging' => $packaging]);
        }

        // Editar no banco de dados a embalagem
        public function update(PackagingRequest $request, Packaging $packaging)
        {
            // Capturar possíveis exceções durante a execução.
            try {
            // Editar as informações do registro no banco de dados
            $packaging->update([
                'name' => $request->name, 
                'height' => $request->height,  
                'width'=> $request->width,
                'length' => $request->length,
                'diameter' => $request->diameter, 
                'weight'=> $request->weight,
                'active' => $request->active
            ]);

            // Salvar log
            Log::info('Embalagem editada.', ['packaging_id' => $packaging->id, 'action_user_id' => Auth::id()]);

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('packagings.show', ['packaging' => $packaging->id])->with('success', 'Embalagem editada com sucesso!');
        } catch (Exception $e) {

            // Salvar log
            Log::notice('Embalagem não editada.', ['error' => $e->getMessage()]);

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Embalagem não editada!');
        }
    }

    // Excluir a embalagem do banco de dados
    public function destroy(Packaging $packaging)
    {
        // Capturar possíveis exceções durante a execução.
        try {

            // Excluir o registro do banco de dados
            $packaging->delete();

            // Salvar log
            Log::info('Embalagem apagada.', ['packaging_id' => $packaging->id, 'action_user_id' => Auth::id()]);

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('packagings.index')->with('success', 'Embalagem apagada com sucesso!');
        } catch (Exception $e) {

            // Salvar log
            Log::notice('Embalagem não apagada.', ['error' => $e->getMessage()]);

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Embalagem não apagada!');
        }
    }
}