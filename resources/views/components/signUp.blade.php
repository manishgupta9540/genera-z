<style>
    .form-control {
    display: block;
    width: 100%;
    padding: .375rem .75rem;
    font-size: 1rem;
    font-weight: 400;
    height: 50px;
    line-height: 1.5;
    color: #212529;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border-radius: .25rem;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}

 .form-group {
    position: relative;
 }
 .eye-btn {
    position: absolute !important;
    right: 7px !important;
    top: 32px !important;
}
@media (min-width: 576px) {
    .modal-dialog {
        max-width: 600px !important;
        margin: 1.75rem auto;
    }
}

</style>
<div class="modal-header px-5">
    <h1 class="modal-title fs-5" id="enrolModalLabel">Create Your Student Account</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<!-- Modal body -->
<div class="modal-body px-5">
    <form action="{{ route('student-register') }}" method="post" id="userRegister" class="ajaxForm">
        @csrf
        <input type="hidden" name="course_id" value="{{ $courseId ?? '' }}">
        <div class="row">
            <div class="form-group mt-2 col-md-6">
                <label for="fname">First Name</label>
                <input type="text" name="first_name" class="form-control"id="fname"
                    placeholder="Enter First Name">
                <p style="margin-bottom: 2px;" class="text-danger error_container" id="first_name_error">
                </p>
            </div>
            <div class="form-group mt-2 col-md-6">
                <label for="lname">Last Name</label>
                <input type="text" name="last_name" class="form-control" id="lname"
                    placeholder="Enter Last Name">
                <p style="margin-bottom: 2px;" class="text-danger error_container" id="last_name_error">
                </p>
            </div>
        </div>
        <div class="row">
            <div class="form-group mt-2 col-md-12">
                <label for="email">Your Email</label>
                <input type="email" name="email" class="form-control" placeholder="Enter Your Email"
                    id="email">
                <p style="margin-bottom: 2px;" class="text-danger error_container" id="email_error"></p>
                <p style="margin-bottom: 2px;" class="text-danger" id="user_allready"></p>
            </div>
        </div>
        <div class="row">
            <div class="form-group mt-2 col-md-6 pwd1">
                <label for="pwd">Enter Password</label>
                <input type="password" name="password" class="form-control" id="pwd" placeholder="********">
                <button class="btn btn-circle eye-btn eye-slash-1" type="button" id="eye-btn" style="">
                    <i class="fa-solid fa-eye-slash "></i>
                </button>
                <p style="margin-bottom: 2px;" class="text-danger error_container" id="password_error"></p>
            </div>
            <div class="form-group mt-2 col-md-6">
                <label for="cpwd">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control"id="cpwd" placeholder="********">
                <button class="btn btn-circle eye-btn eye-slash-2" type="button" id="eye-btn">
                    <i class="fa-solid fa-eye-slash "></i>
                </button>
                <p style="margin-bottom: 2px;" class="text-danger error_container" id="password_confirmation_error"></p>
            </div>
        </div>
        <button type="submit" class="btn btn-theme1 py-2 w-100 mt-2 submit-student">Sign Up</button>
        <div class="mt-4 text-center">
            <p>Already have an account?
                <a href="javascript:void(0)" class="btn btn-theme2 btn-circle checkAuth" data-target="{{route('authModal')}}">
                    Sign In
                </a>
            </p>
        </div>
    </form>
</div>





