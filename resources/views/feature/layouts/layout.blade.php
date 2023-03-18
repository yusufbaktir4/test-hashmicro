<!DOCTYPE html>
<html class="fixed sidebar-left-collapsed">
    <head>

        @include('feature.layouts.link_css_header')

        <style type="text/css">
            .datepicker-dropdown {
                z-index: 10000 !important;
            }
        </style>
    </head>

    <body>
        <section class="body">
            <!-- header -->
            @include('feature.layouts.header')

            <div class="inner-wrapper">
                @include('feature.layouts.menu')

                <!-- content -->
                @yield('content')
            </div>
        </section>

        <!-- Vendor -->
        <script src="{{ asset('template/vendor/jquery/jquery.js') }}"></script>
        <script src="{{ asset('template/vendor/jquery-browser-mobile/jquery.browser.mobile.js') }}"></script>
        <script src="{{ asset('template/vendor/popper/umd/popper.min.js') }}"></script>
        <script src="{{ asset('template/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('template/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>

        <script type="text/javascript">
            $(".datepicker").datepicker({
                format: "yyyy-mm-dd",
                todayHighlight: true,
                autoclose: true
            }).attr("readonly", "readonly").css({"cursor":"pointer", "background":"white"});
        </script>

        <script src="{{ asset('template/vendor/common/common.js') }}"></script>
        <script src="{{ asset('template/vendor/nanoscroller/nanoscroller.js') }}"></script>

        <!-- Specific Page Vendor -->
        <script src="{{ asset('template/vendor/jquery-ui/jquery-ui.js') }}"></script>
        <script src="{{ asset('template/vendor/jqueryui-touch-punch/jquery.ui.touch-punch.js') }}"></script>
        <script src="{{ asset('template/vendor/jquery-appear/jquery.appear.js') }}"></script>
        <script src="{{ asset('template/vendor/bootstrapv5-multiselect/js/bootstrap-multiselect.js') }}"></script>
        <script src="{{ asset('template/vendor/select2/js/select2.js') }}"></script>
        <script src="{{ asset('template/vendor/datatables/media/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('template/vendor/datatables/media/js/dataTables.bootstrap5.min.js') }}"></script>
        <script src="{{ asset('template/vendor/datatables/extras/TableTools/Buttons-1.4.2/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('template/vendor/datatables/extras/TableTools/Buttons-1.4.2/js/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('template/vendor/datatables/extras/TableTools/Buttons-1.4.2/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('template/vendor/datatables/extras/TableTools/Buttons-1.4.2/js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('template/vendor/datatables/extras/TableTools/JSZip-2.5.0/jszip.min.js') }}"></script>
        <script src="{{ asset('template/vendor/datatables/extras/TableTools/pdfmake-0.1.32/pdfmake.min.js') }}"></script>
        <script src="{{ asset('template/vendor/datatables/extras/TableTools/pdfmake-0.1.32/vfs_fonts.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        @yield('add_js')

        <script src="{{ asset('template/js/theme.js') }}"></script>

        <!-- Theme Custom -->
        <script src="{{ asset('template/js/custom.js') }}"></script>

        <!-- Theme Initialization Files -->
        <script src="{{ asset('template/js/theme.init.js') }}"></script>

        <script src="{{ asset('template/js/examples/examples.dashboard.js') }}"></script>

    </body>
</html>