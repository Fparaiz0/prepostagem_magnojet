@extends('layouts.admin')

@section('content')
    <!-- Cabeçalho da Página -->
    <div class="content-header">
        <h2 class="content-title">Perfil do Usuário</h2>
        <div class="flex space-x-3 mt-4 md:mt-0">
            @can('create-role')
                <a href="{{ route('roles.create') }}"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Cadastrar Papel
                </a>
            @endcan
        </div>
    </div>

    <div class="mt-5">
        <x-alert />
    </div>

    <!-- Listagem de Papéis -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden mt-6 border border-blue-200">
        <!-- Cabeçalho da Tabela -->
        <div class="px-6 py-4 border-b border-blue-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-800">Papéis Cadastrados</h3>
            <p class="text-sm text-gray-500 mt-1">{{ $roles->total() }} papéis encontrados</p>
        </div>

        @forelse ($roles as $role)
            <div class="border-b border-blue-200 last:border-b-0">
                <div class="px-6 py-5 hover:bg-gray-50 transition-colors">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-3">
                                <div class="w-3 h-3 rounded-full bg-purple-500"></div>
                                <div>
                                    <h4 class="text-lg font-medium text-gray-800">{{ $role->name }}</h4>
                                    <p class="text-sm text-gray-500 mt-1">ID: {{ $role->id }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center space-x-2 flex-wrap gap-2">
                            @can('index-role-permission')
                                <a href="{{ route('role-permissions.index', ['role' => $role->id]) }}"
                                    class="px-3 py-1.5 bg-purple-100 text-purple-700 rounded-lg hover:bg-purple-200 transition-colors text-sm flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 11c.828 0 1.5.672 1.5 1.5S12.828 14 12 14s-1.5-.672-1.5-1.5S11.172 11 12 11zm4-6a4 4 0 10-8 0v4h8V5zM6 9v10h12V9H6z" />
                                    </svg>
                                    Permissões
                                </a>
                            @endcan

                            @can('show-role')
                                <a href="{{ route('roles.show', ['role' => $role->id]) }}"
                                    class="px-3 py-1.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Visualizar
                                </a>
                            @endcan

                            @can('edit-role')
                                <a href="{{ route('roles.edit', ['role' => $role->id]) }}"
                                    class="px-3 py-1.5 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors text-sm flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Editar
                                </a>
                            @endcan

                            @can('destroy-role')
                                <form action="{{ route('roles.destroy', ['role' => $role->id]) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('delete')
                                    <button type="submit"
                                        onclick="return confirm('Tem certeza que deseja excluir este papel? Esta ação não pode ser desfeita.')"
                                        class="px-3 py-1.5 bg-red-100 cursor-pointer text-red-700 rounded-lg hover:bg-red-200 transition-colors text-sm flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Excluir
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="px-6 py-12 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-300" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-600">Nenhum papel encontrado</h3>
                <p class="mt-1 text-sm text-gray-500">Não há papéis cadastrados no sistema.</p>
                @can('create-role')
                    <a href="{{ route('roles.create') }}"
                        class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Cadastrar Primeiro Papel
                    </a>
                @endcan
            </div>
        @endforelse
    </div>

    <!-- Paginação -->
    @if ($roles->hasPages())
        <div class="mt-6 px-4 py-3 bg-white rounded-2xl shadow-sm border border-gray-100 flex items-center justify-center">
            {{ $roles->links() }}
        </div>
    @endif
@endsection
