@push('js')
    <script>
        function edit(id) {
            $('#form')[0].reset();
            $('.modal-title').text('Edit Rekening ');
            var url = "{{ route('admin.rekening.edit',":id") }}";
            url     = url.replace(':id', id);
            $.get(url, function (data) {
                $('#id').val(data.data.id);
                $('#bank').val(data.data.bank);
                $('#name').val(data.data.name);
                $('#no_rekening').val(data.data.no_rekening);
                $('#modal-create').modal('show');
            });
        }
    </script>
@endpush