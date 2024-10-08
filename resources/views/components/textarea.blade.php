<div class="form-group {{ isset($margin) && !$margin ? '' : 'mb-3' }}">
    @if (isset($label) && $label != '')
        <div class="d-flex ms-1 justify-content-between align-items-center">
            <label for="{{ $id }}" class="mb-1 {{ isset($mandatory) && $mandatory == true ? 'mandatory-field' : '' }}">
                {{ $label }}
            </label>
        </div>
    @endif
    <textarea name="{{ $name ?? '' }}"
        class="form-control {{ isset($mandatory) && $mandatory == true ? 'validate' : '' }} {{ isset($class) ? $class : '' }}"
        id="{{ $id }}" maxlength="{{ $maxlength ?? '' }}" placeholder="{{ $placeholder ?? '' }}"
        @isset($min)
            min="{{ $min }}"
        @endisset
        @isset($max)
            max="{{ $max }}"
        @endisset
        @if(isset($disabled) && $disabled)
            disabled
        @endisset
        {{ $otherattr ?? '' }} {{ isset($readonly) && $readonly == true ? 'readonly' : '' }}>{{ $value ?? '' }}</textarea>
    <span class="text-danger error-msg"></span>
</div>
