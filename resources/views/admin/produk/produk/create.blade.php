@push('js')
    <script>
        function create(){
            $('#modal-create').modal('show');
            $('.modal-title').text('Create Produk');
            $('#id').val(null);
            $('.select2').val(null).change();
            $('#form')[0].reset();
            $('#latitude').val('');
            $('#longitude').val('');
        }
        
        $("#form").submit(function(event) {
            event.preventDefault();
            $('#btncreate').text('Saving ...').attr('disabled', true);

            let formData = new FormData(this);
            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: "{{ route('admin.produk.produk.store') }}",
                type: 'POST', dataType: 'JSON', processData: false, contentType: false, cache: false, data: formData,
                success: function (data) {
                    Swal.fire({ icon: 'success', title: 'Successfully',  text: "Data Saved Successfully", showConfirmButton: false, timer: 2000});
                    $('#modal-create').modal('hide');
                    $('#btncreate').text('Save').attr('disabled', false);
                    $('#form')[0].reset();
                    $('#table').DataTable().ajax.reload(null, false);
                },
                error: function (data) {
                    Swal.fire({icon: 'error', title: data.responseJSON.message, showConfirmButton: true});
                    $('#btncreate').text('Save').attr('disabled', false);
                },
            });
        });
    </script>
@endpush