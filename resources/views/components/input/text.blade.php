@if (isset($label))
    <label class="uk-form-label" for="{{ $name }}">
        <small>{{ $label }}</small>
        @if (isset($required))
            <small class="uk-text-danger">※必須</small>
        @endif
    </label>
@endif
<div class="uk-form-controls">
    <input class="uk-input" type="{{ isset($type) ? $type : 'text' }}" name="{{ $name }}"
        value="{{ old($name, isset($value) ? $value : null) }}"
        placeholder="{{ isset($label) ? $label . 'を入力' : null }}" {{ isset($required) ? 'required' : '' }}>
</div>
