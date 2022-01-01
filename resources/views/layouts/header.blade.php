<nav class="uk-navbar-container uk-box-shadow-medium" uk-navbar>
    <div class="uk-navbar-center">
        <a class="uk-navbar-item uk-logo">
            <img class="uk-width-small" src="{{asset('images/logo.svg')}}" />
        </a>
    </div>
    <div class="uk-navbar-right">
        <div class="uk-navbar-item">
            <a class="uk-button uk-button-primary" href="{{route('admin.index')}}">
                管理トップ
            </a>
        </div>
        <div class="uk-navbar-item">
            <a class="uk-button uk-button-default" href="{{route('admin.logout')}}">
                ログアウト
            </a>
        </div>
    </div>
</nav>