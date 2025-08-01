<x-app-layout title="Produk" subTitle="Produk Category">
    <x-card-component col="12" title="Data Produk Category" :dataTable="$dataTable">
        @can('Produk Category (Create)')
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
                    <x-input-form-component col="12" title="Nama" id="name"/>
                    <x-input-form-component col="6" title="Urutan" type="number" id="urutan" max="11"/>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btncreate">Save</button>
                    </div>
                </div>
            </form>
        </x-modal-component>
    @endslot
    @include('admin.produk.category.create')
    @include('admin.produk.category.edit')
</x-app-layout>