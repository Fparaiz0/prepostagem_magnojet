@extends('layouts.admin')

@section('content')
    <!-- Cabeçalho da Página -->
    <div class="content-header">
        <h2 class="content-title">Remetentes</h2>
        @can('create-sender')
        <a href="{{ route('senders.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Novo Remetente
        </a>
        @endcan
    </div><br>

    <x-alert />

    <!-- Lista de Remetentes -->
    <div class="bg-gray-50 rounded-lg shadow-sm overflow-hidden border border-blue-200">
        <!-- Cabeçalho da Tabela -->
        <div class="grid grid-cols-12 bg-gray-50 px-6 py-3 border-b border-blue-200 font-medium text-gray-500 uppercase text-sm">
            <div class="col-span-4">Nome</div>
            <div class="col-span-3">CNPJ</div>
            <div class="col-span-3">Data de Cadastro</div>
            <div class="col-span-2 text-right">Ações</div>
        </div>

        <!-- Corpo da Lista -->
        @forelse ($senders as $sender)
        <div class="grid grid-cols-12 px-6 py-4 border-b border-blue-200 hover:bg-gray-50 items-center">
            <div class="col-span-4 font-medium text-gray-800">
                {{ $sender->name }}
            </div>
            <div class="col-span-3 text-gray-600 font-mono">
                {{ $sender->cnpj }}
            </div>
            <div class="col-span-3 text-gray-500">
                {{ \Carbon\Carbon::parse($sender->created_at)->format('d/m/Y') }}
            </div>
            <div class="col-span-2 flex justify-end space-x-2">
                @can('show-sender')
                <a href="{{ route('senders.show', ['sender' => $sender->id]) }}" 
                   class="p-2 text-blue-600 hover:bg-blue-50 rounded-full transition-colors"
                   title="Visualizar">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </a>
                @endcan

                @can('edit-sender')
                <a href="{{ route('senders.edit', ['sender' => $sender->id]) }}" 
                   class="p-2 text-green-600 hover:bg-green-50 rounded-full transition-colors"
                   title="Editar">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </a>
                @endcan

                @can('destroy-sender')
                <form action="{{ route('senders.destroy', ['sender' => $sender->id]) }}" method="POST" class="inline">
                    @csrf
                    @method('delete')
                    <button type="submit" 
                            onclick="return confirm('Tem certeza que deseja apagar este registro?')"
                            class="p-2 text-red-600 hover:bg-red-50 rounded-full transition-colors cursor-pointer"
                            title="Apagar">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </form>
                @endcan
            </div>
        </div>
        @empty
        <div class="px-6 py-8 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="mt-2 text-lg font-medium text-gray-700">Nenhum remetente cadastrado</h3>
            <p class="mt-1 text-gray-500">Comece cadastrando um novo remetente</p>
        </div>
        @endforelse
    </div>

    <!-- Paginação -->
    @if($senders->hasPages())
    <div class="mt-4 px-4 py-3 flex flex-col sm:flex-row items-center justify-between bg-white rounded-lg shadow-sm border border-blue-200">
        <div class="text-sm text-gray-600 mb-2 sm:mb-0">
            Mostrando <span class="font-medium">{{ $senders->firstItem() }}</span> a <span class="font-medium">{{ $senders->lastItem() }}</span> de <span class="font-medium">{{ $senders->total() }}</span> resultados
        </div>
        <div class="flex items-center space-x-1">
            @if ($senders->onFirstPage())
                <span class="px-3 py-1 rounded border border-gray-200 text-gray-400 cursor-not-allowed">
                    &laquo;
                </span>
                <span class="px-3 py-1 rounded border border-gray-200 text-gray-400 cursor-not-allowed">
                    &lsaquo;
                </span>
            @else
                <a href="{{ $senders->url(1) }}" class="px-3 py-1 rounded border border-gray-200 hover:bg-gray-50 transition-colors">
                    &laquo;
                </a>
                <a href="{{ $senders->previousPageUrl() }}" class="px-3 py-1 rounded border border-gray-200 hover:bg-gray-50 transition-colors">
                    &lsaquo;
                </a>
            @endif

            @foreach ($senders->getUrlRange(max(1, $senders->currentPage() - 2), min($senders->lastPage(), $senders->currentPage() + 2)) as $page => $url)
                @if ($page == $senders->currentPage())
                    <span class="px-3 py-1 rounded border border-blue-200 bg-blue-50 text-blue-600 font-medium">
                        {{ $page }}
                    </span>
                @else
                    <a href="{{ $url }}" class="px-3 py-1 rounded border border-gray-200 hover:bg-gray-50 transition-colors">
                        {{ $page }}
                    </a>
                @endif
            @endforeach

            @if ($senders->hasMorePages())
                <a href="{{ $senders->nextPageUrl() }}" class="px-3 py-1 rounded border border-gray-200 hover:bg-gray-50 transition-colors">
                    &rsaquo;
                </a>
                <a href="{{ $senders->url($senders->lastPage()) }}" class="px-3 py-1 rounded border border-gray-200 hover:bg-gray-50 transition-colors">
                    &raquo;
                </a>
            @else
                <span class="px-3 py-1 rounded border border-gray-200 text-gray-400 cursor-not-allowed">
                    &rsaquo;
                </span>
                <span class="px-3 py-1 rounded border border-gray-200 text-gray-400 cursor-not-allowed">
                    &raquo;
                </span>
            @endif
        </div>
    </div>
    @endif
@endsection