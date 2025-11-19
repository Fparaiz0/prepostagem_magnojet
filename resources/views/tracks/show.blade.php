@extends('layouts.admin')

@section('page-title', 'Etiquetas Utilizadas')
@section('breadcrumb')
    <li>
        <span class="text-gray-500">/</span>
        <span class="text-gray-700 ml-2">Etiquetas</span>
        <span class="text-gray-500">/</span>
        <span class="text-gray-700 ml-2">Utilizadas</span>
    </li>
@endsection

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Cabeçalho da Página -->
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="mb-4 sm:mb-0">
                        <h1 class="text-2xl font-bold text-gray-900">Etiquetas Utilizadas</h1>
                        <p class="text-sm text-gray-600 mt-1">Visualize as etiquetas que já foram utilizadas</p>
                    </div>

                    <!-- Breadcrumb -->
                    <nav class="flex items-center text-sm text-gray-500">
                        <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-medium">
                            Utilizadas
                        </span>
                    </nav>
                </div>
            </div>

            <!-- Alert -->
            <div class="mb-6">
                <x-alert />
            </div>

            <!-- Formulário de Pesquisa -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <div class="p-2 bg-blue-100 rounded-lg mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Pesquisar Etiquetas</h3>
                            <p class="text-sm text-gray-600 mt-1">Encontre etiquetas utilizadas por código</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('tracks.show') }}" method="GET" class="flex flex-col sm:flex-row gap-4 items-end">
                    <div class="grow">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Código da
                            Etiqueta</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                </svg>
                            </div>
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                placeholder="Digite o código da etiqueta..."
                                class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" />
                        </div>
                    </div>

                    <div class="flex space-x-2 w-full sm:w-auto">
                        <button type="submit"
                            class="flex-1 sm:flex-none px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Pesquisar
                        </button>
                        <a href="{{ route('tracks.show') }}"
                            class="flex-1 sm:flex-none px-4 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors flex items-center justify-center"
                            title="Limpar pesquisa">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </a>
                    </div>
                </form>
            </div>

            <!-- Botões de Navegação -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 space-y-4 sm:space-y-0">
                <div class="flex space-x-3">
                    @can('index-range')
                        <a href="{{ route('tracks.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-50 border border-blue-200 text-blue-700 font-medium rounded-lg hover:bg-blue-100 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Etiquetas Disponíveis
                        </a>
                    @endcan
                </div>
            </div>

            <!-- Lista de Códigos -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <!-- Header -->
                <div class="bg-linear-to-r from-red-50 to-orange-50 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="p-2 bg-red-100 rounded-lg mr-3">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Etiquetas Utilizadas</h3>
                                <p class="text-sm text-gray-600 mt-1">Códigos que já foram vinculados a NF</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-red-100 text-red-800 text-sm font-medium rounded-full">
                            {{ $tracks->total() }} etiquetas
                        </span>
                    </div>
                </div>

                <!-- Conteúdo -->
                <div class="p-6">
                    @if ($tracks->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                            @foreach ($tracks as $range)
                                <div class="group relative">
                                    <!-- Card da Etiqueta -->
                                    <div
                                        class="bg-red-50 border-2 border-red-200 rounded-xl p-4 hover:bg-red-100 hover:border-red-300 hover:shadow-md transition-all duration-200 group-hover:scale-105">
                                        <!-- Código -->
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="font-mono text-sm text-red-800 font-semibold tracking-wide">
                                                {{ $range->object_code }}
                                            </span>
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4 text-red-500 opacity-0 group-hover:opacity-100 transition-opacity"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>

                                        <!-- Nota Fiscal -->
                                        @if ($range->invoice)
                                            <div class="bg-white rounded-lg border border-red-100 p-2 mb-2">
                                                <div class="text-xs text-gray-500 font-medium mb-1">NOTA FISCAL</div>
                                                <div class="text-sm text-gray-800 font-semibold">{{ $range->invoice }}
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Data de Utilização -->
                                        <div class="flex items-center text-xs text-gray-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Utilizada em: {{ $range->updated_at->format('d/m/Y') }}
                                        </div>

                                        <!-- Indicador de Status -->
                                        <div class="absolute top-2 right-2">
                                            <div class="w-3 h-3 bg-red-500 rounded-full border-2 border-white shadow-sm">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <!-- Estado Vazio -->
                        <div class="text-center py-12">
                            <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-700 mb-2">
                                @if (request()->has('search') && !empty(request('search')))
                                    Nenhuma etiqueta encontrada
                                @else
                                    Nenhuma etiqueta utilizada
                                @endif
                            </h3>
                            <p class="text-gray-500 mb-6">
                                @if (request()->has('search') && !empty(request('search')))
                                    Não encontramos etiquetas para "{{ request('search') }}"
                                @else
                                    Todas as etiquetas estão disponíveis no momento
                                @endif
                            </p>
                            @can('index-range')
                                <a href="{{ route('tracks.index') }}"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Ver Etiquetas Disponíveis
                                </a>
                            @endcan
                        </div>
                    @endif
                </div>

                <!-- Paginação -->
                @if ($tracks->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
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
                                    <span
                                        class="px-3 py-2 border border-gray-300 rounded-lg text-gray-400 cursor-not-allowed text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 19l-7-7 7-7" />
                                        </svg>
                                    </span>
                                @else
                                    <a href="{{ $tracks->previousPageUrl() }}"
                                        class="px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition-colors text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 19l-7-7 7-7" />
                                        </svg>
                                    </a>
                                @endif

                                {{-- Links de Página --}}
                                @foreach ($tracks->getUrlRange(max(1, $tracks->currentPage() - 2), min($tracks->lastPage(), $tracks->currentPage() + 2)) as $page => $url)
                                    @if ($page == $tracks->currentPage())
                                        <span
                                            class="px-3 py-2 border border-blue-500 bg-blue-50 text-blue-600 font-medium rounded-lg text-sm">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <a href="{{ $url }}"
                                            class="px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition-colors text-sm">
                                            {{ $page }}
                                        </a>
                                    @endif
                                @endforeach

                                {{-- Botão Próximo --}}
                                @if ($tracks->hasMorePages())
                                    <a href="{{ $tracks->nextPageUrl() }}"
                                        class="px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition-colors text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                @else
                                    <span
                                        class="px-3 py-2 border border-gray-300 rounded-lg text-gray-400 cursor-not-allowed text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
