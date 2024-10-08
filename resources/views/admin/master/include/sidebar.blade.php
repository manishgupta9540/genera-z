<?php use App\Helpers\Helper; ?>
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('home') }}">
                <img alt="image" src="{{ asset('admin/assets/img/GZlogoB.png') }}" class="header-logo" />
                <span class="logo-name">Generation Z</span>
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            <li class="dropdown {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i data-feather="monitor"></i><span>Dashboard</span>
                </a>
            </li>

            @if (Auth::user()->user_type != '0')
                @php
                    $childs = Helper::get_user_permission();
                    $permissions = DB::table('action_masters')
                        ->whereIn('id', $childs)
                        ->where('parent_id', 0)
                        ->orderBy('display_order', 'desc')
                        ->get();
                @endphp

                @foreach ($permissions as $item)
                    <li class="{{ Request::segment(1) == $item->action ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url($item->action) }}">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <span>{{ $item->action_title }}</span>
                        </a>
                    </li>
                @endforeach
            @else
                <li class="dropdown {{ Request::routeIs('roles.index') ? 'active' : '' }}">
                    <a href="#" class="menu-toggle nav-link has-dropdown">
                        <i class="fas fa-users"></i><span>User Management</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="{{ Request::routeIs('permissions.index') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('permissions.index') }}">
                                <span>Permissions</span>
                            </a>
                        </li>
                        <li class="{{ Request::routeIs('roles.index') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('roles.index') }}">
                                <span>Roles & Permissions</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="{{ Request::routeIs('category.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('category.index') }}">
                        <i class="fas fa-list" aria-hidden="true"></i><span>Category Management</span>
                    </a>
                </li>

                <li class="{{ Request::routeIs('skills.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('skills.index') }}">
                        <i class="fas fa-tools" aria-hidden="true"></i><span>Skills Management</span>
                    </a>
                </li>

                <li class="dropdown {{ Request::is('course*') ? 'active' : '' }}">
                    <a href="#" class="menu-toggle nav-link has-dropdown">
                        <i class="fas fa-book"></i><span>Course Management</span>
                    </a>
                    <ul class="dropdown-menu" style="{{ Request::is('course*') ? 'display: block;' : '' }}">
                        <li class="{{ Request::routeIs('course.index') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('course.index') }}">
                                <span>Course List</span>
                            </a>
                        </li>
                        <li class="{{ Request::routeIs('course-module-list') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('course-module-list') }}">
                                <span>Modules</span>
                            </a>
                        </li>
                        <li class="{{ Request::routeIs('sub-module-list') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('sub-module-list') }}">
                                <span>Sub Modules</span>
                            </a>
                        </li>
                        <li class="{{ Request::routeIs('course-material') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('course-material') }}">
                                <span>Course Materials</span>
                            </a>
                        </li>
                        <li class="{{ Request::routeIs('assignment-list') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('assignment-list') }}">
                                <span>Assignment List</span>
                            </a>
                        </li>
                        <li class="{{ Request::routeIs('question-list') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('question-list') }}">
                                <span>Question List</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="{{ Request::routeIs('short-list') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('short-list') }}">
                        <i class="fas fa-user-graduate" aria-hidden="true"></i><span>Student Assignment Overview</span>
                    </a>
                </li>
                <li class="{{ Request::routeIs('user-roles.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('user-roles.index') }}">
                        <i class="fas fa-user-graduate" aria-hidden="true"></i><span>Student Listing</span>
                    </a>
                </li>

                <li class="{{ Request::routeIs('payment-list') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('payment-list') }}">
                        <i class="fas fa-credit-card" aria-hidden="true"></i><span>Payment Management</span>
                    </a>
                </li>

                <li class="{{ Request::routeIs('khda-certificate') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('khda-certificate') }}">
                        <i class="fas fa-certificate" aria-hidden="true"></i><span>KHDA Certificate Applicant</span>
                    </a>
                </li>

                <li class="{{ Request::routeIs('review-list') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('review-list') }}">
                        <i class="fas fa-star" aria-hidden="true"></i><span>Review Management</span>
                    </a>
                </li>


                <li class="{{ Request::routeIs('chat.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('chat.index') }}">
                        <i class="fas fa-comments text-info" aria-hidden="true"></i><span>Chats and Queries</span>
                    </a>
                </li>
            @endif
        </ul>
    </aside>
</div>
