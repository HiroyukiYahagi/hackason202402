<div class="uk-background-muted uk-box-shadow-small" style="height: calc(100vh - 60px);overflow:scroll;">
  <div class="uk-padding-small">
    <form method="GET" action="{{route('admin.senarios.index', ['bot' => $bot])}}">
      <select class="uk-select" name="senario_id" onchange="this.parentNode.submit()">
        @foreach( $bot->senarios as $s )
        <option value="{{ $s->id }}" {{ $senario->id == $s->id ? 'selected' : null }}>{{ $s->name }}</option>
        @endforeach
      </select>
    </form>
  </div>
  <hr class="uk-margin-remove" />
  <div class="uk-padding-small">
    <a class="uk-button uk-button-text" href="{{route('admin.senarios.view', ['bot' => $bot, 'senario' => $senario])}}">
      シナリオ設定
    </a>
  </div>
  <hr class="uk-margin-remove" />
  <div class="uk-padding-small">
    <a class="uk-button uk-button-text" href="{{route('admin.rules.index', ['bot' => $bot, 'senario' => $senario])}}">
      メッセージルール
    </a>
  </div>
  <hr class="uk-margin-remove" />
  <div class="uk-padding-small">
    <a class="uk-button uk-button-text" href="{{route('admin.senarios.accounts', ['bot' => $bot, 'senario' => $senario])}}">
      アカウント一覧
    </a>
  </div>
</div>