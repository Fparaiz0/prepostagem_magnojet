@extends('layouts.admin')

@section('content')
<div class="content-wrapper">
    <!-- Cabeçalho da Página -->
    <div class="content-header flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Range de Etiquetas</h2>
            <p class="text-sm text-gray-500 mt-1">Visualize as etiquetas utilizadas</p>
        </div>
        <nav class="flex space-x-2 text-sm text-gray-500 mt-2 md:mt-0">
            <a href="{{ route('tracks.index') }}" class="text-blue-600 hover:text-blue-800">Etiquetas</a>
            <span class="text-gray-400">/</span>
            <span class="text-gray-600">Utilizadas</span>
        </nav>
    </div>

    <!-- Alert -->
    <div class="mt-4">
        <x-alert />
    </div>

    <!-- Formulário de Pesquisa -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Pesquisar Etiquetas Utilizadas</h3>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>

        <form action="{{ route('tracks.show') }}" method="GET" class="flex flex-col sm:flex-row gap-4 items-end">
            <div class="flex-grow">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Código de Etiqueta</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        name="search" 
                        id="search" 
                        value="{{ request('search') }}" 
                        placeholder="Digite o código da etiqueta..." 
                        class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                    />
                </div>
            </div>

            <div class="flex space-x-2">
                <button 
                    type="submit" 
                    class="px-6 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors flex items-center justify-center"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Pesquisar
                </button>
                <a 
                    href="{{ route('tracks.show') }}" 
                    class="px-4 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors flex items-center justify-center"
                    title="Limpar pesquisa"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </a>
            </div>
        </form>
    </div>

    <!-- Botões de Navegação -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 space-y-4 md:space-y-0">
        <div class="flex space-x-3">
            @can('index-range')
                <a href="{{ route('tracks.index') }}" 
                   class="px-4 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition duration-200 flex items-center text-sm font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Etiquetas Disponíveis
                </a>
            @endcan
        </div>
    </div>

    <!-- Lista de Códigos -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-semibold text-gray-800">Códigos de Etiquetas Utilizadas</h3>
            <span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">
                {{ $tracks->total() }} etiquetas
            </span>
        </div>

        @if($tracks->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3">
                @foreach ($tracks as $range)
                    <div class="px-3 py-2 border border-gray-200 bg-gray-50 rounded-lg shadow-sm hover:shadow-md transition duration-200 group">
                        <div class="flex items-center justify-between">
                            <span class="font-mono text-sm text-gray-700 font-medium tracking-wide">
                                {{ $range->object_code }}
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">
                            Utilizada em: {{ $range->updated_at->format('d/m/Y') }}
                        </p>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">
                    @if(request()->has('search') && !empty(request('search')))
                        Nenhuma etiqueta encontrada para "{{ request('search') }}"
                    @else
                        Nenhuma etiqueta utilizada encontrada
                    @endif
                </h3>
                <p class="text-gray-500">
                    @if(request()->has('search') && !empty(request('search')))
                        Tente ajustar o termo da pesquisa.
                    @else
                        Todas as etiquetas estão disponíveis no momento.
                    @endif
                </p>
            </div>
        @endif

        <!-- Paginação Estilizada -->
        @if($tracks->hasPages())
            <div class="mt-8 border-t border-gray-200 pt-6">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
                    <div class="text-sm text-gray-700">
                        Mostrando
                        <span class="font-medium">{{ $tracks->firstItem() }}</span>
                        a
                        <span class="font-medium">{{ $tracks->lastItem() }}</span>
                        de
                        <span class="font-medium">{{ $tracks->total() }}</span>
                        resultados
                    </div>
                    
                    <div class="flex items-center space-x-1">
                        {{-- Botão Anterior --}}
                        @if ($tracks->onFirstPage())
                            <span class="px-3 py-2 border border-gray-300 rounded-lg text-gray-400 cursor-not-allowed text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </span>
                        @else
                            <a href="{{ $tracks->previousPageUrl() }}" class="px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition-colors text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </a>
                        @endif

                        {{-- Links de Página --}}
                        @foreach ($tracks->getUrlRange(max(1, $tracks->currentPage() - 2), min($tracks->lastPage(), $tracks->currentPage() + 2)) as $page => $url)
                            @if ($page == $tracks->currentPage())
                                <span class="px-3 py-2 border border-blue-500 bg-blue-50 text-blue-600 font-medium rounded-lg text-sm">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" class="px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition-colors text-sm">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        {{-- Botão Próximo --}}
                        @if ($tracks->hasMorePages())
                            <a href="{{ $tracks->nextPageUrl() }}" class="px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition-colors text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        @else
                            <span class="px-3 py-2 border border-gray-300 rounded-lg text-gray-400 cursor-not-allowed text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection