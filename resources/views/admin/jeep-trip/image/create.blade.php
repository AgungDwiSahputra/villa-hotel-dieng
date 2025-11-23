@push('js')
    <script>
        function create(){
            $('#modal-create').modal('show');
            $('.modal-title').text('Tambah Gambar Jeep Trip');
            $('#id').val(null);
            $('.select2').val(null).change();
            $('#form')[0].reset();
        }

        $("#form").submit(function(event) {
            event.preventDefault();
            $('#btncreate').text('Menyimpan ...').attr('disabled', true);

            $.ajax({
                url: "{{ route('admin.jeep-trip.image.store') }}",
                type: 'POST', dataType: 'JSON', processData: false, contentType: false, cache: false, data: new FormData(this),
                success: function (data) {
                    Swal.fire({ icon: 'success', title: 'Berhasil',  text: "Data Berhasil Disimpan", showConfirmButton: false, timer: 2000});
                    $('#modal-create').modal('hide');
                    $('#btncreate').text('Simpan').attr('disabled', false);
                    $('#jeep-trip-image-table').DataTable().ajax.reload(null, false);
                },
                error: function (data) {
                    Swal.fire({icon: 'error', title: data.responseJSON.message, showConfirmButton: true});
                    $('#btncreate').text('Simpan').attr('disabled', false);
                },
            });
        });
    </script>
@endpush