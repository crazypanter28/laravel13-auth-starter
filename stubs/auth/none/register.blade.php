<x-layouts.guest>

    {{-- Validation errors --}}
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <label for="name">Nombre</label>
            <input id="name"
                   type="text"
                   name="name"
                   value="{{ old('name') }}"
                   required
                   autofocus>
        </div>

        <div>
            <label for="email">Email</label>
            <input id="email"
                   type="email"
                   name="email"
                   value="{{ old('email') }}"
                   required>
        </div>

        <div>
            <label for="password">Contraseña</label>
            <input id="password"
                   type="password"
                   name="password"
                   required>
        </div>

        <div>
            <label for="password_confirmation">Confirmar contraseña</label>
            <input id="password_confirmation"
                   type="password"
                   name="password_confirmation"
                   required>
        </div>

        <button type="submit">Crear cuenta</button>

        <p>
            ¿Ya tienes cuenta?
            <a href="{{ route('login') }}">Inicia sesión</a>
        </p>

    </form>

    <hr>
    <p>o continúa con</p>

    <div>
        <a href="{{ route('socialite.redirect', 'github') }}">GitHub</a>
        <a href="{{ route('socialite.redirect', 'google') }}">Google</a>
    </div>

</x-layouts.guest>