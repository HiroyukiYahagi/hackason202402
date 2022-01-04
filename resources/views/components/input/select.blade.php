@isset($label)
<label class="uk-form-label" for="form-{{ $name }}">
  {!! $label !!}
</label>
@endisset
<div class="uk-form-controls">
  <select class="uk-select" name="{{$name}}">
  @foreach( $options as $option )
  <option value="{{ $option['value'] }}" {{ old($name, isset($value) ? $value : null) == $option['value'] ? 'selected' : null }}>
    {{ $option['label'] }}
  </option>
  @endforeach
  </select>
</div>
@isset($required)
<div>
  <span class="uk-text-small uk-text-danger">※必須項目です</span>
</div>
@endisset