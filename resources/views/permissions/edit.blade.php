@extends('layouts.admin')

@section('content')
    <div class="content-header flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="content-title">Editar Permissão</h2>
            <p class="text-sm text-gray-500 mt-1">Atualize as informações da permissão</p>
        </div>
        <div class="flex space-x-3 mt-4 md:mt-0">
            @can('index-permission')
                <a href="{{ route('permissions.index') }}"
                    class="flex items-center px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-700 hover:bg-indigo-50 transition-all shadow-xs hover:shadow-sm hover:border-indigo-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Listar Permissões
                </a>
            @endcan

            @can('show-permission')
                <a href="{{ route('permissions.show', ['permission' => $permission->id]) }}"
                    class="flex items-center px-4 py-2.5 bg-blue-100 text-blue-700 rounded-xl hover:bg-blue-200 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Visualizar
                </a>
            @endcan
        </div>
    </div>

    <div class="mt-5">
        <x-alert />
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-blue-200 overflow-hidden mt-6">
        <form action="{{ route('permissions.update', ['permission' => $permission->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="p-6">
                <div class="pb-5 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-6 text-blue-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 2l8 4v6c0 5.25-3.6 10-8 10s-8-4.75-8-10V6l8-4z" />
                        </svg>
                        Editar Informações da Permissão
                    </h3>
                    <p class="text-sm text-gray-500 mt-2">Atualize os dados da permissão</p>
                </div>

                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-gray-50 rounded-lg">
                    <div class="space-y-1">
                        <label class="block text-xs font-medium text-gray-500">ID do Registro</label>
                        <p class="text-sm font-medium text-gray-800">{{ $permission->id }}</p>
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-medium text-gray-500">Data de Criação</label>
                        <p class="text-sm text-gray-800">
                            {{ \Carbon\Carbon::parse($permission->created_at)->format('d/m/Y H:i:s') }}</p>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="title" class="text-sm font-medium text-gray-700 flex items-center">
                            Título da Permissão
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <input type="text" name="title" id="title" value="{{ old('title', $permission->title) }}"
                            class="w-full px-4 py-2.5 border border-blue-300 rounded-lg focus:ring-green-500 focus:border-green-500 transition-colors"
                            placeholder="Ex: Criar Usuários, Editar Posts..." required>
                        <p class="text-xs text-gray-500">Nome descritivo da permissão (visível para usuários)</p>
                    </div>

                    <div class="space-y-2">
                        <label for="name" class="text-sm font-medium text-gray-700 flex items-center">
                            Nome Interno
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $permission->name) }}"
                            class="w-full px-4 py-2.5 border border-blue-300 rounded-lg focus:ring-green-500 focus:border-green-500 transition-colors font-mono text-sm"
                            placeholder="Ex: create-users, edit-posts..." required>
                        <p class="text-xs text-gray-500">Identificador único usado no sistema (sem espaços)</p>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-blue-200 bg-gray-50 flex justify-between">
                <div class="text-sm text-gray-500">
                    Campos marcados com <span class="text-red-500">*</span> são obrigatórios
                </div>
                <div class="flex space-x-3">
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Salvar Alterações
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl border border-blue-200 shadow-sm overflow-hidden mt-6">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-800">Dicas Importantes</h3>
        </div>
        <div class="p-6">
            <div class="prose prose-sm text-gray-600">
                <ul class="space-y-2">
                    <li class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2 mt-0.5 flex-shrink-0"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span><strong>Título:</strong> Use um nome descritivo que seja fácil de entender para os
                            usuários</span>
                    </li>
                    <li class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2 mt-0.5 flex-shrink-0"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span><strong>Nome Interno:</strong> Use o formato snake_case (ex: create_users) e seja
                            consistente</span>
                    </li>
                    <li class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2 mt-0.5 flex-shrink-0"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span><strong>Padrão:</strong> Mantenha um padrão consistente em todas as permissões do
                            sistema</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
