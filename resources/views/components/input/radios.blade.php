@isset($label)
<label class="uk-form-label" for="form-{{ $name }}">
  {!! $label !!}
</label>
@endisset
<div class="uk-form-controls">
  @foreach( $options as $option )
  <label class="uk-margin-right">
    <input class="uk-radio" type="radio" name="{{$name}}" value="{{ $option['value'] }}" {{ old($name, isset($value) ? $value : null) == $option['value'] ? 'checked' : null }} /> {{ $option['label'] }}
  </label>
  @endforeach
</div>
@isset($required)
<div>
  <span class="uk-text-small uk-text-danger">※必須項目です</span>
</div>
@endisset