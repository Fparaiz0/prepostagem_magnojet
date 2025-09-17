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
                        @foreach ($tracks as $index => $range)
                            <div class="relative">
                                <div
                                    class="absolute -top-2 -left-2 w-6 h-6 flex items-center justify-center bg-blue-200 text-black text-xs font-bold rounded-full">
                                    {{ ($tracks->currentPage() - 1) * $tracks->perPage() + $index + 1 }}
                                </div>
                                <div class="track-code px-3 py-2 border rounded-md font-mono text-sm transition-colors cursor-pointer 
                                    {{ $range->selected ? 'text-red-800 bg-red-50 border-red-100 hover:bg-red-100' : 'text-blue-800 bg-blue-50 border-blue-100 hover:bg-blue-100' }}"
                                    data-id="{{ $range->id }}">

                                    {{-- Exibe código --}}
                                    <div>{{ $range->object_code }}</div>

                                    {{-- Exibe NF embaixo --}}
                                    @if ($range->invoice)
                                        <div class="text-xs text-gray-600 mt-1">NF: {{ $range->invoice }}</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Paginação Estilizada -->
            @if ($tracks->hasPages())
                <div class="mt-8 border-t border-gray-200 pt-6">
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

    <!-- Modal com fundo blur -->
    <div id="invoiceModal" class="fixed inset-0 hidden items-center justify-center z-50 bg-black/40 backdrop-blur-sm">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Vincular Nota Fiscal</h2>
            <input type="text" id="invoiceInput"
                class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-blue-300"
                placeholder="Digite a nota fiscal">
            <div class="flex justify-end mt-4 space-x-2">
                <button id="cancelInvoice" class="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300">Cancelar</button>
                <button id="saveInvoice"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Salvar</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let selectedId = null;
            const modal = document.getElementById("invoiceModal");
            const input = document.getElementById("invoiceInput");

            document.querySelectorAll(".track-code").forEach(function(el) {
                el.addEventListener("click", function() {
                    const id = el.getAttribute("data-id");

                    if (el.classList.contains("text-blue-800")) {
                        // Abrir modal para digitar NF
                        selectedId = id;
                        input.value = "";
                        modal.classList.remove("hidden");
                        modal.classList.add("flex");
                        input.focus();
                    } else {
                        // Já estava selecionado → desmarcar
                        if (confirm("Tem certeza que deseja remover a NF desta etiqueta?")) {
                            toggleInvoice(id, null, el);
                        }
                    }
                });
            });

            document.getElementById("cancelInvoice").addEventListener("click", function() {
                modal.classList.add("hidden");
                modal.classList.remove("flex");
            });

            document.getElementById("saveInvoice").addEventListener("click", function() {
                const invoice = input.value.trim();
                if (!invoice) {
                    alert("Digite a nota fiscal.");
                    return;
                }

                // 1. Checar se já existe NF igual em outro elemento
                const exists = Array.from(document.querySelectorAll(".track-code"))
                    .some(el => el.querySelector(".text-xs")?.innerText === `NF: ${invoice}`);

                const el = document.querySelector(`.track-code[data-id='${selectedId}']`);
                toggleInvoice(selectedId, invoice, el);

                modal.classList.add("hidden");
                modal.classList.remove("flex");
            });

            function toggleInvoice(id, invoice, el) {
                fetch(`/range/${id}/toggle-invoice`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute(
                                "content")
                        },
                        body: JSON.stringify({
                            invoice: invoice
                        })
                    })
                    .then(res => res.json())
                    .then(response => {
                        if (response.success) {
                            if (response.data.selected === 1) {
                                el.classList.remove("text-blue-800", "bg-blue-50", "border-blue-100",
                                    "hover:bg-blue-100");
                                el.classList.add("text-red-800", "bg-red-50", "border-red-100",
                                    "hover:bg-red-100");

                                // Exibir NF embaixo
                                if (invoice) {
                                    el.innerHTML =
                                        `<div>${response.data.object_code}</div><div class="text-xs text-gray-600 mt-1">NF: ${invoice}</div>`;
                                }
                            } else {
                                el.classList.remove("text-red-800", "bg-red-50", "border-red-100",
                                    "hover:bg-red-100");
                                el.classList.add("text-blue-800", "bg-blue-50", "border-blue-100",
                                    "hover:bg-blue-100");

                                // Voltar só para o código
                                el.innerHTML = `<div>${response.data.object_code}</div>`;
                            }
                        } else {
                            alert(response.message || "Erro ao atualizar.");
                        }
                    })
                    .catch(() => alert("Erro de comunicação com o servidor."));
            }
        });
    </script>

@endsection
