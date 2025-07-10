@push('js')
    <script>
        function konfirmasi(id,status){
            console.log(id);
            console.log(status);
            $.ajax({
                url: "{{ route('admin.transaksi.transaksi.store') }}",
                type: 'POST', dataType: 'JSON', data: {id:id,status:status},
                success: function (data) {
                    Swal.fire({ icon: 'success', title: 'Successfully',  text: "Data Status "+status+" Successfully", showConfirmButton: false, timer: 2000});
                    $('#table').DataTable().ajax.reload(null, false);
                },
                error: function (data) {
                    Swal.fire({icon: 'error', title: data.responseJSON.message, showConfirmButton: true});
                },
            });
        }
    </script>
@endpush