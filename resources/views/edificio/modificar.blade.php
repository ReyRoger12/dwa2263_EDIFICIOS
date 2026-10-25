@extends('layouts.app')

@section('title', 'Editar edificio')

@section('content')
    <div class="form-page">
        <a class="back-link" href="{{ route('panel.edificios.index') }}">Volver a edificios</a>

        <section class="form-card">
            <div class="form-heading">
                <span class="eyebrow">{{ $edificio->nombre }}</span>
                <h1>Editar edificio</h1>
                <p>Actualiza el nombre y guarda los cambios.</p>
            </div>

            <form action="{{ route('panel.edificios.update', $edificio) }}" method="post">
                @csrf
                @method('PUT')
                @include('edificio.form', ['buttonText' => 'Guardar cambios'])
            </form>
        </section>
    </div>
@endsection
