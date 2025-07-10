<x-guest-layout>
    <form class="form-horizontal" action="{{ route('login') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Enter email">
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="input-group auth-pass-inputgroup">
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" aria-label="Password" aria-describedby="password-addon">
                <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
            </div>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="remember-check" name="remember">
            <label class="form-check-label" for="remember-check">
                Remember me
            </label>
        </div>
        
        <div class="mt-3 d-grid">
            <button type="submit" class="btn btn-primary waves-effect waves-light" type="submit">Log In</button>
        </div>
    </form>

    {{-- @slot('forgot')
        <div class="mt-2 mb-2 text-center">
            <a href="{{ route('password.request') }}" class="text-muted"><i class="mdi mdi-lock me-1"></i> Forgot your password?</a>
        </div>
    @endslot --}}
</x-guest-layout>
