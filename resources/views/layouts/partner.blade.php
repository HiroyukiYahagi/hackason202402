@extends('layouts.empty')

@section('main')
    <header class="uk-position-relative">
        <nav class="uk-navbar-container uk-navbar-transparent uk-navbar uk-box-shadow-small" id="header-bg" uk-navbar>
            <div class="uk-navbar-left uk-visible@m">
                <div class="uk-navbar-item">
                    <a href="{{ route('partner.carts.create') }}" class="uk-button uk-button-primary uk-width-1-1">
                        新しく発注する
                    </a>
                </div>
                <div class="uk-navbar-item">
                    <a href="{{ route('partner.edit') }}" class="uk-button uk-button-text">
                        パートナー様情報の変更
                    </a>
                </div>
                <div class="uk-navbar-item">
                    <a href="{{ route('partner.payment.edit')}}" class="uk-button uk-button-text">
                        お支払い方法を変更
                    </a>
                </div>
                <div class="uk-navbar-item">
                    <a href="{{ route('partner.orders.index') }}" class="uk-button uk-button-text">
                        発注履歴
                    </a>
                </div>
                <div class="uk-navbar-item">
                    <a href="{{ route('partner.interviews.create') }}" class="uk-button uk-button-text">
                        インタビュー
                    </a>
                </div>
                <div class="uk-navbar-item">
                    <a href="{{ route('partner.downloads') }}" class="uk-button uk-button-text">
                        請求書ダウンロード
                    </a>
                </div>
                <div class="uk-navbar-item">
                    <form action="{{ route('partner.logout') }}" method="POST">
                        @csrf
                        <button class="uk-button uk-button-text">
                            ログアウト
                        </button>
                    </form>
                </div>
            </div>
            <div class="uk-navbar-left uk-hidden@m">
                <ul class="uk-navbar-nav">
                    <li>
                        <a href="#">
                            <span uk-navbar-toggle-icon></span> <span class="uk-margin-small-left">Menu</span>
                        </a>
                        <div class="uk-navbar-dropdown uk-width-medium">
                            <div>
                                <a href="{{ route('partner.carts.create') }}"
                                    class="uk-button uk-button-primary uk-width-1-1">
                                    新しく発注する
                                </a>
                            </div>
                            <hr />
                            <div>
                                <a href="{{ route('partner.edit') }}" class="uk-button uk-button-text">
                                    パートナー様情報の変更
                                </a>
                            </div>
                            <hr />
                            <div>
                                <a href="{{ route('partner.payment.edit')}}" class="uk-button uk-button-text">
                                    お支払い情報
                                </a>
                            </div>
                            <hr />
                            <div>
                                <a href="{{ route('partner.orders.index') }}" lass="uk-button uk-button-text">
                                    発注履歴
                                </a>
                            </div>
                            <hr />
                            <div>
                                <a href="{{ route('partner.interviews.create') }}" class="uk-button uk-button-text">
                                    インタビュー
                                </a>
                            </div>
                            <hr />
                            <div>
                                <a href="{{ route('partner.home') }}" class="uk-button uk-button-text">
                                    パートナー専用ページトップ
                                </a>
                            </div>
                            <hr />
                            <div>
                                <form action="{{ route('partner.logout') }}" method="POST">
                                    @csrf
                                    <button class="uk-button uk-button-text">
                                        ログアウト
                                    </button>
                                </form>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="uk-navbar-right">
                <a href="{{ route('partner.home') }}" class="uk-navbar-item uk-link-reset">
                    <img class="uk-width-small uk-visible@s uk-margin-small-right" src="{{ asset('images/logo.svg') }}"
                        alt="ココグルメ">
                    <img width="40px;" class="uk-hidden@s uk-margin-small-right" src="{{ asset('images/icon.svg') }}"
                        alt="ココグルメ">
                    <span class="uk-text-bold">{{ Auth::user()->name }}様<br />専用ページ</span>
                </a>
            </div>
        </nav>
    </header>

    <main class="uk-section uk-section-muted">
        <div class="uk-container uk-container-small"
            style="min-height: 80vh;background-color: white;padding-top: 32px;padding-bottom: 32px;">
            @yield('content')
        </div>
    </main>

    <footer class="uk-section uk-section-small uk-section-secondary">
        <div class="uk-container uk-container-small uk-text-center">
            <div class="uk-margin-uk-text-center">
                <a href="https://biophilia.co.jp/#contact" {{-- コーポレートの問い合わせ欄に遷移 --}}
                    class="uk-button uk-button-text uk-margin-small-right uk-margin-small-left" target="_blank">
                    お問合せ先
                </a>
                <a href="https://coco-gourmet.com/archives" 
                    class="uk-button uk-button-text uk-margin-small-right uk-margin-small-left" target="_blank">
                    愛犬家のためのコラム
                </a>
                <a href="{{ route('partner.privacy') }}"
                    class="uk-button uk-button-text uk-margin-small-right uk-margin-small-left">
                    プライバシー・ポリシー
                </a>
                <a href="{{ route('partner.term') }}"
                    class="uk-button uk-button-text uk-margin-small-right uk-margin-small-left">
                    利用規約
                </a>
                <a href="{{ route('partner.law') }}"
                    class="uk-button uk-button-text uk-margin-small-right uk-margin-small-left">
                    特定商取引法に関する記載
                </a>
                <a href="https://coco-gourmet.com/"
                    class="uk-button uk-button-text uk-margin-small-right uk-margin-small-left" target="_blank">
                    ココグルメ公式HP
                </a>
                <a href="https://biophilia.co.jp/"
                    class="uk-button uk-button-text uk-margin-small-right uk-margin-small-left" target="_blank">
                    運営会社
                </a>
            </div>
            <div class="uk-margin">
                ©︎ Biophilia inc.
            </div>
    </footer>
@endsection
