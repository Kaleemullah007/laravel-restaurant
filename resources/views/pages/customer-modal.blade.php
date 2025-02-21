
<!-- Modal  for create customer-->
<div class="modal fade" id="add_customer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" id="FormData" action="{{ route('customer.store') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-header border-secondary">
                    <h4 class="modal-title" id="exampleModalLabel">{{ __('users.create') }} {{ __('users.customer') }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="user_type" value="customer" id="user_type">
                        <div class="col-12 mt-2">
                            <label for="first_name" class="form-label fs-6">{{ __('users.First_Name') }}</label>
                            <input type="text"
                                class="form-control mb-2 border-dark @error('first_name') is-invalid @enderror"
                                id="first_name" name="first_name" @if(placeholderVisible()) placeholder={{ __('users.First_Name')}}@endif 
                                value="{{ old('first_name') }}" autocomplete="first_name" required autofocus>
                            @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-12 mt-2">
                            <label for="last_name" class="form-label fs-6">{{ __('users.Last_Name') }}</label>
                            <input type="text"
                                class="form-control mb-2 border-dark @error('last_name') is-invalid @enderror"
                                id="last_name" name="last_name" @if(placeholderVisible()) placeholder={{ __('users.Last_Name')}}@endif 
                                value="{{ old('last_name') }}" autocomplete="last_name" required autofocus>
                            @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-12 mt-2">
                            <label for="phone" class="form-label fs-6">{{ __('users.Phone') }}</label>
                            <input type="phone"
                                class="form-control mb-2 border-dark @error('phone') is-invalid @enderror"
                                id="phone" name="phone" @if(placeholderVisible()) placeholder={{ __('+923001234567')}}@endif value="{{ old('phone') }}"
                                autocomplete="phone" required autofocus>
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-12 mt-2">
                            <label for="email" class="form-label fs-6">{{ __('users.Email') }}</label>
                            <input type="email"
                                class="form-control mb-2 border-dark @error('email') is-invalid @enderror"
                                id="email" name="email" @if(placeholderVisible()) placeholder={{ __('abc123@example.com')}}@endif
                                value="{{ old('email') }}" autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                            class="bi bi-x-circle me-2"></i>{{ __('general.Cancel') }}</button>
                    <button type="submit" id="customerFormBtn"  class="btn btn-primary"><i
                            class="bi bi-save me-2"></i>{{ __('general.Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>