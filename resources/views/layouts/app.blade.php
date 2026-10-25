<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Control de aulas') | Horario</title>
    <link rel="stylesheet" href="{{ asset('css/horario.css') }}">
</head>
<body>
    <header class="site-header">
        <div class="container nav-wrap">
            <a class="brand" href="{{ route('inicio') }}">
                <span class="brand-mark">H</span>
                <span>
                    <strong>Horario</strong>
                    <small>Control de espacios</small>
                </span>
            </a>

            <nav class="main-nav" aria-label="Navegación principal">
                <a href="{{ route('inicio') }}">Aulas</a>
                <a href="{{ route('panel.edificios.index') }}">Edificios</a>
            </nav>
        </div>
    </header>

    <main class="container page-content">
        @if (session('success'))
            <div class="alert alert-success" role="status">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-error" role="alert">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error" role="alert">
                <strong>Revisa la información del formulario.</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

</body>
</html>
