<table class="uk-margin uk-table uk-table-middle uk-table-responsive uk-table-divider uk-table-form">
  <tbody>
      <tr>
          <td class="uk-width-medium@s uk-text-bold">
              商品名 <span class="uk-text-danger">※必須</span>
          </td>
          <td>
              <div class="uk-width-medium">
                  @component('components.input.text', [
                      'name' => 'name',
                      'required' => true,
                      'value' => isset($product) ? $product->name : null,
                  ])@endcomponent
              </div>
          </td>
      </tr>
      <tr>
          <td class="uk-width-medium@s uk-text-bold">
              単価(税抜) <span class="uk-text-danger">※必須</span>
          </td>
          <td>
              <div uk-grid class="uk-grid-small uk-flex-bottom">
                  <div class="uk-width-small">
                      @component('components.input.text', [
                          'name' => 'price',
                          'required' => true,
                          'value' => isset($product) ? $product->price : null,
                      ])@endcomponent
                  </div>
                  <div class="uk-width-auto">
                      <span>円</span>
                  </div>
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
            原価 <span class="uk-text-danger">※必須</span>
        </td>
        <td>
            <div uk-grid class="uk-grid-small uk-flex-bottom">
                <div class="uk-width-small">
                    @component('components.input.text', [
                        'name' => 'prime_cost',
                        'required' => true,
                        'value' => isset($product) ? $product->prime_cost : null,
                    ])@endcomponent
                </div>
                <div class="uk-width-auto">
                    <span>円</span>
                </div>
            </div>
        </td>
    </tr>
  </tbody>
</table>