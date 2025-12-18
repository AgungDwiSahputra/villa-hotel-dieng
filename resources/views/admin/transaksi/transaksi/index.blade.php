<x-app-layout title="Transaksi" subTitle="Transaksi">
    <x-card-component col="12" title="Data Transaksi" :dataTable="$dataTable"/>

    @include('admin.transaksi.transaksi.create')
</x-app-layout>

@push('js')
<script>
    function konfirmasi(id, status) {
        const statusText = status === 'success' ? 'Approve' : 'Reject';

        Swal.fire({
            title: 'Are you sure?',
            text: `Do you want to ${statusText.toLowerCase()} this transaction?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: status === 'success' ? '#28a745' : '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: `Yes, ${statusText}!`
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('admin.transaksi.transaksi.store') }}",
                    type: 'POST',
                    dataType: 'JSON',
                    data: { id: id, status: status, _token: '{{ csrf_token() }}' },
                    success: function (data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: `Transaction ${statusText}d successfully`,
                            showConfirmButton: false,
                            timer: 2000
                        });
                        $('#table').DataTable().ajax.reload(null, false);
                    },
                    error: function (data) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: data.responseJSON?.message || 'Something went wrong',
                            showConfirmButton: true
                        });
                    },
                });
            }
        });
    }
</script>
@endpush