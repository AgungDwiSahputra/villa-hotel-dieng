@push('js')
    <script>
        function edit(id) {
            $('#form')[0].reset();
            $('.modal-title').text('Edit Permission');
            var url = "{{ route('admin.user-management.permission.edit',":id") }}";
            url     = url.replace(':id', id);
            $.get(url, function (data) {
                $('#id').val(data.data.id);
                $('#module').val(data.data.module);
                $('#module_action').val(data.data.module_action);
                $('#modal-create').modal('show');
            });
        }
    </script>
@endpush