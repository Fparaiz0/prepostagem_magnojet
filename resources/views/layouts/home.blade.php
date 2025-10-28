<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pré-Postagem</title>

    @vite('resources/css/app.css')
    @stack('styles')
</head>

<body class="min-h-screen bg-gray-100 text-gray-800 flex flex-col items-center justify-center p-6">

    <div class="mb-4">
        <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-semibold">Acessar Login</a>
    </div>

    <div class="w-full max-w-xl">
        @yield('content')
    </div>

    @stack('scripts')
</body>

</html>
