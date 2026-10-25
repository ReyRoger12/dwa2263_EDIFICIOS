<div class="form-grid">
    <div class="field field-wide">
        <label for="nombre">Nombre del edificio</label>
        <input
            id="nombre"
            name="nombre"
            type="text"
            value="{{ old('nombre', $edificio->nombre ?? '') }}"
            maxlength="255"
            placeholder="Ejemplo: Edificio C"
            required
            autofocus
        >
        @error('nombre')
            <small class="field-error">{{ $message }}</small>
        @enderror
    </div>
</div>

<div class="form-actions">
    <a class="button button-light" href="{{ route('panel.edificios.index') }}">Cancelar</a>
    <button class="button button-primary" type="submit">{{ $buttonText }}</button>
</div>
