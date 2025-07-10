@push('js')
    <script>
        function edit(id) {
            $('#form')[0].reset();
            $('.modal-title').text('Edit Category');
            var url = "{{ route('admin.produk.category.edit',":id") }}";
            url     = url.replace(':id', id);
            $.get(url, function (data) {
                $('#id').val(data.data.id);
                $('#name').val(data.data.name);
                $('#urutan').val(data.data.urutan);
                $('#modal-create').modal('show');
            });
        }
    </script>
@endpush