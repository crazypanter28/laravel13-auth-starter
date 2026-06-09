<x-layouts.guest>

    <p class="text-secondary small mb-4">
        Ingresa tu email y te enviaremos un enlace para restablecer tu contraseña.
    </p>

    {{-- Session status --}}
    @if (session('status'))
        <div class="alert alert-success mb-3">
            {{ session('status') }}
        </div>
    @endif

    {{-- Validation errors --}}
    @if ($errors->any())
        <div class="alert alert-danger mb-3">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        {{-- Email --}}
        <div class="mb-4">
            <label for="email" class="form-label">Email</label>
            <input id="email"
                   type="email"
                   name="email"
                   value="{{ old('email') }}"
                   required
                   autofocus
                   class="form-control">
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn btn-primary w-100">
            Enviar enlace
        </button>

        {{-- Back to login --}}
        <p class="mt-3 text-center small">
            <a href="{{ route('login') }}" class="text-decoration-none">
                Volver al login
            </a>
        </p>

    </form>

</x-layouts.guest>