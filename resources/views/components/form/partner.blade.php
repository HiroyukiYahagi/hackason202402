<table class="uk-margin uk-table uk-table-middle uk-table-responsive uk-table-divider uk-table-form">
    <caption>店舗情報</caption>
    <tbody>
        <tr>
            <td class="uk-width-medium@s uk-text-bold">
                パートナー名 <span class="uk-text-danger">*必須</span>
            </td>
            <td>
                <div class="uk-width-large">
                    @component('components.input.text', [
                        'name' => 'name',
                        'required' => true,
                        'value' => isset($partner) ? $partner->name : null,
                    ])@endcomponent
                </div>
            </td>
        </tr>
        <tr>
            <td class="uk-width-medium@s uk-text-bold">
                担当者名 <span class="uk-text-danger">*必須</span>
            </td>
            <td>
                <div class="uk-width-small">
                    @component('components.input.text', [
                        'name' => 'staff_name',
                        'required' => true,
                        'value' => isset($partner) ? $partner->staff_name : null,
                    ])@endcomponent
                </div>
            </td>
        </tr>
        <tr>
            <td class="uk-width-medium@s uk-text-bold">
                販売形態 <span class="uk-text-danger">*必須</span>
            </td>
            <td>
                <div uk-grid>
                    <div class="uk-grid-1-3">
                        <label class="uk-text-bold">
                            <input type="radio" class="uk-radio" name="sales_style" value="{{ config('const.SALES_STYLE.PURCHASE') }}">
                            買取
                        </label>
                    </div>
                    <div class="uk-grid-1-3">
                        <label class="uk-text-bold">
                            <input type="radio" class="uk-radio" name="sales_style" value="{{ config('const.SALES_STYLE.ENTRUSTMENT') }}">
                            委託
                        </label>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td class="uk-width-medium@s uk-text-bold">
                契約開始日 <span class="uk-text-danger">※必須</span>
            </td>
            <td>
                <div class="uk-width-medium">
                    @component('components.input.text', [
                        'name' => 'contract_start',
                        'required' => true,
                        'type' => 'date',
                        'value' => isset($partner->contract_start) ? $partner->contract_start->format('Y-m-d') : null,
                    ])@endcomponent
                </div>
            </td>
        </tr>
        @if (isset($partner->contract_start))
            <tr>
                <td class="uk-width-medium@s uk-text-bold">
                    契約終了日 <span class="uk-text-danger">※必須</span>
                </td>
                <td>
                    <div class="uk-width-medium">
                        @component('components.input.text', [
                            'name' => 'contract_end',
                            'required' => true,
                            'type' => 'date',
                            'value' => isset($partner->contract_end) ? $partner->contract_end->format('Y-m-d') : null,
                        ])@endcomponent
                    </div>
                </td>
            </tr>
        @else
            <tr>
                <td class="uk-width-medium@s uk-text-bold">
                    契約日数 <span class="uk-text-danger">※必須</span>
                </td>
                <td>
                    <div class="uk-width-small">
                        <select name="contract_days" class="uk-select">
                            @for ($i = 30; $i <= 540; $i++)
                                <option value="{{ $i }}">{{ $i }}日間</option>
                            @endfor
                        </select>
                    </div>
                </td>
            </tr>
        @endif
        <tr>
            <td class="uk-width-medium@s uk-text-bold">
                電話番号 <span class="uk-text-danger">*必須</span>
            </td>
            <td>
                <div class="uk-width-small">
                    @component('components.input.text', [
                        'name' => 'tel',
                        'required' => true,
                        'value' => isset($partner) ? $partner->tel : null,
                    ])@endcomponent
                </div>
            </td>
        </tr>
        <tr>
            <td class="uk-width-medium@s uk-text-bold">
                メールアドレス <span class="uk-text-danger">*必須</span>
            </td>
            <td>
                <div class="uk-width-medium">
                    @component('components.input.text', [
                        'name' => 'email',
                        'type' => 'email',
                        'required' => true,
                        'value' => isset($partner) ? $partner->email : null,
                    ])@endcomponent
                </div>
            </td>
        </tr>
        <tr>
            <td class="uk-width-medium@s uk-text-bold">
                郵便番号 <span class="uk-text-danger">*必須</span>
            </td>
            <td>
                <div class="uk-grid-small uk-flex-middle uk-grid" uk-grid>
                    <div class="uk-width-small">
                        <div class="uk-form-controls">
                            @component('components.input.text', [
                                'name' => 'post_code',
                                'required' => true,
                                'value' => isset($partner) ? $partner->post_code : null,
                            ])@endcomponent
                        </div>
                    </div>
                    <div class="uk-width-small">
                        <div class="uk-form-controls">
                            <button onclick="AjaxZip3.zip2addr(this,'post_code','prefecture','address');" type="button"
                                class="uk-button uk-button-default">
                                自動入力
                            </button>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td class="uk-width-medium@s uk-text-bold">
                都道府県 <span class="uk-text-danger">*必須</span>
            </td>
            <td>
                <div class="uk-form-controls">
                    <select class="uk-select uk-form-width-medium" name="prefecture" v-model="partner.prefecture">
                        @foreach (config('prefectures') as $pref)
                            @if (old('prefecture') == $pref)
                                <option value="{{ $pref }}" selected="selected" name="pref01">
                                    {{ $pref }}</option>
                            @else
                                <option value="" style="display: none;">選択してください</option>
                                <option value="{{ $pref }}" name="pref01">{{ $pref }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <td class="uk-width-medium@s uk-text-bold">
                市区町村 <span class="uk-text-danger">*必須</span>
            </td>
            <td>
                <div class="uk-form-controls">
                    @component('components.input.text', [
                        'name' => 'address',
                        'value' => isset($partner) ? $partner->address : null,
                    ])@endcomponent
                </div>
            </td>
        </tr>
        <tr>
            <td class="uk-width-medium@s uk-text-bold">
                建物・部屋番号
            </td>
            <div class="uk-width-small">
                <td>
                    @component('components.input.text', [
                        'name' => 'address_detail',
                        'value' => isset($partner) ? $partner->address_detail : null,
                    ])@endcomponent
                </td>
            </div>
        </tr>
        <tr>
            <td class="uk-width-medium@s uk-text-bold">
                サムネイル画像URL
            </td>
            <div class="uk-width-small">
                <td>
                    @component('components.input.text', [
                        'name' => 'image_url',
                        'value' => isset($partner) ? $partner->image_url : null,
                    ])@endcomponent
                </td>
            </div>
        </tr>
        <tr>
            <td class="uk-width-medium@s uk-text-bold">
                公式HP URL
            </td>
            <div class="uk-width-small">
                <td>
                    @component('components.input.text', [
                        'name' => 'homepage_url',
                        'value' => isset($partner) ? $partner->homepage_url : null,
                    ])@endcomponent
                </td>
            </div>
        </tr>
        <tr>
            <td class="uk-width-medium@s uk-text-bold">
                記事ページ URL
            </td>
            <div class="uk-width-small">
                <td>
                    @component('components.input.text', [
                        'name' => 'article_url',
                        'value' => isset($partner) ? $partner->article_url : null,
                    ])@endcomponent
                </td>
            </div>
        </tr>
        <tr>
            <td class="uk-width-medium@s uk-text-bold">
                店舗紹介コメント
            </td>
            <div class="uk-width-small">
                <td>
                    @component('components.input.text', [
                        'name' => 'shop_detail',
                        'value' => isset($partner) ? $partner->shop_detail : null,
                    ])@endcomponent
                </td>
            </div>
        </tr>
    </tbody>
</table>
