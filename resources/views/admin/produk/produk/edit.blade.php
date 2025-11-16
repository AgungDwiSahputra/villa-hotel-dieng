@push('js')
    <script>
        function edit(id) {
            $('#form')[0].reset();
            $('.modal-title').text('Edit Produk');
            var url = "{{ route('admin.produk.produk.edit',":id") }}";
            url     = url.replace(':id', id);
            $.get(url, function (data) {
                $('#id').val(data.data.id);
                $('#category_id').val(data.data.category_id);
                $('#name').val(data.data.name);
                $('#unit').val(data.data.unit);
                $('#kamar').val(data.data.kamar);
                $('#orang').val(data.data.orang);
                $('#maks_orang').val(data.data.maks_orang);
                $('#lokasi').val(data.data.lokasi);
                $('#latitude').val(data.data.latitude);
                $('#longitude').val(data.data.longitude);
                $('#harga_weekday').val(data.data.harga_weekday);
                $('#harga_weekend').val(data.data.harga_weekend);
                $('#label').val(data.data.label);
                $('#urutan').val(data.data.urutan);

                // Update map marker if coordinates exist
                if (data.data.latitude && data.data.longitude) {
                    setTimeout(() => {
                        updateMarker(parseFloat(data.data.latitude), parseFloat(data.data.longitude));
                    }, 500);
                }
                $('#modal-create').modal('show');
            });
        }
    </script>
@endpush