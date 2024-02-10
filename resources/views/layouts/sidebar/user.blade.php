<nav class="uk-width-1-1 uk-background-muted uk-box-shadow-small">
    <div class="uk-padding uk-background-secondary">
        <a class="uk-display-block uk-text-center">
            <img class="uk-width-small" src="{{asset('images/logo_w.svg')}}" />
        </a>
        <div class="uk-margin uk-text-white uk-text-small uk-text-center">
            {{ auth("user")->user()->nick_name }}<br/>
            のマイページ
        </div>
    </div>
    <div class="uk-padding-small">
        <div class="uk-margin">
            <a class="uk-button uk-button-primary uk-button-large uk-width-1-1" uk-toggle href="#user-modal">
                寄付する
            </a>
        </div>
        <div class="uk-margin">
            <a class="uk-button uk-button-default uk-button-large uk-width-1-1" href="{{route('user.donates.index')}}">
                寄付実績を見る
            </a>
        </div>
        <div class="uk-margin">
            <a class="uk-button uk-button-default uk-width-1-1" href="{{route('user.edit')}}">
                支払い方法の変更
            </a>
        </div>
        <div class="uk-margin">
            <a class="uk-button uk-button-default uk-width-1-1" href="{{route('root.index')}}">
                トップページ
            </a>
        </div>
        <div class="uk-margin uk-text-center">
            <a class="uk-button uk-button-text" href="{{route('user.logout')}}">
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

<div id="user-modal" uk-modal="esc-close:false;bg-close:false;">
    <div class="uk-modal-dialog uk-border-rounded uk-overflow-hidden">
        <form method="POST" action="{{route('user.donates.add')}}">
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
                            "label" => "寄付金額", "name" => "price", "type" => "number"
                        ])
                    </div>
                    <div class="uk-margin-small">
                        @include("components.input.textarea", [
                            "label" => "寄付したいテーマを入力してください", "name" => "description", "type" => "number"
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
                        <button class="uk-button uk-button-primary uk-width-1-1">寄付する</button>
                    </div>
                </div>
            </div>
            {{ csrf_field() }}
        </form>
    </div>
</div>
