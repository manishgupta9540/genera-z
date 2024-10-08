<div id='category'>
    <div class="row">
        @if (count($courses) > 0)
            @foreach ($courses as $item)
                <div class="col-md-4 mb-4">
                    <div class="card rounded border shadow-none h-100">
                        <a href="{{ url('course/'.base64_encode($item->id).'/detail') }}" class="text-decoration-none">
                            <img class="card-img-top p-2 rounded" src="{{ asset('uploads/course/'.$item->image) }}" alt="Card image" style="width:100%; height: 150px; object-fit: cover;">
                            <div class="card-body">
                                {{-- <p class="card-text">{{ $item->course_overview }}</p> --}}
                                <h4 class="card-title"><b>{{ $item->course_title }}</b></h4>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        @else
        <div class="col-12 d-flex justify-content-center align-items-center" style="height: 100vh;">
            <h1>No Course Found</h1>
        </div>

        @endif
    </div>
</div>
