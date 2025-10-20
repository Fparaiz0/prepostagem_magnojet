@extends('layouts.admin')

@section('content')
    @php
        // Recuperar o token de autenticação do banco de dados
        $apiToken = \App\Models\CorreiosToken::latest()->first()->token ?? null;
        // Contar pré-postagens com situação 1
        $countSituacao1 = \App\Models\PrePostagem::where('situation', 1)->count();
        $countSituacao2 = \App\Models\PrePostagem::where('situation', 2)->count();
        $countSituacao3 = \App\Models\PrePostagem::where('situation', 3)->count();
    @endphp

    <div class="content-wrapper">
        <!-- Cabeçalho da Página -->
        <div class="content-header flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Pré-Postagens</h2>
                <p class="text-sm text-gray-500 mt-1">Gerencie suas pré-postagens</p>
            </div>
            <nav class="flex space-x-2 text-sm text-gray-500 mt-2 md:mt-0">
                <a href="{{ route('prepostagens.index') }}" class="text-blue-600 hover:text-blue-800">Pré-Postagens</a>
                <span class="text-gray-400">/</span>
                <span class="text-gray-600">Listar</span>
            </nav>
        </div>

        <!-- Cards de Status -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-xl shadow-sm border border-blue-200 p-4">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-blue-100 text-blue-600 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Pré-Postadas</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $countSituacao1 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-green-200 p-4">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-green-100 text-green-600 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Postadas</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $countSituacao3 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-red-200 p-4">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-red-100 text-red-600 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Canceladas</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $countSituacao2 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros e Botões -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 space-y-4 md:space-y-0">
            <div class="flex flex-wrap gap-2">

                @can('posted-prepostagem')
                    <a href="{{ route('prepostagens.posted') }}"
                        class="px-4 py-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition duration-200 flex items-center text-sm font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Postadas
                    </a>
                @endcan
                @can('canceled-prepostagem')
                    <a href="{{ route('prepostagens.canceled') }}"
                        class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition duration-200 flex items-center text-sm font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            class="h-4 w-4 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Canceladas
                    </a>
                @endcan
            </div>

            <div class="flex flex-wrap gap-2">
                <!-- Botão de selecionar todas as checkboxes -->
                <button id="selectAllBtn"
                    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition duration-200 flex items-center text-sm font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    Selecionar Todas
                </button>

                <!-- Botão de imprimir selecionados (só aparece quando há checkboxes marcados) -->
                <button id="printSelectedBtn"
                    class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition duration-200 flex items-center text-sm font-medium hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m4 4h6a2 2 0 002-2v-4a2 2 0 00-2-2h-6a2 2 0 00-2 2v4a2 2 0 002 2z" />
                    </svg>
                    Imprimir Selecionados
                </button>

                <!-- Botão de imprimir todas as pré-postagens com situation = 1 -->
                <button id="printAllBtn"
                    class="print-all-btn px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition duration-200 flex items-center text-sm font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m4 4h6a2 2 0 002-2v-4a2 2 0 00-2-2h-6a2 2 0 00-2 2v4a2 2 0 002 2z" />
                    </svg>
                    Imprimir Todas
                </button>

                @can('create-prepostagem')
                    <a href="{{ route('prepostagens.create') }}"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition duration-200 flex items-center text-sm font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Nova Pré-Postagem
                    </a>
                @endcan
            </div>
        </div>

        <!-- Alert -->
        <div class="mt-4">
            <x-alert />
        </div>

        <form action="{{ route('prepostagens.index') }}" method="GET"
            class="bg-white rounded-xl shadow-sm border border-blue-300 p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Pesquisar Pré-Postagens</h3>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 items-end">
                <div class="flex-grow">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Nome do
                        Destinatário</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            placeholder="Digite o nome do destinatário..."
                            class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" />
                    </div>
                </div>

                <div class="flex space-x-2 w-full sm:w-auto">
                    <button type="submit"
                        class="flex-1 sm:flex-none px-6 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Pesquisar
                    </button>
                    <a href="{{ route('prepostagens.index') }}"
                        class="flex-1 sm:flex-none px-4 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors flex items-center justify-center"
                        title="Limpar pesquisa">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </a>
                </div>
            </div>
        </form>

        <!-- Lista de Pré-Postagens -->
        <div class="space-y-4">
            @forelse ($prepostagens as $prepostagem)
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition duration-200 relative hover:border-blue-300">
                    <!-- Checkbox para seleção -->
                    <div class="absolute top-4 right-4">
                        <input type="checkbox" class="object-checkbox h-5 w-5 text-blue-600 rounded focus:ring-blue-500"
                            data-object-code="{{ $prepostagem->object_code }}"
                            data-recipient="{{ $prepostagem->name_recipient }}"
                            @if ($prepostagem->situation != 1) disabled @endif>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-4">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Destinatário</p>
                            <p class="text-gray-800 font-semibold truncate">{{ $prepostagem->name_recipient }}</p>
                            <p class="text-sm text-gray-500 mt-1">{{ $prepostagem->address_recipient }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Data</p>
                            <p class="text-gray-800 font-semibold">
                                {{ \Carbon\Carbon::parse($prepostagem->created_at)->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Código</p>
                            <p class="text-blue-600 font-semibold font-mono">{{ $prepostagem->object_code }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Situação</p>
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                            @if ($prepostagem->situation == 1) bg-blue-100 text-blue-800 
                            @elseif($prepostagem->situation == 2) bg-red-100 text-red-800 
                            @elseif($prepostagem->situation == 3) bg-green-100 text-green-800 
                            @else bg-gray-100 text-gray-800 @endif">
                                @if ($prepostagem->situation == 1)
                                    Pré-Postado
                                @elseif($prepostagem->situation == 2)
                                    Cancelado
                                @elseif($prepostagem->situation == 3)
                                    Postado
                                @else
                                    Desconhecida
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 border-t pt-4 mt-4">
                        @can('show-prepostagem')
                            <a href="{{ route('prepostagens.show', ['prepostagem' => $prepostagem->id]) }}"
                                class="flex items-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200 text-sm font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Detalhes
                            </a>
                        @endcan
                        @if ($prepostagem->situation == 1)
                            @can('destroy-prepostagem')
                                <button type="button"
                                    onclick="openCancelModal({{ $prepostagem->id }}, '{{ $prepostagem->name_recipient }}', '{{ $prepostagem->object_code }}')"
                                    class="flex items-center px-4 py-2 border border-red-300 rounded-lg text-red-600 hover:bg-red-50 transition duration-200 text-sm font-medium cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Cancelar
                                </button>
                            @endcan
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">
                        @if (request()->has('search') && !empty(request('search')))
                            Nenhuma pré-postagem encontrada para "{{ request('search') }}"
                        @else
                            Nenhuma pré-postagem encontrada
                        @endif
                    </h3>
                    <p class="text-gray-500 mb-6">
                        @if (request()->has('search') && !empty(request('search')))
                            Tente ajustar o termo da pesquisa ou criar uma nova pré-postagem.
                        @else
                            Não há pré-postagens cadastradas no momento.
                        @endif
                    </p>
                    @can('create-prepostagem')
                        <a href="{{ route('prepostagens.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Nova Pré-Postagem
                        </a>
                    @endcan
                </div>
            @endforelse
        </div>

        <!-- Paginação Estilizada -->
        @if ($prepostagens->hasPages())
            <div
                class="mt-8 bg-white rounded-xl shadow-sm border border-gray-200 px-4 py-3 flex items-center justify-between">
                <div class="flex-1 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Mostrando
                            <span class="font-medium">{{ $prepostagens->firstItem() }}</span>
                            até
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
                                <span
                                    class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-400 cursor-not-allowed">
                                    <span class="sr-only">Anterior</span>
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                            @else
                                <a href="{{ $prepostagens->previousPageUrl() }}"
                                    class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                    <span class="sr-only">Anterior</span>
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            @endif

                            <!-- Pagination Elements -->
                            @foreach ($prepostagens->getUrlRange(1, $prepostagens->lastPage()) as $page => $url)
                                @if ($page == $prepostagens->currentPage())
                                    <span
                                        class="z-10 bg-blue-50 border-blue-500 text-blue-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}"
                                        class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            <!-- Next Page Link -->
                            @if ($prepostagens->hasMorePages())
                                <a href="{{ $prepostagens->nextPageUrl() }}"
                                    class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                    <span class="sr-only">Próximo</span>
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            @else
                                <span
                                    class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-400 cursor-not-allowed">
                                    <span class="sr-only">Próximo</span>
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                            @endif
                        </nav>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Modal de Cancelamento -->
    <div id="cancelModal"
        class="fixed inset-0 bg-gray-600/50 backdrop-blur-sm flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4 transform transition-all duration-300 scale-95 opacity-0"
            id="modalContent">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Cancelar Pré-Postagem</h3>
                <button type="button" onclick="closeCancelModal()"
                    class="text-gray-400 hover:text-gray-500 transition-colors">
                    <svg class="h-6 w-6 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="cancelForm" method="POST">
                @csrf
                @method('delete')

                <div class="px-6 py-6">
                    <div class="text-center">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>

                        <h3 class="text-lg font-medium text-gray-900 mb-2">Tem certeza que deseja cancelar?</h3>

                        <div class="bg-gray-50 rounded-lg p-4 text-left mb-4">
                            <p class="text-sm text-gray-600">Destinatário:</p>
                            <p id="modalRecipient" class="font-medium text-gray-900"></p>
                            <p class="text-sm text-gray-600 mt-2">Código de objeto:</p>
                            <p id="modalObjectCode" class="font-mono text-blue-600 font-medium"></p>
                        </div>

                        <p class="text-sm text-gray-500">
                            Essa ação não poderá ser desfeita e a pré-postagem será marcada como cancelada.
                        </p>
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3 rounded-b-xl">
                    <button type="button" onclick="closeCancelModal()"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 text-sm font-medium transition-colors cursor-pointer">
                        Voltar
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm font-medium transition-colors cursor-pointer">
                        Cancelar Pré-Postagem
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de Formato de Impressão -->
    <div id="printFormatModal"
        class="fixed inset-0 bg-gray-600/50 backdrop-blur-sm flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4 transform transition-all duration-300 scale-95 opacity-0"
            id="printFormatModalContent">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Formato de Impressão</h3>
                <button type="button" onclick="closePrintFormatModal()"
                    class="text-gray-400 hover:text-gray-500 transition-colors">
                    <svg class="h-6 w-6 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="px-6 py-6">
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m4 4h6a2 2 0 002-2v-4a2 2 0 00-2-2h-6a2 2 0 00-2 2v4a2 2 0 002 2z" />
                        </svg>
                    </div>

                    <h3 class="text-lg font-medium text-gray-900 mb-4">Selecione o formato de impressão</h3>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <!-- Opção Etiqueta -->
                        <button type="button" onclick="selectPrintFormat('etiqueta')"
                            class="print-format-option p-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-colors cursor-pointer text-center"
                            data-format="etiqueta">
                            <div class="flex flex-col items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-600 mb-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                <span class="font-medium text-gray-700">Etiqueta</span>
                                <span class="text-xs text-gray-500 mt-1">Formato padrão</span>
                            </div>
                        </button>

                        <!-- Opção A4 -->
                        <button type="button" onclick="selectPrintFormat('a4')"
                            class="print-format-option p-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-colors cursor-pointer text-center"
                            data-format="a4">
                            <div class="flex flex-col items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-600 mb-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span class="font-medium text-gray-700">A4</span>
                                <span class="text-xs text-gray-500 mt-1">Formato página</span>
                            </div>
                        </button>
                    </div>

                    <p class="text-sm text-gray-500">
                        Escolha o formato desejado para impressão das etiquetas.
                    </p>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3 rounded-b-xl">
                <button type="button" onclick="closePrintFormatModal()"
                    class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 text-sm font-medium transition-colors cursor-pointer">
                    Cancelar
                </button>
                <button type="button" id="confirmPrintBtn" onclick="confirmPrintAll()"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium transition-colors cursor-pointer hidden">
                    Confirmar Impressão
                </button>
            </div>
        </div>
    </div>

    <!-- Modal de Carregamento -->
    <div id="loadingModal"
        class="fixed inset-0 bg-gray-600/50 backdrop-blur-sm flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4 p-6 text-center">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Processando etiquetas</h3>
            <p class="text-sm text-gray-500">Aguarde enquanto enviamos os dados para impressão...</p>
            <p id="loadingError" class="text-sm text-red-500 mt-2 hidden"></p>
        </div>
    </div>

    <script>
        // Variável global para armazenar os códigos selecionados
        let selectedObjects = [];
        let currentReciboId = null;
        let allSelected = false;
        let selectedPrintFormat = null;

        function openCancelModal(id, recipient, objectCode) {
            const form = document.getElementById('cancelForm');
            form.action = "{{ route('prepostagens.destroy', ':id') }}".replace(':id', id);

            document.getElementById('modalRecipient').textContent = recipient;
            document.getElementById('modalObjectCode').textContent = objectCode;

            const modal = document.getElementById('cancelModal');
            const modalContent = document.getElementById('modalContent');

            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 50);
        }

        function closeCancelModal() {
            const modal = document.getElementById('cancelModal');
            const modalContent = document.getElementById('modalContent');

            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
            }, 200);
        }

        // Função para abrir modal de formato de impressão
        function openPrintFormatModal() {
            const modal = document.getElementById('printFormatModal');
            const modalContent = document.getElementById('printFormatModalContent');

            // Resetar seleção
            selectedPrintFormat = null;
            document.querySelectorAll('.print-format-option').forEach(option => {
                option.classList.remove('border-blue-500', 'bg-blue-50');
                option.classList.add('border-gray-200');
            });
            document.getElementById('confirmPrintBtn').classList.add('hidden');

            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 50);
        }

        function closePrintFormatModal() {
            const modal = document.getElementById('printFormatModal');
            const modalContent = document.getElementById('printFormatModalContent');

            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
            }, 200);
        }

        // Função para selecionar formato de impressão
        function selectPrintFormat(format) {
            selectedPrintFormat = format;

            // Atualizar UI
            document.querySelectorAll('.print-format-option').forEach(option => {
                if (option.getAttribute('data-format') === format) {
                    option.classList.add('border-blue-500', 'bg-blue-50');
                    option.classList.remove('border-gray-200');
                } else {
                    option.classList.remove('border-blue-500', 'bg-blue-50');
                    option.classList.add('border-gray-200');
                }
            });

            // Mostrar botão de confirmação
            document.getElementById('confirmPrintBtn').classList.remove('hidden');
        }

        // Função para confirmar impressão de todas
        function confirmPrintAll() {
            if (!selectedPrintFormat) {
                alert('Por favor, selecione um formato de impressão.');
                return;
            }

            closePrintFormatModal();
            printAllPrepostagens(selectedPrintFormat);
        }

        // Função para mostrar/ocultar modal de carregamento
        function toggleLoadingModal(show) {
            const modal = document.getElementById('loadingModal');
            if (show) {
                modal.classList.remove('hidden');
            } else {
                modal.classList.add('hidden');
            }
        }

        // Função para mostrar erro no modal de carregamento
        function showLoadingError(message) {
            const errorElement = document.getElementById('loadingError');
            errorElement.textContent = message;
            errorElement.classList.remove('hidden');

            // Parar a animação de carregamento
            const spinner = document.querySelector('#loadingModal .animate-spin');
            if (spinner) {
                spinner.classList.remove('animate-spin');
                spinner.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        `;
            }
        }

        // Função para enviar dados para API dos Correios via Laravel
        async function sendToCorreiosAPI(objectCodes, formato = 'etiqueta') {
            console.log('Iniciando envio para API dos Correios');
            console.log('Códigos de objeto:', objectCodes);
            console.log('Formato:', formato);

            // Validar se há códigos para enviar
            if (!objectCodes || objectCodes.length === 0) {
                alert('Nenhum código de objeto selecionado para impressão.');
                return;
            }

            toggleLoadingModal(true);

            try {
                // URL da rota Laravel que vai fazer a requisição para os Correios
                const apiUrl = '{{ route('prepostagens.imprimir-selecionados') }}';

                // Preparar dados para envio
                const requestData = {
                    codigosObjeto: objectCodes,
                    formato: formato
                };

                console.log('Dados que serão enviados:', requestData);

                // Enviar requisição para nossa própria API Laravel
                const response = await fetch(apiUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json, application/pdf'
                    },
                    body: JSON.stringify(requestData)
                });

                console.log('Resposta da API:', response);

                // Verificar se a resposta é um PDF
                const contentType = response.headers.get('content-type');
                console.log('Content-Type da resposta:', contentType);

                if (contentType && contentType.includes('application/pdf')) {
                    // Criar blob a partir da resposta
                    const blob = await response.blob();

                    // Criar URL para o blob
                    const url = window.URL.createObjectURL(blob);

                    // Abrir o PDF em uma nova janela
                    window.open(url, '_blank');

                    // Limpar a URL depois de um tempo
                    setTimeout(() => window.URL.revokeObjectURL(url), 100);

                    // Mostrar mensagem de sucesso
                    alert('Etiquetas geradas com sucesso!');

                    // Limpar seleções
                    selectedObjects = [];
                    document.querySelectorAll('.object-checkbox').forEach(checkbox => {
                        checkbox.checked = false;
                    });
                    document.getElementById('printSelectedBtn').classList.add('hidden');

                    toggleLoadingModal(false);
                    return;
                }

                // Se não for PDF, processar como JSON
                const data = await response.json();
                console.log('Dados JSON da resposta:', data);

                if (!response.ok) {
                    // Se for erro 202 (Accepted), significa que o PDF está sendo processado
                    if (response.status === 202 && data.idRecibo) {
                        currentReciboId = data.idRecibo;
                        if (confirm(
                                'As etiquetas estão sendo processadas. Deseja tentar baixar novamente em alguns segundos?'
                            )) {
                            setTimeout(tryDownloadPDFAgain, 5000);
                        }
                    } else {
                        throw new Error(data.message || data.error || `Erro: ${response.status}`);
                    }
                    return;
                }

                // Se chegou aqui, algo inesperado aconteceu
                throw new Error('Resposta inesperada da API');

            } catch (error) {
                console.error('Erro ao enviar para API dos Correios:', error);
                alert('Erro ao processar as etiquetas: ' + error.message);
            } finally {
                toggleLoadingModal(false);
            }
        }

        // Função para imprimir todas as pré-postagens
        async function printAllPrepostagens(formato = 'etiqueta') {
            console.log('Iniciando impressão de todas as pré-postagens');
            console.log('Formato selecionado:', formato);

            toggleLoadingModal(true);

            try {
                // URL da rota Laravel para imprimir todas
                const apiUrl = '{{ route('prepostagens.imprimir-todas') }}';

                // Enviar requisição para nossa própria API Laravel
                const response = await fetch(apiUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json, application/pdf'
                    },
                    body: JSON.stringify({
                        formato: formato
                    })
                });

                console.log('Resposta da API (imprimir todas):', response);

                // Verificar se a resposta é um PDF
                const contentType = response.headers.get('content-type');
                if (contentType && contentType.includes('application/pdf')) {
                    // Criar blob a partir da resposta
                    const blob = await response.blob();

                    // Criar URL para o blob
                    const url = window.URL.createObjectURL(blob);

                    // Abrir o PDF em uma nova janela
                    window.open(url, '_blank');

                    // Limpar a URL depois de um tempo
                    setTimeout(() => window.URL.revokeObjectURL(url), 100);

                    // Mostrar mensagem de sucesso
                    alert('Todas as etiquetas foram geradas com sucesso!');

                    toggleLoadingModal(false);
                    return;
                }

                // Se não for PDF, processar como JSON
                const data = await response.json();

                if (!response.ok) {
                    // Se for erro 202 (Accepted), significa que o PDF está sendo processado
                    if (response.status === 202 && data.idRecibo) {
                        currentReciboId = data.idRecibo;
                        if (confirm(
                                'As etiquetas estão sendo processadas. Deseja tentar baixar novamente em alguns segundos?'
                            )) {
                            setTimeout(tryDownloadPDFAgain, 5000);
                        }
                    } else if (response.status === 404) {
                        // Nenhuma pré-postagem encontrada
                        alert(data.message || 'Nenhuma pré-postagem encontrada para impressão.');
                    } else {
                        throw new Error(data.message || data.error || `Erro: ${response.status}`);
                    }
                    return;
                }

                // Se chegou aqui, algo inesperado aconteceu
                throw new Error('Resposta inesperada da API');

            } catch (error) {
                console.error('Erro ao imprimir todas as pré-postagens:', error);
                alert('Erro ao processar as etiquetas: ' + error.message);
            } finally {
                toggleLoadingModal(false);
            }
        }

        // Função para tentar novamente buscar o PDF
        async function tryDownloadPDFAgain() {
            if (!currentReciboId) return;

            toggleLoadingModal(true);

            try {
                const response = await fetch('/prepostagens/baixar-pdf/' + currentReciboId, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/pdf'
                    }
                });

                const contentType = response.headers.get('content-type');
                if (contentType && contentType.includes('application/pdf')) {
                    const blob = await response.blob();
                    const url = window.URL.createObjectURL(blob);
                    window.open(url, '_blank');
                    setTimeout(() => window.URL.revokeObjectURL(url), 100);
                    alert('PDF baixado com sucesso!');
                    currentReciboId = null;
                } else {
                    const data = await response.json();
                    if (response.status === 202) {
                        alert('PDF ainda está sendo processado. Tente novamente em alguns instantes.');
                    } else {
                        throw new Error(data.message || 'Erro ao baixar PDF');
                    }
                }
            } catch (error) {
                console.error('Erro ao tentar baixar PDF:', error);
                alert('Erro: ' + error.message);
            } finally {
                toggleLoadingModal(false);
            }
        }

        // Função para verificar o estado inicial dos checkboxes
        function checkInitialSelectionState() {
            const checkboxes = document.querySelectorAll('.object-checkbox:not(:disabled)');
            const anySelected = Array.from(checkboxes).some(checkbox => checkbox.checked);
            const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
            const printAllBtn = document.getElementById('printAllBtn');
            const printSelectedBtn = document.getElementById('printSelectedBtn');
            const selectAllBtn = document.getElementById('selectAllBtn');

            if (allChecked && checkboxes.length > 0) {
                allSelected = true;
                if (selectAllBtn) {
                    selectAllBtn.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Desmarcar Todas`;
                }
                if (printAllBtn) printAllBtn.classList.add('hidden');
            }

            if (anySelected && !allChecked && printAllBtn) {
                printAllBtn.classList.remove('hidden');
            }

            if (anySelected && printSelectedBtn) {
                printSelectedBtn.classList.remove('hidden');
            }
        }

        // Inicialização quando o documento estiver carregado
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM carregado, inicializando eventos');

            const checkboxes = document.querySelectorAll('.object-checkbox');
            const printSelectedBtn = document.getElementById('printSelectedBtn');
            const printAllBtn = document.getElementById('printAllBtn');
            const selectAllBtn = document.getElementById('selectAllBtn');

            console.log('Checkboxes encontrados:', checkboxes.length);
            console.log('Botão imprimir selecionados:', printSelectedBtn);
            console.log('Botão imprimir todas:', printAllBtn);
            console.log('Botão selecionar todas:', selectAllBtn);

            // Verificar se temos um token de API válido
            const apiToken = '{{ $apiToken }}';
            console.log('Token API disponível:', !!apiToken);

            if (!apiToken) {
                console.warn('Token de API não encontrado. Os botões de impressão não estarão disponíveis.');
                // Esconder os botões completamente se não houver token
                if (printSelectedBtn) printSelectedBtn.style.display = 'none';
                if (printAllBtn) printAllBtn.style.display = 'none';
                if (selectAllBtn) selectAllBtn.style.display = 'none';
                return;
            }

            // Adicionar evento de change a todos os checkboxes
            checkboxes.forEach((checkbox, index) => {
                console.log(`Adicionando evento ao checkbox ${index + 1}`);

                checkbox.addEventListener('change', function() {
                    const objectCode = this.getAttribute('data-object-code');
                    const recipient = this.getAttribute('data-recipient');

                    console.log('Checkbox alterado:', {
                        checked: this.checked,
                        objectCode: objectCode,
                        recipient: recipient
                    });

                    if (this.checked) {
                        // Adicionar à lista de selecionados
                        selectedObjects.push({
                            code: objectCode,
                            recipient: recipient
                        });
                    } else {
                        // Remover da lista de selecionados
                        selectedObjects = selectedObjects.filter(obj => obj.code !== objectCode);
                        // Se desmarcar um checkbox individual, garantir que o estado "Selecionar Todas" seja false
                        allSelected = false;
                        if (selectAllBtn) {
                            selectAllBtn.innerHTML = `
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            Selecionar Todas`;
                        }
                    }

                    console.log('Objetos selecionados:', selectedObjects);

                    // Mostrar ou esconder o botão de imprimir selecionados
                    if (selectedObjects.length > 0) {
                        // Sempre mostrar apenas "Imprimir Selecionados"
                        printSelectedBtn.classList.remove('hidden');
                        printSelectedBtn.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m4 4h6a2 2 0 002-2v-4a2 2 0 00-2-2h-6a2 2 0 00-2 2v4a2 2 0 002 2z" />
        </svg>
        Imprimir Selecionados (${selectedObjects.length})
    `;

                        if (printAllBtn) printAllBtn.classList.add(
                            'hidden');
                    } else {
                        printSelectedBtn.classList.add('hidden');
                        if (printAllBtn) printAllBtn.classList.remove(
                            'hidden');
                    }

                    // Verificar se todos os checkboxes estão selecionados para atualizar o botão "Selecionar Todas"
                    const allCheckboxes = document.querySelectorAll(
                        '.object-checkbox:not(:disabled)');
                    const allChecked = Array.from(allCheckboxes).every(checkbox => checkbox
                        .checked);

                    if (allChecked && allCheckboxes.length > 0) {
                        allSelected = true;
                        if (selectAllBtn) {
                            selectAllBtn.innerHTML = `
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Desmarcar Todas`;
                        }
                        // Quando todos estão selecionados, esconder "Imprimir Todas"
                        if (printAllBtn) printAllBtn.classList.add('hidden');
                    }
                });
            });

            // Adicionar evento de clique ao botão de selecionar todas
            if (selectAllBtn) {
                selectAllBtn.addEventListener('click', function() {
                    const checkboxes = document.querySelectorAll('.object-checkbox:not(:disabled)');

                    allSelected = !allSelected;

                    // 🔑 Limpar a lista antes de refazer
                    selectedObjects = [];

                    checkboxes.forEach(checkbox => {
                        checkbox.checked = allSelected;

                        if (allSelected) {
                            selectedObjects.push({
                                code: checkbox.getAttribute('data-object-code'),
                                recipient: checkbox.getAttribute('data-recipient')
                            });
                        }
                    });

                    console.log('Objetos selecionados após selecionar todas:', selectedObjects);

                    // Atualizar texto do botão
                    selectAllBtn.innerHTML = allSelected ?
                        `<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
         </svg>
         Desmarcar Todas` :
                        `<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
         </svg>
         Selecionar Todas`;

                    // Mostrar/ocultar botões de impressão
                    if (allSelected) {
                        if (printAllBtn) printAllBtn.classList.add('hidden');
                        if (printSelectedBtn) {
                            printSelectedBtn.classList.remove('hidden');
                            printSelectedBtn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m4 4h6a2 2 0 002-2v-4a2 2 0 00-2-2h-6a2 2 0 00-2 2v4a2 2 0 002 2z" />
                </svg>
                Imprimir Selecionados (${selectedObjects.length})
            `;
                        }
                    } else {
                        if (printAllBtn) printAllBtn.classList.remove('hidden');
                        if (printSelectedBtn) printSelectedBtn.classList.add('hidden');
                    }
                });

            }

            // Adicionar evento de clique ao botão de imprimir selecionados
            if (printSelectedBtn) {
                printSelectedBtn.addEventListener('click', function() {
                    console.log('Botão imprimir selecionados clicado');

                    // Verificar se temos um token válido
                    if (!apiToken) {
                        alert(
                            'Token de autenticação não configurado. Entre em contato com o administrador.'
                        );
                        return;
                    }

                    // Verificar se há itens selecionados
                    if (selectedObjects.length === 0) {
                        alert('Nenhuma pré-postagem selecionada para impressão.');
                        return;
                    }

                    // Abrir modal de formato para selecionados também
                    openPrintFormatModalForSelected();
                });
            }

            // Adicionar evento de clique ao botão de imprimir todas
            if (printAllBtn) {
                printAllBtn.addEventListener('click', function() {
                    console.log('Botão imprimir todas clicado');

                    // Verificar se temos um token válido
                    if (!apiToken) {
                        alert(
                            'Token de autenticação não configurado. Entre em contato com o administrador.'
                        );
                        return;
                    }

                    // Abrir modal de formato
                    openPrintFormatModal();
                });
            }

            console.log('Inicialização concluída');
            checkInitialSelectionState();
        });

        // Função para abrir modal de formato para itens selecionados
        function openPrintFormatModalForSelected() {
            const modal = document.getElementById('printFormatModal');
            const modalContent = document.getElementById('printFormatModalContent');

            // Resetar seleção
            selectedPrintFormat = null;
            document.querySelectorAll('.print-format-option').forEach(option => {
                option.classList.remove('border-blue-500', 'bg-blue-50');
                option.classList.add('border-gray-200');
            });
            document.getElementById('confirmPrintBtn').classList.add('hidden');

            // Atualizar texto do botão de confirmação
            document.getElementById('confirmPrintBtn').textContent = 'Imprimir Selecionados';

            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 50);
        }

        // Função para confirmar impressão dos selecionados
        function confirmPrintSelected() {
            if (!selectedPrintFormat) {
                alert('Por favor, selecione um formato de impressão.');
                return;
            }

            closePrintFormatModal();

            // Extrair apenas os códigos de objeto para enviar à API
            const objectCodes = selectedObjects.map(obj => obj.code);
            console.log('Códigos que serão enviados:', objectCodes);

            // Enviar para a API via Laravel
            sendToCorreiosAPI(objectCodes, selectedPrintFormat);
        }

        // Modificar a função selectPrintFormat para verificar contexto
        function selectPrintFormat(format) {
            selectedPrintFormat = format;

            // Atualizar UI
            document.querySelectorAll('.print-format-option').forEach(option => {
                if (option.getAttribute('data-format') === format) {
                    option.classList.add('border-blue-500', 'bg-blue-50');
                    option.classList.remove('border-gray-200');
                } else {
                    option.classList.remove('border-blue-500', 'bg-blue-50');
                    option.classList.add('border-gray-200');
                }
            });

            // Mostrar botão de confirmação
            const confirmBtn = document.getElementById('confirmPrintBtn');
            confirmBtn.classList.remove('hidden');

            // Verificar se é para selecionados ou todas
            if (selectedObjects.length > 0) {
                confirmBtn.textContent = 'Imprimir Selecionados';
                confirmBtn.onclick = confirmPrintSelected;
            } else {
                confirmBtn.textContent = 'Imprimir Todas';
                confirmBtn.onclick = confirmPrintAll;
            }
        }
    </script>
@endsection
