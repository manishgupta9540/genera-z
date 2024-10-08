<div class="modal-header">
    <h1 class="modal-title fs-5" id="enrolModalLabel">Enroll To This Course</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<!-- Modal body -->
<div class="modal-body px-5">
    <form action="{{ route('course.enrol', urlencode(base64_encode($course->id))) }}" method="post" id="paymentForm">
        @csrf

        @if ($course->one_time)
            <div class="text-center mb-2">
                <h4>{{ $course->title }}</h4>
            </div>
            <div class="text-left">
                <p class="my-1 fw-bold">Your Plan Details </p>
                {!! $course->plan_info !!}
                <b>
                    <div id="total_price" class="d-flex justify-content-between"> <span class="text-start">Total :
                        </span><span class="text-end"> {{ $course->price }} AED</span> </div>
                </b>
            </div>
        @else
            <div class="mt-4">
                @if (count($course->priceOptions))
                    <!-- Nav tabs -->
                    <input type="hidden" id="priceOptionId" name="price_option_id" value="{{urlencode(base64_encode($course->priceOptions[0]->id))}}">
                    <ul class="nav nav-tabs justify-content-between" role="tablist">
                        @foreach ($course->priceOptions as $index => $item)
                            <li class="nav-item mx-1 text-center">
                                <a class="nav-link priceOptionLink rounded px-5 py-3 @if ($index == 0) active @endif"
                                    id="tab{{ $index }}-tab" data-toggle="tab" href="#tab{{ $index }}"
                                    role="tab" aria-controls="tab{{ $index }}"
                                    aria-selected="{{ $index == 0 ? 'true' : 'false' }}"
                                    data-id="{{ urlencode(base64_encode($item->id)) }}">
                                    {{ $item->duration }} Month(s)
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content mt-4">
                        @foreach ($course->priceOptions as $index => $item)
                            <div class="tab-pane fade @if ($index == 0) show active @endif"
                                id="tab{{ $index }}" role="tabpanel"
                                aria-labelledby="tab{{ $index }}-tab">
                                <div class="">
                                    <p id="item_details">{!! $item->details !!}</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p>ESTIMATED STUDY TIME</p>
                                    <p>
                                        <b class="bold-tags1" id="price">{{ $item->price }}/month</b>
                                    </p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p><b class="bold-tags1" id="access_duration">{{ $item->duration }} Month(s)</b>
                                    </p>
                                    <p id="total_price"> <b>Total : {{ $item->price * $item->duration }} AED</b> </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        @endif

        <input type="hidden" name="enrolType" id="enrolType" >
        <div class="d-flex justify-content-between mt-4">
            <button type="button" data-id="{{urlencode(base64_encode(config('constants.enrolTypes.add_to_cart.id')))}}" class="btn-bg btn px-5 p-3 enrol-submit mb-3">Add To Cart</button>
            <button type="button" data-id="{{urlencode(base64_encode(config('constants.enrolTypes.buy_now.id')))}}" class="btn-bg btn px-5 p-3 enrol-submit mb-3">Enroll Now</button>
            {{-- <button type="button"  id="pirceId"  name="checkout" data-course-id="{{ base64_encode($course->id) }}"   data-target="{{ base64_encode(route('checkout')) }}" class="btn-bg float-right btn-block btn-lg btn px-5 p-3 mb-3">
                Buy Now
            </button> --}}



        </div>
    </form>
    <script>
        $('body').on('click', '.priceOptionLink', function() {
            $('#priceOptionId').val($(this).attr('data-id'))
            $('#pirceId').attr('data-id',$(this).attr('data-id'))

        })
        $('body').on('click','.enrol-submit',function () {
            $('#enrolType').val($(this).attr('data-id'))
            $(this).closest('form').trigger('submit');
        })

        $(document).ready(function() {
        $('[name="checkout"]').on('click', function() {
            let courseId = ($(this).attr('data-course-id'));
            let priceId = ($(this).attr('data-id'));
            console.log(courseId,priceId)
            let targetUrl = atob($(this).attr('data-target')) + '/' + courseId +'/'+priceId;
            window.location.href = targetUrl;
        });
    });




    </script>
</div>
