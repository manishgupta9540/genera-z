@extends('front.master')

@section('title', 'Checkout')
@push('styles')
    <link rel="stylesheet" href="{{ asset('front/css/cart.css') }}">
@endpush
@section('content')
    <section class="h-100 h-custom" style="background-color: #eee;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('cart.index') }}" class="text-body">
                                <i class="fas fa-long-arrow-alt-left me-2"></i>
                                Back To Cart
                            </a>
                        </div>
                        <div class="card-body p-4">
                            <h5 class="p-3 pt-0">Order Summary</h5>
                            @php
                                $subTotal = 0;
                                $discountTotal = 0;
                            @endphp
                            @foreach ($items as $item)
                                @php

                                    $course = $item->course ?? [];

                                    $price = $item->price();
                                    $duration = $item->duration();
                                    $subTotal += $price;
                                @endphp
                                <div class="card shadow-0 border mb-1">
                                    <div class="card-body">
                                        <div class="row">

                                            <div class="col-md-1 d-flex align-items-center">
                                                @php
                                                    $courseImage =
                                                        $course && $course->count() > 0
                                                            ? $course->first()->image
                                                            : $item->image;
                                                    $courseTitle =
                                                        $course && $course->count() > 0
                                                            ? $course->first()->title
                                                            : $item->title;

                                                @endphp


                                                <img src="{{ Storage::url('uploads/course/' . $courseImage) }}"
                                                    class="img-fluid" style="max-width: 50px;">

                                                {{-- <h6 class="p-0 m-0">{{ $courseTitle }}</h6> --}}

                                            </div>
                                            <div class="col-md-7">
                                                <h6 class="p-0 m-0">{{ $courseTitle }}</h6>
                                                <p class="text-muted mb-0">{{ $item->realPrice() }} AED</p>
                                            </div>
                                            <div
                                                class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                                <p class="text-muted mb-0 small">{{ $duration }}</p>
                                            </div>
                                            <div
                                                class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                                <p class="text-muted mb-0 small">{{ $price }} AED</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="d-flex justify-content-between pt-2">
                                <p class="fw-bold mb-0">Order Details</p>
                            </div>

                            <div class="d-flex justify-content-between pt-2 px-2">
                                <p class="text-muted mb-0">Sub Total</p>
                                <p class="text-muted mb-0">{{ number_format($subTotal, 2) }} AED</p>
                            </div>

                            <div class="d-flex justify-content-between pt-2 px-2">
                                <p class="text-muted mb-0">Discounts</p>
                                <p class="text-muted mb-0">{{ number_format($discountTotal, 2) }} AED</p>
                            </div>
                            <div class="d-flex justify-content-between pt-2 px-2">
                                <p class="text-muted mb-0">VAT</p>
                                <p class="text-muted mb-0"> 5 %</p>
                            </div>
                            <hr class="my-1">
                            <div class="d-flex justify-content-between pt-2 px-2">
                                @php
                                    $amount = floatval(number_format($subTotal - $discountTotal, 2, '.', ''));
                                    $taxAmount = ($amount * 5) / 100;
                                    $finalAmount = $amount + $taxAmount;
                                @endphp
                                <p class="text-muted mb-0">Total</p>
                                <p class="text-muted mb-0">{{ $finalAmount ?? 0 }} AED</p>
                            </div>

                        </div>
                        <button type="button" class="card-footer border-0 rounded-bottom" initiatePayment
                            style="background-color: #a8729a;">
                            <h5 class="text-white text-center py-2">
                                Proceed To Payment
                            </h5>
                        </button>
                    </div>
                </div>
            </div>
            <div>
                <div>
                    <div>
                        <span>
                            <span>
                                <form id="initiate-pay" name="initiatePayment"
                                    action="{{ route('initiatePayment', [urlencode(base64_encode($id)), urlencode(base64_encode($priceIds))]) }}"
                                    method="post">
                                    @csrf
                                </form>
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('custom-scripts')
    <script>
        $('[initiatePayment]').on('click', function() {
            document.initiatePayment.submit();
        })
    </script>
@endpush
