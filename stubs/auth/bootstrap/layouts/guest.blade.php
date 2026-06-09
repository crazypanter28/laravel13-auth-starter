<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-light min-vh-100 d-flex flex-column align-items-center justify-content-center">

    <div class="card shadow-sm w-100" style="max-width: 420px;">
        <div class="card-body p-4">

            {{-- Logo --}}
            <div class="text-center mb-4">
                <a href="/" class="text-decoration-none">
                    <h4 class="fw-bold text-dark">{{ config('app.name', 'Laravel') }}</h4>
                </a>
            </div>

            {{-- Slot principal --}}
            {{ $slot }}

        </div>
    </div>

    @livewireScripts
</body>
</html>