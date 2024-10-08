
    <style>
    .vertical-nav-menu ul:before {
        content: '';
        height: 100%;
        opacity: 1;
        width: 3px;
        background: transparent;
        position: absolute;
        left: 20px;
        top: 0;
        border-radius: 15px;
}
.vertical-nav-menu ul {
    transition: padding 300ms;
}
.module-link .nav-link {
    margin-bottom: 10px;
    background: 0 0;
    border: 1px solid #40999d;
    border-top-left-radius: 0.25rem;
    border-top-right-radius: 0.25rem;
    font-size: 11px;
}
    </style>
    <div class="app-sidebar sidebar-shadow">
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
        <div class="scrollbar-sidebar">
            <div class="app-sidebar__inner">

                @if (Request::routeIs('student.course.show') || Request::routeIs('student.grades'))
                <p>
                    <b>{{ $course->title ?? "" }}</b>
                    <br>
                    <span class="fs-6">{{ $course->category->name ?? "" }}</span>
                </p>
                <ul class="vertical-nav-menu">
                    <li>
                        @if (Route::is('student.course.show'))
                        <div id="accordion3">
                            <div class="card shadow-none border-0">
                                <div class="card-header d-block border-0 px-0">
                                    <a class="mm-active" data-toggle="collapse" href="#collapseTen">
                                        Course Material
                                    </a>
                                </div>
                                <div id="collapseTen" class="collapse show" data-parent="#accordion3">
                                    <div class="card-body pe-0">
                                        <ul>
                                            @if ($tabs->count() > 0)
                                                <ul class="nav nav-tabs module-link flex-column w-100" id="myTab" role="tablist">
                                                    @foreach ($tabs as $index => $tab)
                                                        <li class="nav-item w-100" role="presentation">
                                                            <a class="nav-link d-flex {{ $index == 0 ? 'active' : '' }}" style="white-space: normal; word-break: break-word;" id="tab-{{ $index }}-tab" data-bs-toggle="tab" href="#tab-{{ $index }}" role="tab" aria-controls="tab-{{ $index }}" aria-selected="{{ $index === 0 ? 'true' : 'false' }}">{{ $tab->name }}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>

                                            @else
                                                <h6 class="text-center">No Module Found</h6>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                            <a href="{{ route('student.course.show',base64_encode($course->id)) }}">
                                Course Material
                            </a>
                        @endif
                    </li>
                    {{-- <li>
                        <a href="{{route('student.grades',base64_encode($course->id))}}" class="{{ Route::is('student.grades') ? 'mm-active' : '' }}">Grades</a>
                    </li> --}}
                </ul>
            @else
                <ul class="vertical-nav-menu">
                    <li>
                        <a href="{{ route('student.my-learning') }}" class="{{ Route::is('student.my-learning') ? 'mm-active' : '' }} nav-link fw-normal">
                            <img src="{{asset('front/img/Vector.png')}}">
                            My Learning
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('student.accomplishments')}}" class="{{ Route::is('student.accomplishments') ? 'mm-active' : '' }} nav-link fw-normal">
                            <img src="{{asset('front/img/cc.png')}}">
                            Accomplishments
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('student.purchases') }}" class="{{ Route::is('student.purchases') ? 'mm-active' : '' }} nav-link fw-normal">
                            <img src="{{asset('front/img/cg.png')}}">
                            My Purchases
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('student.dashboard') }}" class="{{ Route::is('student.dashboard') ? 'mm-active' : '' }} nav-link fw-normal">
                            <img src="{{asset('front/img/cf.png')}}">
                            Profile
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('logout')}}" class=" nav-link fw-normal">
                            <img src="{{asset('front/img/ce.png')}}">
                            Logout
                        </a>
                    </li>
                </ul>
            @endif




            </div>
        </div>
    </div>




