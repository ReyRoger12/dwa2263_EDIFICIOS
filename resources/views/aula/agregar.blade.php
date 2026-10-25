@extends('layouts.app')

@section('title', 'Agregar aula')

@section('content')
    <div class="form-page">
        <a class="back-link" href="{{ route('aulas.index') }}">Volver al listado</a>

        <section class="form-card">
            <div class="form-heading">
                <span class="eyebrow">Nueva aula</span>
                <h1>Registrar aula</h1>
                <p>Completa los datos del espacio que deseas agregar.</p>
            </div>

            <form action="{{ route('aulas.store') }}" method="post">
                @csrf
                @include('aula.form', ['buttonText' => 'Guardar aula'])
            </form>
        </section>
    </div>
@endsection
