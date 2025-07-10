<x-guest-layout>
    <form class="form-horizontal" action="{{ route('password.store') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') ?? $request->email }}" placeholder="Enter email">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">New Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter New Password">
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm New Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Enter Confirm New Password">
        </div>
       
        <div class="mt-3 d-grid">
            <button type="submit" class="btn btn-primary waves-effect waves-light" type="submit">Reset Password</button>
        </div>
    </form>
</x-guest-layout>
