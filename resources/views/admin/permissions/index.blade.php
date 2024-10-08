@push('styles')
@endpush
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
                                            {{ __('Permission Routes List') }}</h4>
                                        {{-- <h6 class="m-0 font-weight-bold text-main">
                                <a href="{{ route('permissions.create') }}" class="btn btn-primary">Add Permission Route</a>
                            </h6> --}}
                                    </div>
                                    <div class="card-body">
                                        <div id="preTable" class="table-responsive">
                                            <form action="{{ route('permissions.store') }}" id="mainForm" method="post">
                                                <table id="permissionTable" class="table table-bordered addGrandParent">
                                                    <thead>
                                                        <tr class="table-danger">
                                                            <th width="150px">
                                                                Route Type
                                                            </th>
                                                            <th width="150px">
                                                                Access Type
                                                            </th>
                                                            <th>
                                                                Parent Label
                                                            </th>
                                                            <th>
                                                                Route Label
                                                            </th>
                                                            <th>
                                                                Route Name
                                                            </th>
                                                            <th>
                                                                Action
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="addParent_{{ config('addPages.route.id') }}"
                                                        class="sortingorder addParent_{{ config('addPages.route.id') }}">

                                                        @foreach ($permissions as $type => $category)
                                                            @if (count($category))
                                                                @foreach ($category as $item)
                                                                    @include('admin.components.route', $item)
                                                                @endforeach
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="8" style="text-align: right;">
                                                                <a href="javascript:void(0);"
                                                                    class="d-none d-sm-inline-block btn btn-primary btn-sm shadow-sm addComponent"
                                                                    pid="{{ config('addPages.route.id') }}">
                                                                    <i class="fas fa-fw fa-cog"></i>
                                                                    Add New
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="8" style="text-align: center;">
                                                                <button type="submit"
                                                                    class="d-none d-sm-inline-block btn btn-primary btn-sm shadow-sm formValidate">
                                                                    Save / Update
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </form>
                                        </div>
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
