<header>
    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
        {{ __('Profile Information') }}
    </h2>

    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
        {{ __("Update your account's profile information and email address.") }}
    </p>
</header>

<form id="form" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('patch')
    <div class="row">
        <input type="hidden" name="id" value="{{ auth()->user()->id }}">
        <x-input-form-component col="6" title="Apps Name" id="name" value="{{ auth()->user()->name }}" />
        <x-input-form-component col="6" title="Email" id="email" value="{{ auth()->user()->email }}" />
        <x-input-form-component col="6" title="Image" type="file" id="image" />
        <div class="d-flex col-12">
            <button type="submit" class="btn btn-primary ms-auto" id="btncreate">Save</button>
        </div>
    </div>
</form>
