<div class="row">
    <div class="col-12">
        <a href="{{ asset('template/import/'.$template) }}">
            <button type="button" class="col-12 btn btn-warning waves-effect btn-label waves-light" title="Template Import User">
                <i class="bx bx-download label-icon"></i> Template Import
            </button>
        </a>
    </div>
    <div class="col-sm-12">
        <div class="mt-3">
            <input class="form-control" type="file" id="file-import">
            <small><span class="text-danger">*</span> Format file : xls, xlsx</small><br>
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-primary w-md" id="btnImport" style="float: right;" onclick="importData()">Import</button>
        </div>
    </div>
</div>

@push('js')
    <script>
        function importData() {
            var form = new FormData();
            form.append('file',$('#file-import').prop('files')[0]);
            $('#btnImport').text('Importing...').attr('disabled', true);
            $.ajax({
                url: "{{ route($route) }}",
                type: 'POST',
                dataType: 'JSON',
                processData: false,
                contentType: false,
                cache: false,
                data: form,
                success: function (data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Import Data Successfully',
                        showConfirmButton: true,
                        timer: 2000
                    });
                    $('#table').DataTable().ajax.reload(null, false);
                    $('#file-import').val(null);
                    $('#btnImport').text('Import').attr('disabled', false);
                },
                error: function (data) {
                    var error_messages = data.responseJSON.message;
                    Swal.fire({
                        icon: 'error',
                        title: error_messages,
                        showConfirmButton: true,
                    });
                    $('#btnImport').text('Import').attr('disabled', false);
                }
            });
        }
    </script>
@endpush