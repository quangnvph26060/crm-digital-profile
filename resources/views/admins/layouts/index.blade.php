<!doctype html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <title> @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('libs/assets/images/favicon.ico') }}">
    <script src="https://cdn.ckeditor.com/4.19.1/standard-all/ckeditor.js"></script>
    <!-- plugin css -->
    <link href="{{ asset('libs/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}"
        rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('libs/assets/css/root.css') }}" type="text/css" />
    <!-- preloader css -->
    <link rel="stylesheet" href="{{ asset('libs/assets/css/preloader.min.css') }}" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="{{ asset('libs/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('libs/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('libs/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />]
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    @yield('css')
</head>

<body>

    <!-- <body data-layout="horizontal"> -->
    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('admins.layouts.header')

        <!-- ========== Left Sidebar Start ========== -->
        @include('admins.layouts.left_sidebar')
        <!-- Left Sidebar End -->



        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            @yield('content')
            <!-- End Page-content -->


            @include('admins.layouts.footer')
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->


    <!-- Right Sidebar -->
    @include('admins.layouts.right_sidebar')
    <!-- /Right-bar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('libs/assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('libs/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('libs/assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('libs/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('libs/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('libs/assets/libs/feather-icons/feather.min.js') }}"></script>
    <!-- pace js -->
    <script src="{{ asset('libs/assets/libs/pace-js/pace.min.js') }}"></script>

    <!-- apexcharts -->
    <script src="{{ asset('libs/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Plugins js-->
    <script src="{{ asset('libs/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('libs/assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js') }}">
    </script>
    <!-- dashboard init -->
    {{-- <script src="{{asset('libs/assets/js/pages/dashboard.init.js')}}"></script> --}}

    <script src="{{ asset('libs/assets/js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(function() {
            $('.confirm').click(function(e) {
                e.preventDefault();
                var href = $(this).attr('href');
                Swal.fire({
                    title: 'Bạn có chắc chắn?',
                    showCancelButton: true,
                    icon: 'warning',
                    confirmButtonText: 'Đồng ý',
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        window.location.href = href;
                    }
                })
            })
        })
        $("input[data-type='currency']").on({
            keyup: function() {
                formatCurrency($(this));
            },
            blur: function() {
                formatCurrency($(this), "blur");
            }
        });


        function formatNumber(n) {
            // format number 1000000 to 1,234,567
            return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        }


        function formatCurrency(input, blur) {
            // appends $ to value, validates decimal side
            // and puts cursor back in right position.

            // get input value
            var input_val = input.val();

            // don't validate empty input
            if (input_val === "") {
                return;
            }

            // original length
            var original_len = input_val.length;

            // initial caret position
            var caret_pos = input.prop("selectionStart");

            // check for decimal
            if (input_val.indexOf(".") >= 0) {

                // get position of first decimal
                // this prevents multiple decimals from
                // being entered
                var decimal_pos = input_val.indexOf(".");

                // split number by decimal point
                var left_side = input_val.substring(0, decimal_pos);
                var right_side = input_val.substring(decimal_pos);

                // add commas to left side of number
                left_side = formatNumber(left_side);

                // validate right side
                right_side = formatNumber(right_side);

                // On blur make sure 2 numbers after decimal
                // if (blur === "blur") {
                // right_side += "00";
                // }

                // Limit decimal to only 2 digits
                right_side = right_side.substring(0, 2);

                // join number by .
                input_val = left_side + "." + right_side;

            } else {
                // no decimal entered
                // add commas to number
                // remove all non-digits
                input_val = formatNumber(input_val);
                input_val = input_val;

                // final formatting
                // if (blur === "blur") {
                // input_val += ".00";
                // }
            }

            // send updated string to input
            input.val(input_val);

            // put caret back in the right position
            var updated_len = input_val.length;
            caret_pos = updated_len - original_len + caret_pos;
            input[0].setSelectionRange(caret_pos, caret_pos);
        }
    </script>
    @yield('scripts')
</body>

</html>
