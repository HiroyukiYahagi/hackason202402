@extends('layouts.empty')

@section('main')
    <header class="uk-position-relative uk-box-shadow-small">
        <nav class="uk-navbar-container uk-navbar-transparent uk-navbar" id="header-bg" uk-navbar>
            <div class="uk-navbar-left uk-margin-left uk-hidden@m">
                <ul class="uk-navbar-nav">
                    <li>
                        <a class="uk-navbar-toggle" href="#">
                            <span uk-navbar-toggle-icon></span> <span class="uk-margin-small-left">Menu</span>
                        </a>
                        <div class="uk-navbar-dropdown">
                            <ul class="uk-nav uk-navbar-dropdown-nav">
                                <li>
                                    <a href="{{ route('admin.index.top')}}" class="uk-button uk-button-text">ダッシュボード</a>
                                </li>
                                <li class="uk-nav-divider"></li>
                                <li class="uk-nav-header">出荷・注文管理</li>
                                <li>
                                    <a href="{{ route('orders.index') }}" class="uk-button uk-button-text">全ての注文</a>
                                </li>
                                <li>
                                    <a href="{{ route('orders.unregistered') }}" class="uk-button uk-button-text">未登録の注文</a>
                                </li>
                                <li>
                                    <a href="{{ route('orders.temporaries') }}" class="uk-button uk-button-text">委託の出荷</a>
                                </li>
                                <li class="uk-nav-divider"></li>
                                <li class="uk-nav-header">パートナー管理</li>
                                <li>
                                    <a href="{{ route('partners.index') }}" class="uk-button uk-button-text">パートナー一覧</a>
                                </li>
                                <li>
                                    <a href="{{ route('partners.cocogurasi') }}" class="uk-button uk-button-text">ココ暮らし出荷</a>
                                </li>
                                <li class="uk-nav-divider"></li>
                                <li class="uk-nav-header">商品管理</li>
                                <li>
                                    <a href="{{ route('products.index') }}" class="uk-button uk-button-text">商品一覧</a>
                                </li>
                                <li class="uk-nav-divider"></li>
                                <li class="uk-nav-header">インタビュー管理</li>
                                <li>
                                    <a href="{{ route('interviews.index') }}" class="uk-button uk-button-text">インタビュー</a>
                                </li>
                                <li class="uk-nav-divider"></li>
                                <li class="uk-nav-header">請求書管理</li>
                                <li>
                                    <a href="{{ route('invoices.index') }}" class="uk-button uk-button-text">全ての請求書</a>
                                </li>
                                @can('accountant')
                                    <li>
                                        <a href="{{ route('invoices.unapproved') }}"
                                            class="uk-button uk-button-text">未承認の請求書</a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="uk-navbar-center">
                <div class="uk-navbar-item uk-padding-small">
                    <a href="https://coco-gourmet.com/">
                        <img class="uk-width-small" src="{{ asset('images/logo.svg') }}" alt="ココグルメのロゴ">
                    </a>
                </div>
            </div>
            @can('accountant')
                <div class="uk-navbar-left">
                    <div class="uk-navbar-item">
                        <span class="uk-label">経理担当者</span>
                    </div>
                </div>
            @endcan
            <div class="uk-navbar-right">
                <div class="uk-navbar-item">
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button class="uk-button uk-button-text">
                            ログアウト
                        </button>
                    </form>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <div uk-grid class="uk-grid-collapse">
            <!-- サイドダッシュボード -->
            <div class="uk-width-auto uk-background-muted uk-visible@m">
                <div class="uk-width-medium uk-padding" style="min-height: calc(100vh - 72px);" id="side-dashboard">
                    <ul class="uk-list uk-list-large uk-list-divider">
                        <li>
                            <a href="{{ route('admin.index.top')}}" class="uk-button uk-button-text">ダッシュボード</a>
                        </li>
                        <li>
                            <span class='uk-text-small'>出荷・注文管理</span>
                            <ul class="uk-list uk-list-bullet">
                                <li>
                                    <a href="{{ route('orders.index') }}" class="uk-button uk-button-text">全ての注文</a>
                                </li>
                                <li>
                                    <a href="{{ route('orders.unregistered') }}" class="uk-button uk-button-text">未登録の注文</a>
                                </li>
                                <li>
                                    <a href="{{ route('orders.temporaries') }}" class="uk-button uk-button-text">委託の出荷</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span class="uk-text-small">パートナー管理</span>
                            <ul class="uk-list uk-list-bullet">
                                <li>
                                    <a href="{{ route('partners.index') }}" class="uk-button uk-button-text">パートナー一覧</a>
                                </li>
                                <li>
                                    <a href="{{ route('partners.cocogurasi') }}" class="uk-button uk-button-text">ココ暮らし出荷</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="{{ route('products.index') }}" class="uk-button uk-button-text">商品一覧</a>
                        </li>
                        <li>
                            <a href="{{ route('interviews.index') }}" class="uk-button uk-button-text">インタビュー</a>
                        </li>
                        <li>
                            <span class="uk-text-small">請求管理</span>
                            <ul class="uk-list uk-list-bullet">
                                <li>
                                    <a href="{{ route('invoices.index') }}" class="uk-button uk-button-text">全ての請求書</a>
                                </li>
                                @can('accountant')
                                    <li>
                                        <a href="{{ route('invoices.unapproved') }}"
                                            class="uk-button uk-button-text">未承認の請求書</a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- 右側 -->
            <div class="uk-width-expand">
                <div class="uk-section uk-section-small">
                    <div class="uk-container uk-container-large">
                        @component('components.flash')
                        @endcomponent
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
