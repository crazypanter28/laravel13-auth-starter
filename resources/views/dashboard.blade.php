<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-100 min-h-screen p-8">

    <div class="max-w-2xl mx-auto">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl font-bold text-gray-800">
                ¡Bienvenido, {{ auth()->user()->name }}!
            </h1>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-red-600 hover:underline">
                    Cerrar sesión
                </button>
            </form>
        </div>

        {{-- Two Factor Auth --}}
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-1">
                Autenticación de dos factores
            </h2>
            <p class="text-sm text-gray-500 mb-6">
                Agrega seguridad adicional a tu cuenta usando una aplicación de autenticación.
            </p>

            @if (auth()->user()->two_factor_secret && auth()->user()->two_factor_confirmed_at)

                {{-- 2FA Activo y confirmado --}}
                <div class="mb-6">
                    <span class="inline-flex items-center gap-1 text-sm text-green-600 font-medium">
                        ✅ Two-factor authentication está activo
                    </span>
                </div>

                {{-- Códigos de recuperación --}}
                @if (auth()->user()->two_factor_recovery_codes)
                    <div class="mb-6">
                        <p class="text-sm font-medium text-gray-700 mb-2">Códigos de recuperación:</p>
                        <div class="bg-gray-50 rounded-md p-4 font-mono text-xs space-y-1">
                            @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
                                <div>{{ $code }}</div>
                            @endforeach
                        </div>
                        <p class="text-xs text-gray-500 mt-2">
                            Guarda estos códigos en un lugar seguro. Cada uno solo puede usarse una vez.
                        </p>
                    </div>
                @endif

                {{-- Desactivar 2FA --}}
                <form method="POST" action="/user/two-factor-authentication">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm text-red-600 hover:underline">
                        Desactivar 2FA
                    </button>
                </form>

            @elseif (auth()->user()->two_factor_secret && !auth()->user()->two_factor_confirmed_at)

                {{-- 2FA activado pero pendiente de confirmar — mostrar QR --}}
                <div class="mb-6">
                    <p class="text-sm font-medium text-gray-700 mb-3">
                        Escanea este código QR con Google Authenticator o Authy:
                    </p>
                    <div class="mb-4">
                        {!! auth()->user()->twoFactorQrCodeSvg() !!}
                    </div>
                    <p class="text-sm font-medium text-gray-700 mb-2">
                        O ingresa este código manualmente:
                    </p>
                    <code class="bg-gray-50 rounded px-3 py-2 text-sm font-mono block mb-6">
                        {{ decrypt(auth()->user()->two_factor_secret) }}
                    </code>

                    {{-- Confirmar con código --}}
                    <form method="POST" action="/user/confirmed-two-factor-authentication">
                        @csrf
                        <div class="mb-4">
                            <label for="code" class="block text-sm font-medium text-gray-700 mb-1">
                                Ingresa el código de tu app para confirmar
                            </label>
                            <input id="code"
                                   type="text"
                                   name="code"
                                   inputmode="numeric"
                                   required
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <button type="submit"
                                class="bg-indigo-600 text-white py-2 px-4 rounded-md text-sm font-medium hover:bg-indigo-700 transition">
                            Confirmar y activar
                        </button>
                    </form>
                </div>

            @else

                {{-- 2FA Inactivo --}}
                <form method="POST" action="/user/two-factor-authentication">
                    @csrf
                    <button type="submit"
                            class="bg-indigo-600 text-white py-2 px-4 rounded-md text-sm font-medium hover:bg-indigo-700 transition">
                        Activar 2FA
                    </button>
                </form>

            @endif

        </div>

    </div>

    @livewireScripts
</body>
</html>