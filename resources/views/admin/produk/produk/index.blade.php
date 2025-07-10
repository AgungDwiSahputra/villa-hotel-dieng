<x-app-layout title="Produk" subTitle="Produk">
    <x-card-component col="12" title="Data Produk" :dataTable="$dataTable">
        @can('Produk (Create)')
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
                    <x-input-form-component col="6" title="Kategori" type="drop-down" id="category_id" :options="$categories"/>
                    <x-input-form-component col="6" title="Nama" id="name"/>
                    <x-input-form-component col="6" title="Unit" type="number" id="unit"/>
                    <x-input-form-component col="6" title="Kamar" type="number" id="kamar"/>
                    <x-input-form-component col="6" title="Ideal Orang" type="number" id="orang"/>
                    <x-input-form-component col="6" title="Maksimal Orang" type="number" id="maks_orang"/>
                    <x-input-form-component col="6" title="Lokasi" id="lokasi"/>
                    <x-input-form-component col="6" title="Harga Weekday" type="number" id="harga_weekday"/>
                    <x-input-form-component col="6" title="Harga Weekend" type="number" id="harga_weekend"/>
                    <x-input-form-component col="6" title="Label" id="label" required="false"/>
                    <x-input-form-component col="6" title="Urutan" type="number" id="urutan" max="11"/>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btncreate">Save</button>
                    </div>
                </div>
            </form>
        </x-modal-component>
    @endslot
    @include('admin.produk.produk.create')
    @include('admin.produk.produk.edit')
</x-app-layout>