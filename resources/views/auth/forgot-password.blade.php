<x-guest-layout>
    <form class="form-horizontal" action="{{ route('password.email') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Enter email">
        </div>
        <div class="mt-3 d-grid">
            <button type="submit" class="btn btn-primary waves-effect waves-light" type="submit">Forgot Password</button>
        </div>
    </form>
</x-guest-layout>

