@extends('layouts.app')

@section('title', 'Editar aula')

@section('content')
    <div class="form-page">
        <a class="back-link" href="{{ route('aulas.index') }}">Volver al listado</a>

        <section class="form-card">
            <div class="form-heading">
                <span class="eyebrow">Aula {{ $aula->nombre }}</span>
                <h1>Editar aula</h1>
                <p>Actualiza los datos y guarda los cambios.</p>
            </div>

            <form action="{{ route('aulas.update', $aula) }}" method="post">
                @csrf
                @method('PUT')
                @include('aula.form', ['buttonText' => 'Guardar cambios'])
            </form>
        </section>
    </div>
@endsection
