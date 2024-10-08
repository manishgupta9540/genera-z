@extends('student.master')

@section('title', 'My Grades')

@section('content')

<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="container-fluid my-5">
            <div class="row">
                <div class="col-md-12 mb-4">
                    <h3><b>Grades</b></h3>
                </div>
            </div>
            <div class="row">
              <div class="box bg-white w-100 p-5">
                   <div class="row">
                      <div class="col-md-12">
                           <div class="grade-1 border p-4">
                                <p class="mb-0 d-flex align-items-center"><i class="fa fa-check-circle grade-icon mr-2" aria-hidden="true"></i> You have completed all of the assessments that are currently due.</p>
                           </div>
                      </div>
                   </div>
                   <div class="row mt-4">
                      <div class="col-md-12">

                           <div class="grade-1 border py-4">
                                <table class="w-100 grade-table">
                                     <thead class="border-bottom">
                                          <tr>
                                               <th class="py-3 px-4">Item</th>
                                               <th class="py-3 px-4">Status</th>
                                               <th class="py-3 px-4">Due Date</th>
                                               <th class="py-3 px-4">Weight</th>
                                               <th class="py-3 px-4">Grade</th>
                                          </tr>
                                     </thead>
                                     <tbody>

                                        @foreach ($assignments as $userAssignment)
                                            <tr class="border-bottom">
                                                <td class="py-3 px-4">
                                                    <i class="fa fa-lock" aria-hidden="true"></i>
                                                    <a href="#" class="text-decoration-none">{{ $userAssignment->assignment->title }}</a>
                                                </td>
                                                <td class="py-3 px-4">
                                                    <i class="fa fa-info-circle" aria-hidden="true"></i> Locked
                                                </td>
                                                <td class="py-3 px-4">{{ \Carbon\Carbon::parse($userAssignment->assignment->due_date)->format('d-M-Y') }}
                                                </td>
                                                <td class="py-3 px-4">--</td>
                                                <td class="py-3 px-4">{{ number_format($userAssignment->percentage, 2) }}%</td>
                                            </tr>
                                        @endforeach

                                     </tbody>
                                </table>
                           </div>
                      </div>
                   </div>
              </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('student-js')
    {{-- <script>
          $(document).ready(function(){
            get_data('{{$course->course_modules[0]->id }}');

        function get_data(id){
            $.ajax({
                type: 'GET',
                url: "{{ url('/module-filter') }}",
                data: {
                    'id': id
                },
                success: function(response) {
                    console.log(response);
                    $('#sub_module_append').replaceWith(response);
                },
            });
        }
        $(document).on('click','.moduleId',function(){
            var id = $(this).attr('data-id');

            get_data(id);
        });
    });
    </script> --}}

@endpush
