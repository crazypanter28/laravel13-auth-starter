<x-layouts.guest>

    <p class="mb-4 text-sm text-gray-600">
        Por seguridad, confirma tu contraseña para continuar.
    </p>

    @if ($errors->any())
        <div class="mb-4 text-sm text-red-600">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div class="mb-6">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                Contraseña
            </label>
            <input id="password"
                   type="password"
                   name="password"
                   required
                   autofocus
                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <button type="submit"
                class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md text-sm font-medium hover:bg-indigo-700 transition">
            Confirmar
        </button>

    </form>

</x-layouts.guest>