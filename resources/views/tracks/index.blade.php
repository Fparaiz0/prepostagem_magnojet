@extends('layouts.admin')

@section('page-title', 'Etiquetas Disponíveis')
@section('breadcrumb')
    <li>
        <span class="text-gray-500">/</span>
        <span class="text-gray-700 ml-2">Etiquetas</span>
        <span class="text-gray-500">/</span>
        <span class="text-gray-700 ml-2">Disponíveis</span>
    </li>
@endsection

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="mb-4 sm:mb-0">
                        <h1 class="text-2xl font-bold text-gray-900">Etiquetas</h1>
                        <p class="text-sm text-gray-600 mt-1">Códigos de rastreamento disponíveis</p>
                    </div>

                    <nav class="flex items-center text-sm text-gray-500">
                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-medium">
                            Disponível
                        </span>
                    </nav>
                </div>
            </div>

            <div class="mb-6">
                <x-alert />
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

                <div class="bg-linear-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center mb-4 sm:mb-0">
                            <div class="p-2 bg-blue-100 rounded-lg mr-3">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900">Códigos de Rastreamento</h2>
                                <p class="text-sm text-gray-600 mt-1">Etiquetas disponíveis para uso</p>
                            </div>
                        </div>

                        @can('create-range')
                            <a href="{{ route('tracks.create') }}"
                                class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-sm hover:shadow-md">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Gerar Etiquetas
                            </a>
                        @endcan
                    </div>
                </div>

                <div class="px-6 py-4 bg-white border-b border-gray-200">
                    <div class="flex flex-wrap gap-3">
                        @can('show-range')
                            <a href="{{ route('tracks.show') }}"
                                class="inline-flex items-center px-4 py-2 bg-red-50 border border-red-200 text-red-700 font-medium rounded-lg hover:bg-red-100 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Etiquetas Utilizadas
                            </a>
                        @endcan
                    </div>
                </div>

                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Etiquetas Disponíveis</h3>
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">
                            {{ $tracks->total() }} etiquetas
                        </span>
                    </div>

                    @if ($tracks->isEmpty())
                        <div class="text-center py-12">
                            <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h4 class="text-lg font-medium text-gray-900 mb-2">Nenhum código disponível</h4>
                            <p class="text-gray-500 mb-6">Gere novos códigos de rastreamento para começar.</p>
                            @can('create-range')
                                <a href="{{ route('tracks.create') }}"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Gerar Primeiras Etiquetas
                                </a>
                            @endcan
                        </div>
                    @else
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3">
                            @foreach ($tracks as $index => $range)
                                <div class="relative group">
                                    <div
                                        class="absolute -top-2 -left-2 w-6 h-6 flex items-center justify-center bg-blue-500 text-white text-xs font-bold rounded-full shadow-sm z-10">
                                        {{ ($tracks->currentPage() - 1) * $tracks->perPage() + $index + 1 }}
                                    </div>

                                    <div class="track-code p-3 border-2 rounded-xl font-mono text-sm transition-all duration-200 cursor-pointer 
                                        {{ $range->selected
                                            ? 'text-red-800 bg-red-50 border-red-200 hover:bg-red-100 hover:border-red-300 shadow-sm'
                                            : 'text-blue-800 bg-blue-50 border-blue-200 hover:bg-blue-100 hover:border-blue-300 shadow-sm hover:shadow-md' }} group-hover:scale-105"
                                        data-id="{{ $range->id }}"
                                        title="{{ $range->selected ? 'Clique para remover NF' : 'Clique para vincular NF' }}">

                                        <div class="text-center font-semibold tracking-wide">
                                            {{ $range->object_code }}
                                        </div>

                                        @if ($range->invoice)
                                            <div class="text-xs text-gray-600 mt-2 p-1 bg-white rounded border text-center">
                                                NF: {{ $range->invoice }}
                                            </div>
                                        @else
                                            <div class="text-xs text-gray-400 mt-2 text-center">
                                                Disponível
                                            </div>
                                        @endif

                                        <div class="absolute bottom-1 right-1">
                                            @if ($range->selected)
                                                <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                                            @else
                                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

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

    <div id="invoiceModal" class="fixed inset-0 hidden items-center justify-center z-50 bg-black/40 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-xl w-96 mx-4 transform transition-all duration-300 scale-95 opacity-0"
            id="modalContent">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Vincular Nota Fiscal</h2>
            </div>

            <div class="p-6">
                <input type="text" id="invoiceInput"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                    placeholder="Digite o número da nota fiscal">

                <div class="flex justify-end space-x-3 mt-6">
                    <button id="cancelInvoice"
                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Cancelar
                    </button>
                    <button id="saveInvoice"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Salvar
                    </button>
                </div>
            </div>
        </div>
    </div>

    @vite(['resources/js/tracks/index.js'])
@endsection
