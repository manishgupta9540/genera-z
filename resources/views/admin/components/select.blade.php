<div class="form-group {{isset($margin) && !$margin ? '' :'mb-3'}}">
    @if (!empty($label))
        <div class="d-flex ms-1 justify-content-between align-items-center">
            <label for="{{ $id }}" class="mb-1 {{ !empty($mandatory) ? 'andatory-field' : '' }}">
                {{ $label }}
                @if (!empty($mandatory))
                    <span class="text-danger">*</span>
                @endif
            </label>
        </div>
    @endif
    <select
        class="form-control form-select {{ !empty($mandatory) ? 'validate' : '' }} {{ $class ?? '' }}"
        id="{{ $id }}" name="{{ $name }}" @if (!empty($multiple)) multiple @endif
        {{ !empty($disabled) ? 'disabled' : '' }} size="1">
        @if(isset($default) && $default)
            <option value="">{{ $default }}</option>
        @endif
        @if (isset($options) && is_countable($options))
            @foreach ($options as $option)
                @php
                    $value = $option[$valueKey ?? 'id'];
                    $text = $option[$optionKey ?? 'name'];
                @endphp
                @if (isset($multiple) && $multiple == true && isset($selected[0]))
                    <option value="{{ $value }}"
                        {{ in_array($value, $selected) ? 'selected' : '' }}>
                        {{ $text ?? '' }}
                    </option>
                @else
                    <option value="{{ $value }}"
                        {{ isset($selected) && $selected == $value ? 'selected' : '' }}>
                        {{ $text ?? '' }}
                    </option>
                @endif
            @endforeach
        @endif
    </select>
    @if ($errors->has($name))
        <div class="invalid-feedback">{{ $errors->first($name) }}</div>
    @endif
</div>
