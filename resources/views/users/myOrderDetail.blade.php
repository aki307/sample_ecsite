@extends('layouts.main_only')
@section('content')
<div id="pc_my_orders_detail-box">
  <div id="my_orders_detail_title">
    <h4>注文の詳細</h4>
  </div>
  @if($shipping->payment==1)
    @if($shipping_items[0]->money_transfer==1)
      <div id="credit-information">
          <p><i class="far fa-check-square"></i>支払が完了していません。</p>
          <div id="credit_payment_button-box">
            <div id="credit_payment_button">
              <a onclick="stripeCheckout();return false;">決済する</a>
               <script>
                // Stripeのチェックアウト処理を呼び出す関数 stripeCheckoutを定義
                function stripeCheckout(){
                    var stripe = Stripe("<?php echo config('my-app.stripePublicKey'); ?>");
                        stripe.redirectToCheckout({
                            sessionId: '{{ $session_id }}'
                        }).then(function (result) {
                    });
                }
                </script>
            </div>
          </div>
        </div>
    @endif
  @endif
  <p>注文日: {!! $shipping->created_at->format('Y年m月d日') !!}</p>
  <div id="pc_my_order_detail_information">
    <div id="pc_my_address">
      <p id="title">お届け先住所</p>
      <p>{!! $shipping->user->name_kanji !!}</p>
      <p>{{ config('pref')[$shipping->shipping_xmpf] }}</p>
      <p>{!! $shipping->shipping_address1 !!} {!! $shipping->shipping_address2 !!}</p>
    </div>
    <div id="pc_my_payment">
      <p id="title">支払方法</p>
      @if($shipping->payment==1)
        @if($shipping_items[0]->money_transfer==1)
          {{ Form::open(['route' => ['paymentChange', $shipping->id]]) }} 
            {{ Form::select('payment', [
            '1' => 'クレジットカード',
            '2' => '代引き',
            '3' => '銀行振込'],
            $shipping->payment
            , ['id'=> 'paymentChangeSelect']) }}
            {{ Form::submit('更新', ['id'=> 'paymentChangeSubmit']) }}
          {{ Form::close() }}
        @else
        <p>{{ config('payment')[$shipping->payment] }}</p>
        @endif
      @else
      <p>{{ config('payment')[$shipping->payment] }}</p>
      @endif
    </div>
    <?php $total_money = 0; ?>
    @foreach($shipping_items as $shipping_item)
      <?php
        $total_money += $shipping_item->sale_price * $shipping_item->quantity;
      ?>
    @endforeach
    <div id="payment">
      <p id="title">領収書/詳細明細書 </p>
      <p>商品の合計：<span id="price_number">¥ <?php echo number_format($total_money); ?></span></p>
      <p>配送料・手数料：<span id="price_number">¥ 0</span></p>
      <p>注文合計：<span id="price_number">¥ <?php echo number_format($total_money); ?></span></p>
      <p id="total_price">ご請求額：<span id="price_number">¥ <?php echo number_format($total_money); ?></span></p>
    </div>
  </div>
  <div id="my_orders-box">
    <div id="pc_my_order-box">
      <div id="my_order_items-box">
        @foreach($shipping_items as $shipping_item)
          <div id="my_order_item-box">
            <div id="my_order_item_picture">
              <a><img src="{{ $shipping_item->item->image_url }}"></a>
              @if($shipping_item->quantity !==1)
                <p class="circle">{!! $shipping_item->quantity !!}</p>
              @endif
            </div>
          <div id="my_order_item_information">
            <p>{!! $shipping_item->item->item_name !!}</p>
            @if($shipping_item->money_transfer !==1)
            <div id="buy_again_button">
              {!! link_to_route('item.show', '再購入する', ['id' => $shipping_item->item->id]) !!}
            </div>
            @endif
          </div>
          <div id="my_order_item_price">
            <p>¥{!! $shipping_item->sale_price !!}</p>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
<div id="sp_my_orders_detail-box">
  <div id="my_orders_detail_title">
    <h3>注文の詳細</h3>
  </div>
  @if($shipping->payment==1)
    @if($shipping_items[0]->money_transfer==1)
      <div id="credit-information">
          <p><i class="far fa-check-square"></i>支払が完了していません。</p>
          <div id="credit_payment_button-box">
            <div id="credit_payment_button">
              <a onclick="stripeCheckout();return false;">決済する</a>
               <script>
                // Stripeのチェックアウト処理を呼び出す関数 stripeCheckoutを定義
                function stripeCheckout(){
                    var stripe = Stripe("<?php echo config('my-app.stripePublicKey'); ?>");
                        stripe.redirectToCheckout({
                            sessionId: '{{ $session_id }}'
                        }).then(function (result) {
                    });
                }
                </script>
            </div>
          </div>
        </div>
    @endif
  @endif
  <div id="sp_my_order_abstract">
    <div id="sp_my_order_abstract_sub_title">
      <p>注文日：</p>
      <p>注文の合計</p>
    </div>
    <div id="sp_my_order_abstract_my_information">
      <!--注文日-->
      <p>{!! $shipping->created_at->format('Y年m月d日') !!}</p>
      <!--注文の合計-->
      <p>¥<?php echo number_format($total_money); ?></p>
    </div>
  </div>
  <div id="sp_my_orders_detail_items_title">
    <h4>注文した商品</h4>
  </div>
  <div id="sp_my_order-box">
    @foreach($shipping_items as $shipping_item)
      <div id="sp_my_order_item-box">
        <div id="sp_my_order_item_picture">
          <a><img src="{{ $shipping_item->item->image_url }}"></a>
        </div>
        <div id="sp_my_order_item_information">
          <h5>{!! $shipping_item->item->item_name !!}</h5>
          <p>数量：{!! $shipping_item-> quantity !!}</p>
        </div>
        <div id="sp_my_order_item_price_box">
          <p>¥ {!! $shipping_item->sale_price !!}</p>
        </div>
      </div>
    @endforeach
  </div>
  <div id="sp_my_orders_detail_items_title">
    <h4>お支払い情報</h4>
  </div>
  <div id="sp_my_orders_detail_payment_information-box">
    <div id="sp_my_how_to_pay">
      <h5>支払方法</h5>
      @if($shipping->payment==1)
        @if($shipping_items[0]->money_transfer==1)
          {{ Form::open(['route' => ['paymentChange', $shipping->id]]) }} 
            {{ Form::select('payment', [
            '1' => 'クレジットカード',
            '2' => '代引き',
            '3' => '銀行振込'],
            $shipping->payment
            , ['id'=> 'paymentChangeSelect']) }}
            {{ Form::submit('更新', ['id'=> 'paymentChangeSubmit']) }}
          {{ Form::close() }}
        @else
        <p>{{ config('payment')[$shipping->payment] }}</p>
        @endif
      @else
      <p>{{ config('payment')[$shipping->payment] }}</p>
      @endif
    </div>
    <div id="sp_my_payment_address">
      <h5>請求先住所</h5>
      <!--郵便番号-->
      <p>{{ config('pref')[$shipping->shipping_xmpf] }}</p>
      <!--住所-->
      <p>{{ $shipping->shipping_address1 }} {{ $shipping->shipping_address2 }}</p>
    </div>
  </div>
  <div id="sp_my_orders_detail_items_title">
    <h4>届け先住所</h4>
  </div>
  <div id="sp_my_payment_address2">
    <!--お名前-->
    <h5>{{ $shipping->user->name_kanji }}</h5>
    <!--郵便番号-->
    <p>{{ config('pref')[$shipping->shipping_xmpf] }}</p>
    <!--住所-->
    <p>{{ $shipping->shipping_address1 }} {{ $shipping->shipping_address2 }}</p>
  </div>
  <div id="sp_my_orders_detail_items_title">
    <h4>領収書/購入明細書</h4>
  </div>
  <div id="sp_my_orders_detail_receipt">
    <p>商品：<span id="receipt_number">¥ <?php echo number_format($total_money); ?></span></p>
    <p>配送料・手数料:<span id="receipt_number">¥0</span></p>
    <h5>注文の合計： <span id="receipt_number2">¥ <?php echo number_format($total_money); ?></span></h5>
  </div>
</div>
@endsection