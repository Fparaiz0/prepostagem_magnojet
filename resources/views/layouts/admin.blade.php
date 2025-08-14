<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pré-Postagem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    
    @can('dashboard')
        <a href="{{ route('dashboard.index') }}">Dashboard</a><br>
    @endcan

    @can('index-range')
        <a href="{{ route('tracks.index') }}">Range de Etiquetas</a><br>
    @endcan

    @can('index-prepostagem')
        <a href="{{ route('prepostagens.index') }}">Pré-Postagem</a><br>
    @endcan

    @can('index-sender')
        <a href="{{ route('senders.index') }}">Remetentes</a><br>
    @endcan

    @can('index-recipient')
        <a href="{{ route('recipients.index') }}">Destinatários</a><br>
    @endcan 

    @can('index-packaging')
        <a href="{{ route('packagings.index') }}">Embalagens</a><br>
    @endcan

    @can('index-user')
        <a href="{{ route('users.index') }}">Usuários</a><br>
    @endcan

    @can('index-user-status')
        <a href="{{ route('user_statuses.index') }}">Status Usuários</a><br>
    @endcan

    @can('index-role')
        <a href="{{ route('roles.index') }}">Papéis</a><br>
    @endcan

    @can('index-permission')
        <a href="{{ route('permissions.index') }}">Permissões</a><br>
    @endcan

    @can('show-profile')
        <a href="{{ route('profile.show') }}">Perfil</a><br>
    @endcan

    <a href="{{ route('logout') }}">Sair</a><br>

    @yield('content')

</body>

</html>
