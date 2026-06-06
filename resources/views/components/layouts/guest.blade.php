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
<body class="min-h-screen bg-gray-100 flex flex-col items-center justify-center">

    <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-md rounded-lg">

        {{-- Logo --}}
        <div class="flex justify-center mb-6">
            <a href="/" class="text-2xl font-bold text-gray-800">
                {{ config('app.name', 'Laravel') }}
            </a>
        </div>

        {{-- Slot principal --}}
        {{ $slot }}

    </div>

    @livewireScripts
</body>
</html>