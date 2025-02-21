@extends('layouts.master')

@section('title')
{{ __('products.Product') }}
@endsection
@section('content')
    <div class="container py-3 px-4">
        <div class="card py-3 px-4">
            <div class="d-flex justify-content-between  py-2">
                <h2>{{ __('products.Product Return') }}</h2>
                <div class="">
                    {{-- <a href="{{ route('product.create') }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>{{ __('products.Create') }}</a> --}}
                </div>
            </div>
            
            @include('message')
            <div class="table-responsive">
                {!! $dataTable->table(['class' => 'table ']) !!}
            </div>
        </div>
    </div>
    @include('datatable-scripts')
    {!! $dataTable->scripts() !!}

@endsection

@section('script')
    
    <script>
//         $(".delete").click(function(e){
//         e.preventDefault();
//         action= $(this).closest("form").attr('action');
//         id = this.id;
// alert(id)
//         swal({
//         title: "Are you sure?",
//         text: "You will not be able to recover this data!",
//         type: "warning",
//         showCancelButton: true,
//         confirmButtonColor: "#DD6B55",
//         confirmButtonText: "Yes, delete it!",
//         closeOnConfirm: false
//         }).then(isConfirmed => {
//         if(isConfirmed) {

//             $.ajaxSetup({
//                     headers: {
//                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                     }
//                 });
//                 $.ajax({
//                     type: 'DELETE', // Just delete Latter Capital Is Working Fine
//                     dataType: "JSON",
//                     url: action,
//                     data:{'action':'delete'},
//                     success: function(data) {
//                         if(data.error == true){
//                             swal("Deleted!", "Your Product has been deleted.", "success");
//                             $("#record"+parseInt(id)).remove();
//                             $('#users-table').DataTable().ajax.reload(null, false); 
                            
//                             // LaravelDataTables["users-table"].ajax.reload();
//                         }
//                         else{
//                             swal("Deleted!", data.message, "danger");
//                         }
                    



//                     },
//                     error:function(){
//                         swal("Deleted!", "Invalid Product.", "danger");
//                     }
//                 });



//         //   window.location.href =action
//         }
//         });
//         });
    </script>

@endsection

