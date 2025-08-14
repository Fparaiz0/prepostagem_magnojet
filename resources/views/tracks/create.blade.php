@extends('layouts.admin')

@section('content')
    <h2>Gerar Range de Etiquetas</h2>

    @can('index-range')
        <a href="{{ route('tracks.index') }}">Listar</a><br><br>
    @endcan
    
    <x-alert />

        <form action="{{ route('tracks.store') }}" method="POST">
            @csrf
            @method('POST')

            <label>Quantidade </label>
            <input type="text" name="amount" id="amount" placeholder="Quantidade de etiquetas" value="{{ old('amount') }}" required><br><br>

            <button type="submit">Gerar</button>
@endsection
