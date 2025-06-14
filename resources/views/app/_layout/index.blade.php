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

            .column-div {
                height: 67vh;
                min-width: 350px;
                bottom: 0;
            }

            .cursor-pointer {
                cursor: pointer;
            }

            .text-light-gray {
                color: #cec6c6;
            }

            .text-light-gray:hover {
                color: #f54a4a;
            }

            .colum-header:hover {
                background-color: #fafafa;
                border-radius: 5px;
            }

            .cards-div {
                z-index: 1000;
                overflow-y: auto;
                width: 100%;
            }

            .dragging {
                opacity: 0.5;
                z-index: 1000;
                background: #f8f9fa;
                box-shadow: 0 0 10px rgba(0,0,0,0.1);
            }
            .card-placeholder {
                border: 2px dashed #ccc;
                margin: 10px 0;
                background: #f9f9f9;
                border-radius: 4px;
                min-height: 100px;
                transition: all 0.2s ease;
            }
            .column-div {
                cursor: move;
            }
            .card {
                transition: all 0.2s ease;
            }
            .card:hover {
                box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            }
            .cards-div {
                min-height: 100px;
                padding: 5px 0;
            }
            .drag-handle {
                /* cursor: move; */
                color: #ccc;
                padding: 0 5px;
                /* display: flex; */
                align-items: center;
            }
            .drag-handle:hover {
                color: #666;
            }
            .card-title {
                cursor: pointer;
            }
            .card-title:hover {
                color: #666 !important;
            }
            .card + .card {
                margin-top: 10px;
            }

            /* Estilos personalizados para as barras de rolagem */
            .columns-div::-webkit-scrollbar,
            .cards-div::-webkit-scrollbar,
            .column-div::-webkit-scrollbar {
                width: 8px;
                height: 8px;
            }

            .columns-div::-webkit-scrollbar-track,
            .cards-div::-webkit-scrollbar-track,
            .column-div::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 4px;
            }

            .columns-div::-webkit-scrollbar-thumb,
            .cards-div::-webkit-scrollbar-thumb,
            .column-div::-webkit-scrollbar-thumb {
                background: #ccc;
                border-radius: 4px;
                transition: all 0.2s ease;
            }

            .columns-div::-webkit-scrollbar-thumb:hover,
            .cards-div::-webkit-scrollbar-thumb:hover,
            .column-div::-webkit-scrollbar-thumb:hover {
                background: #999;
            }

            /* Para Firefox */
            .columns-div,
            .cards-div,
            .column-div {
                scrollbar-width: thin;
                scrollbar-color: #ccc #f1f1f1;
            }

            /* Ajuste no container para melhor visualização */
            .columns-div {
                padding-bottom: 10px;
            }

            /* Ajuste no cards-div para melhor visualização */
            .cards-div {
                padding-right: 5px;
            }

            .card-assigned-user {
                font-size: 12px;
                cursor: pointer;
            }

            .open-card {
                cursor: pointer;
            }

            .card-actions-delete {
                cursor: default;
            }
            
            
        </style>

    </head>
    <body>
        @include('app._components.navbar')
        @yield('content')
    </body>
</html>