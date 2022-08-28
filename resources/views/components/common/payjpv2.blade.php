<script src="https://js.pay.jp/v2/pay.js"></script>
<script type="text/javascript">
var initPayjpV2_{{ $id }} = function() {
  if( window.payjpv2 == null ){
    window.payjpv2 = Payjp("{{config('services.payjp.public')}}");  
  }
  const {{ $id }}elements = window.payjpv2.elements()

  const style = {
    base: {
      fontSize: '16px',
      fontFamily: '"游ゴシック体", YuGothic, "游ゴシック Medium", "Yu Gothic Medium", "游ゴシック", "Yu Gothic", "メイリオ", sans-serif'
    }
  };
  //レンダリングずみはストップ
  if(document.querySelector('#{{ $elements['cardNumber'] }}').innerHTML != ""){
    console.log(document.querySelector('#{{ $elements['cardNumber'] }}').innerHTML);
    return;
  }

  const cardNumber = {{ $id }}elements.create('cardNumber', {style: style})
  cardNumber.mount('#{{ $elements['cardNumber'] }}')

  const cardExpiry = {{ $id }}elements.create('cardExpiry', {style: style})
  cardExpiry.mount('#{{ $elements['cardExpiry'] }}')

  const cardCvc = {{ $id }}elements.create('cardCvc', {style: style})
  cardCvc.mount('#{{ $elements['cardCvc'] }}')

  var {{ $id }} = {
    createToken: function(callback){
      window.payjpv2.createToken(cardNumber).then(function(response) {
        console.log(response);
        if( response.error != null ){
          callback != null && callback(response.error.status, response);  
        }else{
          callback != null && callback(200, response);  
        }
        
      })
    }
  };
  window.{{ $id }} = {{ $id }};
}
window.initPayjpV2_{{ $id }} = initPayjpV2_{{ $id }}
window.initPayjpV2_{{ $id }}_status = false
@isset( $noInit )
@else
initPayjpV2_{{ $id }}();
@endif
</script>