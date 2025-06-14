<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>TaskFlow - Gestor de Tarefas Kanban</title>

        {{-- Fonts --}}
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        {{-- Styles / Scripts --}}
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
            </style>
        @endif

        {{-- Bootstrap --}}
        <link rel="stylesheet" href="{{ asset('/bootstrap-5.3.6-dist/css/bootstrap.min.css') }}">

        {{-- Bootstrap JS --}}
        <script src="{{ asset('/bootstrap-5.3.6-dist/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('/bootstrap-5.3.6-dist/js/bootstrap.min.js') }}"></script>


        {{-- Bootstrap Icons --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

        {{-- jQuery --}}
        <script src="{{ asset('/jquery-3.7.1.min.js') }}"></script>

        {{-- jQuery UI --}}
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

        {{-- Tom Select JS --}}
        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
        
               

        <style>

            .bg-gradient-navbar {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
            
            
        </style>

    </head>
    <body>
        @include('app._components.navbar')
        @yield('content')
    </body>
</html>