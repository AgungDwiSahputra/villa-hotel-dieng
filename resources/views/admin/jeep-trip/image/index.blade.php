<x-app-layout title="Jeep Trip" subTitle="Image">
    <x-card-component col="12" title="Data Image Paket Jeep Trip {{ $jeepTrip->nama_paket }}" :dataTable="$dataTable">
        <div class="row">
            <div class="col-6">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th width="25%">Paket Jeep Trip</th>
                            <td width="1%">:</td>
                            <th width="74%">{{ $jeepTrip->nama_paket }}</th>
                        </tr>
                        <tr>
                            <th>Zona</th>
                            <th>:</th>
                            <th>{{ $jeepTrip->zona ?? '-' }}</th>
                        </tr>
                        <tr>
                            <th>Durasi</th>
                            <th>:</th>
                            <th>{{ $jeepTrip->durasi_jam ? $jeepTrip->durasi_jam . ' jam' : '-' }}</th>
                        </tr>
                        <tr>
                            <th>Harga Weekday</th>
                            <th>:</th>
                            <th>Rp. {{ number_format($jeepTrip->harga_weekday, 0, ',', '.') }}</th>
                        </tr>
                        <tr>
                            <th>Harga Weekend</th>
                            <th>:</th>
                            <th>Rp. {{ number_format($jeepTrip->harga_weekend, 0, ',', '.') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="col-6">
                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.jeep-trip.index') }}" class="btn btn-info waves-effect waves-light me-1 mb-2" title="Paket Jeep Trip">
                        <i class="bx bx-package font-size-16 align-middle"></i>
                    </a>
                    <a href="{{ route('admin.jeep-trip.image.index', ['jeep_trip' => request('jeep_trip')]) }}" class="btn btn-info waves-effect waves-light me-1 mb-2" title="Image">
                        <i class="bx bx-image font-size-16 align-middle"></i>
                    </a>
                    @can('Jeep Trip Image (Create)')
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-primary waves-effect btn-label waves-light" onclick="create()">
                                <i class="bx bx-plus label-icon"></i> Tambah Gambar
                            </button>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </x-card-component>

    @slot('modal')
        <x-modal-component id="modal-create" type="md">
            <form id="form">
                <div class="row">
                    <input type="hidden" id="id" name="id">
                    <input type="hidden" id="jeep_trip_id" name="jeep_trip_id" value="{{ request('jeep_trip') }}">
                    <x-input-form-component col="12" title="Judul Gambar" id="judul" required="false" placeholder="Opsional"/>
                    <x-input-form-component col="12" title="Gambar" type="file" id="image"/>
                    <x-input-form-component col="12" title="Urutan" type="number" id="urutan" min="1"/>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" id="btncreate">Simpan</button>
                    </div>
                </div>
            </form>
        </x-modal-component>
    @endslot
    @include('admin.jeep-trip.image.create')
    @include('admin.jeep-trip.image.edit')
</x-app-layout>