<div class="form-grid">
    <div class="field field-wide">
        <label for="nombre">Nombre del aula</label>
        <input
            id="nombre"
            name="nombre"
            type="text"
            value="{{ old('nombre', $aula->nombre ?? '') }}"
            maxlength="255"
            placeholder="Ejemplo: C4"
            required
            autofocus
        >
        @error('nombre')
            <small class="field-error">{{ $message }}</small>
        @enderror
    </div>

    <div class="field">
        <label for="capacidad">Capacidad</label>
        <input
            id="capacidad"
            name="capacidad"
            type="number"
            value="{{ old('capacidad', $aula->capacidad ?? '') }}"
            min="1"
            max="500"
            placeholder="30"
            required
        >
        @error('capacidad')
            <small class="field-error">{{ $message }}</small>
        @enderror
    </div>

    <div class="field">
        <label for="edificio_id">Edificio</label>
        <select id="edificio_id" name="edificio_id" required {{ $edificios->isEmpty() ? 'disabled' : '' }}>
            <option value="">Selecciona un edificio</option>
            @foreach ($edificios as $edificio)
                <option value="{{ $edificio->id }}" @selected((string) old('edificio_id', $aula->edificio_id ?? '') === (string) $edificio->id)>
                    {{ $edificio->nombre }}
                </option>
            @endforeach
        </select>
        @error('edificio_id')
            <small class="field-error">{{ $message }}</small>
        @enderror
    </div>

    <label class="check-field field-wide" for="wifi">
        <input id="wifi" name="wifi" type="checkbox" value="1" @checked(old('wifi', $aula->wifi ?? false))>
        <span>
            <strong>Cuenta con wifi</strong>
            <small>Marca esta opción si el aula tiene conexión inalámbrica.</small>
        </span>
    </label>
</div>

@if ($edificios->isEmpty())
    <div class="notice compact">
        Registra al menos un edificio desde <code>POST /api/edificios</code> antes de guardar el aula.
    </div>
@endif

<div class="form-actions">
    <a class="button button-light" href="{{ route('aulas.index') }}">Cancelar</a>
    <button class="button button-primary" type="submit" {{ $edificios->isEmpty() ? 'disabled' : '' }}>{{ $buttonText }}</button>
</div>
