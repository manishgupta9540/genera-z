@extends('student.master')

@section('title', 'Edit Profile')

@section('content')
<style>
    .select2-selection--single {
                border: 1px solid #ced4da !important;
                border-radius: .25rem;
                height: 50px !important;
            }
            .select2-selection__rendered {
                padding-top: 10px !important;
            }
            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 26px;
                position: absolute;
                top: 10px !important;
                right: 1px;
                width: 20px;
            }
            .select2-container--default .select2-selection--single .select2-selection__rendered {
                color: #495057cf !important;
                line-height: 28px;
            }

            span.show-hide-password {
                position: absolute;
               cursor: pointer;
                z-index: 6;
                right: 13px;
               margin-top: -32px;
            }
            a.rounded-pill{
             margin-left: 20px;
            }
</style>
<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="container-fluid my-5">
         <div class="row">
              <div class="col-md-12">
                <ul class="nav nav-tabs p-3">
                    <li class="nav-item">
                        <a class="nav-link active rounded-pill px-4 py-2 mr-4" data-toggle="tab"
                            href="#edit">Profile Setting</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link rounded-pill px-4 py-2 mr-4" data-toggle="tab"
                            href="#change">Change Password</a>
                    </li>
                </ul>
                  <ul class="nav nav-pills">
                  </ul>
                    <!-- Tab panes -->
                  <div class="tab-content">
                    <div class="tab-pane edit-tabs container active mx-0 px-0" id="edit">
                      <div class="row">
                          <div class="col-md-10 p-2">
                              <form action="{{ route('profile-save')}}" method="post" id="profile-edit" class="edit-form bg-white p-4">
                                @csrf
                                  <div class="row">
                                      <div class="col-md-12">
                                          <p><b>Your Profile  Picture</b></p>
                                          <div class="edit-upload w-25 text-center">
                                              <label for="file-upload" class="custom-file-upload">
                                                  <i class="fa-solid fa-image edit-image"></i>
                                                  Upload your photo
                                              </label>
                                              <input id="file-upload" type="file" name="image"/>
                                              <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-image"></p>
                                          </div>
                                      </div>
                                      @if($students->image!=NULL && file_exists(public_path('uploads/studentProfile/'.$students->image)))
                                      <div class="col-sm-6">
                                          <div class="form-group">
                                              <a href="{{asset('uploads/studentProfile/'.$students->image)}}" target="_blank">
                                                  <img src="{{asset('uploads/studentProfile/'.$students->image)}}" width="100px" height="100px">
                                              </a>
                                          </div>
                                      </div>
                                  @endif
                                  </div>
                                  <hr>
                                  <div class="row">
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label for="fname">First Name</label>
                                              <input type="hidden" name="id" value="{{ $students->id }}" id="">
                                              <input type="text" class="form-control" name="name" value="{{ $students->name ?? ""}}" id="fname" placeholder="Please enter your first name">
                                              <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-name"></p>
                                          </div>
                                      </div>
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label for="lname">Last Name</label>
                                              <input type="text" class="form-control" name="last_name" value="{{ $students->last_name ?? ""}}" id="lname" placeholder="Please enter your last name">
                                              <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-last_name"></p>
                                          </div>
                                      </div>
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label for="email">Email</label>
                                              <input type="email" class="form-control" name="email" value="{{ $students->email ?? ""}}" id="email" placeholder="Please enter your email" readonly>
                                              <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-email"></p>
                                          </div>
                                      </div>
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label for="phone">Phone Number</label>
                                              <input type="text" class="form-control" name="phone_number" value="{{ $students->phone_number ?? '' }}"
                                              id="phone" placeholder="Please enter your phone number" maxlength="10"
                                              oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);">

                                              <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-phone_number"></p>
                                          </div>
                                      </div>
                                      {{-- <div class="col-md-12">
                                          <div class="form-group">
                                              <label for="phone">Address</label>
                                              <input type="address" class="form-control" name="address" value="{{ $students->address}}" id="address" placeholder="Write your full address">
                                              <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-address"></p>
                                          </div>
                                      </div> --}}
                                      {{-- <div class="col-md-6">
                                          <div class="form-group">
                                              <label for="city">City</label>
                                              <input type="text" class="form-control" name="city" value="{{ $students->city}}" id="city" placeholder="Please enter your city">
                                              <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-city"></p>
                                          </div>
                                      </div> --}}
                                      {{-- <div class="form-group mt-2 col-md-6">
                                        <label for="states">State *</label><br>
                                        <select name="states_id" id="states" class="genders states w-100">
                                            <option value="">Select State</option>
                                            @foreach ($states as $state)
                                                <option value="{{ $state->id }}" {{ $state->id == $students->states_id ? 'selected' : ''}}>{{ $state->name}}</option>
                                            @endforeach
                                        </select>
                                        <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-states_id"></p>
                                    </div> --}}
                                      {{-- <div class="col-md-6">
                                          <div class="form-group">
                                              <label for="zcode">ZIP Code</label>
                                              <input type="text" class="form-control" name="zip_code" value="{{ $students->zip_code}}" id="zcode" placeholder="Please enter your ZIP code">
                                              <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-zip_code"></p>
                                          </div>
                                      </div> --}}
                                      <div class="col-md-6">
                                          <div class="form-group">
                                            <label for="corigin">Country</label>
                                            <select name="country_id" id="corigin" class="genders w-100 country">
                                               <option value="">Select</option>
                                               @foreach ($countries as $countrie)
                                                   <option value="{{ $countrie->id}}" {{ $countrie->id == $students->country_id ? 'selected' : ''}}>{{ $countrie->name}}</option>
                                               @endforeach
                                            </select>
                                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-country_id"></p>
                                          </div>
                                      </div>
                                      <div class="col-md-12 text-right mt-4">
                                          <button type="submit" class="btn btn-bg px-5 py-3 mr-3 ">Update Profile</button>
                                          <a href="{{ route('student.dashboard') }}" class="btn btn-bg2 px-5 py-3">Back</a>
                                      </div>
                                  </div>
                              </form>
                          </div>
                      </div>
                    </div>
                    <div class="tab-pane edit-tabs container fade mx-0 px-0" id="change">
                      <div class="row">
                          <div class="col-md-8 p-2">
                              <form action="{{ route('student.changePassword') }}" method="POST" class="edit-form bg-white p-4">
                                  <p><b>Change your password</b></p>
                                  <div class="col-md-12 px-0">
                                      <div class="form-group" style="position: relative">
                                          <label for="psw">Password</label>
                                          <input type="password" class="form-control" name="old_password" id="old_password" placeholder="Please enter your old password">
                                          <span class="show-hide-password js-show-hide has-show-hide"><i class="bi bi-eye-slash"></i></span>
                                          <span class="error-p text-danger" id="psw1_error"></span>
                                      </div>
                                      <div class="form-group" style="position: relative">
                                          <label for="psw2">New Password</label>
                                          <input type="password" class="form-control" name="password" id="password" placeholder="Please enter your new password">
                                          <span class="show-hide-password js-show-hide has-show-hide"><i class="bi bi-eye-slash"></i></span>
                                          <span class="error-p text-danger" id="psw2_error"></span>
                                      </div>
                                      <div class="form-group" style="position: relative">
                                          <label for="psw3">Confirm Password</label>
                                          <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Please enter your password to confirm">
                                          <span class="show-hide-password js-show-hide has-show-hide"><i class="bi bi-eye-slash"></i></span>
                                          <span class="error-p text-danger" id="psw3_error"></span>
                                      </div>
                                  </div>
                                  <div class="col-md-12 text-right mt-5">
                                      <button class="btn btn-bg px-5 py-3 mr-3">Change Password</button>
                                      <button class="btn btn-bg2 px-5 py-3">Cancel</button>
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

@endsection
@push('student-js')

<script>
     $(document).ready(function() {
        $(".states").select2();
        $('.country').select2();
     });

      //password hide and show
      $(document).on('click','.js-show-hide',function (e) {
        e.preventDefault();
        var _this = $(this);

        if (_this.hasClass('has-show-hide'))
        {
            _this.parent().find('input').attr('type','text');
            _this.html('<i class="fa fa-eye" aria-hidden="true"></i>');
            _this.removeClass('has-show-hide');
        }
        else
        {
            _this.addClass('has-show-hide');
            _this.parent().find('input').attr('type','password');
            _this.html('<i class="bi bi-eye-slash"></i>');
        }
    });
</script>
@endpush
