<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pré-Postagem</title>

    @vite('resources/css/app.css')

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="bg-dashboard">

    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">

            <!-- Botão menu -->
            <button id="toggleSidebar" class="menu-button">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Usuário e Dropdown -->
            <div class="user-container">
                <div class="relative">
                    <button id="userDropdownButton" class="dropdown-button">
                        @auth
                            {{ Auth::user()->name }}
                        @endauth
                        <svg class="ml-2 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                  clip-rule="evenodd" />
                        </svg>
                    </button>

                    <!-- Dropdown do usuário -->
                    <div id="dropdownContent" class="dropdown-content hidden">
                        @can('show-profile')
                            <a href="{{ route('profile.show') }}" class="dropdown-item">Perfil</a>
                        @endcan
                        <a href="{{ route('logout') }}" class="dropdown-item">Sair</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar">
            <div class="sidebar-container">

                <!-- Botão fechar -->
                <button id="closeSidebar" class="sidebar-close-button">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Título -->
                <div class="sidebar-header">
                    <img src="/magnojetsidebar.png" alt="Logo" class="w-40 h-auto flex justify-center">
                </div>

                <!-- Menu -->
                <nav class="sidebar-nav">

                    @can('dashboard')
                        <a href="{{ route('dashboard.index') }}" class="sidebar-link">Página inicial</a>
                    @endcan

                    <!-- Etiquetas -->
                    @can('index-range')
                        <div x-data="{ open: false }" class="w-full">
                            <button @click="open = !open" class="sidebar-link w-full flex justify-between cursor-pointer items-center">
                                Etiquetas
                                <svg :class="{ 'rotate-180': open }"
                                     class="w-4 h-4 transition-transform duration-200"
                                     fill="none" stroke="currentColor" stroke-width="2"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div x-show="open" x-collapse x-cloak class="ml-4 mt-1 space-y-1">
                                <a href="{{ route('tracks.index') }}" class="sidebar-link">Etiquetas - Disponíveis</a>
                                @can('show-range')
                                    <a href="{{ route('tracks.show') }}" class="sidebar-link">Etiquetas - Utilizados</a>
                                @endcan
                                @can('create-range')
                                    <a href="{{ route('tracks.create') }}" class="sidebar-link">Gerar Etiquetas</a>
                                @endcan
                            </div>
                        </div>
                    @endcan

                    <!-- Pré-Postagem -->
                    @can('index-prepostagem')
                        <div x-data="{ open: false }" class="w-full">
                            <button @click="open = !open" class="sidebar-link w-full cursor-pointer flex justify-between items-center">
                                Pré-Postagem
                                <svg :class="{ 'rotate-180': open }"
                                     class="w-4 h-4 transition-transform duration-200"
                                     fill="none" stroke="currentColor" stroke-width="2"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div x-show="open" x-collapse x-cloak class="ml-4 mt-1 space-y-1">
                                @can('create-prepostagem')
                                    <a href="{{ route('prepostagens.create') }}" class="sidebar-link">Cadastrar</a>
                                @endcan
                                <a href="{{ route('prepostagens.index') }}" class="sidebar-link">Listar</a>
                                @can('posted-prepostagem')
                                    <a href="{{ route('prepostagens.posted') }}" class="sidebar-link">Postadas</a>
                                @endcan
                                @can('canceled-prepostagem')
                                    <a href="{{ route('prepostagens.canceled') }}" class="sidebar-link">Canceladas</a>
                                @endcan
                            </div>
                        </div>
                    @endcan

                    <!-- Itens gerais -->
                    @can('index-sender')
                        <a href="{{ route('senders.index') }}" class="sidebar-link">Remetentes</a>
                    @endcan

                    @can('index-recipient')
                        <a href="{{ route('recipients.index') }}" class="sidebar-link">Destinatários</a>
                    @endcan

                    @can('index-packaging')
                        <a href="{{ route('packagings.index') }}" class="sidebar-link">Embalagens</a>
                    @endcan

                    @can('index-user')
                        <a href="{{ route('users.index') }}" class="sidebar-link">Usuários</a>
                    @endcan

                    @can('index-user-status')
                        <a href="{{ route('user_statuses.index') }}" class="sidebar-link">Status Usuários</a>
                    @endcan

                    @can('index-role')
                        <a href="{{ route('roles.index') }}" class="sidebar-link">Papéis</a>
                    @endcan

                    @can('index-permission')
                        <a href="{{ route('permissions.index') }}" class="sidebar-link">Permissões</a>
                    @endcan

                </nav>
            </div>
        </aside>
    </div>

    <!-- Conteúdo Principal -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Dropdown User Script -->
    <script>
        const dropdownButton = document.getElementById('userDropdownButton');
        const dropdownContent = document.getElementById('dropdownContent');

        dropdownButton.addEventListener('click', function () {
            dropdownContent.classList.toggle('hidden');
        });

        window.addEventListener('click', function (event) {
            if (!dropdownButton.contains(event.target) && !dropdownContent.contains(event.target)) {
                dropdownContent.classList.add('hidden');
            }
        });
    </script>

    <!-- Sidebar Toggle Script -->
    <script>
        document.getElementById('toggleSidebar').addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('sidebar-open');
        });

        document.getElementById('closeSidebar').addEventListener('click', function () {
            document.getElementById('sidebar').classList.remove('sidebar-open');
        });
    </script>

</body>

</html>
