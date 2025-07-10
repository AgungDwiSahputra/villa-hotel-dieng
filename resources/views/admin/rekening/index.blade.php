<x-app-layout title="Rekening" subTitle="Rekening">
    <x-card-component col="12" title="Data Rekening" :dataTable="$dataTable">
        @can('Rekening (Create)')
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
                    <x-input-form-component col="12" title="Nama Bank" id="bank" />
                    <x-input-form-component col="12" title="Name" id="name" />
                    <x-input-form-component col="12" title="No Rekening" id="no_rekening" />
                    <x-input-form-component col="12" title="Image" type="file" id="image" />
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btncreate">Save</button>
                    </div>
                </div>
            </form>
        </x-modal-component>
    @endslot
    @include('admin.rekening.create')
    @include('admin.rekening.edit')
</x-app-layout>