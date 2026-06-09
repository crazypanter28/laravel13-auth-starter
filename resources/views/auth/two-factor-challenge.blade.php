<x-layouts.guest>

    <div x-data="{ recovery: false }">

        {{-- Validation errors --}}
        @if ($errors->any())
            <div class="mb-4 text-sm text-red-600">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Código de autenticador --}}
        <div x-show="!recovery">
            <p class="mb-4 text-sm text-gray-600">
                Ingresa el código de tu aplicación de autenticación.
            </p>

            <form method="POST" action="/two-factor-challenge">
                @csrf

                <div class="mb-4">
                    <label for="code" class="block text-sm font-medium text-gray-700 mb-1">
                        Código
                    </label>
                    <input id="code"
                           type="text"
                           name="code"
                           inputmode="numeric"
                           autofocus
                           autocomplete="one-time-code"
                           class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <button type="submit"
                        class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md text-sm font-medium hover:bg-indigo-700 transition">
                    Verificar
                </button>

            </form>

            <p class="mt-4 text-center text-sm text-gray-600">
                <button @click="recovery = true" class="text-indigo-600 hover:underline">
                    Usar código de recuperación
                </button>
            </p>
        </div>

        {{-- Código de recuperación --}}
        <div x-show="recovery">
            <p class="mb-4 text-sm text-gray-600">
                Ingresa uno de tus códigos de recuperación de emergencia.
            </p>

            <form method="POST" action="/two-factor-challenge">
                @csrf

                <div class="mb-4">
                    <label for="recovery_code" class="block text-sm font-medium text-gray-700 mb-1">
                        Código de recuperación
                    </label>
                    <input id="recovery_code"
                           type="text"
                           name="recovery_code"
                           autocomplete="one-time-code"
                           class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <button type="submit"
                        class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md text-sm font-medium hover:bg-indigo-700 transition">
                    Verificar
                </button>

            </form>

            <p class="mt-4 text-center text-sm text-gray-600">
                <button @click="recovery = false" class="text-indigo-600 hover:underline">
                    Usar código de autenticador
                </button>
            </p>
        </div>

    </div>

</x-layouts.guest>