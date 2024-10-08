<div class="row">
    <div class="col-md-12 form-group">
        <label for="usr">Name in Arabic</label>
        <input type="text" class="form-control" id="englishToArabic" readonly name="name_arabic" value="{{$certificates->name_in_arabic}}">
    </div>
    <div class="col-md-12 form-group">
        <label for="usr">Name in English</label>
        <input type="text" class="form-control" id="usr_english" readonly  name="username_english" value="{{$certificates->name_in_english}}">
    </div>
</div>
<div class="row">
    <div class="col-md-6 form-group">
        <label for="religion">Religion</label>
        <input type="text" class="form-control" id="religion" readonly name="religion" value="{{$certificates->religion}}">
    </div>
    <div class="col-md-6 form-group">
        <label for="gender">Gender</label>
        <input type="text" class="form-control" id="religion" readonly name="religion" value="{{$certificates->gender}}">

    </div>
</div>
<div class="row">
    <div class="col-md-6 form-group">
        <label for="DOB">DOB</label>
        <input type="date" class="form-control" id="DOB" name="dob" readonly value="{{$certificates->dob}}">
    </div>
    <div class="col-md-6 form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" readonly name="email" value="{{$certificates->email}}">
    </div>
</div>
<div class="row">
    <div class="col-md-6 form-group">
        <label for="nationality">Nationality</label>

        <input type="email" class="form-control" id="email"  readonly  value="{{$certificates->nationality}}">
    </div>
    <div class="col-md-6 form-group">
        <label for="passport_number">Passport Number</label>
        <input type="text" class="form-control" maxlength="9" id="passport_number" readonly name="passport_number" value="{{$certificates->passport_number}}">
    </div>
</div>
<div class="row">
    <div class="col-md-6 form-group">
        @if($certificates->passport_image !='')
        <label for="passport">Passport</label>
            <img src="{{asset('uploads/passport/'.$certificates->passport_image)}}" style="width: 171%;">
            @endif
    </div>
</div>
</div>
