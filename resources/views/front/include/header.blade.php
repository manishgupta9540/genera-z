<header id="menuHeader" class="header-area menuHeader">
    <div id="navigation" class="navigation navigation-landscape">
        <div class="container position-relative">
            <div class="row align-items-center">
                <div class="col-lg-3">
                    <div class="header-logo">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('front/Content/Assets/GenerationZImages/GZlogoB.png') }}" alt="Logo"
                                style="width:auto;padding:5px;height:90px">
                        </a>
                    </div>
                </div>
                <div class="col-lg-9 position-static">
                    <div class="nav-toggle hideMobile"></div>
                    <nav class="nav-menus-wrapper">
                        <ul class="nav-menu align-items-center justify-content-end">
                            <li class="{{ Route::is('home') ? 'active' : '' }}"><a class="p-0" href="{{ route('home') }}">Home</a></li>
                            {{-- <li class=""><a href="{{ route('about')}}">About</a></li>
                            <li class=""><a href="{{ route('service')}}">Services</a></li> --}}
                            <li class="{{ Route::is('training') ? 'active' : '' }}"><a class="p-0" href="{{ route('training') }}">Training</a></li>
                            {{-- <li class=""><a href="{{ route('blog')}}">Blogs</a></li> --}}
                            <li class="{{ Route::is('contact') ? 'active' : '' }}"><a class="p-0" href="{{ route('contact') }}">Contact</a></li>
                            {{-- <li class=""><a href="{{ route('register')}}">Register</a></li> --}}

                            <li>
                                <a class="active" href="javascript:void(0);"
                                    style="border: 1px solid; padding: 10px 20px; color: rgb(181,47,144)">English</a>
                                <ul class="nav-dropdown nav-submenu">
                                    <li><a href="?lang=ar">عربي </a></li>
                                    <li style="margin-right:0"><a href="?lang=en">English</a></li>
                                    <li style="margin-right:0"><a href="?lang=fr">French</a></li>
                                </ul>
                            </li>

                            @guest
                                <li class=""><a href="javascript:void(0)" class="checkAuth p-0"
                                        data-target="{{ route('authModal') }}">Login</a></li>
                            @else
                                <li>
                                    <div class="dropdown">
                                        <a class="btn dropdown-toggle py-0" href="#" role="button"
                                            id="dropdownMenuLink" style="color: #008080" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="fa-solid fa-circle-user fa-lg"></i>
                                            <span class=" mx-1">{{ ucfirst(Auth::user()->name) }}</span>
                                        </a>

                                        <ul class="dropdown-menu dropdown-menu-end fs-5" aria-labelledby="dropdownMenuLink">
                                            <li class="m-0"><a class="dropdown-item px-2 py-0 fs-6"
                                                    href="{{ route('student.dashboard') }}">Dashboard</a></li>
                                            {{-- <li class="m-0"><a class="dropdown-item px-2 py-0 fs-6"
                                                    href="#">Help</a></li> --}}
                                            <li class="m-0">
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li class="m-0"><a class="dropdown-item px-2 py-0 fs-6"
                                                    href="{{ route('logout') }}">Logout</a></li>
                                        </ul>
                                    </div>
                                </li>
                            @endguest
                            <li>
                                <a class="p-0" href="{{ route('cart.index') }}">
                                    <button type="button" class="btn position-relative">
                                        <i class="fa fa-shopping-cart fa-lg text-theme2" aria-hidden="true"></i>
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-theme2">
                                            <span id="cartCount">
                                                {{ Helper::getCartCount() }}
                                            </span>
                                            <span class="visually-hidden">Items in your cart</span>
                                        </span>
                                    </button>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>

            </div>
        </div>
    </div>
</header>
