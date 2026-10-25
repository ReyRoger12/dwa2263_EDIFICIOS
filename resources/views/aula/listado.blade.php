@extends('layouts.app')

@section('title', 'Aulas')

@section('content')
    <section class="hero">
        <div>
            <span class="eyebrow">Administración del campus</span>
            <h1>Aulas registradas</h1>
            <p>Consulta la capacidad, disponibilidad de wifi y edificio de cada aula.</p>
        </div>
        <a class="button button-primary" href="{{ route('aulas.create') }}">Agregar aula</a>
    </section>

    @if ($edificios->isEmpty())
        <div class="notice">
            <strong>Primero registra un edificio.</strong>
            <span>Necesitas al menos uno antes de agregar aulas.</span>
            <a class="button button-primary" href="{{ route('panel.edificios.create') }}">Registrar edificio</a>
        </div>
    @endif

    <section class="stats" aria-label="Resumen">
        <article class="stat-card">
            <span>Total de aulas</span>
            <strong>{{ $aulas->count() }}</strong>
        </article>
        <article class="stat-card">
            <span>Edificios</span>
            <strong>{{ $edificios->count() }}</strong>
        </article>
        <article class="stat-card">
            <span>Aulas con wifi</span>
            <strong>{{ $aulas->where('wifi', true)->count() }}</strong>
        </article>
    </section>

    <section class="panel">
        <div class="panel-heading">
            <div>
                <h2>Directorio de aulas</h2>
                <p>Información general de los espacios disponibles.</p>
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Aula</th>
                        <th>Edificio</th>
                        <th>Capacidad</th>
                        <th>Wifi</th>
                        <th class="actions-heading">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($aulas as $aula)
                        <tr>
                            <td data-label="ID">#{{ $aula->id }}</td>
                            <td data-label="Aula"><strong>{{ $aula->nombre }}</strong></td>
                            <td data-label="Edificio">{{ $aula->edificio?->nombre ?? 'Sin edificio' }}</td>
                            <td data-label="Capacidad">{{ $aula->capacidad }} personas</td>
                            <td data-label="Wifi">
                                <span class="badge {{ $aula->wifi ? 'badge-success' : 'badge-muted' }}">
                                    {{ $aula->wifi ? 'Disponible' : 'No disponible' }}
                                </span>
                            </td>
                            <td data-label="Acciones">
                                <div class="table-actions">
                                    <a class="button button-light" href="{{ route('aulas.edit', $aula) }}">Editar</a>
                                    <form action="{{ route('aulas.destroy', $aula) }}" method="post" onsubmit="return confirm('¿Quieres eliminar el aula {{ $aula->nombre }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="button button-danger" type="submit">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="empty-state" colspan="6">
                                <strong>Aún no hay aulas registradas.</strong>
                                <span>Agrega la primera para comenzar.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    @if ($edificios->isNotEmpty())
        <section class="building-section">
            <div class="section-heading">
                <h2>Edificios</h2>
                <p>Resumen de aulas por edificio.</p>
            </div>
            <div class="building-grid">
                @foreach ($edificios as $edificio)
                    <article class="building-card">
                        <span>Edificio</span>
                        <strong>{{ $edificio->nombre }}</strong>
                        <small>{{ $edificio->aulas_count }} {{ $edificio->aulas_count === 1 ? 'aula' : 'aulas' }}</small>
                        <a href="{{ route('panel.edificios.edit', $edificio) }}">Administrar</a>
                    </article>
                @endforeach
            </div>
        </section>
    @endif
@endsection
