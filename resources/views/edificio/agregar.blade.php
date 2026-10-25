@extends('layouts.app')

@section('title', 'Agregar edificio')

@section('content')
    <div class="form-page">
        <a class="back-link" href="{{ route('panel.edificios.index') }}">Volver a edificios</a>

        <section class="form-card">
            <div class="form-heading">
                <span class="eyebrow">Nuevo edificio</span>
                <h1>Registrar edificio</h1>
                <p>Agrega el edificio para después relacionar sus aulas.</p>
            </div>

            <form action="{{ route('panel.edificios.store') }}" method="post">
                @csrf
                @include('edificio.form', ['buttonText' => 'Guardar edificio'])
            </form>
        </section>
    </div>
@endsection
