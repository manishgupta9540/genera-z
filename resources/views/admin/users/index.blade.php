@extends('admin.master.index')

@section('title', 'User Listing')

@section('content')
<style>
.no-underline {
    text-decoration: none;
}
</style>

<div class="main-content">
    <section class="section">
        <div class="row">
            <div class="col-md-6">
                <h3>Student Listing</h3>
            </div>
        </div>
      <div class="section-body">
        <div class="row">
            <div class="col-12">
              <div class="card">
                {{-- <div class="card-header">
                  <a href="{{route('user-role-create')}}" class="btn btn-primary btn-sm ">Add User</a>
                </div> --}}

                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped user_datatable" id="user_datatable" >
                      <thead>
                        <tr>
                            <th>#</th>
                            <th>Users</th>
                            <th>Email</th>
                            <th>Phone</th>
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


  <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">User Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="userDetailsContent">
                    <!-- Dynamic content will be loaded here via AJAX -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-close-modal" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>




@endsection

@push('customjs')

<script>
        var table;
        $(document).ready(function() {
            table = $('#user_datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('user-roles.index') }}",
                columns: [
                    {
                        data: null,
                        name: 'serial_number'
                    },
                    {data: 'username', name: 'username'},
                    {data: 'email', name: 'email'},
                    {data: 'phone_number', name: 'phone_number'},

                    {
                            data: 'created_at',
                            type: 'num',
                            render: {
                                _: 'display',
                                sort: 'timestamp'
                            }
                    },
                    {
                        data: 'status',
                        name: 'status',

                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                createdRow: function(row, data, dataIndex) {
                    // Add the serial number in the first cell
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

            var table = 'users';
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
                            url: "{{ route('user-role-delete') }}",
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
            title: 'Are you sure you want to '+ action +' the user account',
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
                        url: "{{url('user-role-status')}}",
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

    $(document).ready(function() {
        $(document).on('click', '.user-name-link', function() {
            var userId = $(this).data('id');

            $.ajax({
                url: '/user/details/' + userId,
                method: 'GET',
                success: function(data) {
                    $('#userDetailsContent').html(data);
                    $('#userModal').modal('show');
                },
                error: function() {
                    $('#userDetailsContent').html('<p>An error occurred while fetching user details.</p>');
                    $('#userModal').modal('show');
                }
            });
        });

        // Handle the modal close button
        $(document).on('click', '.btn-close-modal', function() {
            $('#userModal').modal('hide'); // Close the modal
        });

        $('#userModal').on('hidden.bs.modal', function () {
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open');
            $('body').css('padding-right', '');
        });

        $('#userModal').on('hidden.bs.modal', function () {
            $('.modal-backdrop').remove();
        });
    });


</script>
@endpush
