@extends('layouts.main_only')

@section('content')
    <!--合計金額の計算-->
  <?php 
    $total = 0; 
    foreach($my_carts as $my_item){
      $total += $my_item->sale_price * $my_item->pivot->number;
    }
    $total = number_format($total);
  ?>
  <div class="eight columns">
      <div class="my_cart-box">
        <h3 style="color:#887f69; font-weight:600; margin:0; padding:0; background-color:#ffffff; margin-bottom:10px">注文確認画面</h3>
      </div>
      <div id="sp_cart_navi" >
        <p><span class="price_count">小計（{{ Auth::user()->userCarts()->sum("number") }}点の商品）：¥</span><font size="6"><?php echo $total; ?></font><span class="price_count">(tax in)</span></p>
        @if(empty($total))
        @else
        <div id="sp_cart_button-box">
            {!! Form::open(['route' => ['paymentRegister', $user->id]]) !!}
                {!! Form::submit('確定する', ['class' => "btn btn-danger btn-block", 'id' => 'sp_cart_button']) !!}
            {!! Form::close() !!}
        </div>
        @endif
      </div>
      <h4 style="margin-bottom:5px">お届け先</h4>
      <table class="table table-bordered"  id="payment_confirm_shipping_table">
                    <tr>
                        <td  id="payment_confirm_shipping_table-title">姓名：（漢字）</td>
                        <td  id="payment_confirm_shipping_table-write">{{ $shipping['user_name'] }}</td>
                    </tr>
                    <tr>
                        <td  id="payment_confirm_shipping_table-title">郵便番号：</td>
                        <td id="payment_confirm_shipping_table-write">{{ $shipping['postal_corder'] }}</td>
                    </tr>
                    <tr>
                        <td  id="payment_confirm_shipping_table-title">都道府県：</td>
                        <td id="payment_confirm_shipping_table-write">{{ config('pref')[$shipping['xmpf']] }}</td>
                    </tr>
                    <tr>
                        <td  id="payment_confirm_shipping_table-title">住所1：</td>
                        <td id="payment_confirm_shipping_table-write">{{ $shipping['address1'] }}</td>
                    </tr>
                    <tr>
                        <td  id="payment_confirm_shipping_table-title">住所2：</td>
                        <td id="payment_confirm_shipping_table-write"> {{ $shipping['address2'] }}</td>
                    </tr>
                    
                </table>
        <div id="payment_confirm_how_to_pay">
            <h4>支払方法</h4>
            <p>{{ config('payment')[$shipping['payment']] }}</p>
        </div>
        <h4 style="margin-bottom:5px">注文商品一覧</h4>
        
         <div class="new_items_list-box" id="my_cart_items_box">
    <div id="my_cart_title_price">
      <p>価格</p>
    </div>
    @foreach($my_carts as $my_cart)
      <div class="new_item" id="my_cart_item_box">
        <div id="item_picture"><a href=""><img src="{{ $my_cart -> image_url }}"></a></div>
      <div id="my_cart_item_box">
        <p id="item_title"><a>{!! $my_cart -> item_name !!}</a></p>
        <p id="information1">通常2～5日以内に発送します。</p>
        <p>配送料無料</p>
        {{Form::open(['route' => ['countItem', $my_cart-> id], 'id' => 'pc_item_number_form', 'class' => 'pc_item_number_form'.$my_cart->id]) }}
          <label for="item_number">商品の個数：</label>
          @if($my_cart -> pivot -> number <10)
            {{ Form::select('item_number', [
              '0' => '0',
              '1' => '1',
              '2' => '2',
              '3' => '3',
              '4' => '4',
              '5' => '5',
              '6' => '6',
              '7' => '7',
              '8' => '8',
              '9' => '9',
              '10' => '10以上'],
              $my_cart -> pivot -> number, ['id' => 'item_number_select','class' => 'item_number_select'.$my_cart->id, 'onchange' => "javascript:entryChange($my_cart->id)"]) }}
            {{ Form::text('item_number_describe', $my_cart -> pivot -> number, ['id' => 'item_number_describe','class' => 'item_number_describe'.$my_cart->id, 'onchange' => "javascript:entryChange($my_cart->id)", 'oninput' => "value = value.replace(/[^0-9]+/i,'');"]) }}個
            {{ Form::submit('更新',['id' => "item_number_button",'class' => 'item_number_button'.$my_cart->id, 'entryChange' => "javascript:entryChange($my_cart->id)"]) }}
          @else
            {{ Form::text('item_number_describe', $my_cart -> pivot -> number, ['id' => 'item_number_describe','class' => 'item_number_describe'.$my_cart->id, 'onchange' => "javascript:entryChange($my_cart->id)", 'style' => "display:inline-block;", 'oninput' => "value = value.replace(/[^0-9]+/i,'');"]) }}個
            {{ Form::submit('更新',['id' => "item_number_button",'class' => 'item_number_button'.$my_cart->id, 'entryChange' => "javascript:entryChange($my_cart->id)", 'style' => "display:inline-block"]) }}
          @endif
            {{Form::close() }}
      </div>
      <div id="my_cart_item_price">
        <p id="item_price"><a>¥{!! number_format($my_cart -> sale_price) !!}</a></p>
      </div>
      <div id="sp_item_number_form">
        {{Form::open(['route' => ['countItem', $my_cart-> id], 'id' => 'sp_item_number_form-box', 'class' => 'sp_item_number_form-box'.$my_cart->id]) }}
          @if($my_cart->pivot->number === 1)
            <button type="button" id="item_trash_button" class="item_trash_button{{ $my_cart->id }}" onclick="javascript:sp_item_number('trash', {{ $my_cart->id }});"><i class="fas fa-trash" style="font-size:18px; color:#ffffff;"></i></button>
          @else
            <button type="button" id="item_minus_button" class="item_minus_button{{ $my_cart->id }}" name="item_minus_button" onclick="javascript:sp_item_number('minus', {{ $my_cart->id }});"><i class="fas fa-minus" style="font-size:18px; color:#ffffff;"></i></button>
          @endif
          {{ Form::text('item_number_describe', $my_cart -> pivot -> number, ['id' => 'sp_item_number_describe','class' => 'sp_item_number_describe'.$my_cart->id, 'oninput' => "value = value.replace(/[^0-9]+/i,'');"]) }}
          <button type="button" id="item_plus_button" class="item_plus_button{{ $my_cart->id }}" name="item_plus_button" onclick="javascript:sp_item_number('plus', {{ $my_cart->id }});"><i class="fas fa-plus" style="font-size:18px; color:#ffffff;"></i></button>
          <button type="button" id="item_delete_button" class="item_delete_button{{ $my_cart->id }}" onclick="javascript:sp_item_number('delete', {{ $my_cart->id }});">削除</button>
          {{ Form::submit('更新',['style' => "display:none;"]) }}
        {{Form::close() }}
      </div>
    </div>
  @endforeach
</div>
@if(empty($total))
<p>商品が入っていません</p>
@endif
</div>
<div class="four columns">
   <div id="pc_cart_navi">
    <p><span class="price_count">小計（{{ Auth::user()->userCarts()->sum("number") }}点の商品）：<br>¥</span><font size="6"><?php echo $total; ?></font><span class="price_count">(tax in)</span></p>
    @if(empty($total))
    @else
    <div id="pc_cart_button-box">
      {!! Form::open(['route' => ['paymentRegister', $user->id]]) !!}
        {!! Form::submit('確定する', ['class' => "btn btn-danger btn-block" ,'id' => 'pc_cart_button', 'style'=> 'margin-bottom:0;']) !!}
    {!! Form::close() !!}
    </div>
    @endif
  </div> 
</div>
@endsection