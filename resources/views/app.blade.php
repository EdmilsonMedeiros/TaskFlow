<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>TaskFlow - Gestor de Tarefas Kanban</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                body {
                    font-family: "Figtree", sans-serif !important;
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    min-height: 100vh;
                }

                .hero-section {
                    min-height: 100vh;
                    color: white;
                }

                .logo {
                    font-size: 3.5rem;
                    font-weight: 600;
                    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
                }

                .subtitle {
                    font-size: 1.5rem;
                    opacity: 0.9;
                }

                .description {
                    font-size: 1.1rem;
                    line-height: 1.6;
                    opacity: 0.8;
                }

                .login-btn-custom {
                    background: rgba(255, 255, 255, 0.2) !important;
                    border: 2px solid rgba(255, 255, 255, 0.3) !important;
                    backdrop-filter: blur(10px);
                    border-radius: 50px !important;
                    padding: 15px 40px !important;
                    font-size: 1.2rem;
                    font-weight: 500;
                    transition: all 0.3s ease;
                }

                .login-btn-custom:hover {
                    background: rgba(255, 255, 255, 0.3) !important;
                    border-color: rgba(255, 255, 255, 0.6) !important;
                    transform: translateY(-2px);
                    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
                }

                .feature-card {
                    background: rgba(255, 255, 255, 0.1);
                    backdrop-filter: blur(10px);
                    border: 1px solid rgba(255, 255, 255, 0.2) !important;
                    border-radius: 15px !important;
                    color: white;
                }

                .feature-icon {
                    font-size: 2.5rem;
                }

                @media (max-width: 768px) {
                    .logo {
                        font-size: 2.5rem;
                    }
                    
                    .subtitle {
                        font-size: 1.2rem;
                    }
                }
            </style>
        @endif
        <link rel="stylesheet" href="{{ asset('/bootstrap-5.3.6-dist/css/bootstrap.min.css') }}">
        {{-- Bootstrap Icons --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    </head>
    <body>
        @yield('content')
    </body>
</html>