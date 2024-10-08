@extends('admin.master.index')

@section('title', 'User Create')

@section('content')

<div class="main-content">
    <section class="section">
      <div class="section-body">
        <div class="row">
          <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
              <div class="card-header">
                <h4> Add User </h4>
              </div>
                <form action="{{ route('user-role-create') }}" method="post" id="createUserFrm">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Full Name<span class="text-danger">*</span></label>
                                    <input type="text" name="name"  class="form-control" placeholder="First Name">
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-name"></p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Email<span class="text-danger">*</span></label>
                                    <input type="text" name="email"  class="form-control" placeholder="Email">
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-email"></p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Contact Number<span class="text-danger">*</span></label>
                                    <input type="text" name="contact_number"  class="form-control" placeholder="Contact Number">
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-contact_number"></p>
                                </div>
                            </div>
                           
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Password<span class="text-danger">*</span></label>
                                    <input type="password" name="password"  class="form-control" placeholder="Password">
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-password"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="role" class="form-control-label font-weight-300">Role<span class="text-danger">*</span></label>
                                <select name="role_id" class="form-control" id="role_id">
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{$role->id}}">{{$role->role}}</option>
                                    @endforeach
                                 
                                </select>
                                <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-role_id"></p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary mr-1" type="submit">Submit</button>
                       
                    </div>
                </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

@endsection


@push('customjs')
    <script>
          $(document).on('submit', 'form#createUserFrm', function (event) {
                event.preventDefault();
                //clearing the error msg
                $('p.error_container').html("");
                
                var form = $(this);
                var data = new FormData($(this)[0]);
                var url = form.attr("action");
                var loadingText = '<i class="fa fa-circle-o-notch fa-spin"></i> loading...';
                $('.submit').attr('disabled',true);
                $('.form-control').attr('readonly',true);
                $('.form-control').addClass('disabled-link');
                $('.error-control').addClass('disabled-link');
                if ($('.submit').html() !== loadingText) {
                    $('.submit').html(loadingText);
                }
                    $.ajax({
                        type: form.attr('method'),
                        url: url,
                        data: data,
                        cache: false,
                        contentType: false,
                        processData: false,      
                        success: function (response) {
                            window.setTimeout(function(){
                                $('.submit').attr('disabled',false);
                                $('.form-control').attr('readonly',false);
                                $('.form-control').removeClass('disabled-link');
                                $('.error-control').removeClass('disabled-link');
                                $('.submit').html('Save');
                            },2000);
                            console.log(response);
                            if(response.success==true) {   
                                toastr.success("User Creted Successfully");
                                window.setTimeout(function() {
                                    window.location.href = "{{URL::to('user-roles-list')}}"
                                }, 2000);
                            }
                            //show the form validates error
                            if(response.success==false ) {                              
                                for (control in response.errors) {  
                                var error_text = control.replace('.',"_");
                                $('#error-'+error_text).html(response.errors[control]);
                                // $('#error-'+error_text).html(response.errors[error_text][0]);
                                // console.log('#error-'+error_text);
                                }
                                // console.log(response.errors);
                            }
                        },
                        error: function (response) {
                            // alert("Error: " + errorThrown);
                            console.log(response);
                        }
                    });
                    event.stopImmediatePropagation();
                    return false;
            });

    </script>
@endpush

