@extends('layouts.admin')

@section('content')
    
    <!-- Cabeçalho da Página -->
    <div class="content-header">
        <h2 class="content-title">Status Usuários</h2>
        <div class="flex space-x-3 mt-4 md:mt-0">
            @can('create-user-status')
            <a href="{{ route('user_statuses.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Cadastrar Status
            </a>
            @endcan
        </div>
    </div>

    <div class="mt-5">
        <x-alert />
    </div>

    <!-- Listagem de Status -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden mt-6 border border-blue-200">
        <!-- Cabeçalho da Tabela -->
        <div class="px-6 py-4 border-b border-blue-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-800">Status Cadastrados</h3>
        </div>

        @forelse ($userStatuses as $userStatus)
        <div class="border-b border-blue-200 last:border-b-0">
            <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full bg-indigo-500"></div>
                            <h4 class="text-lg font-medium text-gray-800">{{ $userStatus->name }}</h4>
                        </div>
                        <p class="text-sm text-gray-500 mt-1 ml-6">ID: {{ $userStatus->id }}</p>
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        @can('show-user-status')
                        <a href="{{ route('user_statuses.show', ['userStatus' => $userStatus->id]) }}" 
                           class="px-3 py-1.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Visualizar
                        </a>
                        @endcan

                        @can('edit-user-status')
                        <a href="{{ route('user_statuses.edit', ['userStatus' => $userStatus->id]) }}" 
                           class="px-3 py-1.5 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors text-sm flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Editar
                        </a>
                        @endcan

                        @can('destroy-user-status')
                        <form action="{{ route('user_statuses.destroy', ['userStatus' => $userStatus->id]) }}" method="POST" class="inline">
                            @csrf
                            @method('delete')
                            <button type="submit" 
                                    onclick="return confirm('Tem certeza que deseja apagar este status?')"
                                    class="px-3 py-1.5 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors text-sm flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Apagar
                            </button>
                        </form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="px-6 py-12 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-600">Nenhum status encontrado</h3>
            <p class="mt-1 text-sm text-gray-500">Não há status de usuário cadastrados no momento.</p>
            @can('create-user-status')
            <a href="{{ route('user_statuses.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Cadastrar Primeiro Status
            </a>
            @endcan
        </div>
        @endforelse
    </div>

    <!-- Paginação -->
    @if($userStatuses->hasPages())
    <div class="mt-6 px-4 py-3 bg-white rounded-2xl shadow-sm border border-gray-100">
        {{ $userStatuses->links() }}
    </div>
    @endif
@endsection