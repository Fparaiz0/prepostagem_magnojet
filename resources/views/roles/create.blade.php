@extends('layouts.admin')

@section('content')
    <!-- Cabeçalho da Página -->
    <div class="content-header flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="content-title text-2xl font-bold text-gray-800">Cadastrar Papel</h2>
            <p class="text-sm text-gray-500 mt-1">Adicione um novo papel ao sistema</p>
        </div>
        <div class="flex space-x-3 mt-4 md:mt-0">
            @can('index-role')
            <a href="{{ route('roles.index') }}" 
                class="flex items-center px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-700 hover:bg-indigo-50 transition-all shadow-xs hover:shadow-sm hover:border-indigo-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Listar Papéis
            </a>
            @endcan
        </div>
    </div>

    <div class="mt-5">
        <x-alert />
    </div>

    <!-- Formulário de Cadastro -->
    <div class="bg-white rounded-xl border border-blue-200 shadow-sm overflow-hidden mt-6">
        <form action="{{ route('roles.store') }}" method="POST">
            @csrf
            @method('POST')

            <div class="p-6">
                <!-- Cabeçalho do Formulário -->
                <div class="pb-5 border-b border-blue-200">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Informações do Papel
                    </h3>
                    <p class="text-sm text-gray-500 mt-2">Preencha as informações do novo papel</p>
                </div>

                <!-- Campo Nome -->
                <div class="mt-6 space-y-2 max-w-md">
                    <label for="name" class="text-sm font-medium text-gray-700 flex items-center">
                        Nome do Papel
                        <span class="text-red-500 ml-1">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                           class="w-full px-4 py-2.5 border border-blue-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 transition-colors"
                           placeholder="Ex: Administrador, Usuário, Moderador..." required>
                    <p class="text-xs text-gray-500">Digite um nome descritivo para o papel</p>
                </div>
            </div>

            <!-- Rodapé do Formulário -->
            <div class="px-6 py-4 border-t border-blue-200 bg-gray-50 flex justify-between">
                <div class="text-sm text-gray-500">
                    Campos marcados com <span class="text-red-500">*</span> são obrigatórios
                </div>
                <div class="flex space-x-3">
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Cadastrar Papel
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Informações Adicionais -->
    <div class="bg-white rounded-xl shadow-sm border border-blue-200 overflow-hidden mt-6">
        <div class="px-6 py-4 border-b border-blue-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Sobre Papéis
            </h3>
        </div>
        <div class="p-6">
            <div class="prose prose-sm text-gray-600">
                <p>Os papéis definem grupos de usuários com permissões específicas no sistema.</p>
                <ul class="mt-3 space-y-1">
                    <li>• Use nomes descritivos para facilitar a identificação</li>
                    <li>• Após criar o papel, você poderá atribuir permissões específicas</li>
                    <li>• Exemplos comuns: Administrador, Moderador, Usuário, Convidado</li>
                </ul>
            </div>
        </div>
    </div>
@endsection