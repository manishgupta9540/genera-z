@extends('admin.master.index')

@section('title', 'Assignment List')

@section('content')

<?php  use App\Helpers\Helper; ?>
<div class="main-content">
    <section class="section">
        <div class="row">
            <div class="col-md-8">
                <h3>Courses / Module / Sub Module / Assignment</h3>
            </div>
        </div>
      <div class="section-body">
        <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                    {{-- @if(Auth::user()->user_type != '0')
                        <?php
                            $childs = Helper::get_user_permission();
                            $permissions = DB::table('action_masters')->whereIn('id', $childs)->get();
                        ?>
                        @foreach ($permissions as $item)
                            @if($item->action == 'blogs-create')
                                <a href="{{route('blogs-create')}}" class="btn btn-primary btn-sm ">Add Blogs</a>
                            @endif
                        @endforeach
                    @else
                        <a href="{{route('blogs-create')}}" class="btn btn-primary btn-sm ">Add Blogs</a>
                    @endif --}}

                </div>

                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped user_datatable" id="user_datatable" >
                      <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Duration</th>
                            <th>Created At</th>
                            <th>Status Public</th>
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
        var table;
        $(document).ready(function() {
            table = $('#user_datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('assignment-list') }}",
                columns: [
                    {
                        data: null,
                        name: 'serial_number'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'duration',
                        name: 'duration'
                    },
                    {
                            data: 'created_at',
                            type: 'num',
                            render: {
                                _: 'display',
                                sort: 'timestamp'
                            }
                    },
                    {
                        data: 'public_show',
                        name: 'public_show'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                createdRow: function(row, data, dataIndex) {
                    // Add the serial number in the first
                    var pageInfo = table.page.info();
                    $('td:eq(0)', row).html(pageInfo.start + dataIndex + 1);
                }
            });
        });

    $(document).ready(function(){
        // delete button
        $(document).on('click', '.deleteBtn', function() {
            var _this = $(this);
            var id = $(this).data('id');

            var table = 'assignments';
            swal({
                    // icon: "warning",
                    type: "warning",
                    title: "Are You Sure You Want to Delete?",
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
                        _this.addClass('disabled-link');
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: "{{ route('assignment-delete') }}",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                'id': id,
                                'table_name': table
                            },
                            success: function(response) {
                                console.log(response);
                                window.setTimeout(function() {
                                    _this.removeClass('disabled-link');
                                }, 2000);

                                if (response.success==true ) {
                                    window.setTimeout(function() {
                                        window.location.reload();
                                    }, 2000);
                                }
                            },
                            error: function(response) {
                                console.log(response);
                            }
                        });
                        swal.close();
                    } else {
                        swal.close();
                    }
                }
            );
            });

            // publish button
            $(document).on('click', '.publishBtn', function() {
                var _this = $(this);
                var id = $(this).data('id');

                var table = 'assignments';
                swal({
                        // icon: "warning",
                        type: "warning",
                        title: "Are You Sure You Want to Publish?",
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
                            _this.addClass('disabled-link');
                            $.ajax({
                                type: "POST",
                                dataType: "json",
                                url: "{{ route('assignment-publish') }}",
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    'id': id,
                                    'table_name': table
                                },
                                success: function(response) {
                                    console.log(response);
                                    window.setTimeout(function() {
                                        _this.removeClass('disabled-link');
                                    }, 2000);

                                    if (response.success==true ) {
                                        window.setTimeout(function() {
                                            window.location.reload();
                                        }, 2000);
                                    }
                                },
                                error: function(response) {
                                    console.log(response);
                                }
                            });
                            swal.close();
                        } else {
                            swal.close();
                        }
                    }
                );
            });
        });

        //status active and deactive
        $(document).on('click', '.status', function (event) {

            var id = $(this).attr('data-id');
            var type =$(this).attr('data-type');

            var action = '';
            var type_decode =atob(type);
                //   alert(type_decode);
            if (type_decode== 'enable') {
                var action = 'activate';
            }
            if (type_decode== 'disable') {
                var action = 'deactivate';
            }
            swal({
            // icon: "warning",
            type: "warning",
            title: 'Are you want to '+ action +' Assignment',
            text: "",
            dangerMode: true,
            showCancelButton: true,
            confirmButtonColor: "#007358",
            confirmButtonText: "YES",
            cancelButtonText: "CANCEL",
            closeOnConfirm: false,
            closeOnCancel: false
            },
            function(e){
                if(e==true)
                {
                    $.ajax({
                        type:'POST',
                        url: "{{url('assignment-status')}}",
                        data: {"_token" : "{{ csrf_token() }}",'id':id,'type':type},
                        success: function (response) {

                            if (response.success) {
                                window.setTimeout(function(){
                                location.reload();
                                },2000);
                                toastr.success("Status Changed Successfully");
                            }
                            else {

                            }

                            swal.close();

                        },
                        error: function (xhr, textStatus, errorThrown) {
                            // alert("Error: " + errorThrown);
                        }

                    });
                }
                else
                {
                    swal.close();
                }
        });
    });


</script>
@endpush
