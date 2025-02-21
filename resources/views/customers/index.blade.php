@extends('layouts.master')

@section('title')
{{ __('users.User Listing')}}
@endsection
@section('content')
<div class="container py-3 px-4">
    <div class="card py-3 px-4">
        <div class="d-flex justify-content-between py-2">
            <h2>{{ __('users.Users') }}</h2>
            <div class="">
                {{-- <a href="{{ route('customer.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-circle me-2"></i>{{ __('users.create') }}</a> --}}
            </div>
        </div>
        <div id="loader1" style="display:none;">
            <img src="{{ asset('assets/images/big/img1.jpg') }}" alt="Loading..." />
        </div>
        <div class="table-responsive">
            {!! $dataTable->table(['class' => 'table ']) !!}
        </div>
    </div>
</div>
@include('datatable-scripts')
{!! $dataTable->scripts() !!}
@endsection
