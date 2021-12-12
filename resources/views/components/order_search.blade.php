<div class="uk-grid-small uk-flex-bottom" uk-grid>
  <div class="uk-width-1-6@s">
      <label for="id" class="uk-form-label">
          <small>ID</small>
      </label>
      <input type="number" class="uk-input" placeholder="IDを入力" name="id"
          value="{{ isset($param['id']) ? $param['id'] : null }}">
  </div>
  <div class="uk-width-1-6@s">
      <label for="partner_name" class="uk-form-label">
          <small>パートナー名</small>
      </label>
      <input type="text" class="uk-input" placeholder="パートナー名を入力" name="partner_name"
          value="{{ isset($param['partner_name']) ? $param['partner_name'] : null }}">
  </div>
  <div class="uk-width-1-6@s">
      <label for="shipping_date_from" class="uk-form-label">
          <small>出荷日~</small>
      </label>
      <input type="date" class="uk-input" name="shipping_date_from"
          value="{{ isset($param['shipping_date_from']) ? $param['shipping_date_from'] : null }}">
  </div>
  <div class="uk-width-1-6@s">
      <label for="shipping_date_to" class="uk-form-label">
          <small>まで</small>
      </label>
      <input type="date" class="uk-input" name="shipping_date_to"
          value="{{ isset($param['shipping_date_to']) ? $param['shipping_date_to'] : null }}">
  </div>
  <div class="uk-width-1-6@s">
      <button class="uk-button uk-button-primary uk-width-1-1">
          検索
      </button>
  </div>
</div>