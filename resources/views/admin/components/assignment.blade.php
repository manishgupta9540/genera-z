<div class="accordion-item" id="assignment_{{ $id }}">
    <h2 class="accordion-header p-0" id="heading{{ $id }}">
        <button class="accordion-button" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapse{{ $id }}" aria-expanded="true" aria-controls="collapse{{ $id }}">
            Assignment ##
        </button>
    </h2>
    <div id="collapse{{ $id }}" class="accordion-collapse collapse show" aria-labelledby="heading{{ $id }}" data-bs-parent="#assignmentAddParent">
        <div class="accordion-body">
            <div class="row">
                <div class="col-md-12">
                    @include('components.input', [
                        'id' => 'data_' . $id . '_title',
                        'name' => 'data[' . $id . '][title]',
                        'label' => 'Title',
                        'type' => 'text',
                        'mandatory' => true,
                        'class' => '',
                        'readonly' => false,
                        'maxlength' => '255',
                        'value' => isset($title) && $type==1 ? ($title ?? '') : '',
                        'placeholder' => 'Title',
                    ])
                </div>
                <div class="col-md-3">
                    @include('components.input', [
                        'id' => 'data_' . $id . '_attempts',
                        'name' => 'data[' . $id . '][attempts]',
                        'label' => 'Number of Attempts',
                        'type' => 'number',
                        'mandatory' => true,
                        'class' => 'unsignedNumber',
                        'readonly' => false,
                        'maxlength' => '255',
                        'value' => isset($attempts) && $type==1 ? ($attempts ?? '') : '',
                        'placeholder' => 'Attempts',
                    ])
                </div>
                <div class="col-md-3">
                    @include('components.input', [
                        'id' => 'data_' . $id . '_duration',
                        'name' => 'data[' . $id . '][duration]',
                        'label' => 'Duration(In Minutes)',
                        'type' => 'number',
                        'mandatory' => true,
                        'class' => 'unsignedNumber',
                        'readonly' => false,
                        'maxlength' => '255',
                        'value' => isset($duration) && $type==1 ? ($duration ?? '') : '',
                        'placeholder' => 'Duration(In Minutes)',
                    ])
                </div>
                <div class="col-md-3">
                    @include('components.input', [
                        'id' => 'data_' . $id . '_pass_score',
                        'name' => 'data[' . $id . '][pass_score]',
                        'label' => 'Passing Score',
                        'type' => 'number',
                        'mandatory' => true,
                        'class' => 'unsignedNumber',
                        'readonly' => false,
                        'maxlength' => '255',
                        'value' => isset($pass_score) && $type==1 ? ($pass_score ?? '') : '',
                        'placeholder' => 'Passing Score',
                    ])
                </div>
                <div class="col-md-3">
                    @include('components.input', [
                        'id' => 'data_' . $id . '_max_score',
                        'name' => 'data[' . $id . '][max_score]',
                        'label' => 'Maximum Score',
                        'type' => 'number',
                        'mandatory' => true,
                        'class' => 'unsignedNumber',
                        'readonly' => false,
                        'maxlength' => '255',
                        'value' => isset($max_score) && $type==1 ? ($max_score ?? '') : '',
                        'placeholder' => 'Maximum Score',
                    ])
                </div>
                {{-- <div class="col-md-12">
                    <label for="data_{{$id}}_description">Description</label>
                    <textarea name="data[{{$id}}][description]" id="data_{{$id}}_description" class="summernote" cols="30" rows="10">{!! ( isset($type) && $type == 1 && $description) ? ($description ?? '' ) : '' !!}
                    </textarea>
                    <span class="error-p text-danger" id="data_{{$id}}_description_error"></span>
                </div> --}}
            </div>
        </div>

        <div class="d-flex justify-content-end p-3">
            <button type="button" class="btn btn-outline-danger btn-rounded deleteAccordion" data-id="{{ $id }}"> <i class="fas fa-trash text-danger"></i></button>
        </div>
    </div>
</div>
