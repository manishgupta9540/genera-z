@extends('admin.master.index')

@section('title', 'Roles')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">

                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm ">Add Role</a>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped user_datatable" id="user_datatable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Role Name</th>
                                                <th>Description</th>
                                                <th>Created At</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

@endsection

@push('customjs')
    <script>
        $(document).ready(function() {
            var table = $('#user_datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('roles.index') }}",
                columns: [{
                        data: null,
                        name: 'serial_number'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        type: 'num',
                        render: {
                            _: 'display',
                            sort: 'timestamp'
                        }
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                createdRow: function(row, data, dataIndex) {
                    var pageInfo = table.page.info();
                    $('td:eq(0)', row).html(pageInfo.start + dataIndex + 1);
                }
            });
        });


        $(document).ready(function() {
            // delete button 
            $(document).on('click', '.deleteBtn', function() {
                var item = $(this);

                swal({
                        icon: "warning",
                        type: "warning",
                        title: "",
                        text: "Are You Sure You Want to Delete?",
                        dangerMode: true,
                        showCancelButton: true,
                        confirmButtonColor: "#dc3545",
                        confirmButtonText: "YES",
                        cancelButtonText: "CANCEL",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function(e) {
                        if (e == true) {
                            item.addClass('disabled-link');
                            performAjaxRequest(item.attr('url'), [], 'DELETE')
                            swal.close();
                        } else {
                            swal.close();
                        }
                    }
                );
            });
        });

        //status active and deactive
        $(document).on('click', '.status', function(event) {
            var item = $(this);
            swal({
                type: "warning",
                title: `Are you sure you want to change the status?`,
                text: "",
                dangerMode: true,
                showCancelButton: true,
                confirmButtonColor: "#007358",
                confirmButtonText: "YES",
                cancelButtonText: "CANCEL",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(e) {
                if (e == true) {
                    performAjaxRequest(item.attr('url'), [], 'PUT')
                } else {
                    swal.close();
                }
            });
        });
    </script>
@endpush
