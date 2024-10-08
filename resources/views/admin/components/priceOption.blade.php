<div class="card shadow-none border-bottom rounded-0 border-1">
    <div class="card-header bg-info bg-gradient border-0 py-0 px-2">
        <a class="card-link text-muted w-100 p-3 d-flex justify-content-between align-items-center rounded"
            data-toggle="collapse" href="#collapse{{ $id }}">
            <h6 class="mb-0 text-primary font-weight-bold">Pricing Option ##
            </h6>
            <span class="text-primary mr-2">Details<i class="fa fa-chevron-down mx-2" aria-hidden="true"></i></span>
        </a>
        <a href="javascript:void(0)" class="text-danger deleteRecord px-3" url="{{isset($new) && $new ? '' : route('priceOptionDestroy',urlencode(base64_encode($id)))}}">
            <i class="fas fa-trash"></i>
        </a>
    </div>
    <div id="collapse{{ $id }}" class="collapse" data-parent="#priceOptionsList">
        <div class="card-body">
            <div class=" row">
                <div class="col-sm-6">
                    @include('components.input', [
                        'id' => 'duration_' . $id,
                        'name' => 'pricingOptions[' . $id . '][duration]',
                        'label' => 'Duration in Months',
                        'type' => 'number',
                        'mandatory' => true,
                        'readonly' => false,
                        'min' => 1,
                        'max' => 12,
                        'class' => 'unsignedNumber',
                        'value' => isset($duration) ? $duration : '',
                        'placeholder' => 'Enter Month Duration',
                        'otherattr' => '',
                    ])
                </div>
                <div class="col-sm-6">
                    @include('components.input', [
                        'id' => 'price_' . $id,
                        'name' => 'pricingOptions[' . $id . '][price]',
                        'label' => 'Price Per Month',
                        'type' => 'number',
                        'mandatory' => true,
                        'readonly' => false,
                        'min' => 0,
                        'value' => isset($price) ? $price : '',
                        'placeholder' => 'Enter 1 Month Price',
                        'otherattr' => '',
                    ])
                </div>
                <div class="col-sm-12">
                    @include('components.textarea', [
                        'id' => 'details_' . $id,
                        'name' => 'pricingOptions[' . $id . '][details]',
                        'label' => 'Pricing Details',
                        'class' => 'summernote',
                        'mandatory' => true,
                        'readonly' => false,
                        'min' => 0,
                        'value' => isset($details) ? $details : '',
                        'placeholder' => 'Enter Subscription Details',
                        'otherattr' => '',
                    ])
                </div>
            </div>
        </div>
    </div>
</div>
