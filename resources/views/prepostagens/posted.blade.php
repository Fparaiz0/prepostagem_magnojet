@extends('layouts.admin')

@section('content')
<div class="content-wrapper">
    <!-- Cabeçalho da Página -->
    <div class="content-header flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Pré-Postagens Postadas</h2>
            <p class="text-sm text-gray-500 mt-1">Visualize as pré-postagens que já foram postadas</p>
        </div>
        <nav class="flex space-x-2 text-sm text-gray-500 mt-2 md:mt-0">
            <a href="{{ route('prepostagens.index') }}" class="text-blue-600 hover:text-blue-800">Pré-Postagens</a>
            <span class="text-gray-400">/</span>
            <span class="text-gray-600">Postadas</span>
        </nav>
    </div>

    <!-- Filtros e Botões -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 space-y-4 md:space-y-0">
        <div class="flex space-x-3">
            @can('index-prepostagem')
                <a href="{{ route('prepostagens.index') }}" 
                   class="px-4 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition duration-200 flex items-center text-sm font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7l9 5 9-5M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Pré-Postadas
                </a>
            @endcan
            @can('canceled-prepostagem')
                <a href="{{ route('prepostagens.canceled') }}" 
                   class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition duration-200 flex items-center text-sm font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636a9 9 0 11-12.728 12.728 9 9 0 0112.728-12.728zM6.343 17.657l11.314-11.314" />
                    </svg>
                    Canceladas
                </a>
            @endcan
        </div>
    </div>

    <!-- Alert -->
    <div class="mt-4">
        <x-alert />
    </div>

    <!-- Formulário de Pesquisa -->
    <div class="bg-white rounded-xl shadow-sm border border-green-300 p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Pesquisar Pré-Postagens Postadas</h3>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>

        <form action="{{ route('prepostagens.posted') }}" method="GET" class="flex flex-col sm:flex-row gap-4 items-end">
            <div class="flex-grow">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Nome do Destinatário</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        name="search" 
                        id="search" 
                        value="{{ request('search') }}" 
                        placeholder="Digite o nome do destinatário..." 
                        class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                    />
                </div>
            </div>

            <div class="flex space-x-2">
                <button 
                    type="submit" 
                    class="px-6 py-2.5 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors flex items-center justify-center"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Pesquisar
                </button>
                <a 
                    href="{{ route('prepostagens.posted') }}" 
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

    <!-- Lista de Pré-Postagens -->
    <div class="space-y-4">
        @forelse ($prepostagens as $prepostagem)
            <div class="bg-white rounded-xl shadow-sm border border-green-300 p-6 hover:shadow-md transition duration-200">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-4">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Destinatário</p>
                        <p class="text-gray-800 font-semibold truncate">{{ $prepostagem->name_recipient }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Data de Criação</p>
                        <p class="text-gray-800 font-semibold">{{ \Carbon\Carbon::parse($prepostagem->created_at)->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Código de Rastreio</p>
                        <p class="text-blue-600 font-semibold font-mono">{{ $prepostagem->object_code }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Situação</p>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Postado
                        </span>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 border-t pt-4 mt-4">
                    @can('show-prepostagem')
                        <a href="{{ route('prepostagens.show', ['prepostagem' => $prepostagem->id]) }}" 
                           class="flex items-center px-4 py-2 border border-green-300 rounded-lg text-green-700 hover:bg-green-50 transition duration-200 text-sm font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Detalhes
                        </a>
                    @endcan
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">
                    @if(request()->has('search') && !empty(request('search')))
                        Nenhuma pré-postagem postada encontrada para "{{ request('search') }}"
                    @else
                        Nenhuma pré-postagem postada encontrada
                    @endif
                </h3>
                <p class="text-gray-500 mb-6">
                    @if(request()->has('search') && !empty(request('search')))
                        Tente ajustar o termo da pesquisa.
                    @else
                        Não há pré-postagens postadas no momento.
                    @endif
                </p>
            </div>
        @endforelse
    </div>

    <!-- Paginação Estilizada -->
    @if($prepostagens->hasPages())
        <div class="mt-8 bg-white rounded-xl shadow-sm border border-gray-200 px-4 py-3 flex items-center justify-between">
            <div class="flex-1 flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-700">
                        Mostrando
                        <span class="font-medium">{{ $prepostagens->firstItem() }}</span>
                        a
                        <span class="font-medium">{{ $prepostagens->lastItem() }}</span>
                        de
                        <span class="font-medium">{{ $prepostagens->total() }}</span>
                        resultados
                    </p>
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <!-- Previous Page Link -->
                        @if ($prepostagens->onFirstPage())
                            <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-400 cursor-not-allowed">
                                <span class="sr-only">Anterior</span>
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        @else
                            <a href="{{ $prepostagens->previousPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Anterior</span>
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        @endif

                        <!-- Pagination Elements -->
                        @foreach ($prepostagens->getUrlRange(max(1, $prepostagens->currentPage() - 2), min($prepostagens->lastPage(), $prepostagens->currentPage() + 2)) as $page => $url)
                            @if ($page == $prepostagens->currentPage())
                                <span aria-current="page" class="z-10 bg-green-50 border-green-500 text-green-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        <!-- Next Page Link -->
                        @if ($prepostagens->hasMorePages())
                            <a href="{{ $prepostagens->nextPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Próximo</span>
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        @else
                            <span class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-400 cursor-not-allowed">
                                <span class="sr-only">Próximo</span>
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        @endif
                    </nav>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection