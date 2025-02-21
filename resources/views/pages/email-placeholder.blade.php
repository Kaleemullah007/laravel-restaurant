@extends('layouts.master')

@section('title')
Placeholders
@endsection
@section('content')
    <div class="container">
        <div class="container">
            <div class="row pt-3">
                <div class="col-12">
                    <h4>{{__('en.Placeholders')}}</h4>
                </div>
            </div>
            <hr>
            <div class="row p-3">
                <div class="col-12 shadow-css">
                    {{-- form for email placeholder --}}
                    <form method="POST" action="">
                        <div class="row pt-2">
                            <div class="col-lg-4 col-md-6 col-12 mt-3">
                                <label for="name" class="form-label fs-6">{{__('en.Name')}}</label>
                                <div class="d-flex">
                                    <input type="text" class="form-control border-secondary @error('name') is-invalid @enderror" id="name" name="name"
                                    placeholder="Name" value="{{ old('name') }}" autocomplete="name" required>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <button type="button" class="btn btn-success ms-3"><i class="bi bi-plus-lg"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- save button row included below -->
                            @include('pages.table-footer')
                        </div>
                    </form>
                    {{-- end form email placeholder --}}                    
                </div>
            </div>

        </div>
    </div>

@endsection
