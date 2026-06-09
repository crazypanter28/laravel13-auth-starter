<x-layouts.guest>

    {{-- Validation errors --}}
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div>
            <label for="email">Email</label>
            <input id="email"
                   type="email"
                   name="email"
                   value="{{ old('email', request()->email) }}"
                   required
                   autofocus>
        </div>

        <div>
            <label for="password">Nueva contraseña</label>
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

        <button type="submit">Restablecer contraseña</button>

    </form>

</x-layouts.guest>