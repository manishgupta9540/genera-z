@extends('student.master')

@section('title', 'My Learning')
<style>
    .check-success {
        font-size: 20px;
    }

    .nav-tabs .nav-link {
        border-radius: 10px !important;
        margin-bottom: 0px;
        background: 0 0;
        border: 1px solid transparent;
    }
</style>
@section('content')
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="container-fluid my-5">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box shadow bg-white p-3">

                            <div class="tab-content m-3" id="myTabContent">
                                @foreach ($tabs as $moduleIndex => $module)
                                    <div class="tab-pane fade {{ $moduleIndex === 0 ? 'show active' : '' }}"
                                        id="tab-{{ $moduleIndex }}" role="tabpanel"
                                        aria-labelledby="tab-{{ $moduleIndex }}-tab">
                                        <!-- Accordion -->
                                        {{-- {{dd($module->sub_modules)}} --}}
                                        <div class="accordion p-3 border rounded-3 card-body" id="accordion{{ $moduleIndex }}">
                                            @foreach ($module->sub_modules->where('status', 1)->values() as $subModuleIndex => $subModule)
                                                {{-- @if (!empty($subModule->materials) && $subModule->materials->count() != 0) --}}
                                                    <div class="accordion-item border-0">
                                                        <h5 class="card-header border-bottom bg-transparent"
                                                            id="heading{{ $moduleIndex }}-{{ $subModuleIndex }}">
                                                            <a class="card-link text-muted border-0 {{ $subModuleIndex === 0 ? '' : 'collapsed' }}"
                                                                type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#collapse{{ $moduleIndex }}-{{ $subModuleIndex }}"
                                                                aria-expanded="{{ $subModuleIndex === 0 ? 'true' : 'false' }}"
                                                                aria-controls="collapse{{ $moduleIndex }}-{{ $subModuleIndex }}">
                                                                <i class="fa fa-chevron-down mr-2" aria-hidden="true"></i>
                                                                {{ $subModule->name }}
                                                            </a>
                                                        </h5>
                                                        <div id="collapse{{ $moduleIndex }}-{{ $subModuleIndex }}"
                                                            class="accordion-collapse collapse {{ $subModuleIndex === 0 ? 'show' : '' }}"
                                                            aria-labelledby="heading{{ $moduleIndex }}-{{ $subModuleIndex }}">
                                                            <div class="accordion-body">
                                                                @php
                                                                    $total_metarial = 0;
                                                                    $complete_metarial = 0;

                                                                    $firstMaterial       = $subModule->materials->where('status',1)->first();
                                                                    $firstAssignMaterial = $subModule->assignments->where('status', 1)->first();
                                                                @endphp


                                                                @foreach ($subModule->materials->where('status', 1) as $material)
                                                                    @php
                                                                        $completeddata = DB::table('user_materials')
                                                                            ->where([
                                                                                'material_id' => $material->id,
                                                                                'user_id' => Auth::User()->id,
                                                                            ])
                                                                            ->first();

                                                                        $total_metarial++;
                                                                        $complete_metarial += $completeddata ? 1 : 0;
                                                                    @endphp

                                                                    <div class="d-flex align-items-center">
                                                                        <a href="{{ route('student.material.show', urlencode(base64_encode($material->id))) }}"
                                                                            class="w-100 d-flex align-items-center p-2 module-a text-decoration-none">
                                                                            <span>
                                                                                <i class="fa fa-{{ $material->reading ? 'book' : 'play-circle' }} mr-2 rounded border"
                                                                                    aria-hidden="true"></i>
                                                                            </span>
                                                                            <span>{{ ucwords($material->name) }}
                                                                                <span class="d-block fs-7">
                                                                                    {{ $material->reading ? 'Reading' : 'Video' }}
                                                                                    {{ isset($material->duration) ? ' - ' . $material->duration . ' min' : '' }}
                                                                                </span>
                                                                            </span>
                                                                        </a>
                                                                        <i class="fa {{ $completeddata ? 'fa-check-circle text-success check-success' : 'fa-circle' }} mr-2" aria-hidden="true"></i>
                                                                        <input type="hidden" name="material_ids[]" value="{{ $material->id }}" disabled>
                                                                    </div>
                                                                @endforeach

                                                               
                                                                {{-- @if ($completeddata) --}}
                                                                    @foreach ($subModule->assignments->where('status', 1) as $assignment)
                                                                        @php
                                                                            $completedAnswerdata = DB::table('short_answers')
                                                                                                    ->where([
                                                                                                        'assignment_id' => $assignment->id,
                                                                                                        'user_id' => Auth::User()->id,
                                                                                                        'status' => 1,
                                                                                                    ])->exists();
                                                                            $userAssignment = DB::table('user_assignments')
                                                                                                ->where([
                                                                                                    'assignment_id' => $assignment->id,
                                                                                                    'user_id' => Auth::User()->id,
                                                                                                    'completed' => 1,
                                                                                                ])->exists();
                                                                                                    //dd($completedAnswerdata);
                                                                            $questionCheck = DB::table('questions')
                                                                                                ->where('assignment_id', $assignment->id)
                                                                                                ->exists();

                                                                        @endphp

                                                                        @if($questionCheck)
                                                                            <div class="d-flex align-items-center justify-content-between">
                                                                                <a href="{{ route('student.assignment-data', urlencode(base64_encode($assignment->id))) }}"
                                                                                    class="w-100 d-flex align-items-center p-2 module-a text-decoration-none">
                                                                                    <span><i class="fa fa-rectangle-list mr-2"></i></span>
                                                                                    <span>{{ $assignment->title }}<br>Assignment. {{ $assignment->duration }} min</span>
                                                                                </a>
                                                                                <i class="fa {{ !empty($userAssignment) || !empty($completedAnswerdata) ? 'fa-check-circle text-success check-success' : 'fa-circle' }} mr-2" aria-hidden="true"></i>
                                                                            </div>
                                                                        @endif

                                                                    @endforeach
                                                                {{-- @endif --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                {{-- @endif --}}
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('student-js')
    @if (isset($course->course_modules) && count($course->course_modules) > 0)
        <script>
            $(document).ready(function() {
                @if (isset($course->course_modules) && count($course->course_modules) > 0)
                    get_data('{{ $course->course_modules[0]->id }}');
                @endif
                function get_data(id) {
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
                $(document).on('click', '.moduleId', function() {
                    var id = $(this).attr('data-id');
                    get_data(id);
                });


                $(document).on('click', '.course-material', function(event) {
                    var current_data = $(this);
                    var cm_id = $(this).attr('data-id');

                    $.ajax({
                        type: 'GET',
                        url: "{{ url('/course-material-attempt') }}",
                        data: {
                            'cm_id': cm_id
                        },
                        success: function(response) {
                            console.log(data);
                            $('.error-container').html('');
                            window.setTimeout(function() {
                                $('.new_check_submit').html('Submit');
                                $('.btn-disable').attr('disabled', false);
                            }, 2000);


                        },
                    });

                });
            });
        </script>
    @else
        <p>No course modules available.</p>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // By default, all icons are disabled
            function disableAllIcons() {
                document.querySelectorAll('.fa-circle, .fa-check-circle').forEach(function (icon) {
                    icon.classList.add('disabled'); // Add disabled class initially
                });
            }
            disableAllIcons();

            function checkAllMaterialsCompleted() {
                const totalMaterials = document.querySelectorAll('.fa-circle, .fa-check-circle');
                console.log(totalMaterials);
                const completedMaterials = document.querySelectorAll('.fa-check-circle');
                if (totalMaterials.length === completedMaterials.length) {
                    updateCourseAsCompleted();
                }
            }
            checkAllMaterialsCompleted();

            document.querySelectorAll('.fa-circle, .fa-check-circle').forEach(function (icon) {
                icon.addEventListener('click', function () {
                    if (this.classList.contains('disabled')) {
                        return;
                    }
                    // Toggle class to simulate checking/unchecking
                    this.classList.toggle('fa-check-circle');
                    this.classList.toggle('fa-circle');
                    this.classList.toggle('text-success');
                    checkAllMaterialsCompleted();
                });
            });

            function updateCourseAsCompleted() {
                fetch('{{ route("student.course.complete", ["course_id" => $course->id]) }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        user_id: {{ Auth::user()->id }},
                        course_id: {{ $course->id }},
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Course marked as completed!');
                        const redirectUrl = '{{ route("student.my-learning") }}';
                        window.location.href = redirectUrl;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
        });
    </script>



@endpush
