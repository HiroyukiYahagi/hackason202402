@extends('layouts.empty')

@section('main')

    <!-- ヘッダ -->
    <header class="uk-position-relative uk-box-shadow-small">
        <nav class="uk-navbar-container uk-navbar-transparent" uk-navbar>
            <div class="uk-navbar-center">
                <div class="uk-navbar-item uk-padding-small">
                    <img class="uk-width-small" src="{{ asset('images/logo.svg') }}" alt="ココグルメのロゴ">
                </div>
            </div>
        </nav>
    </header>
    <!-- メイン -->
    <div class="uk-section uk-section-small">
        <div class="uk-width-medium@s uk-align-center uk-margin">
        @component('components.flash')
        @endcomponent
        </div>
        <div class="uk-container uk-container-xsmall">
            <div class="uk-padding uk-background-muted">
                <h1 class="uk-text-center">管理者ログイン</h1>
                <div class="uk-margin">
                    <form method="POST" action="{{ route('admin.login') }}">
                        @csrf
                        <!-- メールアドレス -->
                        <div class="uk-margin">
                            @component('components.input.text', ['name' => 'email', 'label' => 'メールアドレス', 'required' =>
                            true, 'type' => 'text'])@endcomponent
                        </div>
                        <!-- パスワード -->
                        <div class="uk-margin">
                            @component('components.input.text', ['name' => 'password', 'label' => 'パスワード', 'required' =>
                            true, 'type' => 'password'])@endcomponent
                        </div>
                        <div class="uk-margin uk-text-center">
                            <button type="submit" class="uk-button uk-button-primary uk-width-large@s">
                                ログイン
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
