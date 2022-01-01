@php
$admin = \Auth::guard("admin")->user();
$admin->load(["bots"])
@endphp
<div class="uk-background-primary uk-light" uk-height-viewport>
  <div class="uk-padding-small">
    <form method="GET" action="{{route('admin.bots.index')}}">
      <select class="uk-select" name="bot_id" onchange="this.parentNode.submit()">
        @foreach( $admin->bots as $b )
        <option value="{{ $b->id }}" {{ isset($bot) && $bot->id == $b->id ? 'selected' : null }}>{{ $b->name }}</option>
        @endforeach
      </select>
    </form>
  </div>
  <hr class="uk-margin-remove" />
  <div class="uk-padding-small">
    <a class="uk-button uk-button-link" href="{{route('admin.bots.view', ['bot' => $bot])}}">
      <span uk-icon="icon: home" class="uk-margin-small-right"></span> ダッシュボード
    </a>
  </div>
  <hr class="uk-margin-remove" />
  <div class="uk-padding-small">
    <a class="uk-button uk-button-link" href="{{route('admin.bots.edit', ['bot' => $bot])}}">
      <span uk-icon="icon: info" class="uk-margin-small-right"></span> 基本設定
    </a>
  </div>
  <hr class="uk-margin-remove" />
  <div class="uk-padding-small">
    <a class="uk-button uk-button-link" href="{{route('admin.senarios.index', ['bot' => $bot])}}">
      <span uk-icon="icon: list" class="uk-margin-small-right"></span> シナリオ設定
    </a>
  </div>
  <hr class="uk-margin-remove" />
  <div class="uk-padding-small">
    <a class="uk-button uk-button-link" href="{{route('admin.accounts.index', ['bot' => $bot])}}">
      <span uk-icon="icon: users" class="uk-margin-small-right"></span> 登録ユーザー一覧
    </a>
  </div>
  <hr class="uk-margin-remove" />
  <div class="uk-padding-small">
    <a class="uk-button uk-button-link" href="{{route('admin.assets.index')}}">
      <span uk-icon="icon: image" class="uk-margin-small-right"></span> 素材
    </a>
  </div>
  <hr class="uk-margin-remove" />
  <div class="uk-padding-small">
    <a class="uk-button uk-button-link" href="{{route('admin.index')}}">
      <span uk-icon="icon: cog" class="uk-margin-small-right"></span> 管理者の設定
    </a>
  </div>
</div>