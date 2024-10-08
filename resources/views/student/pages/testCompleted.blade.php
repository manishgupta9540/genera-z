@extends('student.master')

@section('title', 'Assignment Completed')

@section('content')
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="container my-5">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box shadow bg-white p-3 text-center">
                            Assignment Test is completed.
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="box shadow bg-white p-3 text-center">
                            <strong>Your Passing Score : </strong> {{$passingScore}}%
                            <br><br>
                            @if(!empty($userAssign))
                            <strong>Your Percentage Score : </strong> {{$userAssign->score}}%
                            @else
                            <strong>Your Percentage Score : </strong> 0.00%
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
