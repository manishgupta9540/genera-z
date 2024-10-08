<div class="form-group {{ isset($margin) && !$margin ? 'm-0' : 'mb-3' }}">
    @if (isset($label) && $label != '')
        <div class="d-flex ms-1 justify-content-between align-items-center">
            <label for="{{$id}}" class="mb-1 {{ isset($mandatory) && $mandatory == true ? 'mandatory-field' : '' }}">
                {{ $label }}
            </label>
        </div>

    @endif
       
    <select class="form-control form-select {{ !empty($mandatory) ? 'validate' : '' }} {{ $class ?? '' }}"
        id="{{ $id }}" name="{{ $name }}" @if (!empty($multiple)) multiple @endif
        {{ !empty($disabled) ? 'disabled' : '' }} size="1">
        @if (isset($default) && $default)
            <option value="">{{ $default }}</option>
        @endif
        @if (isset($options) && is_countable($options))
            {{-- <option value="">Select</option> --}}
            @foreach ($options as $option)
                @php
                    $value = $option[$valueKey ?? 'id'];
                    $text = $option[$optionKey ?? 'name'];
                @endphp
                @if (isset($multiple) && $multiple == true && isset($selected[0]))
                    <option value="">Select</option>
                    <option value="{{ $value }}" {{ in_array($value, $selected) ? 'selected' : '' }}>
                        {{ $text ?? '' }}
                    </option>
                    <p id="{{$name}}_error" class="text-danger error-p"></p>
                @else
                    <option value="{{ $value }}"
                        {{ isset($selected) && $selected == $value ? 'selected' : '' }}>
                        {{ $text ?? '' }}
                    </option>
                    <p id="{{$name}}_error" class="text-danger error-p"></p>
                @endif
            @endforeach
        @endif
    </select>
    @if ($errors->has($name))
        <div class="invalid-feedback">{{ $errors->first($name) }}</div>
    @endif
    <p id="{{$name}}_error" class="text-danger error-p"></p>
</div>
