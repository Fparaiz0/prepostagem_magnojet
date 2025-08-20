@extends('layouts.admin')

@section('content')
    <!-- Cabeçalho da Página -->
    <div class="content-header">
        <h2 class="content-title">Embalagens</h2>
        <div class="flex flex-wrap gap-3">
                @can('index-packaging')
                <a href="{{ route('packagings.index') }}"
                   class="flex items-center px-4 py-2.5 bg-white border border-gray-200 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Lista Completa
                </a>
                @endcan

                @can('edit-packaging')
                <a href="{{ route('packagings.edit', $packaging->id) }}"
                   class="flex items-center px-4 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Editar
                </a>
                @endcan
            </div>
    </div>
    <!-- Alert -->
    <div class="mt-4">
        <x-alert />
    </div>

    <!-- Main Content -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 mt-6 overflow-hidden">
        <!-- Packaging Overview -->
        <div class="bg-indigo-50 px-6 py-4 border-b border-gray-200">
            <div class="flex items-center gap-4">
                <div class="bg-white p-3 rounded-full shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">{{ $packaging->name }}</h2>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $packaging->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $packaging->active ? 'Ativo' : 'Inativo' }}
                        </span>
                        <span class="text-xs text-gray-500">Criado {{ $packaging->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Packaging Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
            <!-- Dimensions -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0v7a2 2 0 01-1 1.732l-7 4a2 2 0 01-2 0l-7-4A2 2 0 014 14V7m16 0L12 11M4 7l8 4" />
                    </svg>
                    Dimensões
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Altura</p>
                        <p class="text-gray-800 font-medium">{{ $packaging->height }} cm</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Largura</p>
                        <p class="text-gray-800 font-medium">{{ $packaging->width }} cm</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Comprimento</p>
                        <p class="text-gray-800 font-medium">{{ $packaging->length }} cm</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Diâmetro</p>
                        <p class="text-gray-800 font-medium">{{ $packaging->diameter }} cm</p>
                    </div>
                </div>
            </div>

            <!-- Specifications -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                    </svg>
                    Especificações
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Peso</p>
                        <p class="text-gray-800 font-medium">{{ $packaging->weight }} g</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Tipo</p>
                        <p class="text-gray-800 font-medium">{{ $packaging->type ?? 'Padrão' }}</p>
                    </div>
                </div>
            </div>

            <!-- System Information -->
            <div class="space-y-4 md:col-span-2">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Informações do Sistema
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Cadastrado em</p>
                        <p class="text-gray-800">{{ $packaging->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Última atualização</p>
                        <p class="text-gray-800">{{ $packaging->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Action -->
        @can('destroy-packaging')
        <div class="px-6 py-4 border-t border-blue-200 border-gray-200 bg-gray-50 flex justify-end">
            <form action="{{ route('packagings.destroy', $packaging->id) }}" method="POST">
                @csrf
                @method('delete')
                <button type="submit"
                        onclick="return confirm('Tem certeza que deseja excluir esta embalagem? Todos os dados serão permanentemente removidos.')"
                        class="flex items-center px-4 py-2 bg-white border border-red-200 rounded-lg text-red-600 hover:bg-red-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Excluir Embalagem
                </button>
            </form>
        </div>
        @endcan
    </div>
@endsection