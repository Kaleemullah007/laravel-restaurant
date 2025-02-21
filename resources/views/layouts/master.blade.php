<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

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

    <title>@yield('title','Admin panel')</title>

    <!-- Scripts -->
 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js" defer></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}" defer></script>
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/switch/js/switch.min.js') }}" defer></script>
    <script src="{{ asset('assets/libs/select2/dist/js/select2.full.min.js') }}" defer></script>
    <script src="{{ asset('assets/libs/custom/js/custom.js') }}" defer></script>
    <script src="{{ asset('assets/libs/chart/apexcharts/apexcharts.min.js') }}" defer></script>
    <script src="{{ asset('assets/libs/chart/chart.js') }}" defer></script>
    {{-- <script src="{{ asset('assets/libs/datatable/datatables.min.js') }}" defer></script> --}}

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" defer></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap/dist/css/bootstrap.min.css') }}?v={{ time() }}">

    <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap-icons/bootstrap-icons.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/switch/css/switch.min.css') }}"?v={{ time() }}>
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}"?v={{ time() }}>
    <link rel="stylesheet" href="{{ asset('assets/libs/custom/css/custom.css') }}"?v={{ time() }}>
    <link rel="stylesheet" href="{{ asset('assets/libs/custom/css/sass.css') }}"?v={{ time() }}>
    <link rel="stylesheet" href="{{ asset('assets/libs/custom/css/custom2.css') }}"?v={{ time() }}>
    <link rel="stylesheet" href="{{ asset('assets/libs/custom/css/layout.css') }}"?v={{ time() }}>
    <link rel="stylesheet" href="{{ asset('assets/libs/custom/css/responsive.css') }}"?v={{ time() }}>
    <link rel="stylesheet" href="{{ asset('assets/libs/chart/apexcharts/apexcharts.css') }}"?v={{ time() }}>
    <link rel="stylesheet" href="{{ asset('assets/libs/datatable/datatables.min.css') }}"?v={{ time() }}>
    <link rel="stylesheet" href="{{ asset('assets/css/custom-bootstrap.css') }}"?v={{ time() }}>

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>
    <div id="app">


        @include('layouts.navbar')
        @include('layouts.sidebar')


        <main class="pt-4">
            @yield('content')
        </main>

        @include('layouts.footer')

    </div>
</body>
<script>
    $(document).on("click",".delete",function(e){
      e.preventDefault();
      action= $(this).closest("form").attr('action');
      id = this.id;

    swal({
    title: "Are you sure?",
    text: "You will not be able to recover this data!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Yes, delete it!",
    closeOnConfirm: false
    }).then(isConfirmed => {
    if(isConfirmed) {

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'DELETE', // Just delete Latter Capital Is Working Fine
                dataType: "JSON",
                url: action,
                data:{'action':'delete'},
                success: function(data) {
                    if(data.error == true){
                        swal("Deleted!", "Your Product has been deleted.", "success");
                        $("#record"+parseInt(id)).remove();
                        $('#users-table').DataTable().ajax.reload(null, false); 
                        
                        //$("#record"+id).remove();
                    }
                    else{
                        swal("Deleted!", data.message, "danger");
                    }
                



                },
                error:function(){
                    swal("Deleted!", "Invalid Product.", "danger");
                }
            });



    //   window.location.href =action
    }
    });
    });
</script>

@yield('script')



</html>
