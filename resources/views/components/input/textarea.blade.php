@isset($label)
<label class="uk-form-label" for="form-{{ $name }}">
  {!! $label !!}
</label>
@endisset
<div class="uk-form-controls">
  <textarea class="uk-textarea uk-height-medium" id="form-{{ $name }}" name="{{$name}}" placeholder="{{ isset($placeholder) ? $placeholder : $label }}" {{ isset($required) ? 'required' : null }}>{{ old($name, isset($value) ? $value : null) }}</textarea>
</div>
@isset($required)
<div>
  <span class="uk-text-small uk-text-danger">※必須項目です</span>
</div>
@endisset