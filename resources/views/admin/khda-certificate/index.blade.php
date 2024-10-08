@extends('admin.master.index')

@section('title', 'Skills List')
@section('content')
    <style>
        .buttons-html5 {
            width: 100%;
        }
    </style>

    <?php use App\Helpers\Helper; ?>
    <div class="main-content">
        <section class="section">
            <div class="row">
                <div class="col-md-6">
                    <h3>KHDA Certificate</h3>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped user_datatable" id="certificatesTable">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Student Name</th>
                                                <th>Email</th>
                                                <th>Applied Date</th>
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
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">KHDA Certification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="appendData"></div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('customjs')
    <script>
        var table;
        $(document).ready(function() {
            var table = $('#certificatesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('khda-certificate') }}',
                    type: 'GET'
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        title: 'Index'
                    },
                    {
                        data: 'name_in_english',
                        title: 'Name in English'
                    },
                    {
                        data: 'email',
                        title: 'Email'
                    },
                    {
                        data: 'created_at',
                        title: 'Created At'
                    },
                    {
                        data: 'status',
                        title: 'Status'
                    },
                    {
                        data: 'action',
                        title: 'Action'
                    },
                    {
                        data: 'name_in_arabic',
                        title: 'Name in Arabic',
                        visible: false

                    },
                    {
                        data: 'religion',
                        name: 'religion',
                        title: 'Religion',
                        visible: false
                    },
                    {
                        data: 'gender',
                        name: 'gender',
                        title: 'Gender',
                        visible: false
                    },
                    {
                        data: 'dob',
                        name: 'dob',
                        title: 'Date of Birth',
                        visible: false
                    },
                    {
                        data: 'passport_number',
                        name: 'passport_number',
                        title: 'Passport Number',
                        visible: false
                    },
                    {
                        data: 'amount',
                        name: 'amount',
                        title: 'Amount',
                        visible: false
                    },
                    {
                        data: 'order_id',
                        name: 'order_id',
                        title: 'Order ID',
                        visible: false
                    }
                ],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1, 6, 2, 7, 8, 9, 10, 11,
                                12,4 ,3] // Include all columns, including hidden ones
                        }
                    },
                ]
            });
        });



        //status active and deactive
        $(document).on('click', '.status', function(event) {
            var id = $(this).attr('data-id');
            var type = $(this).attr('data-type');
            swal({
                    // icon: "warning",
                    type: "warning",
                    title: 'Are you want to Skills?',
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
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('khda-certificate-approve') }}",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                'id': id,
                                'type': type
                            },
                            success: function(response) {

                                if (response.success) {
                                    window.setTimeout(function() {
                                        location.reload();
                                    }, 2000);
                                    toastr.success(response.msg);
                                } else {
                                    toastr.error(response.msg);
                                }
                                swal.close();

                            },
                            error: function(xhr, textStatus, errorThrown) {
                                // alert("Error: " + errorThrown);
                            }

                        });
                    } else {
                        swal.close();
                    }
                });
        });

        function getModalCertificate(id) {
            $('#appendData').html('')
            $.ajax({
                url: '{{ route('khda-certificate-get') }}',
                type: 'GET',
                data: {
                    id: id
                },
                success: function(resp) {
                    $('#appendData').html(resp)
                    console.log(resp);
                }
            })
        }

        function approvedStatus(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('khda-certificate-approve') }}',
                        type: 'GET',
                        data: {
                            id: id
                        },
                        success: function(resp) {
                            Swal.fire({
                                title: "Deleted!",
                                text: "Your file has been deleted.",
                                icon: "success"
                            });
                        }
                    })

                }
            });
        }
    </script>
@endpush
