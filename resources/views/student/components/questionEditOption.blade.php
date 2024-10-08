<div class="row py-1">
    <label for="answer_{{$id}}" class="m-0 col-sm-1 d-flex justify-content-center align-items-center">
        <input type="radio" class="answerRadio" name="answer" value="{{$id}}" id="answer_{{$id}}" {{isset($question->answer) && isset($question->answer->option_id) && $question->answer->option_id == $id ? 'checked' : '' }}>
    </label>
    <div class="col-sm-10">
        @include('components.input', [
            'id' => 'options_'.$id.'_content',
            'name' => 'options['.$id.'][content]',
            'label' => '',
            'type' => 'text',
            'mandatory' => true,
            'class' => '',
            'readonly' => false,
            'maxlength' => '255',
            'value' => isset($option->content) ? $option->content : '',
            'placeholder' => 'Option Content',
            'otherattr' => '',
            'margin' => false,
        ])
    </div>
    <div class="col-sm-1">
        <a href="javascript:void(0)" class="btn btn-danger btn-circle deleteRecord" url="{{isset($new) && $new ? '' : route('admin.options.destroy',urlencode(base64_encode($id)))}}">
            <i class="fas fa-trash"></i>
        </a>
    </div>
</div>
