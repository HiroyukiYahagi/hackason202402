<?php

return [
    'REGISTERED' => 1,
    'UNREGISTERED' => 0,

    'TRANSFER' => 0, //口座振込
    'CREDIT' => 1, //クレカ

    'TAX_RATE' => 0.1, //消費税
    'FREE_SHIPPING_AMOUNT' => 20000, //送料無料ライン
    'SHIPPING_FEE' => 1500, //通常の送料
    'FAR_SHIPPING_FEE' => 2500, //遠方の送料
    'MINIMUM_SIZES' => 20, //最低注文個数
    'REFERRAL_DISCOUNT' => 3000, // 紹介1件あたりの割引金額
    'ARRIVAL_LEAD_DAYS' => 5,
    'SALES_ADDRESS' => 'info@coco-gourmet.com',

    'public_key' => env('PAYJP_PUBLIC_KEY'),
    'secret_key' => env('PAYJP_SECRET_KEY'),

    'SALES_STYLE' => [ //契約形態
        'PURCHASE' => 0, //買取
        'ENTRUSTMENT' => 1, //委託
    ],

    'FAR_AREA' => [  //遠方のため、到着が通常よりも遅れる地域
        'THREE_DAYS' => [
            '北海道',
            '長崎県',
            '鹿児島県',
        ],
        'TWO_DAYS' => [
            '沖縄県',
            '熊本県',
            '大分県',
            '佐賀県',
        ]
    ],
    'DELIVERY_EXCLUSION_DATES' => [
        '2021-12-29',
        '2021-12-30',
        '2021-12-31',
        '2022-1-1',
        '2022-1-2',
        '2022-1-3',
        '2022-1-4',
        '2022-1-5',
        '2022-1-6',
        '2022-1-7',
        '2022-1-8',
        '2022-1-9',
    ],
    'MIRAKU_DELIVERY_HOLIDAY' => [
        '2021-10-09',
        '2021-11-13',
        '2021-12-29',
        '2021-12-30',
        '2021-12-31',
        '2022-01-01',
        '2022-01-02',
        '2022-01-03',
        '2022-01-04',
        '2022-04-09',
    ],

    // company information
    'TRANSFER_ACCOUNT' => [ //振込先
        'PayPay銀行(0033)',
        'ビジネス営業部(005)',
        '普通',
        '1854546',
    ],
    'COMPANY_INFO' => [ //会社情報
        'NAME' => '株式会社バイオフィリア',
        'POST_CODE' => '1410022',
        'ADDRESS' => '東京都品川区東五反田5-22-7',
        'ADDRESS_DETAIL' => '池田山KAY&KAY WEST 302号室',
        'TELL' => '03-5422-3057',
        'FAX' => '03-4586-6420',
    ],
    'INVOICE_REMARKS' => [ //請求書の備考欄に記載する内容
        '下代 273円/袋(+税)',
        '下代合計2万円以上のお申し込みの場合送料弊社負担',
        '発注受付後5営業日以内でのご納品',
        '不良品以外の返品は原則不可',
        '当月末締め翌月末払い',
        '紹介1件につき、請求金額から3000円割引'
    ]
];
