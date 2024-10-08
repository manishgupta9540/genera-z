@extends('admin.master.index')

@section('title', 'Certification Listing')

@section('content')


<div class="main-content">
    <section class="section">
      <div class="section-body">
        <div class="row">

            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <a href="{{route('certification-create')}}" class="btn btn-primary btn-sm ">Add Certification</a>
                </div>
               
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped user_datatable" id="user_datatable" >
                      <thead>
                        <tr>
                            <th>#</th>
                            <th>Certification Title</th>
                            <th>Certificate </th>
                            <th>Course</th>
                            <th>Issuing Organization</th>
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
        var table;
        $(document).ready(function() {
            table = $('#user_datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('certification.index') }}",
                columns: [
                    {data: null,  name: 'serial_number'},
                    {data: 'certification_title', name: 'certification_title'},
                    {data: 'certificate_design', name: 'certificate_design'},
                    {data: 'courses.title', name: 'courses.title'},
                    {data: 'issuing_organization',name: 'issuing_organization'},
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
            
            var table = 'certifications';
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
                            url: "{{ route('certification-delete') }}",
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
            title: 'Are you sure you want to '+ action +' the role?',
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
                        url: "{{url('certification-status')}}",
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