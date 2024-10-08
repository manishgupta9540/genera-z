<div class="w-25 d-md-none">
    <a href="#"><img src="{{asset('front/img/GZlogoB.png')}}" class="w-100" style="margin-left: 30px;"></a>
</div>
<div class="app-header__mobile-menu">
    <div>
        <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
        </button>
    </div>
</div>
<div class="app-header__menu">
    <span>
        <button type="button"
            class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
            <span class="btn-icon-wrapper">
                <i class="fa fa-ellipsis-v fa-w-6"></i>
            </span>
        </button>
    </span>
</div>
<div class="app-header__content justify-content-between">
    <div class="w-25">
        <a href="{{route('home')}}"><img src="{{asset('front/img/GZlogoB.png')}}" class="w-25" style="margin-left: 65px;"></a>
    </div>
    <div class="app-header-right">
        <div class="header-btn-lg pr-0">
            <div class="widget-content p-0">
                <div class="widget-content-wrapper">
                    <div class="widget-content-left">
                        <div class="btn-group d-flex align-items-center">
                            <ul class="header-menu nav align-items-center">
                                <li class="btn-group nav-item">
                                    <a href="{{url('chatify/'.$users->id)}}" target="_blank" class="nav-link">
                                        <img src="{{asset('front/img/light.png')}}">
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <div class="dropdown">
                                        <a href="{{url('chatify/'.$users->id)}}" class="nav-link">
                                            {{-- <img src="{{ asset('front/img/Union.png') }}"> --}}
                                            @if(Auth::user()->unreadNotifications->count() > 0)
                                                <span class="badge badge-pill badge-danger">{{ Auth::user()->unreadNotifications->count() }}</span>
                                            @endif
                                        </a>
                                        <div class="dropdown-menu">
                                            <div class="dropdown-header border-bottom">
                                                <h6 class="text-dark mb-0"><strong>Notifications</strong></h6>
                                            </div>
                                            @foreach(Auth::user()->notifications as $notification)
                                                <a class="dropdown-item" href="#">
                                                    <div class="media d-flex justify-content-between">
                                                        <div class="colum-1 mr-2">
                                                            <img src="{{ asset('front/img/profile.png') }}">
                                                        </div>
                                                        <div class="colum-2">
                                                           <p class="mb-1">
                                                                <strong>{!! nl2br(e($notification->data['message'])) !!}</strong>
                                                           </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            @endforeach
                                            <div class="dropdown-footer border-top text-center pt-2">
                                                <a href="#" class="">Show all Notifications</a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div class="dropdown d-flex align-items-center">
                                <a href="#" class="nav-link" id="dropdownProfileMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ Auth::user()->image ? asset('uploads/studentProfile/'.Auth::user()->image) : asset('front/img/profile.png') }}" class="rounded-circle" width="40px">
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownProfileMenuLink">
                                  <a class="dropdown-item" href="{{Route::is('student.dashboard') ? 'javascript:void(0)' : route('student.dashboard') }}">{{ Auth::user()->name ?? ""}}</a>
                                  <a class="dropdown-item" href="{{ route('logout')}}">Logout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
