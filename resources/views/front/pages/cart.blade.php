@extends('front.master')

@section('title', 'Cart')
@push('styles')
    <link rel="stylesheet" href="{{ asset('front/css/cart.css') }}">
@endpush
@section('content')
    <section class="h-100 h-custom" style="background-color: #eee;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col">
                    <div class="card">
                        <div class="card-body p-4">

                            <div class="row">

                                <div class="col-lg-7">
                                    <h5 class="mb-3"><a href="#!" class="text-body"><i
                                                class="fas fa-long-arrow-alt-left me-2"></i>Continue shopping</a></h5>
                                    <hr>

                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div>
                                            <p class="mb-0">You have {{ count($carts) }} items in your cart</p>
                                        </div>
                                        <!--                                         <div>
                                                <p class="mb-0"><span class="text-muted">Sort by:</span> <a href="#!"
                                                        class="text-body">price <i class="fas fa-angle-down mt-1"></i></a></p>
                                            </div> -->
                                    </div>
                                    <div>
                                        @php
                                            $subTotal = 0;
                                            $discountTotal = 0;
                                        @endphp
                                        @foreach ($carts as $item)
                                            @php
                                                $course = $item->course;
                                                $price = $item->price();
                                                $duration = $item->duration();
                                                $subTotal += $price;
                                            @endphp
                                            <div class="card mb-3">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="d-flex flex-row align-items-center">
                                                            <div>
                                                                <img src="{{ Storage::url('uploads/course/' . $course->image) }}"
                                                                    class="img-fluid rounded-3" alt="{{ $course->title }}"
                                                                    style="width: 65px;">
                                                            </div>
                                                            <div class="ms-3">
                                                                <h6>{{ $course->title }} </h6>
                                                                <p class="small mb-0">{{ $duration }} month(s) |
                                                                    {{ number_format($item->realPrice(), 2) }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex flex-row align-items-center">
                                                            <div class="mx-2">
                                                                <p class="mb-0">{{ number_format($price, 2) }} AED</p>
                                                            </div>
                                                            <a href="javascript:void(0)"
                                                                class="btn btn-danger btn-circle deleteRecord"
                                                                url="{{ route('cart.destroy', urlencode(base64_encode($item->id))) }}">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                                <div class="col-lg-5">
                                    <div class="card text-white rounded-3">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-4">
                                                <h5 class="mb-0">Payment Details</h5>
                                                <img src="{{ asset('front/img/GZlogoB.png') }}"
                                                    class="img-fluid rounded-3 float-right" style="width: 100px;"
                                                    alt="Avatar">
                                            </div>

                                            <hr class="my-4">

                                            <div class="d-flex justify-content-between">
                                                <p class="mb-2">Subtotal</p>
                                                <p class="mb-2">{{ number_format($subTotal, 2) }} AED</p>
                                            </div>

                                            <div class="d-flex justify-content-between">
                                                <p class="mb-2">Discount</p>
                                                <p class="mb-2">{{ number_format($discountTotal, 2) }} AED</p>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <p class="mb-2">VAT</p>
                                                <p class="mb-2"> 5 %</p>
                                            </div>

                                            <div class="d-flex justify-content-between mb-4">
                                                <p class="mb-2">Total(Incl. taxes)</p>
                                                @php
                                                    $amount = floatval(
                                                        number_format($subTotal - $discountTotal, 2, '.', ''),
                                                    );
                                                    $taxAmount = ($amount * 5) / 100;
                                                    $finalAmount = $amount + $taxAmount;
                                                @endphp
                                                <p class="mb-2">{{ $finalAmount ?? 0 }} AED
                                                </p>
                                            </div>
                                            @if (count($carts))
                                                <button type="button" name="checkout" checkout
                                                    data-target="{{ base64_encode(route('checkout')) }}"
                                                    class="btn btn-bg float-right btn-block btn-lg">
                                                    <div class="d-flex justify-content-between">
                                                        <span> Checkout <i
                                                                class="fas fa-long-arrow-alt-right ms-2"></i></span>
                                                    </div>
                                                </button>
                                            @endif

                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('custom-scripts')
    <script>
        $('[name="checkout"]').on('click', function() {
            window.location.href = atob($(this).attr('data-target'))
        })
    </script>
@endpush
