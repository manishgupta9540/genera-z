
<input type="hidden" name="uaid" value="{{urlencode(base64_encode($uaid))}}">
{{-- {{dd($assignment)}} --}}
@foreach ($assignment->questions as $index => $question)
    <input type="hidden" name="assigmnet_id" value="{{$assignment->id}}">
    <input type="hidden" name="question_id[]" value="{{$question->id}}">
    <input type="hidden" name="type" value="{{$question->type}}">
    <div class="my-2">
        <div class="">
            <b>{{ $index + 1 }}.</b>
            <div class="d-inline question-content">
                {!! $question->content !!}
                <br>
                @if ($question->type == 1)
                    @if (!empty($question->image))
                    <img src="{{ asset('/uploads/questionImages/' . $question->image) }}" style="height: 235px; width: 733px;" alt="">
                    <br>
                    @endif
                @endif

            </div>
        </div>
        <br>
        @if ($question->type == 0)
            @if (!empty($question->image))
                <img src="{{ asset('/uploads/questionImages/' . $question->image) }}" style="height: 235px; width: 853px;" alt="">
                <br>
            @endif
            <br>
            <textarea name="answer[]" id="answer_{{ $question->id }}" class="form-control summernote" id="summernote"></textarea>
            <br>
        @else
        @foreach ($question->options as $option)
        <div class="form-check mt-2">
            <input type="radio" class="form-check-input" id="check_{{ $question->id }}_{{ $option->id }}"
                name="check[{{ $question->id }}]" value="{{ base64_encode($option->id) }}"
                {{ $loop->first ? 'required' : '' }}> <!-- Add required to the first radio -->
            <label class="form-check-label" for="check_{{ $question->id }}_{{ $option->id }}">{{ $option->content }}</label>
        </div>
    @endforeach

        @endif
    </div>
@endforeach


<script>
    $(document).ready(function(){
        reinitializeSummernote();
    })

    function reinitializeSummernote() {
        $('.summernote').summernote({
            tabsize: 2,
            height: 200
        });
    }

</script>




