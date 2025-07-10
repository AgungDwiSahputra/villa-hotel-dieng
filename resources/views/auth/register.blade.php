<x-guest-layout>
    <form class="form-horizontal" action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" id="role" name="role" value="test">
        <div class="mb-3">
            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Enter Name">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Enter email">
        </div>
        <div class="mb-3">
            <label class="form-label">Password <span class="text-danger">*</span></label>
            <div class="input-group auth-pass-inputgroup">
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
            </div>
        </div>        
        <div class="mb-3">
            <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
            <div class="input-group auth-pass-inputgroup">
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Enter Confirm password">
            </div>
        </div>
        <div class="mb-3">
            <label for="no_hp" class="form-label">No HP <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" placeholder="Enter No HP">
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="alamat" name="alamat" value="{{ old('alamat') }}" placeholder="Enter Alamat">
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" id="image" name="image" value="{{ old('image') }}">
        </div>
        <div class="mt-3 d-grid">
            <button type="submit" class="btn btn-primary waves-effect waves-light" type="submit">Log In</button>
        </div>
    </form>
</x-guest-layout>
