<nav class="uk-width-1-1 uk-background-muted uk-box-shadow-small">
    <div class="uk-padding uk-background-danger">
        <a class="uk-display-block uk-text-center">
            <img class="uk-width-small" src="{{asset('images/logo_w.svg')}}" />
        </a>
        <div class="uk-margin uk-text-white uk-text-small uk-text-center">
            {{ auth("shop")->user()->shop_name }}<br/>
            のマイページ
        </div>
    </div>
    <div class="uk-padding-small">
        <div class="uk-margin">
            <a class="uk-button uk-button-primary uk-button-large uk-width-1-1" uk-toggle href="#shop-modal">
                寄付を受け取る
            </a>
        </div>
        <div class="uk-margin">
            <a class="uk-button uk-button-default uk-button-large uk-width-1-1" href="{{route('shop.petitions.index')}}">
                受け取り履歴を見る
            </a>
        </div>
        <div class="uk-margin">
            <a class="uk-button uk-button-default uk-width-1-1" href="{{route('shop.edit')}}">
                会員情報の変更
            </a>
        </div>
        <div class="uk-margin">
            <a class="uk-button uk-button-default uk-width-1-1" href="{{route('root.index')}}">
                トップページ
            </a>
        </div>
        <div class="uk-margin uk-text-center">
            <a class="uk-button uk-button-text" href="{{route('shop.logout')}}">
                ログアウト
            </a>
        </div>
        <div class="uk-margin">
            <a class="uk-button uk-button-link">
                利用規約
            </a>
        </div>
        <div class="uk-margin">
            <a class="uk-button uk-button-link">
                よくあるご質問
            </a>
        </div>
        <div class="uk-margin">
            <a class="uk-button uk-button-link">
                プライバシーポリシー
            </a>
        </div>
        <div class="uk-margin">
            <a class="uk-button uk-button-link uk-margin-small-right uk-margin-small-left">
                <span uk-icon="twitter"></span>
            </a>
            <a class="uk-button uk-button-link uk-margin-small-right uk-margin-small-left">
                <span uk-icon="facebook"></span>
            </a>
            <a class="uk-button uk-button-link uk-margin-small-right uk-margin-small-left">
                <span uk-icon="instagram"></span>
            </a>
        </div>
        <hr/>
        <div class="uk-margin uk-text-small">
            ©︎ Team Dog Lover's
        </div>
    </div>
</nav>



<div id="shop-modal" uk-modal="esc-close:false;bg-close:false;">
    <div class="uk-modal-dialog uk-border-rounded uk-overflow-hidden">
        <form method="POST" action="{{route('shop.petitions.add')}}">
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">寄付を受取り応募フォーム</h2>
            </div>
            <div class="uk-modal-body">
                <p class="uk-text-small">
                    寄付の利用用途と希望金額を入力してください。<br/>
                    利用用途と一致するプール金から寄付が適用されます。
                </p>
                <div class="uk-margin">
                    <h4 class="uk-margin-small">受け取り希望</h4>
                    <div class="uk-margin-small">
                        @include("components.input.text", [
                            "label" => "金額する金額", "name" => "desired_price", "type" => "number"
                        ])
                    </div>
                    <div class="uk-margin-small">
                        @include("components.input.textarea", [
                            "label" => "活動テーマ・利用目的を記載してください", "name" => "description", "type" => "number"
                        ])
                    </div>
                </div>
            </div>
            <div class="uk-modal-footer">
                <div class="uk-grid-small uk-margin" uk-grid>
                    <div class="uk-width-1-2">
                        <a class="uk-button uk-button-link uk-modal-close uk-width-1-1" type="button">キャンセル</a>
                    </div>
                    <div class="uk-width-1-2">
                        <button class="uk-button uk-button-primary uk-width-1-1">応募する</button>
                    </div>
                </div>
            </div>
            {{ csrf_field() }}
        </form>
    </div>
</div>