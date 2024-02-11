<nav class="uk-width-1-1 uk-background-muted uk-box-shadow-small">
    <div class="uk-padding uk-background-primary">
        <a class="uk-display-block uk-text-center" href="{{route('root.index')}}">
            <img class="uk-width-small" src="{{asset('images/logo_w.svg')}}" />
        </a>
        <div class="uk-margin uk-text-white uk-h3 uk-text-center">
            "コト"に寄付する<br/>プラットフォーム
        </div>
    </div>
    <div class="uk-padding-small">
        <div class="uk-margin">
            <a class="uk-button uk-button-primary uk-button-large uk-width-1-1" uk-toggle href="#user-modal">
                寄付する
            </a>
        </div>
        <div class="uk-margin">
            <a class="uk-button uk-button-default uk-button-large uk-width-1-1" uk-toggle href="#shop-modal">
                寄付を受けとる
            </a>
        </div>
        <div class="uk-margin uk-text-center">
            <a class="uk-button uk-button-text" uk-toggle href="#login-modal">
                ログインする
            </a>
        </div>
        <div class="uk-margin">
            <a class="uk-button uk-button-link" href="{{route('root.other')}}">
                利用規約
            </a>
        </div>
        <div class="uk-margin">
            <a class="uk-button uk-button-link" href="{{route('root.other')}}">
                よくあるご質問
            </a>
        </div>
        <div class="uk-margin">
            <a class="uk-button uk-button-link" href="{{route('root.other')}}">
                プライバシーポリシー
            </a>
        </div>
        <div class="uk-margin">
            <a class="uk-button uk-button-link uk-margin-small-right uk-margin-small-left" href="{{route('root.other')}}">
                <span uk-icon="twitter"></span>
            </a>
            <a class="uk-button uk-button-link uk-margin-small-right uk-margin-small-left" href="{{route('root.other')}}">
                <span uk-icon="facebook"></span>
            </a>
            <a class="uk-button uk-button-link uk-margin-small-right uk-margin-small-left" href="{{route('root.other')}}">
                <span uk-icon="instagram"></span>
            </a>
        </div>
        <hr/>
        <div class="uk-margin uk-text-small">
            ©︎ Team Dog Lover's
        </div>
    </div>
</nav>

<div id="user-modal" uk-modal="esc-close:false;bg-close:false;">
    <div class="uk-modal-dialog uk-border-rounded uk-overflow-hidden">
        <form method="POST" action="{{route('user.add')}}">
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">寄付する</h2>
            </div>
            <div class="uk-modal-body">
                <p class="uk-text-small">
                    あなたが寄付したい金額と、寄付対象のテーマを自由に入力してください。<br/>
                    入力していただいたテーマに沿った寄付受け取り依頼に対して、プールした金額から配分されていきます。
                </p>
                <div class="uk-margin">
                    <h4 class="uk-margin-small">寄付内容</h4>
                    <div class="uk-margin-small">
                        @include("components.input.text", [
                            "label" => "ニックネーム", "name" => "nick_name", "type" => "text"
                        ])
                    </div>
                    <div class="uk-margin-small">
                        @include("components.input.text", [
                            "label" => "寄付金額", "name" => "price", "type" => "number"
                        ])
                    </div>
                    <div class="uk-margin-small">
                        @include("components.input.textarea", [
                            "label" => "寄付したいテーマを入力してください", "name" => "description", "type" => "number"
                        ])
                    </div>
                </div>
                <div class="uk-margin">
                    <h4 class="uk-margin-small">お支払い方法</h4>
                    <div class="uk-margin-small">
                        <img class="uk-width-medium" src="{{asset('images/card.png')}}" />
                    </div>
                    <div class="uk-margin-small">
                        @include("components.input.text", [
                            "label" => "カード番号", "name" => "card_number", "type" => "number"
                        ])
                    </div>
                    <div class="uk-margin-small uk-grid-small" uk-grid>
                        <div class="uk-width-1-2">
                            @include("components.input.text", [
                                "label" => "有効期限(MM/YY)", "name" => "card_yearmonth", "type" => "text"
                            ])
                        </div>
                        <div class="uk-width-1-2">
                            @include("components.input.text", [
                                "label" => "CVC", "name" => "card_cvc", "type" => "number"
                            ])
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-modal-footer">
                <div class="uk-grid-small uk-margin" uk-grid>
                    <div class="uk-width-1-2">
                        <a class="uk-button uk-button-link uk-modal-close uk-width-1-1" type="button">キャンセル</a>
                    </div>
                    <div class="uk-width-1-2">
                        <button class="uk-button uk-button-primary uk-width-1-1">寄付する</button>
                    </div>
                </div>
            </div>
            {{ csrf_field() }}
        </form>
    </div>
</div>


<div id="shop-modal" uk-modal="esc-close:false;bg-close:false;">
    <div class="uk-modal-dialog uk-border-rounded uk-overflow-hidden">
        <form method="POST" action="{{route('shop.add')}}">
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
                            "label" => "団体名", "name" => "shop_name", "type" => "text"
                        ])
                    </div>
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


<div id="login-modal" uk-modal="esc-close:false;bg-close:false;">
    <div class="uk-modal-dialog uk-border-rounded uk-overflow-hidden">
        <div class="uk-modal-header">
            <h2 class="uk-modal-title">ログイン</h2>
        </div>
        <div class="uk-modal-body">
            <div class="uk-margin">
                <a class="uk-button uk-button-primary uk-button-large uk-width-1-1" href="{{route('user.login')}}">寄付者としてログイン</a>
            </div>
            <div class="uk-margin">
                <a class="uk-button uk-button-secondary uk-button-large uk-width-1-1"  href="{{route('shop.login')}}">受け取り希望者としてログイン</a>
            </div>
            <div class="uk-margin">
                <a class="uk-button uk-button-link uk-modal-close uk-width-1-1" type="button">キャンセル</a>
            </div>
        </div>
    </div>
</div>