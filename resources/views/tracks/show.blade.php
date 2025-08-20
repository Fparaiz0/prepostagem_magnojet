@extends('layouts.admin')

@section('content')

    <x-alert />

    <!-- Wrapper Principal -->
    <div class="content-wrapper">

        <!-- Cabeçalho da Página -->
        <div class="content-header">
            <h2 class="content-title">Range de etiquetas</h2>
            <nav class="breadcrumb">
                <span>Utilizado</span>
            </nav>
        </div>

        <!-- Caixa de Conteúdo Principal -->
        <div class="content-box">

            <!-- Cabeçalho da Caixa -->
            <div class="content-box-header">
                <h3 class="text-gray-700 mb-4 font-bold">Códigos de Rastreamento</h3>

                <!-- Botão: Gerar Etiquetas -->
                <div class="flex space-x-1">
                    @can('index-range')
                        <a href="{{ route('tracks.index') }}">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded cursor-pointer">
                                Disponíveis
                            </button>
                        </a>
                    @endcan
                </div>
            </div>

            <!-- Lista de Códigos -->
            <div class="bg-white rounded-lg p-6">
                <h2 class="text-xl font-bold mb-4">Códigos de Objetos - Utilizado</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 text-gray-800">
                    @forelse ($tracks as $range)
                        <div class="px-2 py-1 border border-blue-200 shadow-sm hover:shadow-md transition duration-200 rounded">
                            {{ $range->object_code }}
                        </div>
                    @empty
                        <p class="col-span-full text-gray-500">Nenhum registro encontrado!</p>
                    @endforelse
                </div>

                <!-- Paginação personalizada com Tailwind -->
                @if ($tracks->hasPages())
                    <div class="mt-6 flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">

                        <!-- Informações de resultados -->
                        <div class="text-sm text-gray-700">
                            Mostrando 
                            <span class="font-medium">{{ $tracks->firstItem() }}</span>
                            a 
                            <span class="font-medium">{{ $tracks->lastItem() }}</span>
                            de 
                            <span class="font-medium">{{ $tracks->total() }}</span>
                            resultados
                        </div>

                        <!-- Navegação -->
                        <div class="flex flex-wrap items-center space-x-1">

                            {{-- Botão Anterior --}}
                            @if ($tracks->onFirstPage())
                                <span class="px-3 py-1 border rounded text-gray-400 cursor-not-allowed">
                                    &laquo; Anterior
                                </span>
                            @else
                                <a href="{{ $tracks->previousPageUrl() }}"
                                   class="px-3 py-1 border rounded bg-white text-gray-700 hover:bg-gray-100">
                                    &laquo; Anterior
                                </a>
                            @endif

                            {{-- Links de Página --}}
                            @foreach ($tracks->getUrlRange(1, $tracks->lastPage()) as $page => $url)
                                @if ($page == $tracks->currentPage())
                                    <span class="px-3 py-1 border rounded bg-blue-500 text-white font-medium">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}"
                                       class="px-3 py-1 border rounded bg-white text-gray-700 hover:bg-gray-100">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            {{-- Botão Próximo --}}
                            @if ($tracks->hasMorePages())
                                <a href="{{ $tracks->nextPageUrl() }}"
                                   class="px-3 py-1 border rounded bg-white text-gray-700 hover:bg-gray-100">
                                    Próximo &raquo;
                                </a>
                            @else
                                <span class="px-3 py-1 border rounded text-gray-400 cursor-not-allowed">
                                    Próximo &raquo;
                                </span>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
