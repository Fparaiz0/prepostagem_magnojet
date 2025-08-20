@extends('layouts.admin')

@section('content')
    <!-- Cabeçalho da Página -->
    <div class="content-header flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="content-title">Cadastrar Permissão</h2>
        </div>
        <div class="flex space-x-3 mt-4 md:mt-0">
            @can('index-permission')
            <a href="{{ route('permissions.index') }}" 
                class="flex items-center px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-700 hover:bg-indigo-50 transition-all shadow-xs hover:shadow-sm border-indigo-100 hover:border-indigo-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Listar Permissões
            </a>
            @endcan 
        </div>
    </div>

    <div class="mt-5">
        <x-alert />
    </div>

    <!-- Formulário de Cadastro -->
    <div class="bg-white rounded-xl border border-blue-200 shadow-sm overflow-hidden mt-6">
        <form action="{{ route('permissions.store') }}" method="POST">
            @csrf
            @method('POST')

            <div class="p-6">
                <!-- Cabeçalho do Formulário -->
                <div class="pb-5 border-b border-blue-200">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2l8 4v6c0 5.25-3.6 10-8 10s-8-4.75-8-10V6l8-4z" />
                        </svg>
                        Informações da Permissão
                    </h3>
                    <p class="text-sm text-gray-500 mt-2">Preencha os dados da nova permissão</p>
                </div>

                <!-- Campos do Formulário -->
                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Campo Título -->
                    <div class="space-y-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 flex items-center">
                            Título da Permissão
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}"
                               class="w-full px-4 py-2.5 border border-blue-300 rounded-lg focus:ring-green-500 focus:border-green-500 transition-colors"
                               placeholder="Ex: Criar Usuários, Editar Posts..." required>
                        <p class="text-xs text-gray-500">Nome descritivo da permissão (visível para usuários)</p>
                    </div>

                    <!-- Campo Nome -->
                    <div class="space-y-2">
                        <label for="name" class="block text-sm font-medium text-gray-700 flex items-center">
                            Nome Interno
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                               class="w-full px-4 py-2.5 border border-blue-300 rounded-lg focus:ring-green-500 focus:border-green-500 transition-colors font-mono text-sm"
                               placeholder="Ex: create-users, edit-posts..." required>
                        <p class="text-xs text-gray-500">Identificador único usado no sistema (sem espaços)</p>
                    </div>
                </div>
            </div>

            <!-- Rodapé do Formulário -->
            <div class="px-6 py-4 border-t border-blue-200 bg-gray-50 flex justify-between">
                <div class="text-sm text-gray-500">
                    Campos marcados com <span class="text-red-500">*</span> são obrigatórios
                </div>
                <div class="flex space-x-3">
                    <a href="{{ URL::previous() }}" class="px-5 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Cadastrar Permissão
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
                Sobre Permissões
            </h3>
        </div>
        <div class="p-6">
            <div class="prose prose-sm text-gray-600">
                <p class="font-medium">As permissões controlam o acesso a funcionalidades específicas do sistema:</p>
                <ul class="mt-3 space-y-2">
                    <li class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span><strong>Título:</strong> Use nomes descritivos que os usuários possam entender facilmente</span>
                    </li>
                    <li class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span><strong>Nome Interno:</strong> Use formato snake_case (ex: create_users) e mantenha a consistência</span>
                    </li>
                    <li class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span><strong>Padrão:</strong> Siga um padrão consistente em todo o sistema</span>
                    </li>
                    <li class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span><strong>Exemplos:</strong> create-users, edit-posts, delete-comments, view-reports</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection