@extends('front.master')

@section('title', 'Training')

@section('content')
    <style>
        .certificate {
            background-color: #ddfdff78;
        }

        .enroll-btn {
            background-color: #40999d;
            color: white;
        }

        .inactive {
            background-color: #ddfdff78;
            border-radius: 6px;
        }

        .certificate-span {
            background-color: rgb(240, 239, 239);
        }

        .box3 img {
            position: absolute;
            top: -65px;
        }

        .nav-pills .nav-link.active {
            border: 1px solid #40999d;
            background: #40999d;
            color: white !important;
        }

        .nav-pills .nav-link {
            border: 1px solid #40999d;
            color: #40999d !important;
        }

        .show-btn {
            border: 1px solid #40999d;
            background-color: #40999d;
            color: white;
            height: 60px;
        }

        .explore-btn {
            border: 1px solid white;
            background-color: white;
            color: #40999d;
        }

        .section2 {
            background-color: #ddfdff78;
        }

        .join-input {
            height: 60px;
        }

        .join-h1 {
            font-size: 40px;
        }

        .category-h1 {
            font-size: 40px;
            color: white;
        }

        .training-banner {
            background-color: #40999d;
            color: white;
            margin-top: 100px;
        }

        .training-img {
            filter: invert(1);
        }
    </style>
    <section class="training-banner mb-5">
        <div class="container-fluid p-5">
            <div class="container py-5">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h1 class="category-h1 mb-4"><strong>Course - Category</strong></h1>
                        <p class="mb-5 text-white">Lorem ipsum dolor sit amet consectetur adipisicing elit. Harum quos
                            ratione ducimus accusantium ad suscipit, possimus commodi nobis beatae porro necessitatibus
                            laudantium esse eaque quasi tempora quae vitae iure! Ratione.</p>
                        <a href="#" class="explore-btn px-5 py-3 rounded text-decoration-none">Explore</a>
                    </div>
                    <div class="col-md-6 text-center">
                        <img src="{{ asset('front/img/homework.png') }}" alt="" class="w-50 training-img">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="certificate-header">
        <div class="container-fluid">
            <div class="container my-4">
                <div class="row">
                    <div class="col-md-4">
                        <div class="box border p-5 rounded h-100">
                            <h4><b>Category</b></h4>
                            <ul class="nav nav-pills mt-4">
                                @foreach ($categories as $category)
                                    <li class="nav-item w-100 {{ $loop->first ? '' : 'mt-2' }}">
                                        <a class="categoryFilter nav-link {{ $loop->first ? 'active' : '' }} text-secondary"
                                            data-id="{{ $category->id }}" data-toggle="pill"
                                            href="#category{{ $loop->iteration }}">{{ $category->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="tab-content">
                            @foreach ($categories as $category)
                            <div class="tab-pane container {{ $loop->first ? 'active' : '' }}" id="category{{ $loop->iteration }}">
                                <div class="row">
                                    @if (count($category->courses) > 0)
                                        @foreach ($category->courses as $item)
                                            @if (!in_array($item->id, $data) && $item->status == 1 && count($item->modules) > 0)
                                                <div class="col-md-4 mb-4">
                                                    <div class="card rounded border shadow-none h-100">
                                                        <a href="{{ url('course/' . urlencode(base64_encode($item->id))) . '/detail' }}" class="text-decoration-none">
                                                            <img class="card-img-top p-2 rounded" src="{{ Storage::url('uploads/course/' . $item->image) }}" alt="Card image" style="width:100%; height: 150px; object-fit: cover;">
                                                            <div class="card-body">
                                                                <h5 class="card-title">{{ $item->title }}</h5>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @else
                                    <div class="col-12 d-flex justify-content-center align-items-center">
                                        <h1>No Course Found</h1>
                                    </div>

                                    @endif
                                </div>
                            </div>
                        @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- <section class="section2 mt-5">
    <div class="container-fluid p-5">
         <div class="container py-5">
              <div class="row align-items-center">
                   <div class="col-md-4">
                        <h1 class="join-h1 mb-0"><strong>Join Our Community!</strong></h1>
                        <div class="progress w-50 mb-4" style="height: 5px;">
                             <div class="progress-bar" style="width:100%; height: 5px; background-color: #40999d;"></div>
                        </div>
                        <p class="mb-0">Stay up to date on the latest news and developments in the world of education.</p>
                   </div>
                   <div class="col-md-8">
                        <form>
                             <div class="input-group mb-0">
                                  <input type="email" class="form-control join-input rounded-0" placeholder="Enter your email here.">
                                  <div class="input-group-append">
                                      <a href="#" class="input-group-text show-btn rounded-0 px-5 text-decoration-none">Subscribe Now</a>
                                  </div>
                             </div>
                        </form>
                   </div>
              </div>
         </div>
    </div>
</section> --}}

@endsection

@push('custom-scripts')
    <script type="text/javascript" src="https://demo.dashboardpack.com/architectui-html-free/assets/scripts/main.js">
    </script>
    @if (session('signin_modal'))
        <script>
            $(document).ready(function() {
                $('.loignmodal').trigger('click');
            });
        </script>
    @endif

    <script>
        $(document).ready(function() {


            //filter category
            $(document).on('click', '.categoriesFilter', function(event) {
                var id = $(this).attr('data-id');

                $.ajax({
                    type: 'GET',
                    url: "{{ url('/category-filter') }}",
                    data: {
                        'id': id
                    },
                    success: function(response) {
                        console.log(response);
                        $('#category').replaceWith(response);
                    },
                });
            });


        });
    </script>

@endpush
