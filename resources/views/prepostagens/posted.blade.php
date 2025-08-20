@extends('layouts.admin')

@section('content')
    <!-- Cabeçalho da Página -->
        <div class="content-header">
            <h2 class="content-title">Pré-Postagem</h2>
            <nav class="breadcrumb">
                <span>Postadas</span>
            </nav>
        </div><br>
            <div class="flex space-x-4">
                @can('index-prepostagem')
                    <a href="{{ route('prepostagens.index') }}" 
                       class="px-4 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition duration-200 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7l9 5 9-5M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                        Pré-Postadas
                    </a>
                @endcan
                @can('canceled-prepostagem')
                    <a href="{{ route('prepostagens.canceled') }}" 
                       class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition duration-200 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636a9 9 0 11-12.728 12.728 9 9 0 0112.728-12.728zM6.343 17.657l11.314-11.314" />
                        </svg>
                        Canceladas
                    </a>
                @endcan
            </div>
        </div>
    </div>

    <!-- Alert -->
    <div class="mt-4">
        <x-alert />
    </div>

    <!-- Lista de Pré-Postagens -->
    <div class="space-y-4">
        @forelse ($prepostagens as $prepostagem)
            <div class="p-6 border border-green-300 rounded-lg bg-white shadow-sm hover:shadow-md transition duration-200">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                    <div>
                        <p class="text-sm font-medium text-blue-500">Destinatário</p>
                        <p class="text-black-800 font-semibold">{{ $prepostagem->name_recipient }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-blue-500">Data</p>
                        <p class="text-black-800 font-semibold">{{ \Carbon\Carbon::parse($prepostagem->created_at)->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-blue-500">Código</p>
                        <p class="text-black-600 font-semibold">{{ $prepostagem->object_code }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-blue-500">Situação</p>
                        <span class="px-3 py-1 rounded-full text-xs font-medium 
                            @if($prepostagem->situation == 1) bg-blue-200 text-blue-800 
                            @elseif($prepostagem->situation == 2) bg-red-200 text-red-800 
                            @elseif($prepostagem->situation == 3) bg-green-300 text-green-800 
                            @else bg-gray-100 text-gray-800 @endif">
                            {{
                                $prepostagem->situation == 1 ? 'Pré-Postado' : 
                                ($prepostagem->situation == 2 ? 'Cancelado' : 
                                ($prepostagem->situation == 3 ? 'Postado' : 'Desconhecida'))
                            }}
                        </span>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 border-t pt-4 mt-4">
                    @can('show-prepostagem')
                        <a href="{{ route('prepostagens.show', ['prepostagem' => $prepostagem->id]) }}" 
                           class="flex items-center px-4 py-2 border border-green-300 rounded-lg text-green-700 hover:bg-green-50 transition duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Visualizar
                        </a>
                    @endcan
                </div>
            </div>
        @empty
            <div class="p-8 text-center bg-white rounded-lg shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-700">Nenhum registro encontrado</h3>
                <p class="mt-1 text-gray-500">Não há pré-postagens cadastradas no momento.</p>
            </div>
        @endforelse
    </div>

    <!-- Paginação Estilizada -->
    @if($prepostagens->hasPages())
        <div class="mt-8 px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6 bg-white rounded-b-lg shadow-sm">
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
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
                            <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-300 cursor-not-allowed">
                                <span class="sr-only">Anterior</span>
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        @else
                            <a href="{{ $prepostagens->previousPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Anterior</span>
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        @endif

                        <!-- Pagination Elements -->
                        @foreach ($prepostagens->getUrlRange(1, $prepostagens->lastPage()) as $page => $url)
                            @if ($page == $prepostagens->currentPage())
                                <span aria-current="page" class="z-10 bg-blue-50 border-blue-500 text-blue-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
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
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        @else
                            <span class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-300 cursor-not-allowed">
                                <span class="sr-only">Próximo</span>
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        @endif
                    </nav>
                </div>
            </div>
        </div>
    @endif
@endsection