<!-- Navbar start -->
<div class="header-container fixed-top">
    <header class="header navbar navbar-expand-sm expand-header">
        <div class="header-left d-flex ">
            <div class="logo">
                <img src="/assets/images/logo-no-background.png" class="logo-image" alt="logo">
                {{-- <span class="logo-text"> RK Tech</span> --}}
            </div>
            <a href="#" class="sidebarCollapse " id="toggleSidebar" data-placement="bottom">
                <i class="bi bi-list"></i>
            </a>
            {{-- <i class="bi bi-arrows-fullscreen header-icon d-none d-sm-inline-block py-2" onClick="toggleFullScreen()"></i> --}}
            {{-- <li class=""> --}}
                
            {{-- </li> --}}
        </div>
            
        <div class="mx-auto search-mt">
            @yield('datefilter')
        </div>
        <ul class="navbar-item flex-row ms-auto d-flex align-items-center">
            <li class="nav-item dropdown user-profile-dropdown">

                <a href="{{ route('pos') }}" class="btn btn-primary  fw-bold mt-1 ms-3" id="Notify">
                    <!-- {{ __('users.create') }} -->
                    {{ __('general.POS') }}
                </a>
            </li>
            <li class="nav-item dropdown has-arrow flag-nav">
                @include('layouts.localization')

            </li>
            <li class="nav-item dropdown user-profile-dropdown">
                
                <a href="#" class="nav-link user me-3" id="Notify" data-bs-toggle="dropdown">
                    <i class="bi bi-gear fs-4"></i>
                </a>
                <div class="dropdown-menu">
                    <div class="user-profile-section">
                        <div class="media mx-auto">
                            @php
                                if (file_exists('images/' . auth()->user()->picture) && !is_null(auth()->user()->picture)) {
                                    $image = '/images/' . auth()->user()->picture;
                                    // dd($image);
                                } else {
                                    $image = '/assets/images/user3.png';
                                }

                            @endphp
                            <img src="{{$image}}" alt="" class="img-fluid mr-2">
                            <div class="media-body">
                                <h5>{{auth()->user()->name}}</h5>
                                <p class="fs-6">{{auth()->user()->email}}</p>
                                <p class="fs-6">{{auth()->user()->user_type}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="dp-main-menu">
                        <a href="{{ route('user-profile-setting') }}" class="dropdown-item"><span><i
                                    class="bi bi-person-fill"></i></span>{{ __('general.Profile')}}</a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                            <span><i class="bi bi-box-arrow-left"></i></span>{{ __('general.Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </li>
        </ul>
    </header>
</div>
<!-- Navbar End -->

