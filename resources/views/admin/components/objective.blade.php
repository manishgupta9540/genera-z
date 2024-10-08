<div class="row">
    <div class="col-sm-11">
        @include('components.input', [
            'id' => 'objectives_' . $id,
            'name' => 'objectives[' . $id . ']',
            'label' => '',
            'type' => 'text',
            'mandatory' => true,
            'class' => '',
            'readonly' => false,
            'maxlength' => '255',
            'value' => isset($content) ? $content : '',
            'placeholder' => 'Enter Objective',
            'otherattr' => '',
        ])
    </div>
    <div class="col-sm-1">
        <a href="javascript:void(0)" class="btn btn-danger btn-circle deleteRecord" url="{{isset($new) && $new ? '' : route('objectiveDestroy',urlencode(base64_encode($id)))}}">
            <i class="fas fa-trash"></i>
        </a>
    </div>
</div>
