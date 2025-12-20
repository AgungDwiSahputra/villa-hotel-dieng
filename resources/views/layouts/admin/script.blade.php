<!-- JAVASCRIPT -->
<script src="{{ asset('assets/libs/jquery/jquery.min.js')}}"></script>
<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('assets/libs/metismenu/metisMenu.min.js')}}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{ asset('assets/libs/node-waves/waves.min.js')}}"></script>

<!-- apexcharts -->
<script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>

<!-- App js -->
<script src="{{ asset('assets/js/app.js')}}"></script>

<!-- dashboard init - moved after app.js to ensure all dependencies are loaded -->
<script src="{{ asset('assets/js/pages/dashboard.init.js')}}"></script>

<!-- Required datatable js -->
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<!-- Buttons examples - ensure correct loading order -->
<script src="{{ asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js')}}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}"></script>

<!-- Export dependencies -->
<script src="{{ asset('assets/libs/jszip/jszip.min.js')}}"></script>
<script src="{{ asset('assets/libs/pdfmake/build/pdfmake.min.js')}}"></script>
<script src="{{ asset('assets/libs/pdfmake/build/vfs_fonts.js')}}"></script>

<script src="{{ asset('assets/libs/leaflet/leaflet.js')}}"></script>
<script src="{{ asset('assets/js/pages/leaflet-us-states.js')}}"></script>
{{-- <script src="{{ asset('assets/js/pages/leaflet-map.init.js')}}"></script> --}}
<script src="{{ asset('assets/libs/tinymce/tinymce.min.js')}}"></script>
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
<script src="{{ asset('assets/libs/toastr/build/toastr.min.js')}}"></script>
<script src="{{ asset('assets/libs/select2/js/select2.min.js')}}"></script>
<script src="{{ asset('assets/libs/spectrum-colorpicker2/spectrum.min.js')}}"></script>
<script src="{{ asset('assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js')}}"></script>

@include('layouts.admin.custom-script')

@stack('js')

<!-- Ensure all DataTables extensions are properly initialized -->
<script>
// Wait for all DataTables components to be loaded
document.addEventListener('DOMContentLoaded', function() {
    // Check if DataTables and buttons are loaded
    if (typeof jQuery !== 'undefined' && jQuery.fn.DataTable && jQuery.fn.DataTable.Buttons) {
        // Ensure print button type is available
        if (jQuery.fn.DataTable.Buttons.type) {
            jQuery.fn.DataTable.Buttons.type('print', 'print');
        }
        
        // Reinitialize DataTables with proper button extensions
        if (window.promoDataTableInitialized) {
            // Refresh any existing DataTables instances
            jQuery('.dataTable').each(function() {
                if (jQuery(this).DataTable().initialized) {
                    const api = jQuery(this).DataTable();
                    api.rows().invalidate().draw();
                }
            });
        }
    }
});
</script>