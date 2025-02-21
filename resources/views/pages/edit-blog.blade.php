@extends('layouts.master')

@section('title')
Edit Blog
@endsection

@section('content')
    <div class="container">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h4>{{ __('en.Edit Blog') }}</h4>
                </div>
            </div>
            <hr>
            <form method="POST" action="" enctype="">
                <div class="row d-flex justify-content-around mt-3">
                    <div class="col-lg-7 col-12">
                        <div class="d-flex flex-column">
                            <div class="row mt-4">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                                    <label for="title" class="form-label fs-6 mt-2">{{__('en.Title')}}</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-12">
                                    <input type="text" class="form-control border-secondary @error('title') is-invalid @enderror" value="This is a title." id="title" name="title"
                                    value="{{ old('title') }}" autocomplete="title" required>
                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                                    <label for="shortDescription" class="form-label fs-6 mt-2">{{__('en.Short Description')}}</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-12">
                                    <input type="text" class="form-control border-secondary @error('shortDescription') is-invalid @enderror" value="This is a Short Description" id="shortDescription" name="shortDescription"
                                    value="{{ old('shortDescription') }}" autocomplete="shortDescription" required>
                                    @error('shortDescription')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>  
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                                    <label for="longDescription" class="form-label fs-6 mt-2">{{__('en.Long Description')}}</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-12">
                                    <textarea type="text" class="form-control border-secondary @error('longDescription') is-invalid @enderror" id="longDescription" name="longDescription"
                                    autocomplete="longDescription" required>This is a Long Description.{{ old('longDescription') }}</textarea>
                                    @error('longDescription')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                                    <label for="tags" class="form-label fs-6 mt-2">{{__('en.Tags')}}</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-12">
                                    <select class="form-select border-secondary @error('tags') is-invalid @enderror" multiple name="tags" id="tags" autocomplete="tags" required>
                                        <option>{{__('en.Choose')}}</option>
                                        <option value="1" @if(old('tags') == 1) 'selected' @endif selected>{{__('en.Tag')}} 1</option>
                                        <option value="2" @if(old('tags') == 2) 'selected' @endif >{{__('en.Tag')}} 2</option>
                                    </select>
                                    @error('tags')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>  
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                                    <label for="status" class="form-label fs-6 mt-2">{{__('en.Status')}}</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-12">
                                    <input type="checkbox" data-size="md" data-toggle="toggle" data-on="Published"
                                    data-off="Draft" data-onstyle="success" data-offstyle="danger">
                                </div>  
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                                    <label for="schedule" class="form-label fs-6 mt-2">{{__('en.Schedule Publish')}}</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-12">
                                    <input type="datetime-local" class="form-control border-secondary @error('schedule') is-invalid @enderror" value="2023-03-12T19:30" id="schedule" name="schedule"
                                    value="{{ old('schedule') }}" autocomplete="schedule" required>
                                    @error('schedule')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12 ">
                        <img class="img img-thumbnail mt-4 mb-2 d-block mx-auto" src="/assets/images/user1.png"
                            alt="">
                        <div class="d-flex justify-content-center">
                            <input type="file"
                                class="w-75 mt-4 form-control float-center  @error('profileImg') is-invalid @enderror"
                                id="profileImg" name="profileImg" value="{{ old('profileImg') }}"
                                autocomplete="profileImg" required>
                        </div>
                    </div>
                </div>
                <!-- save button row included below -->
                @include('pages.table-footer')
            </form>
        </div>
    </div>
@endsection
