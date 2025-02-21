@extends('layouts.master')

@section('title')
{{ __('expenses.Expenses') }}
@endsection
@section('content')
    <div class="container py-3 px-4">
        <div class="card py-3 px-4">
            <div class="d-flex justify-content-between py-2">
                <h2>{{ __('expenses.Expenses') }}</h2>
                <div class="">
                    {{-- <a href="{{ route('expense.create') }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>{{ __('expenses.Create') }}</a> --}}
                </div>
            </div>
            
            <div class="table-responsive">
                {!! $dataTable->table(['class' => 'table ']) !!}
            </div>    
        </div>
    </div>
    @include('datatable-scripts')
    {!! $dataTable->scripts() !!}
@endsection