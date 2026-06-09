<x-layouts.guest>

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

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email"
                   type="email"
                   name="email"
                   value="{{ old('email', request()->email) }}"
                   required
                   autofocus
                   class="form-control">
        </div>

        {{-- Password --}}
        <div class="mb-3">
            <label for="password" class="form-label">Nueva contraseña</label>
            <input id="password"
                   type="password"
                   name="password"
                   required
                   class="form-control">
        </div>

        {{-- Confirm Password --}}
        <div class="mb-4">
            <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
            <input id="password_confirmation"
                   type="password"
                   name="password_confirmation"
                   required
                   class="form-control">
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn btn-primary w-100">
            Restablecer contraseña
        </button>

    </form>

</x-layouts.guest>