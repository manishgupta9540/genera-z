<!DOCTYPE html>
<html lang="en">

<!-- auth-login.html  21 Nov 2019 03:49:32 GMT -->
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Login</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{asset('admin/assets/css/app.min.css')}}">
  <link rel="stylesheet" href="{{asset('admin/assets/bundles/bootstrap-social/bootstrap-social.css')}}">
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{asset('admin/assets/css/style.css')}}">
  <link rel="stylesheet" href="{{asset('admin/assets/css/components.css')}}">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="{{asset('admin/assets/css/custom.css')}}">
  <link rel='shortcut icon' type='image/x-icon' href="{{asset('admin/assets/img/GZlogoB.png')}}" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
</head>
  <style>
    .invalid-feedback {
        display:inline-block;
    }
    span.show-hide-password {
      position: absolute;
      top: 292px;
      right: 15%;
      font-size: 16px;
      color: #748a9c;
      cursor: pointer;
      z-index: 6;
    }
  </style>

<body>
  <div class="loader"></div>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            @if(Session::has('error'))
              <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <h4><i class="icon fa fa-ban"></i> Error!</h4>{{ Session::get('error') }}
              </div>
            @endif
          
            @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <h4><i class="icon fa fa-ban"></i> Error!</h4>{{ Session::get('success') }}
                </div>
            @endif

            <div class="card card-primary">
              <div class="card-header">
                <h4>Login</h4>
              </div>

              <div class="card-body">
                <img alt="image" src="{{asset('admin/assets/img/GZlogoB.png')}}" class="header-logo" style="width: 107px;height:92px; margin-left:95px;"/>
                <form  action="{{ route('admin.authenticate') }}" method="POST" id="loginFrm">
                  @csrf
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" name="email">
                    
                    @error('email')
                      <p class="invalid-feedback" style="color:red">{{ $message }}</p>
                    @enderror

                  </div>
                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" class="control-label">Password</label>
                      {{-- <div class="float-right">
                        <a href="auth-forgot-password.html" class="text-small">
                          Forgot Password?
                        </a>
                      </div> --}}
                    </div>
                    <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                    <span class="show-hide-password js-show-hide has-show-hide"><i class="bi bi-eye-slash"></i></span>

                    @error('password')
                      <p class="invalid-feedback" style="color:red">{{ $message }}</p>
                    @enderror

                  </div>
                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                      <label class="custom-control-label" for="remember-me">Remember Me</label>
                    </div>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Login
                    </button>
                  </div>
                </form>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- General JS Scripts -->
  <script src="{{asset('admin/assets/js/app.min.js')}}"></script>
  <!-- JS Libraies -->
  <!-- Page Specific JS File -->
  <!-- Template JS File -->
  <script src="{{asset('admin/assets/js/scripts.js')}}"></script>
  <!-- Custom JS File -->
  <script src="{{asset('admin/assets/js/custom.js')}}"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script>
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

</body>
</html>