<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <style>
        .stripe-colmn {
            margin-top: 100px;
        }
    </style>
</head>
<body>
    <div class="container ">
        <div class="row ">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default credit-card-box stripe-colmn">
                    <div class="panel-heading display-table">
                        <h3 class="panel-title">Payment Details</h3>
                    </div>
                    <div class="panel-body">

                        @if (Session::has('success'))
                            <div class="alert alert-success text-center">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                <p>{{ Session::get('success') }}</p>
                            </div>
                        @endif

                        <form role="form" action="{{route('stripe.post')}}" method="post" class="require-validation pr" data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="payment-form">
                            @csrf

                            <div class='form-row row'>
                                <div class='col-xs-12 form-group required'>
                                    <label class='control-label'>Name on Card</label> 
                                    <input class='form-control' size='4' type='text'>
                                </div>
                            </div>

                            <div class='form-row row'>
                                <div class='col-xs-12 form-group card required'>
                                    <label class='control-label'>Card Number</label> 
                                    <input autocomplete='off' maxlength="16" class='form-control card-number' size='20' type='text'>
                                </div>
                            </div>

                            <div class='form-row row'>
                                <div class='col-xs-12 col-md-4 form-group cvc required'>
                                    <label class='control-label'>CVV</label> 
                                    <input autocomplete='off' maxlength="3" class='form-control card-cvc' placeholder='ex. 311' size='4' type='text'>
                                </div>
                                <div class='col-xs-12 col-md-4 form-group expiration required'>
                                    <label class='control-label'>Expiration Month</label> 
                                    <input class='form-control card-expiry-month' placeholder='MM' size='2' type='text'>
                                </div>
                                <div class='col-xs-12 col-md-4 form-group expiration required'>
                                    <label class='control-label'>Expiration Year</label> 
                                    <input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text'>
                                </div>
                            </div>

                            <div class='form-row row'>
                                <div class='col-md-12 error form-group hide'>
                                    <div class='alert-danger alert'>Please correct the errors and try again.</div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <input type="hidden" name="price" value="{{ $payments->pricing }}">
                                    <input type="hidden" name="payments_id" value="{{ base64_encode($payments->id) }}">
                                    
                                    <button class="btn btn-primary btn-lg btn-block submit" type="submit"> Pay Now {{ $payments->pricing }} </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

</body>

<script src="https://js.stripe.com/v2/"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script type="text/javascript">

$(function() {
    var $form = $(".require-validation");

    $('form.require-validation').on('submit', function(e) {
        e.preventDefault(); // Prevent default form submission

        var inputSelector = 'input[type=email], input[type=password], input[type=text], input[type=file], textarea';
        var $inputs = $form.find('.required').find(inputSelector);
        var $errorMessage = $form.find('div.error');

        $errorMessage.addClass('hide');
        $('.has-error').removeClass('has-error');

        var valid = true;
        $inputs.each(function(i, el) {
            var $input = $(el);
            if ($input.val().trim() === '') { // Check if input value is empty
                $input.parent().addClass('has-error');
                $errorMessage.removeClass('hide');
                valid = false;
            }
        });

        if (valid && !$form.data('cc-on-file')) {
            // If form is valid and credit card info is not on file, proceed to create token
            var stripeKey = $form.data('stripe-publishable-key');
            if (!stripeKey) {
                alert("Stripe publishable key is not set.");
                return;
            }

            Stripe.setPublishableKey(stripeKey);

            Stripe.createToken({
                number: $('.card-number').val(),
                cvc: $('.card-cvc').val(),
                exp_month: $('.card-expiry-month').val(),
                exp_year: $('.card-expiry-year').val()
            }, stripeResponseHandler);
        }
    });

    function stripeResponseHandler(status, response) {
        if (response.error) {
            $('.error').removeClass('hide').find('.alert').text(response.error.message);
        } else {
            // Token creation successful, proceed with AJAX form submission
            var token = response.id;
            $form.find('input[type=text]').val(''); // Clear text inputs

            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");

            // AJAX submission configuration
            var form = $('form.pr');
            var data = $form.serialize(); // Serialize form data
            var url = form.attr("action");

            var loadingText = '<i class="fa fa-circle-o-notch fa-spin"></i> loading...';
            $('.submit').attr('disabled', true).html(loadingText);
            $('.form-control').prop('readonly', true).addClass('disabled-link');
            $('.error-control').addClass('disabled-link');

            $.ajax({
                type: form.attr('method'),
                url: url,
                data: data,
                success: function(response) {
                    // Handle success response
                    setTimeout(function() {
                        $('.submit').attr('disabled', false).html('Pay Now'); // Reset button text
                        $('.form-control').prop('readonly', false).removeClass('disabled-link');
                        $('.error-control').removeClass('disabled-link');

                        if (response.success) {
                            toastr.success("Payment successful!");
                            setTimeout(function() {
                                window.location.href = "/student.dashboard"; // Redirect after success
                            }, 1500);
                        }
                    }, 2000);
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.log("Error: " + error);
                }
            });
        }
    }
});

</script>

</html>
