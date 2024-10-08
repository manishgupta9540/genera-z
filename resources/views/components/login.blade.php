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
    background-color: transparent;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border-radius: .25rem;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}
@media (min-width: 576px) {
    .modal-dialog {
        max-width: 600px !important;
        margin: 1.75rem auto;
    }
}
.eye-btn {
    position: absolute !important;
    right: 0 !important;
    top: 7px !important;
}
.input-group .btn {
    position: relative;
    z-index: 3;
}

</style>
<div class="modal-header px-5" id="login_modal">
    <h1 class="modal-title fs-5" id="enrolModalLabel">Login</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body px-5">
    <form action="{{ route('user_login') }}" method="post" id="loginFrm" class="ajaxForm">
        @csrf
        <input type="hidden" name="course_id" value="{{$courseId ?? ''}}">
        <div class="form-group mt-2">
            <label for="email">Your Email</label>
            <input type="email" name="user_email" class="form-control" placeholder="Enter Your Email" id="email">
            <p style="margin-bottom: 2px;" class="text-danger error_container" id="user_email_error"></p>

        </div>
        <div class="form-group mt-2 your-pswd">
            <label for="pwd">Your Password</label>
            <div class="input-group">
                <input type="password" name="user_password" class="form-control" placeholder="********" aria-describedby="eye-btn" id="pwd">
                <button class="btn btn-circle eye-btn" type="button" id="eye-btn">
                    <i class="fa-solid fa-eye-slash"></i>
                </button>
            </div>
            <p style="margin-bottom: 2px;" class="text-danger error_container" id="user_password_error">
            </p>
        </div>
        <span style="" class="text-left text-danger error_container" id="wrong-credential"> </span>
        {{-- <div class="form-group form-check mt-2 d-flex justify-content-between">
            <label class="form-check-label">
                <input class="form-check-input" type="checkbox"> Remember me
            </label>
            <div>
                <a href="#">Forgot Password?</a>
            </div>
        </div> --}}
        <div class="text-center mt-3">
            <button type="submit" class="btn btn-theme1 py-3 w-100 submit">Submit</button>
        </div>
        <div class="mt-4 text-center">
            <p>Don't have an account?
            <a href="javascript:void(0)" class="btn btn-theme2 btn-circle checkAuth" data-content="{{json_encode(['form'=>'register'])}}" data-target="{{route('authModal')}}">
                    Sign Up
            </a>
            </p>
        </div>
    </form>
</div>

