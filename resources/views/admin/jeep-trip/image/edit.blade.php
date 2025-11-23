@push('js')
    <script>
        function editData(id) {
            $('#form')[0].reset();
            $('.modal-title').text('Edit Gambar Jeep Trip');
            var url = "{{ route('admin.jeep-trip.image.edit',":id") }}";
            url = url.replace(':id', id);
            $.get(url, function (data) {
                $('#id').val(data.data.id);
                $('#judul').val(data.data.judul || '');
                $('#urutan').val(data.data.urutan);
                $('#modal-create').modal('show');
            });
        }

        function deleteData(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ route('admin.jeep-trip.image.destroy',":id") }}";
                    url = url.replace(':id', id);

                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function (data) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Data berhasil dihapus',
                                showConfirmButton: false,
                                timer: 2000
                            });
                            $('#jeep-trip-image-table').DataTable().ajax.reload(null, false);
                        },
                        error: function (data) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.responseJSON.message || 'Terjadi kesalahan saat menghapus data'
                            });
                        }
                    });
                }
            });
        }
    </script>
@endpush