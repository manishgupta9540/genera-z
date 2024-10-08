@extends('admin.master.index')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="container">
                    <div class="form-panel">
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <div class="card shadow">
                                    <div class="card-header d-flex flex-row align-items-center justify-content-between">

                                        <h4 class="m-0 header-heading fw-bold text-primary">
                                            {{ __('Edit Role For ') . $role->name }}</h4>
                                        <h6 class="m-0 font-weight-bold text-main">
                                            <a href="{{ route('roles.index') }}" class="btn btn-primary">Roles
                                                List</a>
                                        </h6>
                                    </div>
                                    @php
                                        $rolePermissions = $role->permissions->pluck('name')->toArray();
                                    @endphp
                                    <div class="card-body">
                                        <form id="mainForm" action="{{ route('roles.permissionStore',urlencode(base64_encode($role->id))) }}" method="post">
                                            @csrf
                                            <input type="hidden" name="role_id" value="{{ $role->id }}">
                                            @foreach ($permissions as $type => $parents)
                                                <div class="ml-4">
                                                    <h3>{{ $type == config('constants.permissionTypes.menu.id') ? config('constants.permissionTypes.menu.name') : config('constants.permissionTypes.url.name') }}
                                                    </h3>
                                                    @foreach ($parents as $parent_label => $perms)
                                                        <div class="form-group ml-3 mb-1 border-bottom">
                                                            <div class="form-check">
                                                                <input type="checkbox"
                                                                    class="form-check-input parent-checkbox"
                                                                    id="category-{{ $type }}-{{ Str::slug($parent_label) }}">
                                                                <label class="form-check-label"
                                                                    for="category-{{ $type }}-{{ Str::slug($parent_label) }}">{{ $parent_label }}</label>
                                                            </div>
                                                            <div class="ml-4">
                                                                @foreach ($perms as $permission)
                                                                    <div class="form-check">
                                                                        <input type="checkbox"
                                                                            class="form-check-input child-checkbox"
                                                                            name="permissions[]"
                                                                            value="{{ $permission->id }}"
                                                                            {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}
                                                                            id="permission-{{ $permission->id }}">
                                                                        <label class="form-check-label"
                                                                            for="permission-{{ $permission->id }}">{{ ucwords(str_replace(['-', '.', '_'], ' ', $permission->name)) }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group d-flex justify-content-center">
                                                        <button type="submit" class="btn ms-1 btn-primary">
                                                            <span class="icon">
                                                                <i class="fa-solid fa-floppy-disk"></i>
                                                            </span>
                                                            <span class="text mx-1">Save</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('admin/assets/js/rolePermissions.js') }}"></script>
@endsection
