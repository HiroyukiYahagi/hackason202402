@isset($label)
<label class="uk-form-label" for="form-{{ $name }}">
  {!! $label !!}
</label>
@endisset
<div class="uk-form-controls">
  <input class="uk-input" id="form-{{ $name }}" name="{{$name}}" type="{{ $type }}" placeholder="{{ isset($placeholder) ? $placeholder : (isset($label) ? $label:null) }}" value="{{ old($name, isset($value) ? $value : null) }}" {{ isset($required) ? 'required' : null }}>
</div>
@isset($required)
<div>
  <span class="uk-text-small uk-text-danger">※必須項目です</span>
</div>
@endisset