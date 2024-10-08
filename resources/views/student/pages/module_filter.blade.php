<div id="sub_module_append">
    <div id="accordion2">
        @if (count($subModules) > 0)
            @foreach ($subModules as $index => $item)
            {{-- $item->materials --}}
            <div class="card shadow-none">
                    <div class="card-header border-bottom">
                        <a class="card-link text-muted" data-toggle="collapse" href="#collapse{{ $index }}">
                            <i class="fa fa-chevron-down mr-2" aria-hidden="true"></i> {{ $item->name }}
                        </a>
                    </div>
                    
                    <div id="collapse{{ $index }}" class="collapse {{ $index == 0 ? 'show' : '' }}" data-parent="#accordion2">
                       @if ($item->count() > 0)
                      
                            @foreach ($item->materials  as $material)
                                <div class="card-body">
                                    <p>
                                        <a href="{{ url('course-material-details/'.base64_encode($material->id)) }}"  data-id="{{$material->id}}" class=" w-100 d-flex align-items-center p-2 module-a text-decoration-none">
                                            <i class="fa fa-check-circle grade-icon mr-2" aria-hidden="true"></i>
                                            <span>{{ $material->video_name }}</span>
                                        </a>
                                    </p>
                                    <p>
                                        <a href="{{ url('course-material-title/'.base64_encode($material->id)) }}"  data-id="{{$material->id}}" class="course-material w-100 d-flex align-items-center p-2 module-a text-decoration-none">
                                            <i class="fa fa-check-circle grade-icon mr-2" aria-hidden="true"></i>
                                            <span>{{ $material->material_name }}</span>
                                        </a>
                                    </p>
                                </div>
                            @endforeach
                        @else
                            <div class="card-body">
                                <p>No Course  Metarial</p>
                            </div>
                        @endif

                        @if ($item->count() > 0)
                            @foreach ($item->assignments as $assignment)
                                <div class="card-body">
                                    <p>
                                        <a href="{{ url('course-material-quize/' . base64_encode($assignment->id)) }}" class="w-100 d-flex align-items-center p-2 module-a text-decoration-none">
                                            <i class="fa fa-check-circle grade-icon mr-2" aria-hidden="true"></i>
                                            <span>{{ $assignment->title }}</span>
                                        </a>
                                    </p>
                                </div>
                            @endforeach
                        @else
                            <div class="card-body">
                                <p>No Assignment</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <h5>No Module Found</h5>
        @endif
       
    </div>
</div>