@extends('layouts.admin')

@section('content')
    <h2>Cadastrar Usuário</h2>

    @can('index-user')
        <a href="{{ route('users.index') }}">Listar</a><br>
    @endcan

    <br>
    <x-alert />

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        @method('POST')

        <label>Nome: </label>
        <input type="text" name="name" id="name" placeholder="Nome do usuário" value="{{ old('name') }}" required><br><br>

        <label>E-mail: </label>
        <input type="email" name="email" id="email" placeholder="E-mail do usuário" value="{{ old('email') }}" required><br><br>

        @can('edit-roles-user')
        <label>Papel: </label>
        @forelse ($roles as $role)
            @if ($role != 'Super Admin' || Auth::user()->hasRole('Super Admin'))
                <input type="checkbox" name="roles[]" id="role_{{ Str::slug($role) }}" value="{{ $role }}" {{ collect(old('role'))->contains($role) ? 'checked' : '' }}>
                <label for="role_{{ Str::slug($role) }}"> {{ $role }} </label>
            @endif
        @empty
            <p>Nenhum pepel disponível.</p>
        @endforelse
        <br><br>
        @endcan

        <label>Senha: </label>
        <input type="password" name="password" id="password" placeholder="Senha do usuário" value="{{ old('password') }}" required><br><br>

        <label>Confirmar Senha: </label>
        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirmar a senha" value="{{ old('password_confirmation') }}" required><br><br>

        <button type="submit">Cadastrar</button>
    </form>
@endsection
