@extends('layouts.master')

@section('title')
Templates
@endsection
@section('content')
    <div class="container">
        <div class="container">
            <div class="row pt-3">
                <div class="col-12">
                    <h4>{{__('en.Templates')}}</h4>
                </div>
            </div>
            <hr>
            <div class="row p-3">
                <div class="col-12 shadow-css">
                    {{-- form for email Template --}}
                    <form method="POST" action="">
                        <div class="d-flex flex-column">
                            <div class="row mt-4">
                                <div class="col-lg-2 col-md-4 col-sm-4 col-12">
                                    <label for="name" class="form-label fs-6 mt-1">{{__('en.Name')}}</label>
                                </div>
                                <div class="col-lg-5 col-md-8 col-sm-8 col-12">
                                    <input type="text" class="form-control border-secondary @error('name') is-invalid @enderror" id="name" name="name"
                                    value="{{ old('name') }}" placeholder="Name" autocomplete="name" required>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-2 col-md-4 col-sm-4 col-12">
                                    <label for="subject" class="form-label fs-6">{{__('en.Subject')}}</label>
                                </div>
                                <div class="col-lg-5 col-md-8 col-sm-8 col-12">
                                    <input type="text" class="form-control border-secondary @error('subject') is-invalid @enderror" id="subject" name="subject"
                                    value="{{ old('subject') }}" placeholder="Subject" autocomplete="subject" required>
                                    @error('subject')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-lg-2 col-md-4 col-sm-4 col-12">
                                </div>
                                <div class="col-lg-5 col-md-8 col-sm-8 col-12">
                                    <span data-bs-toggle="modal" data-bs-target="#placeholder">Use Placeholder</span>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-lg-2 col-md-4 col-sm-4 col-12">
                                    <label for="message" class="form-label fs-6">{{__('en.Message')}}</label>
                                </div>
                                <div class="col-lg-5 col-md-8 col-sm-8 col-12">
                                    <textarea type="text" class="form-control border-secondary @error('message') is-invalid @enderror" id="message" name="message"
                                    placeholder="Message" autocomplete="message" required>{{ old('message') }}</textarea>
                                    @error('message')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-2 col-md-4 col-sm-4 col-12">
                                    <label for="status" class="form-label fs-6">{{__('en.Status')}}</label><br>
                                </div>
                                <div class="col-lg-5 col-md-8 col-sm-8 col-12">
                                    <input type="checkbox" checked data-size="md" data-toggle="toggle" data-on="Active"
                                    data-off="Inactive" data-onstyle="success" data-offstyle="danger">
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row pt-2">
                            <div class="col-lg-4 col-md-6 col-12 mt-3">
                                <label for="name" class="form-label fs-6">{{__('en.Name')}}</label>
                                <input type="text" class="form-control border-secondary @error('name') is-invalid @enderror" id="name" name="name"
                                value="{{ old('name') }}" placeholder="Name" autocomplete="name" required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 mt-3">
                                <label for="subject" class="form-label fs-6">{{__('en.Subject')}}</label>
                                <input type="text" class="form-control border-secondary @error('subject') is-invalid @enderror" id="subject" name="subject"
                                value="{{ old('subject') }}" placeholder="Subject" autocomplete="subject" required>
                                @error('subject')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-2 col-md-3 col-6 mt-3">
                                <label for="placeholder" class="form-label fs-6">{{__('en.Placeholder')}}</label>
                                <!-- Modal trigger for use placeholder -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#placeholder">
                                    Use Placeholder
                                </button>
                            </div>
                            <div class="col-lg-2 col-md-3 col-6 mt-3">
                                <label for="status" class="form-label fs-6">{{__('en.Status')}}</label><br>
                                <input type="checkbox" checked data-size="md" data-toggle="toggle" data-on="Active"
                                    data-off="Inactive" data-onstyle="success" data-offstyle="danger">
                            </div>
                            <div class=" col-12 mt-3">
                                <label for="message" class="form-label fs-6">{{__('en.Message')}}</label>
                                <textarea type="text" class="form-control border-secondary @error('message') is-invalid @enderror" id="message" name="message"
                                placeholder="Message" autocomplete="message" required>{{ old('message') }}</textarea>
                                @error('message')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> --}}

                        <div class="row">
                            <!-- save button row included below -->
                            @include('pages.table-footer')
                        </div>
                        <!-- Modal itself for use placeholder -->
                        <div class="modal fade" id="placeholder" tabindex="-1" aria-labelledby="placeholderLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h1 class="modal-title fs-5" id="placeholderLabel">{{__('en.Placeholders')}}</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                ...
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                                </div>
                            </div>
                            </div>
                        </div>
                    </form>
                    {{-- end form email Template --}}                    
                </div>
            </div>
        </div>
    </div>

@endsection
