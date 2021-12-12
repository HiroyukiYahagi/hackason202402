<caption>請求先情報</caption>
<tbody>
    <tr>
        <td class="uk-width-medium@s uk-text-bold">
            宛名 <span class="uk-text-danger">*必須</span>
        </td>
        <td>
            <div class="uk-width-large">
                @component('components.input.text', [
                    'name' => 'billing[name]',
                    'required' => true,
                    'value' => isset($billingInformation) ? $billingInformation->name : null,
                ])@endcomponent
            </div>
        </td>
    </tr>
    <tr>
        <td class="uk-width-medium@s uk-text-bold">
            請求先担当者名 <span class="uk-text-danger">*必須</span>
        </td>
        <td>
            <div class="uk-width-small">
                @component('components.input.text', [
                    'name' => 'billing[staff_name]',
                    'required' => true,
                    'value' => isset($billingInformation) ? $billingInformation->staff_name : null,
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
                    'name' => 'billing[email]',
                    'type' => 'email',
                    'required' => true,
                    'value' => isset($billingInformation) ? $billingInformation->email : null,
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
                            'name' => 'billing[post_code]',
                            'required' => true,
                            'value' => isset($billingInformation) ? $billingInformation->post_code : null,
                        ])@endcomponent
                    </div>
                </div>
                <div class="uk-width-small">
                    <div class="uk-form-controls">
                        <button
                            onclick="AjaxZip3.zip2addr(this,'billing[post_code]','billing[prefecture]','billing[address]');"
                            type="button" class="uk-button uk-button-default">
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
                <select class="uk-select uk-form-width-medium" type="text" name="billing[prefecture]"
                    v-model="(partner.billing_information || {}).prefecture">
                    @foreach (config('prefectures') as $pref)
                        @if (old('billing[prefecture]') == $pref)
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
                    'name' => 'billing[address]',
                    'value' => isset($billingInformation) ? $billingInformation->address : null,
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
                    'name' => 'billing[address_detail]',
                    'value' => isset($billingInformation) ? $billingInformation->address_detail : null,
                ])@endcomponent
            </td>
        </div>
    </tr>
</tbody>
