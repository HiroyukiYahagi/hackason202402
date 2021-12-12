<table class="uk-table uk-table-striped">
  <thead class="thead-color">
      <tr>
          <th>
              @if (isset($param['direction']) && $param['direction'] == 'asc')
                  @sortablelink('created_at', 'ID▲')
              @else
                  @sortablelink('created_at', 'ID▼')
              @endif
          </th>
          <th>出荷日/到着希望日</th>
          <th>発注者情報</th>
          <th>数量</th>
          <th>支払方法</th>
          <th>請求金額</th>
          <th>操作</th>
      <tr>
  </thead>
  <tbody>
      @foreach ($orders as $order)
          <tr>
              <td><a href="{{ route('orders.edit', ['order' => $order]) }}" method="get">{{ $order->id }}</a>
              </td>
              <td>
                  <div>
                      {{ $order->shipping_date->format('Y/m/d') }}出荷
                  </div>
                  <div>
                      {{ $order->arrival_date->format('Y/m/d') }}
                      {{ $order->arrival_time }}
                  </div>
                  @if ($order->registered == $order::UNREGISTERED)
                      <span class="uk-label uk-label-danger">未登録</span>
                  @elseif($order->registered == $order::REGISTERED)
                      <span class="uk-label uk-label-success">登録済</span>
                  @else
                      <span>登録されていないステータス</span>
                  @endif
              </td>
              <td>
                  <a href="{{ route('partners.show', ['partner' => $order->partner]) }}">
                      {{ $order->partner_name }}
                  </a>
                  (<span class="uk-margin-small-right">担当:</span>{{ $order->staff_name }}様) <br>
                  {{ $order->tel }}
                  <span>/</span>
                  <a href="mailto:{{ $order->partner->email }}">{{ $order->email }}</a> <br>
                  〒{{ $order->post_code }} <br>
                  {{ $order->prefecture }}
                  {{ $order->address }}
                  {{ $order->address_detail }}
              </td>
              <td>
                  @foreach ($order->carts as $cart)
                      <div>
                          <span class="uk-margin-small-right">{{ $cart->product_name }}:</span>
                          {{ $cart->size }}個
                      </div>
                  @endforeach
              </td>
              <td>
                  @component('components.payment_type', [
                      'payment_type' => $order->payment_type
                  ])@endcomponent
              </td>
              <td>
                  @if ($order->temporary == true)
                      <div class="uk-text-danger">※請求金額確定前です</div>
                  @elseif($order->temporary == false)
                      {{ number_format($order->total_sales) }} 円
                  @endif
              </td>
              <td>
                  @component('components.icon', [
                      'route' => 'orders.edit',
                      'args' => ['order' => $order],
                      'icon' => 'file-edit',
                      'color' => 'primary',
                  ])@endcomponent
              </td>
          </tr>
      @endforeach
  </tbody>
</table>
