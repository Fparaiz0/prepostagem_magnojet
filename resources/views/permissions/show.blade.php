@extends('layouts.admin')

@section('content')
    <div class="content-header flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="content-title text-2xl">Detalhes da Permissão</h2>
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

            @can('edit-permission')
                <a href="{{ route('permissions.edit', ['permission' => $permission->id]) }}"
                    class="flex items-center px-4 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors shadow-xs hover:shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Editar
                </a>
            @endcan
        </div>
    </div>

    <div class="mt-5">
        <x-alert />
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden mt-6">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center">
            <div class="w-3 h-3 rounded-full bg-green-500 mr-3"></div>
            <h3 class="text-lg font-semibold text-gray-800">Informações da Permissão</h3>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-500">ID</label>
                    <p class="text-lg font-semibold text-gray-800">{{ $permission->id }}</p>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-500">Título</label>
                    <p class="text-lg font-semibold text-gray-800">{{ $permission->title }}</p>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-500">Nome Interno</label>
                    <p class="text-sm font-mono text-green-600 bg-green-50 p-2 rounded-lg">{{ $permission->name }}</p>
                    <p class="text-xs text-gray-500 mt-1">Identificador único usado no sistema</p>
                </div>

                <div class="space-y-2"></div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-500">Data de Cadastro</label>
                    <p class="text-sm text-gray-800 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ \Carbon\Carbon::parse($permission->created_at)->format('d/m/Y H:i:s') }}
                    </p>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-500">Última Atualização</label>
                    <p class="text-sm text-gray-800 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        {{ \Carbon\Carbon::parse($permission->updated_at)->format('d/m/Y H:i:s') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end">
            @can('destroy-permission')
                <form action="{{ route('permissions.destroy', ['permission' => $permission->id]) }}" method="POST">
                    @csrf
                    @method('delete')
                    <button type="submit"
                        onclick="return confirm('Tem certeza que deseja excluir permanentemente esta permissão? Esta ação não pode ser desfeita.')"
                        class="px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Excluir Permissão
                    </button>
                </form>
            @endcan
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden mt-6">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-800">Ações Rápidas</h3>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
            @can('index-permission')
                <a href="{{ route('permissions.index') }}"
                    class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors flex items-center">
                    <div class="bg-blue-100 p-3 rounded-lg mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-800">Ver Todas as Permissões</h4>
                        <p class="text-sm text-gray-500 mt-1">Lista completa de permissões</p>
                    </div>
                </a>
            @endcan

            @can('create-permission')
                <a href="{{ route('permissions.create') }}"
                    class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors flex items-center">
                    <div class="bg-green-100 p-3 rounded-lg mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-800">Criar Nova Permissão</h4>
                        <p class="text-sm text-gray-500 mt-1">Adicionar outra permissão</p>
                    </div>
                </a>
            @endcan
        </div>
    </div>
@endsection
