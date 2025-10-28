@extends('layouts.admin')

@section('content')
    <div class="content-header">
        <h2 class="content-title">Embalagens</h2>
        @can('create-packaging')
            <a href="{{ route('packagings.create') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Nova Embalagem
            </a>
        @endcan
    </div>

    <div class="mt-6">
        <x-alert />
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden mt-6 border border-blue-200">
        @if ($packagings->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-blue-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-blue-200">
                        @foreach ($packagings as $packaging)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $packaging->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        @can('show-packaging')
                                            <a href="{{ route('packagings.show', $packaging->id) }}"
                                                class="text-indigo-600 hover:text-indigo-900 px-2 py-1 rounded hover:bg-indigo-50 transition-colors"
                                                title="Visualizar">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                        @endcan

                                        @can('edit-packaging')
                                            <a href="{{ route('packagings.edit', $packaging->id) }}"
                                                class="text-blue-600 hover:text-blue-900 px-2 py-1 rounded hover:bg-blue-50 transition-colors"
                                                title="Editar">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                        @endcan

                                        @can('destroy-packaging')
                                            <form action="{{ route('packagings.destroy', $packaging->id) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('delete')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900 px-2 py-1 rounded hover:bg-red-50 transition-colors cursor-pointer"
                                                    onclick="return confirm('Tem certeza que deseja apagar esta embalagem?')"
                                                    title="Apagar">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($packagings->hasPages())
                <div
                    class="px-6 py-4 border-t border-blue-200 bg-gray-50 flex flex-col sm:flex-row items-center justify-between">
                    <div class="text-sm text-gray-600 mb-2 sm:mb-0">
                        Mostrando <span class="font-medium">{{ $packagings->firstItem() }}</span> a <span
                            class="font-medium">{{ $packagings->lastItem() }}</span> de <span
                            class="font-medium">{{ $packagings->total() }}</span> resultados
                    </div>
                    <div class="flex items-center space-x-1">
                        @if ($packagings->onFirstPage())
                            <span class="px-3 py-1 rounded border border-gray-200 text-gray-400 cursor-not-allowed">
                                &laquo;
                            </span>
                            <span class="px-3 py-1 rounded border border-gray-200 text-gray-400 cursor-not-allowed">
                                &lsaquo;
                            </span>
                        @else
                            <a href="{{ $packagings->url(1) }}"
                                class="px-3 py-1 rounded border border-gray-200 hover:bg-gray-50 transition-colors">
                                &laquo;
                            </a>
                            <a href="{{ $packagings->previousPageUrl() }}"
                                class="px-3 py-1 rounded border border-gray-200 hover:bg-gray-50 transition-colors">
                                &lsaquo;
                            </a>
                        @endif

                        @foreach ($packagings->getUrlRange(max(1, $packagings->currentPage() - 2), min($packagings->lastPage(), $packagings->currentPage() + 2)) as $page => $url)
                            @if ($page == $packagings->currentPage())
                                <span
                                    class="px-3 py-1 rounded border border-indigo-200 bg-indigo-50 text-indigo-600 font-medium">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}"
                                    class="px-3 py-1 rounded border border-gray-200 hover:bg-gray-50 transition-colors">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        @if ($packagings->hasMorePages())
                            <a href="{{ $packagings->nextPageUrl() }}"
                                class="px-3 py-1 rounded border border-gray-200 hover:bg-gray-50 transition-colors">
                                &rsaquo;
                            </a>
                            <a href="{{ $packagings->url($packagings->lastPage()) }}"
                                class="px-3 py-1 rounded border border-gray-200 hover:bg-gray-50 transition-colors">
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
        @else
            <div class="px-6 py-12 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">Nenhuma embalagem encontrada</h3>
                <p class="mt-1 text-sm text-gray-500">Cadastre sua primeira embalagem para começar</p>
                @can('create-packaging')
                    <div class="mt-6">
                        <a href="{{ route('packagings.create') }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cadastrar Embalagem
                        </a>
                    </div>
                @endcan
            </div>
        @endif
    </div>
@endsection
