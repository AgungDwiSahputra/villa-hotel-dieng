<script>
    $(document).ready(function () {
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif

        @if (session('success'))
            toastr.success('{{ session('success') }}');
        @endif

        $(".max-length").maxlength({
            warningClass: "badge bg-info",
            limitReachedClass: "badge bg-warning"
        });

        $(".color").spectrum({ showInitial: !0, showInput: !0 });

        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        });

        $('body').on('click', '.delete-item', function(e) {
            e.preventDefault()
            let url = $(this).data('url');
            let tableId = $(this).data('tableid');
            Swal.fire({
                title: 'Are you sure?',
                text: "You will delete this data!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        method: 'DELETE',
                        url: url,
                        success: function(response) {
                            Swal.fire({ icon: 'success', title: 'Successfully',  text: "Data Deleted Successfully", showConfirmButton: false, timer: 2000});
                            $('#'+tableId).DataTable().ajax.reload(null, false);
                        },
                        error: function(error) {
                            Swal.fire({icon: 'error', title: error.responseJSON.message, showConfirmButton: true});
                        }
                    })
                }
            })
        });

        $('.modal').on('shown.bs.modal', function () {
            $(this).find('.select2').select2({
                dropdownParent: $(this)
            });
        });

        $('.select-filter').select2();
        
        $('#date_range').daterangepicker({
            locale: {
                format: 'DD-MM-YYYY'
            }
        });

        //Dark Mode
        if($('#dark-mode-switch').is(':checked')){
            $('body').addClass('dark-mode');
        }

        $('#light-mode-switch').on('change', function() {
            if ($(this).is(':checked')) {
                $('body').removeClass('dark-mode');
            }
        }); 

        $('#dark-mode-switch').on('change', function() {
            if ($(this).is(':checked')) {
                $('body').addClass('dark-mode');
            } else {
                $('body').removeClass('dark-mode');
            }
        });
    });

    function showImage(file,name) {
        $('.modal-title').text(name);
        var res = "{{ asset('storage/') }}/" + file;
        document.getElementById('show-image').src = res;
        $('#modal-image').modal('show');
    }
</script>