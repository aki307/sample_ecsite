@extends('layouts.app')

@section('content')
    @if(!empty($session_id))
    <h2>注文確定しました</h2>
    <div class="text-center">
        <div class="card">
            {{ $session_id }}
            <h5 class="card-text">
                <a class="btn btn-primary" onclick="stripeCheckout();return false;">決済を行う</a>
                <script>
                // Stripeのチェックアウト処理を呼び出す関数 stripeCheckoutを定義
                var stripe = Stripe("<?php echo config('my-app.stripePublicKey'); ?>");
                stripe.redirectToCheckout({
                  sessionId: '{{ $session_id }}'
                }).then(function (result) {
                });
                </script>
            </h5>
        </div>
    </div>
    @else
    <h2>注文確定しました２</h2>
    
    <div class="text-center">
        <div class="card">
            <h5 class="card-text">
                
            </h5>
        </div>
    </div>
    @endif
@endsection