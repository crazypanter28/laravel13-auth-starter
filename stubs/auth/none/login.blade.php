<x-layouts.guest>

    @if (session('status'))
        <div>{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>

        <div>
            <label for="password">Contraseña</label>
            <input id="password" type="password" name="password" required>
        </div>

        <div>
            <label>
                <input type="checkbox" name="remember">
                Recordarme
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
            @endif
        </div>

        <button type="submit">Iniciar sesión</button>

        <p>
            ¿No tienes cuenta?
            <a href="{{ route('register') }}">Regístrate</a>
        </p>

    </form>

    @if (Route::has('socialite.redirect'))
    <hr>
    <p>o continúa con</p>
    <div>
        <a href="{{ route('socialite.redirect', 'github') }}">GitHub</a>
        <a href="{{ route('socialite.redirect', 'google') }}">Google</a>
    </div>
    @endif

</x-layouts.guest>