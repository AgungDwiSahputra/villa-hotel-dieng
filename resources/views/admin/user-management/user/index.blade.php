<x-app-layout title="User Management" subTitle="User">
    <x-card-component col="12" title="Data User" :dataTable="$dataTable">
        @can('User Management User (Create)')
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-primary waves-effect btn-label waves-light" onclick="create()"><i class="bx bx-plus label-icon"></i> Create</button>
            </div>
        @endcan
    </x-card-component>

    @slot('modal')
        <x-modal-component id="modal-create" type="lg">
            <form id="form">
                <div class="row">
                    <input type="hidden" id="id" name="id">
                    <input type="hidden" id="type" name="type" value="Perorangan">
                    <x-input-form-component col="6" title="Name" id="name" />
                    <x-input-form-component col="6" title="Email" id="email" />
                    <x-input-form-component col="6" type="password" title="Password" id="password" />
                    <x-input-form-component col="6" type="password" title="Password Confirm" id="password_confirmation" />
                    <x-input-form-component col="6" title="Role" type="drop-down" id="role" :options="$roles" />
                    <x-input-form-component col="6" title="Image" type="file" id="image" />
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btncreate">Save</button>
                    </div>
                </div>
            </form>
        </x-modal-component>
    @endslot
    @include('admin.user-management.user.create')
    @include('admin.user-management.user.edit')
</x-app-layout>