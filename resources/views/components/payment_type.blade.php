@if ($payment_type == config('const.CREDIT'))
    クレジットカード
@elseif($payment_type == config('const.TRANSFER'))
    口座振り込み
@endif