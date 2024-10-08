@extends('student.master')

@section('title', 'My Purchases')

@section('content')

    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="container-fluid my-5">
                <div class="row">
                    <div class="col-md-12">
                        <h3><b>Payment History</b></h3>
                    </div>
                    <div class="col-md-12">
                        <ul class="nav nav-tabs p-3">
                            {{-- <li class="nav-item">
                                <span class="nav-link rounded-pill px-4 py-2 mr-4"
                                    >Payment History</span>
                            </li> --}}
                            {{-- <li class="nav-item">
                                <a class="nav-link rounded-pill px-4 py-2" data-toggle="tab" href="#method">Payment
                                    Method</a>
                            </li> --}}
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane container active mx-0 px-0" id="history">
                                <table class="w-100 table">
                                    <thead class="table-success">
                                        <tr>
                                            <th class="px-3 text-center">Date</th>
                                            <th class="px-3 text-center">Courses Purchased</th>
                                            <th class="px-3 text-center">Amount</th>
                                            <th class="px-3 text-center">Transaction ID</th>
                                            <th class="px-3 text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($payments))
                                            @foreach ($payments as $payment)
                                                <tr class="box bg-white">
                                                    <td class=" px-3 border-right text-center">
                                                        {{ $payment->created_at->format('j M, Y') }}</td>
                                                    <td class="w-50 px-3 border-right">
                                                        @foreach ($payment->paymentCourses as $index => $paymentCourse)
                                                            {{ $paymentCourse->course->title }}{!! $index != count($payment->paymentCourses) - 1 ? ', ' : '' !!}
                                                        @endforeach
                                                    </td>
                                                    <td class=" px-3 border-right text-center">{{ $payment->amount }} AED
                                                    </td>
                                                    <td class=" px-3 border-right text-center">{{ $payment->tracking_id }}
                                                    </td>
                                                    @if ($payment->status)
                                                        <td class=" px-3 text-center text-warning">Pending</td>
                                                    @else
                                                        <td class=" px-3 text-center text-success">Success</td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4" class="py-5 px-3 text-center">
                                                    <h1>No Payments Details Found</h1>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane container fade mx-0 px-0" id="method">
                                <div class="box bg-white payment-box">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <form action="#" class="p-5">
                                                <div class="row align-items-center">
                                                    <div class="col-md-3">
                                                        <label for="n-card" class="mb-0">Name of Card</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="mt-0 w-100" name="n-card"
                                                            id="n-card" placeholder="User Name">
                                                    </div>
                                                </div>
                                                <div class="row align-items-center mt-4">
                                                    <div class="col-md-3">
                                                        <label for="card-n" class="mb-0">Card Number</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="mt-0 w-100" name="card-n"
                                                            id="card-n" placeholder="1234-1234-1234-1234">
                                                    </div>
                                                </div>
                                                <div class="row align-items-center mt-4">
                                                    <div class="col-md-3">
                                                        <label for="exp" class="mb-0">Expiry Date</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="date" class="mt-0 w-100" name="exp"
                                                            id="exp">
                                                    </div>
                                                </div>
                                                <div class="row align-items-center mt-4">
                                                    <div class="col-md-3">
                                                        <label for="cvv" class="mb-0">CVV</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="password" class="mt-0 w-100" name="cvv"
                                                            id="cvv" placeholder="xxx">
                                                    </div>
                                                </div>
                                                <div class="row align-items-center mt-4">
                                                    <div class="col-md-3">
                                                        <label for="country" class="mb-0">Country</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <select name="country" id="country" class="mt-0 w-100">
                                                            <option class="selected" value="country" selected>Country
                                                            </option>
                                                            <option class="selected" value="country">India</option>
                                                            <option class="selected" value="country">USA</option>
                                                            <option class="selected" value="country">Russia</option>
                                                            <option class="selected" value="country">England</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row align-items-center mt-4">
                                                    <div class="col-md-12">
                                                        <button type="submit" class="btn btn-bg py-3 w-50">Save</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
