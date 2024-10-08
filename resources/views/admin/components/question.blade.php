<div class="accordion-item" id="question_{{ $id }}">
    <div style="background: #e7f1ff;box-shadow: inset 0 -1px 0 rgba(0,0,0,.125)"
        class="accordion-header p-0 d-flex justify-content-between align-items-center" id="heading{{ $id }}">
        <button class="accordion-button" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapse{{ $id }}" aria-expanded="true"
            aria-controls="collapse{{ $id }}">
            Question ##
        </button>
        <a href="javascript:void(0)" class="mx-2 btn btn-danger btn-circle deleteRecord"
            url="{{ isset($new) && $new ? '' : route('questionDestroy', urlencode(base64_encode($id))) }}">
            <i class="fas fa-trash"></i>
        </a>
    </div>
    <div id="collapse{{ $id }}" class="accordion-collapse collapse show"
        aria-labelledby="heading{{ $id }}" data-bs-parent="#questionList">
        <div class="accordion-body">
            <div class="row">
                <div class="col-md-12">
                    <label for="data_{{ $id }}_content">Question Content</label>
                    <textarea name="data[{{ $id }}][content]" id="data_{{ $id }}_content" class="summernote"
                        cols="30" rows="10">{!! isset($question) && $question->type == 1 ? $question->content : '' !!}</textarea>
                    <span class="error-p text-danger" id="data_{{ $id }}_content_error"></span>
                </div>
                <div class="col-md-12 py-2">
                    <input type="file" name="data[{{ $id }}][image]" class="form-control"
                        id="data_{{ $id }}_image" placeholder="Video Material">
                    <span class="error-p text-danger" id="data_{{ $id }}_image_error"></span>
                    @if (isset($question) &&
                            $question->type == 1 &&
                            !empty($question->image) &&
                            file_exists(public_path('uploads/questionImages/' . $question->image)))
                        <div class="form-group">
                            <a href="{{ asset('uploads/questionImages/' . $question->image) }}" target="_blank">
                                <img src="{{ asset('uploads/questionImages/' . $question->image) }}" width="100px"
                                    height="100px">
                            </a>
                        </div>
                    @endif

                    <div class="col-md-12 addGrandParent">
                        <div class="d-flex justify-content-between align-items-center py-2">
                            <h5 class="form-control-label font-weight-bold">Question : Options</h5>
                            <button type="button" class="btn btn-success addComponent mt-2"
                                pid="{{ config('addPages.option.id') }}"
                                data="{{ json_encode(['question_id' => $id]) }}">
                                <i class="fa fa-plus mx-2"></i>Add Option
                            </button>
                        </div>
                        <div class="row">
                            <span id="data_{{ $id }}_options"></span>
                            <span class="error-p text-danger" id="data_{{ $id }}_options_error"></span>
                        </div>
                        <div class="accordion p-3 border rounded addParent_{{ config('addPages.option.id') }}">
                            @if (isset($question->options))
                                @foreach ($question->options as $option)
                                    @include('admin.components.option', [
                                        'id' => $option->id,
                                        'question_id' => $id,
                                        'option' => $option,
                                    ])
                                @endforeach
                            @endif
                        </div>
                        <div class="row">
                            <span id="data_{{ $id }}_answer"></span>
                            <span class="error-p text-danger" id="data_{{ $id }}_answer_error"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
