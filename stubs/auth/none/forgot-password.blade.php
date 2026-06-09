<x-layouts.guest>

    <p>Ingresa tu email y te enviaremos un enlace para restablecer tu contraseña.</p>

    {{-- Session status --}}
    @if (session('status'))
        <div>{{ session('status') }}</div>
    @endif

    {{-- Validation errors --}}
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div>
            <label for="email">Email</label>
            <input id="email"
                   type="email"
                   name="email"
                   value="{{ old('email') }}"
                   required
                   autofocus>
        </div>

        <button type="submit">Enviar enlace</button>

        <p>
            <a href="{{ route('login') }}">Volver al login</a>
        </p>

    </form>

</x-layouts.guest>