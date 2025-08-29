@extends('layouts.admin')

@section('content')
    <!-- Cabeçalho da Página -->
    <div class="content-header flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="content-title">Permissões do Sistema</h2>
        </div>
        <div class="flex space-x-3 mt-4 md:mt-0">
            @can('create-permission')
            <a href="{{ route('permissions.create') }}" 
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Cadastrar Permissão
            </a>
            @endcan
        </div>
    </div>

    <div class="mt-5">
        <x-alert />
    </div>

    <!-- Listagem de Permissões -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden mt-6 border border-blue-200">
        <!-- Cabeçalho da Tabela -->
        <div class="px-6 py-4 border-b border-blue-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-800">Permissões Cadastradas</h3>
            <p class="text-sm text-gray-500 mt-1">{{ $permissions->total() }} permissões encontradas</p>
        </div>

        @forelse ($permissions as $permission)
        <div class="border-b border-blue-200 last:border-b-0">
            <div class="px-6 py-5 hover:bg-gray-50 transition-colors">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full bg-green-500"></div>
                            <div>
                                <h4 class="text-lg font-medium text-gray-800">{{ $permission->title }}</h4>
                                <p class="text-sm text-gray-500 mt-1">ID: {{ $permission->id }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-2 flex-wrap gap-2">
                        @can('show-permission')
                        <a href="{{ route('permissions.show', ['permission' => $permission->id]) }}" 
                           class="px-3 py-1.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Visualizar
                        </a>
                        @endcan

                        @can('edit-permission')
                        <a href="{{ route('permissions.edit', ['permission' => $permission->id]) }}" 
                           class="px-3 py-1.5 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors text-sm flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Editar
                        </a>
                        @endcan

                        @can('destroy-permission')
                        <form action="{{ route('permissions.destroy', ['permission' => $permission->id]) }}" method="POST" class="inline">
                            @csrf
                            @method('delete')
                            <button type="submit" 
                                    onclick="return confirm('Tem certeza que deseja excluir esta permissão? Esta ação não pode ser desfeita.')"
                                    class="px-3 py-1.5 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors text-sm flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-600">Nenhuma permissão encontrada</h3>
            <p class="mt-1 text-sm text-gray-500">Não há permissões cadastradas no sistema.</p>
            @can('create-permission')
            <a href="{{ route('permissions.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Cadastrar Primeira Permissão
            </a>
            @endcan
        </div>
        @endforelse
    </div>

     <!-- Pagination -->
        @if ($permissions->hasPages())
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
                    <!-- Results Info -->
                    <div class="text-sm text-gray-600">
                        Mostrando
                        <span class="font-medium">{{ $permissions->firstItem() }}</span>
                        a
                        <span class="font-medium">{{ $permissions->lastItem() }}</span>
                        de
                        <span class="font-medium">{{ $permissions->total() }}</span>
                        resultados  
                    </div>

                    <!-- Navigation -->
                    <nav class="flex items-center space-x-1">
                        {{-- Previous Button --}}
                        @if ($permissions->onFirstPage())
                            <span class="px-3 py-1 border rounded-md text-gray-400 cursor-not-allowed">
                                <span class="sr-only">Anterior</span>
                                &laquo;
                            </span>
                        @else
                            <a href="{{ $permissions->previousPageUrl() }}"
                               class="px-3 py-1 border rounded-md bg-white text-gray-700 hover:bg-gray-50 transition-colors">
                                <span class="sr-only">Anterior</span>
                                &laquo;
                            </a>
                        @endif

                        {{-- Page Numbers --}}
                        @foreach ($permissions->getUrlRange(1, $permissions->lastPage()) as $page => $url)
                            @if ($page == $permissions->currentPage())
                                <span class="px-3 py-1 border rounded-md bg-blue-600 text-white font-medium">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}"
                                   class="px-3 py-1 border rounded-md bg-white text-gray-700 hover:bg-gray-50 transition-colors">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        {{-- Next Button --}}
                        @if ($permissions->hasMorePages())
                            <a href="{{ $permissions->nextPageUrl() }}"
                               class="px-3 py-1 border rounded-md bg-white text-gray-700 hover:bg-gray-50 transition-colors">
                                <span class="sr-only">Próximo</span>
                                &raquo;
                            </a>
                        @else
                            <span class="px-3 py-1 border rounded-md text-gray-400 cursor-not-allowed">
                                <span class="sr-only">Próximo</span>
                                &raquo;
                            </span>
                        @endif
                    </nav>
                </div>
            </div>
        @endif
@endsection