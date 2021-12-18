<label class="uk-form-label" for="form-{{ $name }}">
  {!! $label !!}
</label>
<div class="uk-form-controls">
  <input class="uk-input" id="form-{{ $name }}" name="{{$name}}" type="{{ $type }}" placeholder="{{ isset($placeholder) ? $placeholder : $label }}" value="{{ old($name, isset($value) ? $value : null) }}" {{ $required ? 'required' : null }}>
</div>