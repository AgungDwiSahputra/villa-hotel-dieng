@push('js')
    <script>
        function edit(id) {
            $('#form')[0].reset();
            $('.modal-title').text('Edit Fasilitas');
            var url = "{{ route('admin.produk.fasilitas.edit',":id") }}";
            url     = url.replace(':id', id);
            $.get(url, function (data) {
                $('#id').val(data.data.id);
                $('#name').val(data.data.name);
                $('#modal-create').modal('show');
            });
        }
    </script>
@endpush