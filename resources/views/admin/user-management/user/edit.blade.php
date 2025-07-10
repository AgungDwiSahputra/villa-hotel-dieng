@push('js')
    <script>
        function edit(id) {
            $('#form')[0].reset();
            $('.modal-title').text('Edit User');
            var url = "{{ route('admin.user-management.user.edit',":id") }}";
            url     = url.replace(':id', id);
            $.get(url, function (data) {
                $('#id').val(data.data.id);
                $('#name').val(data.data.name);
                $('#email').val(data.data.email);
                $('#role').val(data.role).change();
                $('#modal-create').modal('show');
            });
        }
    </script>
@endpush