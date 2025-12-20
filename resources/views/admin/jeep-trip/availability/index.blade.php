<x-app-layout title="Jeep Trip Availability" subTitle="Kelola Quota Jeep Trip">
    <x-card-component col="12" title="Data Availability Jeep Trip" :dataTable="$dataTable">
        @can('Jeep Trip Availability (Create)')
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-primary waves-effect btn-label waves-light" onclick="create()">
                    <i class="bx bx-plus label-icon"></i> Tambah Availability
                </button>
            </div>
        @endcan
    </x-card-component>

    @slot('modal')
        <x-modal-component id="modal-create" type="lg">
            <form id="form">
                <div class="row">
                    <input type="hidden" id="id" name="id">

                    <x-input-form-component col="12" title="Slot Jeep Trip" type="drop-down" id="jeep_trip_slot_id" :options="$slots"/>
                    <x-input-form-component col="6" title="Tanggal" type="date" id="tanggal"/>
                    <x-input-form-component col="6" title="Quota Jeep" type="number" id="quota_jeep" min="1" max="50"/>
                    <div class="col-12">
                        <div class="alert alert-info" id="availability-info" style="display: none;">
                            <strong>Informasi Availability:</strong><br>
                            <span id="quota-info"></span>
                        </div>
                    </div>
                    <x-input-form-component col="12" title="Status Tutup" type="drop-down" id="is_closed" :options="(object)[(object)['id' => '0', 'name' => 'Terbuka'], (object)['id' => '1', 'name' => 'Ditutup']]"/>

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
            // Reset button text when modal is hidden
            $('#modal-create').on('hidden.bs.modal', function () {
                $('#btncreate').text('Simpan');
            });
            // Form submission
            $('#form').submit(function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const url = formData.get('id') ? `/admin/jeep-trip/availability/${formData.get('id')}` : '/admin/jeep-trip/availability';
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
                            $('#jeep-trip-availability-table').DataTable().ajax.reload();
                            toastr.success(response.message || 'Data berhasil disimpan');
                            $('#form')[0].reset();
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

            // Global functions for DataTable actions
            window.create = function() {
                $('#form')[0].reset();
                $('#btncreate').text('Simpan');
                $('#availability-info').hide();
                $('#modal-create').modal('show');
            };

            window.editData = function(id) {
                $.get(`/admin/jeep-trip/availability/${id}/edit`, function(data) {
                    $('#id').val(data.data.id);
                    $('#jeep_trip_slot_id').val(data.data.jeep_trip_slot_id);
                    $('#tanggal').val(data.data.tanggal);
                    $('#quota_jeep').val(data.data.quota_jeep);
                    $('#is_closed').val(data.data.is_closed ? '1' : '0');

                    // Show availability information
                    const tersedia = data.data.quota_jeep - data.data.quota_terpakai;
                    $('#quota-info').html(`
                        Total Quota: ${data.data.quota_jeep}<br>
                        Sudah Terpakai: ${data.data.quota_terpakai}<br>
                        Tersedia: ${tersedia}<br>
                        Dibuat: ${new Date(data.data.created_at).toLocaleString('id-ID')}
                    `);
                    $('#availability-info').show();

                    // Update button text to show current usage
                    $('#btncreate').text(`Update (Terpakai: ${data.data.quota_terpakai}, Tersedia: ${tersedia})`);

                    $('#modal-create').modal('show');
                });
            };

            window.deleteData = function(id) {
                if (confirm('Apakah Anda yakin ingin menghapus availability ini?')) {
                    $.ajax({
                        url: `/admin/jeep-trip/availability/${id}`,
                        type: 'DELETE',
                        success: function(response) {
                            if (response.status) {
                                $('#jeep-trip-availability-table').DataTable().ajax.reload(null, false);
                                toastr.success(response.message || 'Data berhasil dihapus');
                            } else {
                                toastr.error(response.message || 'Terjadi kesalahan');
                            }
                        },
                        error: function(xhr) {
                            const errorMsg = xhr.responseJSON?.message || 'Terjadi kesalahan saat menghapus data';
                            toastr.error(errorMsg);
                        }
                    });
                }
            };
        </script>
    @endpush
</x-app-layout>