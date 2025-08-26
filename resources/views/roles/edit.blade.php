@extends('layouts.admin')

@section('content')
    <!-- Cabeçalho da Página -->
    <div class="content-header flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="content-title text-2xl font-bold text-gray-800">Editar Papel</h2>
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
            
            @can('show-role')
            <a href="{{ route('roles.show', ['role' => $role->id]) }}" 
                class="flex items-center px-4 py-2.5 bg-blue-100 text-blue-700 rounded-xl hover:bg-blue-200 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                Visualizar
            </a>
            @endcan
        </div>
    </div>

    <div class="mt-5">
        <x-alert />
    </div>

    <!-- Formulário de Edição -->
    <div class="bg-white rounded-xl shadow-sm border border-blue-200 overflow-hidden mt-6">
        <form action="{{ route('roles.update', ['role' => $role->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="p-6">
                <!-- Cabeçalho do Formulário -->
                <div class="pb-5 border-b border-blue-200">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Editar Informações do Papel
                    </h3>
                    <p class="text-sm text-gray-500 mt-2">Atualize o nome do papel</p>
                </div>

                <!-- Informações do Registro -->
                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-gray-50 rounded-lg">
                    <div class="space-y-1">
                        <label class="block text-xs font-medium text-gray-500">ID do Registro</label>
                        <p class="text-sm font-medium text-gray-800">{{ $role->id }}</p>
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-medium text-gray-500">Data de Criação</label>
                        <p class="text-sm text-gray-800">{{ \Carbon\Carbon::parse($role->created_at)->format('d/m/Y H:i:s') }}</p>
                    </div>
                </div>

                <!-- Campo Nome -->
                <div class="mt-6 space-y-2  max-w-md">
                    <label for="name" class="text-sm font-medium text-gray-700 flex items-center">
                        Nome do Papel
                        <span class="text-red-500 ml-1">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $role->name) }}"
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
                    <a href="{{ URL::previous() }}" class="px-5 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white font-medium cursor-pointer rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Salvar Alterações
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Informações Adicionais -->
    <div class="bg-white rounded-xl border border-blue-200 shadow-sm overflow-hidden mt-6">
        <div class="px-6 py-4 border-b border-blue-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-800">Histórico de Alterações</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Data de Criação</label>
                    <p class="text-sm text-gray-800 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ \Carbon\Carbon::parse($role->created_at)->format('d/m/Y H:i:s') }}
                    </p>
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Última Atualização</label>
                    <p class="text-sm text-gray-800 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        {{ \Carbon\Carbon::parse($role->updated_at)->format('d/m/Y H:i:s') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection