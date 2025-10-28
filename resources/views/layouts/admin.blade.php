<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pré-Postagem MagnoJet</title>

    @vite('resources/css/app.css')

    <style>
        [x-cloak] {
            display: none !important;
        }

        .sidebar-transition {
            transition: transform 0.3s ease-in-out;
        }

        .main-content-transition {
            transition: margin 0.3s ease-in-out;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50">
    <div class="flex h-screen">
        <aside class="hidden lg:flex lg:flex-shrink-0">
            <div class="flex flex-col w-64 bg-white shadow-xl border-r border-gray-200">
                <div class="flex items-center justify-center p-6 border-b border-gray-200">
                    <img src="/magnojetsidebar.png" alt="Logo MagnoJet" class="h-20 w-35">
                </div>

                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                    @can('dashboard')
                        <a href="{{ route('dashboard.index') }}"
                            class="flex items-center px-4 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-colors group">
                            <i class="fas fa-home w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-500"></i>
                            <span class="font-medium">Dashboard</span>
                        </a>
                    @endcan

                    @can('index-range')
                        <div x-data="{ open: false }" class="w-full">
                            <button @click="open = !open"
                                class="flex items-center justify-between w-full px-4 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-colors group cursor-pointer">
                                <div class="flex items-center">
                                    <i class="fas fa-tags w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-500"></i>
                                    <span class="font-medium">Etiquetas</span>
                                </div>
                                <svg :class="{ 'rotate-180': open }"
                                    class="w-4 h-4 transition-transform duration-200 text-gray-400" fill="none"
                                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1">
                                <a href="{{ route('tracks.index') }}"
                                    class="flex items-center px-3 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-colors">
                                    <i class="fas fa-list w-4 h-4 mr-2"></i>
                                    Disponíveis
                                </a>
                                @can('show-range')
                                    <a href="{{ route('tracks.show') }}"
                                        class="flex items-center px-3 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-colors">
                                        <i class="fas fa-check-circle w-4 h-4 mr-2"></i>
                                        Utilizados
                                    </a>
                                @endcan
                                @can('create-range')
                                    <a href="{{ route('tracks.create') }}"
                                        class="flex items-center px-3 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-colors">
                                        <i class="fas fa-plus-circle w-4 h-4 mr-2"></i>
                                        Gerar Etiquetas
                                    </a>
                                @endcan
                            </div>
                        </div>
                    @endcan

                    @can('index-prepostagem')
                        <div x-data="{ open: false }" class="w-full">
                            <button @click="open = !open"
                                class="flex items-center justify-between w-full px-4 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-colors group cursor-pointer">
                                <div class="flex items-center">
                                    <i
                                        class="fas fa-shipping-fast w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-500"></i>
                                    <span class="font-medium">Pré-Postagem</span>
                                </div>
                                <svg :class="{ 'rotate-180': open }"
                                    class="w-4 h-4 transition-transform duration-200 text-gray-400" fill="none"
                                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1">
                                @can('create-prepostagem')
                                    <a href="{{ route('prepostagens.create') }}"
                                        class="flex items-center px-3 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-colors">
                                        <i class="fas fa-plus w-4 h-4 mr-2"></i>
                                        Nova Pré-Postagem
                                    </a>
                                @endcan
                                <a href="{{ route('prepostagens.index') }}"
                                    class="flex items-center px-3 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-colors">
                                    <i class="fas fa-list w-4 h-4 mr-2"></i>
                                    Todas as Pré-Postagens
                                </a>
                                @can('posted-prepostagem')
                                    <a href="{{ route('prepostagens.posted') }}"
                                        class="flex items-center px-3 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-colors">
                                        <i class="fas fa-check w-4 h-4 mr-2"></i>
                                        Postadas
                                    </a>
                                @endcan
                                @can('canceled-prepostagem')
                                    <a href="{{ route('prepostagens.canceled') }}"
                                        class="flex items-center px-3 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-colors">
                                        <i class="fas fa-times w-4 h-4 mr-2"></i>
                                        Canceladas
                                    </a>
                                @endcan
                            </div>
                        </div>
                    @endcan

                    <div class="pt-4">
                        <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                            Cadastros
                        </h3>

                        @can('index-sender')
                            <a href="{{ route('senders.index') }}"
                                class="flex items-center px-4 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-colors group">
                                <i class="fas fa-user-tie w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-500"></i>
                                <span class="font-medium">Remetentes</span>
                            </a>
                        @endcan

                        @can('index-recipient')
                            <a href="{{ route('recipients.index') }}"
                                class="flex items-center px-4 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-colors group">
                                <i class="fas fa-users w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-500"></i>
                                <span class="font-medium">Destinatários</span>
                            </a>
                        @endcan

                        @can('index-packaging')
                            <a href="{{ route('packagings.index') }}"
                                class="flex items-center px-4 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-colors group">
                                <i class="fas fa-box w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-500"></i>
                                <span class="font-medium">Embalagens</span>
                            </a>
                        @endcan
                    </div>

                    <div class="pt-4">
                        @can('index-user')
                            <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                Administração
                            </h3>
                        @endcan

                        @can('index-user')
                            <a href="{{ route('users.index') }}"
                                class="flex items-center px-4 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-colors group">
                                <i class="fas fa-user-cog w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-500"></i>
                                <span class="font-medium">Usuários</span>
                            </a>
                        @endcan

                        @can('index-user-status')
                            <a href="{{ route('user_statuses.index') }}"
                                class="flex items-center px-4 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-colors group">
                                <i class="fas fa-user-clock w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-500"></i>
                                <span class="font-medium">Status Usuários</span>
                            </a>
                        @endcan

                        @can('index-role')
                            <a href="{{ route('roles.index') }}"
                                class="flex items-center px-4 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-colors group">
                                <i class="fas fa-shield-alt w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-500"></i>
                                <span class="font-medium">Papéis</span>
                            </a>
                        @endcan

                        @can('index-permission')
                            <a href="{{ route('permissions.index') }}"
                                class="flex items-center px-4 py-3 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-colors group">
                                <i class="fas fa-key w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-500"></i>
                                <span class="font-medium">Permissões</span>
                            </a>
                        @endcan
                    </div>
                </nav>

                <div class="p-4 border-t border-gray-200">
                    <div class="text-center text-xs text-gray-500">
                        <p>Versão 1.0.0</p>
                        <p class="mt-1">&copy; {{ date('Y') }} MagnoJet</p>
                    </div>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center space-x-4">
                        <button id="toggleSidebar"
                            class="lg:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-colors">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="hidden md:flex items-center space-x-2 text-sm text-gray-500">
                            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                            <span>Sistema Online</span>
                        </div>

                        <div class="relative">
                            <button id="userDropdownButton"
                                class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex items-center space-x-2">
                                    <div
                                        class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-sm font-semibold">
                                        @auth
                                            {{ substr(Auth::user()->name, 0, 1) }}
                                        @endauth
                                    </div>
                                    <div class="hidden md:block text-left">
                                        <div class="text-sm font-medium text-gray-900">
                                            @auth
                                                {{ Auth::user()->name }}
                                            @endauth
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            @auth
                                                {{ Auth::user()->email }}
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                                <svg class="w-4 h-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div id="dropdownContent"
                                class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-200 py-2 hidden z-50">
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-medium text-gray-900">
                                        @auth
                                            {{ Auth::user()->name }}
                                        @endauth
                                    </p>
                                    <p class="text-sm text-gray-500 truncate">
                                        @auth
                                            {{ Auth::user()->email }}
                                        @endauth
                                    </p>
                                </div>

                                <div class="py-1">
                                    @can('show-profile')
                                        <a href="{{ route('profile.show') }}"
                                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                            <i class="fas fa-user-circle w-5 h-5 mr-3 text-gray-400"></i>
                                            Meu Perfil
                                        </a>
                                    @endcan
                                    <a href="{{ route('logout') }}"
                                        class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                        <i class="fas fa-sign-out-alt w-5 h-5 mr-3"></i>
                                        Sair do Sistema
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-auto bg-gray-50">
                <div class="container mx-auto px-6 py-8">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>

    <div id="mobileSidebar" class="fixed inset-0 z-50 lg:hidden hidden">
        <div class="fixed inset-0 bg-black bg-opacity-50" id="sidebarOverlay"></div>
        <div class="fixed inset-y-0 left-0 w-64 bg-white shadow-xl transform transition-transform -translate-x-full"
            id="sidebarMobile">
            <div class="flex flex-col h-full">
                <div class="flex items-center justify-between p-6 border-b border-gray-200">
                    <img src="/magnojetsidebar.png" alt="Logo MagnoJet" class="h-10 w-auto">
                    <button id="closeSidebar"
                        class="p-2 rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition-colors">
                        <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                </div>
            </div>
        </div>
    </div>

    <script>
        const toggleSidebar = document.getElementById('toggleSidebar');
        const closeSidebar = document.getElementById('closeSidebar');
        const mobileSidebar = document.getElementById('mobileSidebar');
        const sidebarMobile = document.getElementById('sidebarMobile');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function openMobileSidebar() {
            mobileSidebar.classList.remove('hidden');
            setTimeout(() => {
                sidebarMobile.classList.remove('-translate-x-full');
            }, 10);
        }

        function closeMobileSidebar() {
            sidebarMobile.classList.add('-translate-x-full');
            setTimeout(() => {
                mobileSidebar.classList.add('hidden');
            }, 300);
        }

        if (toggleSidebar) {
            toggleSidebar.addEventListener('click', openMobileSidebar);
        }

        if (closeSidebar) {
            closeSidebar.addEventListener('click', closeMobileSidebar);
        }

        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', closeMobileSidebar);
        }

        const dropdownButton = document.getElementById('userDropdownButton');
        const dropdownContent = document.getElementById('dropdownContent');

        if (dropdownButton && dropdownContent) {
            dropdownButton.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdownContent.classList.toggle('hidden');
            });

            window.addEventListener('click', function() {
                dropdownContent.classList.add('hidden');
            });
        }

        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                closeMobileSidebar();
            }
        });
    </script>

    @yield('scripts')
</body>

</html>
