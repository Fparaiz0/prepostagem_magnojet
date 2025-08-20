@extends('layouts.admin')

@section('content')

<!-- Cabeçalho da Página -->
<div class="content-header">
    <h2 class="content-title">Etiquetas</h2>

    <div class="flex flex-wrap gap-3">
        <nav class="mt-2 md:mt-0">
            <ol class="flex items-center space-x-2 text-sm">
                <li><span class="text-gray-500">Disponível</span></li>
            </ol>
        </nav>
    </div>
</div>

<!-- Alert -->
<div class="mt-4">
    <x-alert />
</div>

<!-- Main Content Box -->
<div class="content-box">

    <!-- Box Header with Actions -->
    <div class="content-box-header">
        <div class="flex items-center justify-between w-full">
            <h2 class="text-xl font-semibold text-gray-800">Códigos de Rastreamento</h2>

            @can('create-range')
                <a href="{{ route('tracks.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Gerar etiquetas
                </a>
            @endcan
        </div>
    </div>

    <!-- Tracking Codes List -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Códigos Disponíveis</h3>

            @if ($tracks->isEmpty())
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h4 class="mt-2 text-sm font-medium text-gray-900">Nenhum código disponível</h4>
                    <p class="mt-1 text-sm text-gray-500">Gere novos códigos de rastreamento para começar.</p>
                </div>
            @else
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
                    @foreach ($tracks as $range)
                        <div
                            class="px-3 py-2 bg-blue-50 border border-blue-100 rounded-md text-blue-800 font-mono text-sm hover:bg-blue-100 transition-colors cursor-default">
                            {{ $range->object_code }}
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if ($tracks->hasPages())
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
                    <!-- Results Info -->
                    <div class="text-sm text-gray-600">
                        Mostrando
                        <span class="font-medium">{{ $tracks->firstItem() }}</span>
                        a
                        <span class="font-medium">{{ $tracks->lastItem() }}</span>
                        de
                        <span class="font-medium">{{ $tracks->total() }}</span>
                        resultados
                    </div>

                    <!-- Navigation -->
                    <nav class="flex items-center space-x-1">
                        {{-- Previous Button --}}
                        @if ($tracks->onFirstPage())
                            <span class="px-3 py-1 border rounded-md text-gray-400 cursor-not-allowed">
                                <span class="sr-only">Anterior</span>
                                &laquo;
                            </span>
                        @else
                            <a href="{{ $tracks->previousPageUrl() }}"
                               class="px-3 py-1 border rounded-md bg-white text-gray-700 hover:bg-gray-50 transition-colors">
                                <span class="sr-only">Anterior</span>
                                &laquo;
                            </a>
                        @endif

                        {{-- Page Numbers --}}
                        @foreach ($tracks->getUrlRange(1, $tracks->lastPage()) as $page => $url)
                            @if ($page == $tracks->currentPage())
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
                        @if ($tracks->hasMorePages())
                            <a href="{{ $tracks->nextPageUrl() }}"
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
    </div>
</div>

@endsection
