@if(isset($errors) || session('message') || session('error') )
<div class="uk-position-fixed uk-position-top-right uk-padding-small" style="z-index: 1000;">
  @foreach ($errors->all() as $message)
  <div class="uk-display-block uk-width-large@s uk-margin-small uk-alert-danger" uk-alert>
    <a class="uk-alert-close" uk-close></a>
    <p class="uk-padding-small-right uk-text-bold">
        {!! $message !!}
    </p>
  </div>
  @endforeach
  @if( session('error') )
  <div class="uk-display-block uk-width-large@s uk-margin-small uk-alert-danger" uk-alert>
    <a class="uk-alert-close" uk-close></a>
    <p class="uk-text-bold uk-padding-small-right">
        {!! session('error') !!}
    </p>
    @if( session('error_detail') )
    <div class="uk-margin-small">
      <h6 class="uk-margin-xsmall">■以下をご確認ください</h6>
      <p class="uk-margin-xsmall">
        <small>{!! nl2br(session('error_detail')) !!}</small>
      </p>
    </div>
    @endif
  </div>
  @endif
  @if( session('message') )
  <div class="uk-display-block uk-width-large@s uk-margin-small uk-alert-success" uk-alert>
      <a class="uk-alert-close" uk-close></a>
      <p class="uk-text-bold">
          {!! session('message') !!}
      </p>
  </div>
  @endif
</div>
@endif