@extends('layouts.wani')

@section('content')

<h1 class="uk-text-center">寄附金申請フォーム</h1>

<div class="uk-margin">
  <div class="uk-background-muted uk-padding-small">
    わににゃるプロジェクトにご賛同いただきありがとうございます。<br/>
    いただいた寄付金は全国の保護団体様にお届けいたします。
  </div>
</div>

<div id="donate-form" class="uk-margin-medium">
  <form name="donateForm" method="post" action="{{route('donate.view', ['hash' => $hash])}}">
    <h3 class="uk-text-center">お申込み内容</h3>

    <div class="uk-margin">
      <label class="uk-form-label" for="form-stacked-text">寄付者様のお名前<span class="uk-label uk-label-danger uk-margin-small-left">必須</span></label>
      <div class="uk-form-controls uk-margin-small">
        <input class="uk-input uk-form-large uk-border-rounded" type="text" placeholder="お名前を入力してください" v-model="name" name="name">
      </div>
    </div>

    <div class="uk-margin" v-if="!showPrice">
      <div class="uk-margin-small">
        <label class="uk-form-label" for="form-stacked-text">寄附額<span class="uk-label uk-label-danger uk-margin-small-left">必須</span></label>
      </div>
      <div class="uk-margin-small uk-grid-small" uk-grid>
        <div v-for="p in plans" class="uk-width-1-3@s uk-width-1-1">
          <label class="uk-card uk-card-default uk-card-small uk-card-body uk-position-relative">
            <div class="uk-grid-small uk-flex-middle" uk-grid>
              <div class="uk-width-auto">
                <input class="uk-radio" type="radio" name="plan" v-bind:value="p.tag" v-model="plan" />
              </div>
              <div class="uk-width-expand">
                <h3 class="uk-margin-remove"><span v-text="p.price"></span><span class="uk-text-small">円</span></h3>
                <span class="uk-text-small uk-text-muted" v-text="p.cta"></span>
              </div>
            </div>
            <span v-if="p.is_recommend" class="uk-label uk-position-top-right">オススメ</span>
          </label>
        </div>
        <div class="uk-width-1-3@s uk-width-1-1">
          <label class="uk-card uk-card-default uk-card-small uk-card-body uk-position-relative">
            <div class="uk-grid-small uk-flex-middle" uk-grid>
              <div class="uk-width-auto">
                <input class="uk-radio" type="radio" name="plan" v-model="plan" value="custom" />
              </div>
              <div class="uk-width-expand">
                <span class="uk-h5">任意の金額</span>
                <div style="margin-top: 7px;">
                  <div class="uk-grid-small uk-flex-middle" uk-grid>
                    <div class="uk-width-expand">
                      <input class="uk-input uk-border-rounded" type="number" placeholder="寄付金を入力してください" v-model="custom_price">
                    </div>
                    <div class="uk-width-auto">
                      <span class="uk-text-small uk-text-bold">円</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </label>
        </div>
      </div>
    </div>
    <div v-bind:hidden="!showPrice" class="uk-margin">
      <div class="uk-margin-small">
        <label class="uk-form-label" for="form-stacked-text">寄附額<span class="uk-label uk-label-danger uk-margin-small-left">必須</span></label>
      </div>
      <div class="uk-margin-small uk-grid-small uk-flex-bottom uk-flex-center" uk-grid>
        <div class="uk-width-expand">
          <input class="uk-input uk-form-large uk-border-rounded" type="number" placeholder="寄付金を入力してください" name="price" v-model="price">
        </div>
        <div class="uk-width-medium@s uk-width-auto">
          円
        </div>
      </div>
    </div>

    <h3 class="uk-text-center">お支払い方法</h3>

    <div class="uk-margin uk-text-center@s">
      <img class="uk-width-large" src="{{asset('images/card.png')}}" />
    </div>

    <div class="uk-margin">
      <label class="uk-form-label" for="form-stacked-text">カード番号<span class="uk-label uk-label-danger uk-margin-small-left">必須</span></label>
      <div class="uk-form-controls uk-margin-small">
        <input class="uk-input uk-form-large uk-border-rounded" type="number" placeholder="カード番号を入力してください" v-model="card_number">
      </div>
    </div>

    <div class="uk-margin uk-grid-small" uk-grid>
      <div class="uk-width-1-2">
        <label class="uk-form-label" for="form-stacked-text">月</label>
        <div class="uk-form-controls uk-margin-small">
          <select class="uk-select uk-form-large" v-model="card_month">
            @for( $i=1; $i<=12; $i++ )
            <option value="{{ $i }}">{{ $i }}月</option>
            @endfor
          </select>
        </div>
      </div>
      <div class="uk-width-1-2">
        <label class="uk-form-label" for="form-stacked-text">年</label>
        <div class="uk-form-controls uk-margin-small">
          <select class="uk-select uk-form-large" v-model="card_year">
            @for( $i=2022; $i<=2045; $i++ )
            <option value="{{ $i }}">{{ $i }}年</option>
            @endfor
          </select>
        </div>
      </div>
    </div>

    <div class="uk-margin uk-grid-small uk-flex-bottom" uk-grid>
      <div class="uk-width-1-2">
        <label class="uk-form-label" for="form-stacked-text">CVC<span class="uk-label uk-label-danger uk-margin-small-left">必須</span></label>
        <div class="uk-form-controls uk-margin-small">
          <input class="uk-input uk-form-large uk-border-rounded" type="number" placeholder="CVCを入力してください" v-model="card_cvc">
        </div>
      </div>
      <div class="uk-width-1-5">
        <img class="uk-width-large" src="{{asset('images/securitycode.png')}}" />
      </div>
    </div>
    <div class="uk-margin">
      <div class="uk-margin-small uk-text-center">
        <label>
          <input type="checkbox" v-model="is_agreed" class="uk-checkbox uk-margin-small-right" />利用規約に同意の上送信ください
        </label>
      </div>
      <div class="uk-margin-small uk-height-small uk-overflow-auto uk-padding-small" style="border: 1px solid #F0F0F0;font-size: 13px;">
        @include("components.common.term")
      </div>
    </div>
    <div v-if="error_message.length > 0" class="uk-margin uk-alert uk-alert-danger">
      <p v-html="error_message"></p>
    </div>
    <div class="uk-margin uk-text-center">
      <button class="uk-button uk-button-primary uk-button-large uk-width-medium uk-text-bold" type="button" v-bind:disabled="!catSubmit()" v-on:click="onSubmit()">
        確認画面に進む
      </button>
    </div>
    <input type="hidden" name="payment_type" v-model="payment_type">
    <input type="hidden" name="payment_token" v-model="payment_token">
    <input type="hidden" name="hash" value="{{$hash}}">
    {{ csrf_field() }}
  </form>
</div>

<script type="text/javascript" src="https://js.pay.jp/"></script>
<script type="text/javascript">
Payjp.setPublicKey("{{config('services.payjp.public')}}");
</script>

<script type="text/javascript">
let vm = new Vue( {
  el: '#donate-form',
  data: {
    plan: "m",
    plans: [
      { tag: "ss", price: 500, cta:"支援の気持ちワンコイン" },
      { tag: "s", price: 2000, cta:"およそ2週間分のごはん代" },
      { tag: "m", price: 5000, cta:"およそ1ヶ月分のごはん代", is_recommend: true },
      { tag: "l", price: 20000, cta:"ワクチン・避妊去勢手術費" },
    ],
    price: 5000,
    showPrice: false,
    custom_price: null,
    name: "",
    card_number: "",
    card_cvc: "",
    card_year: 2025,
    card_month: 6,
    payment_type: 0,
    payment_token: "",
    error_message: "",
    is_agreed: true
  },
  watch: {
    plan: function(n, o){
      let filted = this.plans.filter( function(p){
        return p.tag == n
      })
      if( filted.length > 0 ){
        this.price = filted[0].price
      }else{
        this.custom_price = 3000
        this.price = 3000
      }
    },
    price: function(){
      this.price = this.toHankaku(this.price)
    },
    card_number: function(){
      this.card_number = this.toHankaku(this.card_number)
    },
    card_cvc: function(){
      this.card_cvc = this.toHankaku(this.card_cvc)
    },
    custom_price: function(){
      let _this = this;
      _this.plan = "custom";
      this.plans.map( function(plan){
        if(_this.custom_price == plan.price){
          _this.plan = plan.tag
        }
      })
    },
  },
  methods: {
    toHankaku: function (v) {
      return v.replace("ー", "-").replace("•", "・").replace("–", "-").replace("‐", "-")
        .replace(/[\u200B-\u200D\uFEFF\u202A-\u202E]/g, '')
        .replace(/[Ａ-Ｚａ-ｚ０-９＠]/g, function(s) { 
          return String.fromCharCode(s.charCodeAt(0) - 65248); 
        });
    },
    onSubmit: function(){
      var card = {
        number: this.card_number,
        cvc: this.card_cvc,
        exp_month: this.card_month,
        exp_year: this.card_year
      };
      let _this = this;
      Payjp.createToken(card, function(status, response) {
        console.log(response);
        if (status == 200) {
          _this.payment_token = response.id;
          _this.$nextTick(function() {
            document.donateForm.submit();
          });
        } else {
          var message = "このクレジットカードは利用できません。<br/>入力した内容に間違いがないか再度ご確認ください。";
          if( response.error != null ){
            switch( response.error.code ){
              case "card_declined":
                message = "何らかの理由でカード会社に利用を拒否されています。<br/>お手数お掛けしますが、他のカードもしくは決済方法をご利用ください。";
                break;
              case "expired_card":
                message = "カードの有効期限が切れています。<br/>お手数お掛けしますが、他のカードもしくは決済方法をご利用ください。";
                break;
              case "incorrect_card_data":
                message = "入力したカード番号の情報に誤りがあります。<br/>入力した内容に間違いがないか再度ご確認ください。";
                break;
              case "processing_error":
                message = "現在メンテナンス中のためカードが登録できません。<br/>お手数お掛けしますが、時間をおいて再度ご設定いただけますと幸いです。";
                break;
            }  
          }
          _this.error_message = message
        };
      });
    },
    catSubmit: function(){
      return this.price > 0 && this.card_number.length > 14 && this.card_cvc.length > 2 && this.name.length > 0 && this.is_agreed
    }
  }
});
</script>

@endsection
