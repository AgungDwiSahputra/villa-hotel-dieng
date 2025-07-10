<x-app-layout title="Produk" subTitle="Syarat & Ketentuan">
    <x-card-component col="12" title="Data Syarat & Ketentuan Produk {{ $produk->name }}" :dataTable="$dataTable">
         <div class="row">
            <div class="col-6">
                <table class="table table-sm">
                    </thead>
                        <tr>
                            <th width="25%">Produk</th>
                            <td width="1%">:</td>
                            <th width="74%">{{ $produk->name }}</th>
                        </tr>
                        <tr>
                            <th>Lokasi</th>
                            <th>:</th>
                            <th>{{ $produk->lokasi }}</th>
                        </tr>
                        <tr>
                            <th>Harga Weekday</th>
                            <th>:</th>
                            <th>Rp. {{ number_format($produk->harga_weekday,0,',','.') }}</th>
                        </tr>
                        <tr>
                            <th>Harga Weekend</th>
                            <th>:</th>
                            <th>Rp. {{ number_format($produk->harga_weekend,0,',','.') }}</th>
                        </tr>
                    <thead>
                </table>
            </div>
            <div class="col-6">
                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.produk.image.index',['produk' => request('produk')]) }}" class="btn btn-info waves-effect waves-light me-1 mb-2" title="Image"><i class="bx bx-image font-size-16 align-middle"></i></a>
                    <a href="{{ route('admin.produk.fasilitas.index',['produk' => request('produk')]) }}" class="btn btn-info waves-effect waves-light me-1 mb-2" title="Fasilitas"><i class="bx bx-cog font-size-16 align-middle"></i></a>
                    <a href="{{ route('admin.produk.wisata.index',['produk' => request('produk')]) }}" class="btn btn-info waves-effect waves-light me-1 mb-2" title="Wisata"><i class="bx bx-map font-size-16 align-middle"></i></a>
                    <a href="{{ route('admin.produk.syarat.index',['produk' => request('produk')]) }}" class="btn btn-info waves-effect waves-light mb-2" title="Syarat & Ketentuan"><i class="bx bx-file font-size-16 align-middle"></i></a>
                </div>
                @can('Produk Syarat (Create)')
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary waves-effect btn-label waves-light" onclick="create()"><i class="bx bx-plus label-icon"></i> Create</button>
                    </div>
                @endcan
            </div>
        </div>
    </x-card-component>

    @slot('modal')
        <x-modal-component id="modal-create" type="md">
            <form id="form">
                <div class="row">
                    <input type="hidden" id="id" name="id">
                    <input type="hidden" id="produk_id" name="produk_id" value="{{ request('produk') }}">
                    <x-input-form-component col="12" title="Nama" id="name"/>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btncreate">Save</button>
                    </div>
                </div>
            </form>
        </x-modal-component>
    @endslot
    @include('admin.produk.syarat.create')
    @include('admin.produk.syarat.edit')
</x-app-layout>