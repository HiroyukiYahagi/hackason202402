<select class="uk-select" name="{{ $name }}" value="{{ isset($value) ? $value : null }}">
  <option hidden>選択してください</option>
  <?php $to = now()->format('Y') + 20 ?>
  @for($i = now()->format('Y'); $i <= $to; $i++)
    <option value="{{ $i }}">{{ $i }}年</option> 
  @endfor
</select>