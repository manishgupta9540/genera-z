<div class="accordion-item" id="courseMaterial_{{ $id }}">
    <h2 class="accordion-header p-0" id="heading{{ $id }}">
        <button class="accordion-button" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapse{{ $id }}" aria-expanded="true" aria-controls="collapse{{ $id }}">
            Course Material ##
        </button>
    </h2>
    <div id="collapse{{ $id }}" class="accordion-collapse collapse show" aria-labelledby="heading{{ $id }}" data-bs-parent="#courseMaterialAddParent">
        <div class="accordion-body">
            <div class="row">
                <div class="col-md-4">
                    @include('components.input', [
                        'id' => 'data_' . $id . '_name',
                        'name' => 'data[' . $id . '][name]',
                        'label' => 'Material Name',
                        'type' => 'text',
                        'mandatory' => true,
                        'class' => '',
                        'readonly' => false,
                        'maxlength' => '255',
                        'value' => isset($name) ? $name : '',
                        'placeholder' => 'Enter Material Name',
                        'margin' => false,
                    ])
                </div>
                <div class="col-md-4">
                    @include('components.select', [
                        'id' => 'data_' . $id . '_reading',
                        'name' => 'data[' . $id . '][reading]',
                        'class' => 'materialType',
                        'mandatory' => true,
                        'multiple' => false,
                        'margin' => false,
                        'disabled' => false,
                        'default' => '',
                        'label' => 'Material Type',
                        'options' => config('constants.materialTypes'),
                        'selected' => isset($reading) ? $reading : '',
                    ])
                </div>
                <div class="col-md-4">
                    @include('components.input', [
                        'id' => 'data_' . $id . '_duration',
                        'name' => 'data[' . $id . '][duration]',
                        'label' => 'Duration(In Minutes)',
                        'type' => 'number',
                        'mandatory' => true,
                        'class' => 'duration',
                        'readonly' => isset($reading) && !$reading,
                        'maxlength' => '255',
                        'value' => isset($duration) ? $duration : '',
                        'placeholder' => 'Enter Duration in Minutes',
                        'margin' => false,
                    ])
                </div>

                @if(isset($value->ppt))
                    <div class="col-md-12 py-2">
                        <input type="file" name="ppt" class="form-control material" id="ppt" accept=".ppt,.pptx">
                        <br>
                        <a href="{{ asset('uploads/PPT/' . $value->ppt) }}" target="_blank">
                            <img src="{{ asset('admin/assets/img/ppt_icon.png') }}" height="80px" width="80px" alt="PPT File">
                        </a>
                    </div>
                @else
                    <div class="col-md-12 py-2">
                        <div class="d-flex ms-1 justify-content-between align-items-center">
                            <label for="data_{{ $id }}_content" class="mb-1 {{ isset($mandatory) && $mandatory == true ? 'mandatory-field' : '' }}">
                                Material Content
                            </label>
                        </div>
                        @if (isset($reading) && !$reading && file_exists(public_path('uploads/materialVideo/' . $content)))
                            <input type="file" name="data[{{ $id }}][content]" class="form-control material"
                            id="data_{{ $id }}_content" placeholder="Video Material" accept="video/*">
                            <div class="form-group">
                                <video width="320" height="240" controls>
                                    <source src="{{ asset('uploads/materialVideo/' . $content) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        @else
                            <textarea type="text" name="data[{{ $id }}][content]" class="summernote form-control material"
                            id="data_{{ $id }}_content" placeholder="Reading Material">{!! $content ?? '' !!}</textarea>
                        @endif
                        <span class="error-p text-danger" id="data_{{ $id }}_content_error"></span>
                    </div>
                @endif

            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end mt-2">
        <button type="button" class="btn btn-outline-danger btn-rounded" onclick="deleteAccordionItem({{ $id }})"><i class="fas fa-trash text-danger"></i></button>
    </div>
</div>

