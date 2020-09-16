@extends('layouts.main_only')

@section('content')
    @if(!empty($session_id))
    <div id="credit-information">
          <p><i class="far fa-check-square"></i>支払が完了していません。</p>
          <div id="credit_payment_button-box">
            <div id="credit_payment_button">
              <a onclick="stripeCheckout();return false;">決済する</a>
               <script>
                // Stripeのチェックアウト処理を呼び出す関数 stripeCheckoutを定義
                    var stripe = Stripe("<?php echo config('my-app.stripePublicKey'); ?>");
                        stripe.redirectToCheckout({
                            sessionId: '{{ $session_id }}'
                        }).then(function (result) {
                    });
                </script>
            </div>
          </div>
        </div>
    @else
    <div id="messages" style="border:#9d1a2d solid 5px; background-color:#ffffff;">
        <p>ご注文承りました。ありがとうございます。</p>
    </div>
    @endif
@endsection