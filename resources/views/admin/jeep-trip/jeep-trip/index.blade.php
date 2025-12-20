<x-app-layout title="Jeep Trip" subTitle="Paket Jeep Trip">
    @push('css')
        <style>
            .dynamic-field {
                margin-bottom: 10px;
            }
            .dynamic-field .input-group {
                margin-bottom: 5px;
            }
            .slot-item {
                border: 1px solid #dee2e6;
                border-radius: 8px;
                padding: 15px;
                margin-bottom: 15px;
                background-color: #f8f9fa;
            }
        </style>
    @endpush

    <x-card-component col="12" title="Data Paket Jeep Trip" :dataTable="$dataTable">
        @can('Jeep Trip (Create)')
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-primary waves-effect btn-label waves-light" onclick="create()">
                    <i class="bx bx-plus label-icon"></i> Tambah Paket
                </button>
            </div>
        @endcan
    </x-card-component>

    @slot('modal')
        <x-modal-component id="modal-create" type="xl">
            <form id="form" enctype="multipart/form-data">
                <div class="row">
                    <input type="hidden" id="id" name="id">

                    <!-- Basic Information -->
                    <div class="col-12">
                        <h5 class="mb-3">Informasi Dasar</h5>
                    </div>

                    <x-input-form-component col="6" title="Kode Paket" id="kode" required="false" placeholder="Opsional"/>
                    <x-input-form-component col="6" title="Nama Paket" id="nama_paket"/>
                    <x-input-form-component col="6" title="Zona" id="zona" required="false" placeholder="sunrise, favorit, dll"/>
                    <x-input-form-component col="6" title="Durasi (Jam)" type="number" id="durasi_jam" required="false" min="1" max="24"/>
                    <x-input-form-component col="6" title="Rating" type="number" step="0.1" max="5" id="rating" required="false"/>
                    <x-input-form-component col="6" title="Kapasitas Ideal per Jeep" type="number" id="kapasitas_ideal_per_jeep" min="1" max="10"/>
                    <x-input-form-component col="6" title="Kapasitas Maksimal per Jeep" type="number" id="kapasitas_max_per_jeep" min="1" max="10"/>
                    <x-input-form-component col="6" title="Harga Weekday" type="number" id="harga_weekday"/>
                    <x-input-form-component col="6" title="Harga Weekend" type="number" id="harga_weekend"/>
                    <x-input-form-component col="6" title="Status" type="drop-down" id="is_active" :options="(object)[(object)['id' => '1', 'name' => 'Aktif'], (object)['id' => '0', 'name' => 'Tidak Aktif']]"/>
                    <x-input-form-component col="12" title="Deskripsi Singkat" type="textarea" id="deskripsi_singkat" required="false" rows="2"/>
                    <x-input-form-component col="12" title="Deskripsi Lengkap" type="textarea" id="deskripsi_lengkap" required="false" rows="4"/>

                    <!-- Destinations -->
                    <div class="col-12 mt-4">
                        <h5 class="mb-3">Destinasi Trip</h5>
                        <div id="destinations-container">
                            <div class="dynamic-field destination-item">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="destinations[0][nama_destinasi]" placeholder="Nama destinasi">
                                    <button type="button" class="btn btn-danger remove-destination" style="display: none;">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-destination">
                            <i class="bx bx-plus"></i> Tambah Destinasi
                        </button>
                    </div>

                    <!-- Includes -->
                    <div class="col-12 mt-4">
                        <h5 class="mb-3">Include (Termasuk dalam Paket)</h5>
                        <div id="includes-container">
                            <div class="dynamic-field include-item">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="includes[0][nama_item]" placeholder="Item yang termasuk">
                                    <button type="button" class="btn btn-danger remove-include" style="display: none;">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-include">
                            <i class="bx bx-plus"></i> Tambah Include
                        </button>
                    </div>

                    <!-- Excludes -->
                    <div class="col-12 mt-4">
                        <h5 class="mb-3">Exclude (Tidak Termasuk)</h5>
                        <div id="excludes-container">
                            <div class="dynamic-field exclude-item">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="excludes[0][nama_item]" placeholder="Item yang tidak termasuk">
                                    <button type="button" class="btn btn-danger remove-exclude" style="display: none;">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-exclude">
                            <i class="bx bx-plus"></i> Tambah Exclude
                        </button>
                    </div>


                    <!-- Slots -->
                    <div class="col-12 mt-4">
                        <h5 class="mb-3">Slot Waktu</h5>
                        <div id="slots-container">
                            <div class="slot-item">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label">Nama Slot</label>
                                        <input type="text" class="form-control" name="slots[0][nama_slot]" placeholder="Contoh: Sunrise">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Jam Mulai</label>
                                        <input type="time" class="form-control" name="slots[0][jam_mulai]">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Jam Selesai</label>
                                        <input type="time" class="form-control" name="slots[0][jam_selesai]">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Aktif</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="slots[0][is_active]" value="1" checked>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <button type="button" class="btn btn-danger btn-sm remove-slot" style="display: none;">
                                        <i class="bx bx-trash"></i> Hapus Slot
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-slot">
                            <i class="bx bx-plus"></i> Tambah Slot
                        </button>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" id="btncreate">Simpan</button>
                    </div>
                </div>
            </form>
        </x-modal-component>
    @endslot

    @push('js')
        <script>
            let destinationIndex = 1;
            let includeIndex = 1;
            let excludeIndex = 1;
            let slotIndex = 1;

            // Add destination
            $('#add-destination').click(function() {
                const html = `
                    <div class="dynamic-field destination-item">
                        <div class="input-group">
                            <input type="text" class="form-control" name="destinations[${destinationIndex}][nama_destinasi]" placeholder="Nama destinasi">
                            <button type="button" class="btn btn-danger remove-destination">
                                <i class="bx bx-trash"></i>
                            </button>
                        </div>
                    </div>
                `;
                $('#destinations-container').append(html);
                destinationIndex++;
                $('.remove-destination').show();
            });

            // Remove destination
            $(document).on('click', '.remove-destination', function() {
                $(this).closest('.destination-item').remove();
                if ($('.destination-item').length === 1) {
                    $('.remove-destination').hide();
                }
            });

            // Add include
            $('#add-include').click(function() {
                const html = `
                    <div class="dynamic-field include-item">
                        <div class="input-group">
                            <input type="text" class="form-control" name="includes[${includeIndex}][nama_item]" placeholder="Item yang termasuk">
                            <button type="button" class="btn btn-danger remove-include">
                                <i class="bx bx-trash"></i>
                            </button>
                        </div>
                    </div>
                `;
                $('#includes-container').append(html);
                includeIndex++;
                $('.remove-include').show();
            });

            // Remove include
            $(document).on('click', '.remove-include', function() {
                $(this).closest('.include-item').remove();
                if ($('.include-item').length === 1) {
                    $('.remove-include').hide();
                }
            });

            // Add exclude
            $('#add-exclude').click(function() {
                const html = `
                    <div class="dynamic-field exclude-item">
                        <div class="input-group">
                            <input type="text" class="form-control" name="excludes[${excludeIndex}][nama_item]" placeholder="Item yang tidak termasuk">
                            <button type="button" class="btn btn-danger remove-exclude">
                                <i class="bx bx-trash"></i>
                            </button>
                        </div>
                    </div>
                `;
                $('#excludes-container').append(html);
                excludeIndex++;
                $('.remove-exclude').show();
            });

            // Remove exclude
            $(document).on('click', '.remove-exclude', function() {
                $(this).closest('.exclude-item').remove();
                if ($('.exclude-item').length === 1) {
                    $('.remove-exclude').hide();
                }
            });

            // Add slot
            $('#add-slot').click(function() {
                const html = `
                    <div class="slot-item">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label">Nama Slot</label>
                                <input type="text" class="form-control" name="slots[${slotIndex}][nama_slot]" placeholder="Contoh: Sunrise">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Jam Mulai</label>
                                <input type="time" class="form-control" name="slots[${slotIndex}][jam_mulai]">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Jam Selesai</label>
                                <input type="time" class="form-control" name="slots[${slotIndex}][jam_selesai]">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Aktif</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="slots[${slotIndex}][is_active]" value="1" checked>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="button" class="btn btn-danger btn-sm remove-slot">
                                <i class="bx bx-trash"></i> Hapus Slot
                            </button>
                        </div>
                    </div>
                `;
                $('#slots-container').append(html);
                slotIndex++;
                $('.remove-slot').show();
            });

            // Remove slot
            $(document).on('click', '.remove-slot', function() {
                $(this).closest('.slot-item').remove();
                if ($('.slot-item').length === 1) {
                    $('.remove-slot').hide();
                }
            });


            // Form submission
            $('#form').submit(function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const url = formData.get('id') ? `/admin/jeep-trip/${formData.get('id')}` : '/admin/jeep-trip';
                const method = formData.get('id') ? 'POST' : 'POST';

                if (formData.get('id')) {
                    formData.append('_method', 'PUT');
                }

                $('#btncreate').prop('disabled', true).text('Menyimpan...');

                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status) {
                            $('#modal-create').modal('hide');
                            $('#jeep-trip-table').DataTable().ajax.reload();
                            toastr.success(response.message || 'Data berhasil disimpan');
                            $('#form')[0].reset();
                            resetForm();
                        } else {
                            toastr.error(response.message || 'Terjadi kesalahan');
                        }
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON?.errors;
                        if (errors) {
                            let errorMessage = 'Validation Error:\n';
                            Object.keys(errors).forEach(key => {
                                errorMessage += `- ${errors[key][0]}\n`;
                            });
                            toastr.error(errorMessage);
                        } else {
                            const errorMsg = xhr.responseJSON?.message;
                            toastr.error(errorMsg ? errorMsg : 'Terjadi kesalahan saat menyimpan data');
                        }
                    },
                    complete: function() {
                        $('#btncreate').prop('disabled', false).text('Simpan');
                    }
                });
            });

            function resetForm() {
                destinationIndex = 1;
                includeIndex = 1;
                excludeIndex = 1;
                slotIndex = 1;
                $('#destinations-container').html(`
                    <div class="dynamic-field destination-item">
                        <div class="input-group">
                            <input type="text" class="form-control" name="destinations[0][nama_destinasi]" placeholder="Nama destinasi">
                            <button type="button" class="btn btn-danger remove-destination" style="display: none;">
                                <i class="bx bx-trash"></i>
                            </button>
                        </div>
                    </div>
                `);
                $('#includes-container').html(`
                    <div class="dynamic-field include-item">
                        <div class="input-group">
                            <input type="text" class="form-control" name="includes[0][nama_item]" placeholder="Item yang termasuk">
                            <button type="button" class="btn btn-danger remove-include" style="display: none;">
                                <i class="bx bx-trash"></i>
                            </button>
                        </div>
                    </div>
                `);
                $('#excludes-container').html(`
                    <div class="dynamic-field exclude-item">
                        <div class="input-group">
                            <input type="text" class="form-control" name="excludes[0][nama_item]" placeholder="Item yang tidak termasuk">
                            <button type="button" class="btn btn-danger remove-exclude" style="display: none;">
                                <i class="bx bx-trash"></i>
                            </button>
                        </div>
                    </div>
                `);
                $('#slots-container').html(`
                    <div class="slot-item">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label">Nama Slot</label>
                                <input type="text" class="form-control" name="slots[0][nama_slot]" placeholder="Contoh: Sunrise">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Jam Mulai</label>
                                <input type="time" class="form-control" name="slots[0][jam_mulai]">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Jam Selesai</label>
                                <input type="time" class="form-control" name="slots[0][jam_selesai]">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Aktif</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="slots[0][is_active]" value="1" checked>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="button" class="btn btn-danger btn-sm remove-slot" style="display: none;">
                                <i class="bx bx-trash"></i> Hapus Slot
                            </button>
                        </div>
                    </div>
                `);
            }

            // Global functions for DataTable actions
            window.create = function() {
                $('#form')[0].reset();
                resetForm();
                $('#modal-create').modal('show');
            };

            window.editData = function(id) {
                $.get(`/admin/jeep-trip/${id}/edit`, function(data) {
                    populateForm(data.data);
                    $('#modal-create').modal('show');
                });
            };

            window.deleteData = function(id) {
                if (confirm('Apakah Anda yakin ingin menghapus paket Jeep Trip ini?')) {
                    // Show loading state
                    // toastr.info('Menghapus data...', '', {timeOut: 0});

                    $.ajax({
                        url: `/admin/jeep-trip/${id}`,
                        type: 'DELETE',
                        success: function(response) {
                            if (response.status) {
                                // Reload DataTable to reflect changes immediately
                                $('#jeep-trip-table').DataTable().ajax.reload(null, false);
                                toastr.clear();
                                toastr.success(response.message || 'Data berhasil dihapus');
                            } else {
                                toastr.clear();
                                toastr.error(response.message || 'Terjadi kesalahan');
                            }
                        },
                        error: function(xhr) {
                            toastr.clear();
                            const errorMsg = xhr.responseJSON?.message || 'Terjadi kesalahan saat menghapus data';
                            toastr.error(errorMsg);
                        }
                    });
                }
            };

            function populateForm(data) {
                $('#id').val(data.id);
                $('#kode').val(data.kode || '');
                $('#nama_paket').val(data.nama_paket);
                $('#zona').val(data.zona || '');
                $('#durasi_jam').val(data.durasi_jam || '');
                $('#rating').val(data.rating || '');
                $('#kapasitas_ideal_per_jeep').val(data.kapasitas_ideal_per_jeep);
                $('#kapasitas_max_per_jeep').val(data.kapasitas_max_per_jeep);
                $('#harga_weekday').val(data.harga_weekday);
                $('#harga_weekend').val(data.harga_weekend);
                $('#is_active').val(data.is_active ? '1' : '0');
                $('#deskripsi_singkat').val(data.deskripsi_singkat || '');
                $('#deskripsi_lengkap').val(data.deskripsi_lengkap || '');

                // Populate destinations
                $('#destinations-container').empty();
                if (data.destinations && data.destinations.length > 0) {
                    data.destinations.forEach((dest, index) => {
                        const showRemove = data.destinations.length > 1 ? '' : 'style="display: none;"';
                        const html = `
                            <div class="dynamic-field destination-item">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="destinations[${index}][nama_destinasi]" value="${dest.nama_destinasi}" placeholder="Nama destinasi">
                                    <button type="button" class="btn btn-danger remove-destination" ${showRemove}>
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </div>
                            </div>
                        `;
                        $('#destinations-container').append(html);
                    });
                }

                // Populate includes
                $('#includes-container').empty();
                if (data.includes && data.includes.length > 0) {
                    data.includes.forEach((item, index) => {
                        const showRemove = data.includes.length > 1 ? '' : 'style="display: none;"';
                        const html = `
                            <div class="dynamic-field include-item">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="includes[${index}][nama_item]" value="${item.nama_item}" placeholder="Item yang termasuk">
                                    <button type="button" class="btn btn-danger remove-include" ${showRemove}>
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </div>
                            </div>
                        `;
                        $('#includes-container').append(html);
                    });
                }

                // Populate excludes
                $('#excludes-container').empty();
                if (data.excludes && data.excludes.length > 0) {
                    data.excludes.forEach((item, index) => {
                        const showRemove = data.excludes.length > 1 ? '' : 'style="display: none;"';
                        const html = `
                            <div class="dynamic-field exclude-item">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="excludes[${index}][nama_item]" value="${item.nama_item}" placeholder="Item yang tidak termasuk">
                                    <button type="button" class="btn btn-danger remove-exclude" ${showRemove}>
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </div>
                            </div>
                        `;
                        $('#excludes-container').append(html);
                    });
                }

                // Populate slots
                $('#slots-container').empty();
                if (data.slots && data.slots.length > 0) {
                    data.slots.forEach((slot, index) => {
                        const checked = slot.is_active ? 'checked' : '';
                        const showRemove = data.slots.length > 1 ? '' : 'style="display: none;"';
                        const html = `
                            <div class="slot-item">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label">Nama Slot</label>
                                        <input type="text" class="form-control" name="slots[${index}][nama_slot]" value="${slot.nama_slot}" placeholder="Contoh: Sunrise">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Jam Mulai</label>
                                        <input type="time" class="form-control" name="slots[${index}][jam_mulai]" value="${slot.jam_mulai ? slot.jam_mulai.substring(0, 5) : ''}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Jam Selesai</label>
                                        <input type="time" class="form-control" name="slots[${index}][jam_selesai]" value="${slot.jam_selesai ? slot.jam_selesai.substring(0, 5) : ''}">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Aktif</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="slots[${index}][is_active]" value="1" ${checked}>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <button type="button" class="btn btn-danger btn-sm remove-slot" ${showRemove}>
                                        <i class="bx bx-trash"></i> Hapus Slot
                                    </button>
                                </div>
                            </div>
                        `;
                        $('#slots-container').append(html);
                    });
                }

            }
        </script>
    @endpush
</x-app-layout>