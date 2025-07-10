<x-app-layout title="User Management" subTitle="Permission">
    <x-card-component col="12" title="Data Permission" :dataTable="$dataTable">
        @can('User Management Permission (Create)')
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-primary waves-effect btn-label waves-light" onclick="create()"><i class="bx bx-plus label-icon"></i> Create</button>
            </div>
        @endcan
    </x-card-component>

    @slot('modal')
        <x-modal-component id="modal-create" type="md">
            <form id="form">
                <div class="row">
                    <input type="hidden" id="id" name="id">
                    <x-input-form-component col="12" title="Module" id="module" />
                    <x-input-form-component col="12" title="Module Action" id="module_action" />
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btncreate">Save</button>
                    </div>
                </div>
            </form>
        </x-modal-component>
    @endslot
    @include('admin.user-management.permission.create')
    @include('admin.user-management.permission.edit')
</x-app-layout>