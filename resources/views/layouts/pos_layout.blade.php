<!doctype html>
<html lang="{{ str_replace('_', '-', app()->currentLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="keywords"
        content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, Matrix lite admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, Matrix admin lite design, Matrix admin lite dashboard bootstrap 5 dashboard template" />
    <meta name="description"
        content="Matrix Admin Lite Free Version is powerful and clean admin dashboard template, inpired from Bootstrap Framework" />
    <meta name="robots" content="noindex,nofollow" />

    <title>POS Screen</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/switch/css/switch.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/custom/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/custom/css/sass.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/custom/css/custom2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/custom/css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/custom/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/chart/apexcharts/apexcharts.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/datatable/datatables.min.css') }}">
    <!-- Styles -->





    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
</head>

<body>
@include('pages.customer-modal')

    <div id="app">

        
        {{-- <div class="d-flex justify-content-end">
            <a  href="{{ route('logout') }}"
                onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();" class="btn btn-info p-2">
                <span><i class="bi bi-box-arrow-left"></i></span>{{ __('en.Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div> --}}
        
        {{-- @include('layouts.navbar') --}}
        {{-- @include('layouts.sidebar') --}}


     
        <main class="">
            @yield('content')
        </main>
    </div>
    
    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}" ></script>
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}" ></script>
    <script src="{{ asset('assets/libs/switch/js/switch.min.js') }}" ></script>
    <script src="{{ asset('assets/libs/select2/dist/js/select2.full.min.js') }}" ></script>
    <script src="{{ asset('assets/libs/custom/js/custom.js') }}" ></script>
    <script src="{{ asset('assets/libs/chart/apexcharts/apexcharts.min.js') }}" ></script>
    <script src="{{ asset('assets/libs/chart/chart.js') }}" ></script>
    <script src="{{ asset('assets/libs/datatable/datatables.min.js') }}" ></script>



    @yield('script')
    <script>
        // Fullscreen function
        function toggleFullscreen() {
            // Check if full screen is supported and request fullscreen
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen().catch((err) => {
                    alert(`Error attempting to enable fullscreen mode: ${err.message} (${err.name})`);
                });
            } else {
                // If already in fullscreen, exit it
                document.exitFullscreen();
            }
        }

        // Add event listener to the button
        document.getElementById("fullscreen-btn").addEventListener("click", toggleFullscreen);
          
        
        $("#actionOne").on("submit", function (event) {
                      
                      event.preventDefault(); // Prevent default form submission
                      let action = $('#myForm').attr('action');
                      var formData = $(this).serialize();
                      alert("s");
                    //   $.ajaxSetup({
                    //       headers: {
                    //           "X-CSRF-TOKEN": $(
                    //               'meta[name="csrf-token"]'
                    //           ).attr("content"),
                    //       },
                    //   });
                      
                    //   $.ajax({
                    //       type: "POST",
                    //       url: action,
                    //       data: formData,
                    //       success: function (data) {
                    //        // $("#remaining_amount").text(0);
                    //        // $("#remaining_amount").text(0);
                    //        // $("#remaining_amount").text(0);
                    //        // $("#remaining_amount").text(0);
                    //        // $("#remaining_amount").text(0);
                    //        // $("#remaining_amount").text(0);
                    //        if(!data.error){
                    //            toastr.success('Your order has been placed successfully!', 'Success');
                    //            $('.setting > tr').remove();

                    //           $("#myForm")[0].reset();
                    //        }
                    //        else{
                    //            toastr.error('something went wrong');
                    //        }
                           
                    //       },
                    //   });
                  });
    </script>
    <script>
        function resetForm() {
                $("#total").text(0);
                    $("#paid_view").text(0);
                    $("#remaining").text(0);
                    $("#show_discount").text(0);
                    $("#tax_view").text(0);
                    $("#show_shipping").text(0);

                    $("#grand_view").text(0);
                    $("#sub_total").text(0);
                    $("#total_product_view").text(0);
                    
                        // toastr.success('Your order has been placed successfully!', 'Success');
                        $('.setting > tr').remove();

                        $("#myForm")[0].reset();
                        $('#user_id').val(null).trigger('change');
                        
        }
    </script>

    
</body>

</html>
