<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="p-8">
    <h1 class="text-2xl font-bold mb-4">¡Bienvenido, {{ auth()->user()->name }}!</h1>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="text-sm text-red-600 hover:underline">
            Cerrar sesión
        </button>
    </form>
</body>
</html>