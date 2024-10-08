@extends('student.master')

@section('title', 'Student Dashboard')
@push('styles')
    <style>
        .btn-bg {
            background-color: #40999d;
            color: white
        }

        input[type="file"]::file-selector-button {
            background-color: #ced4da;
            color: #495057;
            padding: 10px 20px;
            border-top: none;
            border-bottom: none;
            border-left: none;
            border-right: 1px solid #ced4da;
            border-radius: 0px;
            cursor: pointer;
            height: 50px !important;
        }

        .myinput {
            border: 1px solid #ced4da;
            border-radius: .25rem;
            height: 50px !important;
        }

        .form-control {
            display: block;
            width: 100%;
            height: 50px !important;
            padding: .375rem .75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: .25rem;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        .error {
            color: red;
        }

        #englishToArabic {
            /* width: 300px ; */
            padding: 10px;
            font-size: 16px;
        }
        a.rounded-pill{
             margin-left: 20px;
        }
    </style>
@endpush
@section('content')

    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="container-fluid my-5">
                <div class="row">
                    {{-- <div class="col-md-12 mb-4">
                        <h3><b>My Learning</b></h3>
                    </div> --}}
                    <div class="col-md-12">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                              <a class="nav-link active rounded-pill px-4 py-2 mr-4" data-toggle="tab" href="#profile">Profile</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link rounded-pill px-4 py-2" data-toggle="tab" href="#certificate">KHDA Certificate</a>
                            </li>
                          </ul>

                          <!-- Tab panes -->
                          <div class="tab-content">
                            <div class="tab-pane active mx-0 px-0" id="profile">
                                <div class="container-fluid my-5">
                                    <div class="row">
                                        <div class="col-md-12 mb-4">
                                            <h3><b>My Profile</b></h3>
                                        </div>
                                    </div>
                                    <div class="row">
                                      <div class="box bg-white w-100 p-0">
                                           <div class="row px-3">
                                                <div class="col-md-5 px-0">
                                                     <div class="img-box h-50">
                                                          <div class="profile-content text-center text-white">
                                                               <img src="{{ $students->image ? asset('uploads/studentProfile/'.$students->image) : asset('front/img/profile.png') }}" class="rounded-circle profile-img" style="width: 220px; height:220px;">
                                                               <h6 class="mt-2"><b>{{ $students->name ?? ""}}</b></h6>

                                                          </div>
                                                     </div>
                                                     <div class="img-box2 h-50"></div>
                                                </div>
                                                <div class="col-md-7 p-5">
                                                     <h5><b>Profile Information</b></h5>
                                                     <p>Hi, I'm Alec Thompson, Decisions: If you can't decide, the answer is no. <br> If two equally difficult paths, choose the one more painful in the short term <br> (pain avoidance is creating an illusion of equality).</p>
                                                     <table class="w-100 profile-table">
                                                          <tr>
                                                               <td class="w-25"><b>Full Name</b></td>
                                                               <td class="w-25"><b>:</b></td>
                                                               <td class="w-50">{{ $students->name ?? ""}}</td>
                                                          </tr>
                                                          <tr>
                                                               <td class="w-25"><b>Mobile</b></td>
                                                               <td class="w-25"><b>:</b></td>
                                                               <td class="w-50">{{ $students->phone_number }}</td>
                                                          </tr>
                                                          <tr>
                                                               <td class="w-25"><b>Email</b></td>
                                                               <td class="w-25"><b>:</b></td>
                                                               <td class="w-50">{{ $students->email }}</td>
                                                          </tr>
                                                          <tr>
                                                               <td class="w-25"><b>Country</b></td>
                                                               <td class="w-25"><b>:</b></td>
                                                               <td class="w-50">{{ $students->country->name ?? ""}}</td>
                                                          </tr>
                                                     </table>
                                                     <div class="mt-5">
                                                          <a href="{{route('edit-profile')}}" class="btn btn-bg2 py-3 w-25 mr-4">Edit Profile</a>
                                                          {{-- <a href="edit-profile.html" class="btn btn-bg py-3 w-25">Change Password</a> --}}
                                                     </div>
                                                </div>
                                           </div>
                                      </div>
                                    </div>
                                </div>
                            </div>

                            @if(!empty($khdaCerficate) && $khdaCerficate->status==1)
                            <div class="tab-pane fade mx-0 px-0" id="certificate">
                                <div class="container-fluid my-5">
                                    <div class="row">
                                      <div class="box bg-white w-100 py-5">
                                        <div class="container py-5">
                                            <div class="row justify-content-center">
                                                <div class="col-md-6 text-center">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h5 class="mb-0">To obtain an attested KHDA certificate, apply  process is completed...</h5>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-5">
                                                        <div class="col-md-12">
                                                            <img src="{{asset('front/img/image_2024_08_26T10_20_41_341Z.png')}}" alt="" class="w-25">
                                                        </div>
                                                    </div>
                                                    {{-- <div class="row mt-5">
                                                        <div class="col-md-12">
                                                            <button type="submit" class="btn btn-bg w-50 py-3" data-toggle="modal" data-target="#myModalone">Apply</button>
                                                        </div>
                                                    </div> --}}
                                                </div>
                                            </div>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="tab-pane fade mx-0 px-0" id="certificate">
                                <div class="container-fluid my-5">
                                    <div class="row">
                                      <div class="box bg-white w-100 py-5">
                                        <div class="container py-5">
                                            <div class="row justify-content-center">
                                                <div class="col-md-6 text-center">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h5 class="mb-0">To obtain an attested KHDA certificate, apply here. Note that it will cost an additional 80 AED.</h5>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-5">
                                                        <div class="col-md-12">
                                                            <img src="{{asset('front/img/image_2024_08_26T10_20_41_341Z.png')}}" alt="" class="w-25">
                                                        </div>
                                                    </div>
                                                    <div class="row mt-5">
                                                        <div class="col-md-12">
                                                            <button type="submit" class="btn btn-bg w-50 py-3" data-toggle="modal" data-target="#myModalone">Apply</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


<div class="modal" id="myModalone">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-white px-4 align-items-center">
                <h4 class="modal-title"><strong>Attested KHDA Certificate</strong></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body px-4">
                <form id="initiate-pay" name="initiatePayment" action="{{ route('payment-attested') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="usr">Name in Arabic</label>
                            <input type="text" class="form-control" id="englishToArabic" name="name_arabic">
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="usr">Name in English</label>
                            <input type="text" class="form-control" id="usr_english" name="username_english">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="religion">Religion</label>
                            <input type="text" class="form-control" id="religion" name="religion">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="gender">Gender</label>
                            <select class="form-control" name="gender" id="gender">
                                <option value="" disabled selected>Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="DOB">DOB</label>
                            <input type="date" class="form-control" id="DOB" name="dob">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="nationality">Nationality</label>
                            <select class="form-control" name="nationality" id="nationality">
                                <option value="" disabled selected>Select Nationality</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Muslim">Muslim</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="passport_number">Passport Number</label>
                            <input type="text" class="form-control" maxlength="9" id="passport_number" name="passport_number">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="passport">Passport</label>
                            <input type="file" class="form-control" id="passport" name="passport_image">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-bg w-100 py-3" initiatePayment>Submit</button>
                        </div>
                    </div>
                </form>

            </div>
            <!-- Modal footer -->
            {{-- <div class="modal-footer bg-white">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div> --}}
        </div>
    </div>
</div>


@push('student-js')
    <script>
        $(document).ready(function() {
            // Define a mapping of English characters to Arabic characters
            const englishToArabicMap = {
                'a': 'ا',
                'b': 'ب',
                'c': 'پ',
                'd': 'ت',
                'e': 'ث',
                'f': 'ج',
                'g': 'چ',
                'h': 'ح',
                'i': 'خ',
                'j': 'د',
                'k': 'ڈ',
                'l': 'ذ',
                'm': 'ر',
                'n': 'ز',
                'o': 'س',
                'p': 'ش',
                'q': 'ص',
                'r': 'ض',
                's': 'ط',
                't': 'ظ',
                'u': 'ع',
                'v': 'غ',
                'w': 'ف',
                'x': 'ق',
                'y': 'ک',
                'z': 'گ',
                'A': 'آ',
                'B': 'ب',
                'C': 'پ',
                'D': 'ت',
                'E': 'ث',
                'F': 'ج',
                'G': 'چ',
                'H': 'ح',
                'I': 'خ',
                'J': 'د',
                'K': 'ڈ',
                'L': 'ذ',
                'M': 'ر',
                'N': 'ز',
                'O': 'س',
                'P': 'ش',
                'Q': 'ص',
                'R': 'ض',
                'S': 'ط',
                'T': 'ظ',
                'U': 'ع',
                'V': 'غ',
                'W': 'ف',
                'X': 'ق',
                'Y': 'ک',
                'Z': 'گ'
            };

            $('#englishToArabic').on('input', function() {
                let inputVal = $(this).val();
                let arabicVal = '';

                // Convert each character based on the mapping
                for (let char of inputVal) {
                    arabicVal += englishToArabicMap[char] || char; // Convert or keep the character
                }

                $(this).val(arabicVal);
            });
        });

        $(document).ready(function() {
            // Custom validation method for passport numbers
            $.validator.addMethod("passportNumber", function(value, element) {
                return this.optional(element) || /^[A-Z0-9]{6,9}$/.test(value);
            }, "Please enter a valid passport number.");

            // Custom validation method to allow only alphabetic characters
            $.validator.addMethod("onlyAlphabets", function(value, element) {
                return this.optional(element) || /^[a-zA-Z\u0600-\u06FF\s]+$/.test(value);
            }, "Please enter only alphabets.");

            $('#initiate-pay').validate({
                rules: {
                    name_arabic: {
                        required: true,
                        onlyAlphabets: true
                    },
                    username_english: {
                        required: true,
                        onlyAlphabets: true
                    },
                    religion: "required",
                    gender: "required",
                    dob: "required",
                    email: {
                        required: true,
                        email: true,
                        remote: {
                            url: '/check-email-unique',
                            type: 'POST',
                            data: {
                                email: function() {
                                    return $('#email').val();
                                },
                                _token: $('meta[name="csrf-token"]').attr('content')
                            }
                        }
                    },
                    nationality: "required",
                    passport_number: {
                        required: true,
                        passportNumber: true
                    }
                },
                messages: {
                    name_arabic: {
                        required: "Please enter your name in Arabic.",
                        onlyAlphabets: "Please enter only alphabets in Arabic."
                    },
                    username_english: {
                        required: "Please enter your name in English.",
                        onlyAlphabets: "Please enter only alphabets in English."
                    },
                    religion: "Please specify your religion.",
                    gender: "Please select your gender.",
                    dob: "Please provide your date of birth.",
                    email: {
                        required: "Please enter a valid email address.",
                        email: "Please enter a valid email address.",
                        remote: "This email is already in use. Please use a different email address."
                    },
                    nationality: "Please select your nationality.",
                    passport_number: {
                        required: "Please provide your passport number.",
                        passportNumber: "Please enter a valid passport number."
                    }
                },
                submitHandler: function(form) {
                    document.initiatePayment.submit();
                }
            });
        });

        function testInput(event) {
            var value = String.fromCharCode(event.which);
            var pattern = new RegExp(/[a-zåäö ]/i);
            return pattern.test(value);
        }

        $('#englishToArabic,#usr_english,#religion').bind('keypress', testInput);
    </script>
@endpush
