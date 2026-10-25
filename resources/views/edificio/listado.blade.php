@extends('layouts.app')

@section('title', 'Edificios')

@section('content')
    <section class="hero">
        <div>
            <span class="eyebrow">Administración del campus</span>
            <h1>Edificios registrados</h1>
            <p>Administra los edificios y consulta cuántas aulas tiene cada uno.</p>
        </div>
        <a class="button button-primary" href="{{ route('panel.edificios.create') }}">Agregar edificio</a>
    </section>

    <section class="stats" aria-label="Resumen">
        <article class="stat-card">
            <span>Total de edificios</span>
            <strong>{{ $edificios->count() }}</strong>
        </article>
        <article class="stat-card">
            <span>Aulas relacionadas</span>
            <strong>{{ $edificios->sum('aulas_count') }}</strong>
        </article>
        <article class="stat-card">
            <span>Con aulas</span>
            <strong>{{ $edificios->where('aulas_count', '>', 0)->count() }}</strong>
        </article>
    </section>

    <section class="panel">
        <div class="panel-heading">
            <div>
                <h2>Directorio de edificios</h2>
                <p>Desde aquí puedes registrar, modificar o eliminar edificios.</p>
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Aulas</th>
                        <th class="actions-heading">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($edificios as $edificio)
                        <tr>
                            <td data-label="ID">#{{ $edificio->id }}</td>
                            <td data-label="Nombre"><strong>{{ $edificio->nombre }}</strong></td>
                            <td data-label="Aulas">{{ $edificio->aulas_count }}</td>
                            <td data-label="Acciones">
                                <div class="table-actions">
                                    <a class="button button-light" href="{{ route('panel.edificios.edit', $edificio) }}">Editar</a>
                                    <form action="{{ route('panel.edificios.destroy', $edificio) }}" method="post" onsubmit="return confirm('¿Quieres eliminar {{ $edificio->nombre }}? También se eliminarán sus aulas relacionadas.')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="button button-danger" type="submit">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="empty-state" colspan="4">
                                <strong>Aún no hay edificios registrados.</strong>
                                <span>Agrega el primero para después registrar sus aulas.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
