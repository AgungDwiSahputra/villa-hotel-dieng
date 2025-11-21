<x-app-layout title="Produk" subTitle="Produk">
    @push('css')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <style>
            #map {
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }
            .leaflet-popup-content-wrapper {
                border-radius: 8px;
            }
        </style>
    @endpush
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
                    <x-input-form-component col="6" title="Owner" type="email" id="owner"/>
                    <x-input-form-component col="6" title="Rating" type="number" placeholder="5,0" step="0.1" max="5" id="rating"/>
                    <x-input-form-component col="6" title="Harga Weekday" type="number" id="harga_weekday"/>
                    <x-input-form-component col="6" title="Harga Weekend" type="number" id="harga_weekend"/>
                    <x-input-form-component col="6" title="Label" id="label" required="false"/>
                    <x-input-form-component col="6" title="Urutan" type="number" id="urutan" max="11"/>
                    <x-input-form-component col="6" title="Lokasi" id="lokasi"/>
                    <x-input-form-component col="6" title="Latitude" type="number" step="any" id="latitude" required="false"/>
                    <x-input-form-component col="6" title="Longitude" type="number" step="any" id="longitude" required="false"/>
                    <x-input-form-component col="6" title="Status" type="drop-down" id="status" :options="(object)[(object)['id' => 'publish', 'name' => 'publish'], (object)['id' => 'draft', 'name' => 'Draft']]"/>
                    <div class="col-12">
                        <label for="map" class="form-label">Pilih Lokasi di Peta</label>
                        <div id="map" style="height: 400px; width: 100%; border: 1px solid #ddd; border-radius: 8px;"></div>
                        <small class="text-muted">Klik pada peta untuk menentukan lokasi villa</small>
                    </div>
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

    @push('js')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script>
            let map;
            let marker;

            // Initialize map when modal is shown
            $('#modal-create').on('shown.bs.modal', function() {
                initializeMap();
            });

            function initializeMap() {
                // Default coordinates (Indonesia center)
                const defaultLat = -7.7956;
                const defaultLng = 110.3695;

                // Initialize map if not already initialized
                if (!map) {
                    map = L.map('map').setView([defaultLat, defaultLng], 8);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap contributors'
                    }).addTo(map);

                    // Add click event to map
                    map.on('click', function(e) {
                        const lat = e.latlng.lat;
                        const lng = e.latlng.lng;

                        // Update form fields
                        $('#latitude').val(lat.toFixed(8));
                        $('#longitude').val(lng.toFixed(8));

                        // Update or create marker
                        updateMarker(lat, lng);
                    });
                }
            }

            function updateMarker(lat, lng) {
                // Remove existing marker
                if (marker) {
                    map.removeLayer(marker);
                }

                // Create new marker
                marker = L.marker([lat, lng]).addTo(map)
                    .bindPopup(`<b>Lokasi Villa</b><br>Lat: ${lat.toFixed(6)}<br>Lng: ${lng.toFixed(6)}`)
                    .openPopup();

                // Center map on marker
                map.setView([lat, lng], 15);
            }

            // Update marker when latitude/longitude fields change
            $('#latitude, #longitude').on('input', function() {
                const lat = parseFloat($('#latitude').val());
                const lng = parseFloat($('#longitude').val());

                if (!isNaN(lat) && !isNaN(lng) && lat >= -90 && lat <= 90 && lng >= -180 && lng <= 180) {
                    updateMarker(lat, lng);
                }
            });

            // Reset map when modal is hidden
            $('#modal-create').on('hidden.bs.modal', function() {
                if (map) {
                    map.remove();
                    map = null;
                    marker = null;
                }
            });
        </script>
    @endpush
</x-app-layout>