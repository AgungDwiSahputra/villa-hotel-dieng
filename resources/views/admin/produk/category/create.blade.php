@push('js')
    <script>
        function create(){
            $('#modal-create').modal('show');
            $('.modal-title').text('Create Produk Category');
            $('#id').val(null);
            $('.select2').val(null).change();
            $('#form')[0].reset();
        }
        
        $("#form").submit(function(event) {
            event.preventDefault();
            $('#btncreate').text('Saving ...').attr('disabled', true);

            $.ajax({
                url: "{{ route('admin.produk.category.store') }}",
                type: 'POST', dataType: 'JSON', processData: false, contentType: false, cache: false, data: new FormData(this),
                success: function (data) {
                    Swal.fire({ icon: 'success', title: 'Successfully',  text: "Data Saved Successfully", showConfirmButton: false, timer: 2000});
                    $('#modal-create').modal('hide');
                    $('#btncreate').text('Save').attr('disabled', false);
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