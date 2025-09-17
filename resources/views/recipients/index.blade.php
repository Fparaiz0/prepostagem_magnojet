@extends('layouts.admin')

@section('content')
    <!-- Cabeçalho da Página -->
    <div class="content-header">
        <h2 class="content-title">Destinatários</h2>
        @can('create-recipient')
            <a href="{{ route('recipients.create') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Novo Destinatário
            </a>
        @endcan
    </div>

    <div class="mt-6">
        <x-alert />
    </div>

    <!-- Formulário de Pesquisa Estilizado com Tailwind -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Pesquisar Destinatários</h3>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>

        <form action="{{ route('recipients.index') }}"
            class="space-y-4 md:space-y-0 md:grid md:grid-cols-12 md:gap-6 md:items-end">
            <div class="md:col-span-8">
                <label for="nome" class="block text-sm font-medium text-gray-700 mb-1">Nome do Destinatário</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <input type="text" name="nome" id="nome" value="{{ $name }}"
                        placeholder="Digite o nome para pesquisar..."
                        class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" />
                </div>
            </div>

            <div class="md:col-span-4 flex space-x-3">
                <button type="submit"
                    class="flex-1 px-4 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Pesquisar
                </button>
                <a href="{{ route('recipients.index') }}"
                    class="px-4 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Limpar
                </a>
            </div>
        </form>
    </div>

    <!-- Lista de Destinatários -->
    <div class="bg-gray-50 rounded-lg shadow-sm overflow-hidden border border-blue-200">
        <!-- Cabeçalho da Tabela -->
        <div class="grid grid-cols-12 divide-x divide-blue-200 border-b border-blue-200 bg-blue-50">
            <div class="col-span-4 px-6 py-4 text-center font-semibold text-blue-800">Nome</div>
            <div class="col-span-3 px-6 py-4 text-center font-semibold text-blue-800">Cidade - UF</div>
            <div class="col-span-3 px-6 py-4 text-center font-semibold text-blue-800">Data de Cadastro</div>
            <div class="col-span-2 px-6 py-4 text-center font-semibold text-blue-800">Ações</div>
        </div>

        <!-- Corpo da Lista -->
        @forelse ($recipients as $recipient)
            <div
                class="grid grid-cols-12 divide-x divide-blue-200 border-b border-blue-200 hover:bg-white transition-colors">
                <div class="col-span-4 font-medium px-6 py-4 text-center text-gray-800">
                    {{ $recipient->name }}
                </div>
                <div class="col-span-3 px-6 py-4 text-center text-gray-600">
                    {{ $recipient->city }} - {{ $recipient->uf }}
                </div>
                <div class="col-span-3 px-6 py-4 text-center text-gray-500">
                    {{ \Carbon\Carbon::parse($recipient->created_at)->format('d/m/Y') }}
                </div>
                <div class="col-span-2 flex px-6 py-4 text-center justify-center space-x-2">
                    @can('show-recipient')
                        <a href="{{ route('recipients.show', $recipient->id) }}"
                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-full transition-colors" title="Visualizar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </a>
                    @endcan

                    @can('edit-recipient')
                        <a href="{{ route('recipients.edit', $recipient->id) }}"
                            class="p-2 text-green-600 hover:bg-green-50 rounded-full transition-colors" title="Editar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>
                    @endcan

                    @can('destroy-recipient')
                        <form action="{{ route('recipients.destroy', $recipient->id) }}" method="POST" class="inline">
                            @csrf
                            @method('delete')
                            <button type="submit" onclick="return confirm('Tem certeza que deseja apagar este registro?')"
                                class="p-2 text-red-600 hover:bg-red-50 rounded-full transition-colors cursor-pointer"
                                title="Apagar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    @endcan
                </div>
            </div>
        @empty
            <div class="px-6 py-12 text-center bg-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Nenhum destinatário encontrado</h3>
                <p class="text-gray-500 mb-6">Tente ajustar os termos da pesquisa ou cadastrar um novo destinatário.</p>
                @can('create-recipient')
                    <a href="{{ route('recipients.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Cadastrar Destinatário
                    </a>
                @endcan
            </div>
        @endforelse
    </div>

    <!-- Paginação Estilizada -->
    @if ($recipients->hasPages())
        <div
            class="mt-6 px-4 py-3 flex flex-col sm:flex-row items-center justify-between bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="text-sm text-gray-600 mb-4 sm:mb-0">
                Mostrando <span class="font-medium">{{ $recipients->firstItem() }}</span> a <span
                    class="font-medium">{{ $recipients->lastItem() }}</span> de <span
                    class="font-medium">{{ $recipients->total() }}</span> resultados
            </div>
            <div class="flex items-center space-x-1">
                @if ($recipients->onFirstPage())
                    <span class="px-3 py-2 rounded-lg border border-gray-300 text-gray-400 cursor-not-allowed">
                        &laquo;
                    </span>
                    <span class="px-3 py-2 rounded-lg border border-gray-300 text-gray-400 cursor-not-allowed">
                        &lsaquo;
                    </span>
                @else
                    <a href="{{ $recipients->url(1) }}"
                        class="px-3 py-2 rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors">
                        &laquo;
                    </a>
                    <a href="{{ $recipients->previousPageUrl() }}"
                        class="px-3 py-2 rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors">
                        &lsaquo;
                    </a>
                @endif

                @foreach ($recipients->getUrlRange(max(1, $recipients->currentPage() - 2), min($recipients->lastPage(), $recipients->currentPage() + 2)) as $page => $url)
                    @if ($page == $recipients->currentPage())
                        <span class="px-3 py-2 rounded-lg border border-blue-500 bg-blue-50 text-blue-600 font-medium">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}"
                            class="px-3 py-2 rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                @if ($recipients->hasMorePages())
                    <a href="{{ $recipients->nextPageUrl() }}"
                        class="px-3 py-2 rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors">
                        &rsaquo;
                    </a>
                    <a href="{{ $recipients->url($recipients->lastPage()) }}"
                        class="px-3 py-2 rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors">
                        &raquo;
                    </a>
                @else
                    <span class="px-3 py-2 rounded-lg border border-gray-300 text-gray-400 cursor-not-allowed">
                        &rsaquo;
                    </span>
                    <span class="px-3 py-2 rounded-lg border border-gray-300 text-gray-400 cursor-not-allowed">
                        &raquo;
                    </span>
                @endif
            </div>
        </div>
    @endif
@endsection
