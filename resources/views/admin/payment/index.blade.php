@extends('admin.master.index')

@section('title', 'Payment List')

@section('content')
<style>
    .buttons-html5{
        width: 76px;
    }
</style>

<div class="main-content">
    <section class="section">
        <div class="row">
            <div class="col-md-6">
                <h3>Payment History</h3>
            </div>
        </div>
      <div class="section-body">
        <div class="row">

            <div class="col-12">
              <div class="card">


                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped user_datatable" id="user_datatable" >
                      <thead>
                        <tr>
                            <th>#</th>
                            <th>Student Name</th>
                            <th>Course Name</th>
                            <th>Date of Purchase</th>
                            <th>Transaction ID</th>
                            <th>Amount</th>
                            <th>Transaction Status</th>
                            {{-- <th>Action</th> --}}
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
                pageLength: 50,
                ajax: "{{ route('payment-list') }}",
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        title: 'Index'
                    },
                    {
                        data: 'student_name',
                    },
                    {
                        data: 'course_title',
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
                        data: 'tracking_id',
                    },
                    {
                        data: 'amount',
                    },
                    {
                        data: 'order_status',
                    },

                    // {
                    //     data: 'action',

                    //     orderable: false,
                    //     searchable: false
                    // },
                ],

                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',

                    },
                    {
                        extend: 'pdf',
                    },
                ]
            });
        });



</script>
@endpush
