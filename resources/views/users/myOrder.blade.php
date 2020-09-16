@extends('layouts.main')

@section('content')
        <div id="my_orders-box">
            <h4>注文履歴</h4>
            @foreach($shippings as $shipping)
            <div id="pc_my_order-box">
                <div id="my_order_information-box">
                    <div id="my_order_day">
                        <p>注文日</p>
                        <p id="my_order_information">{!! $shipping->created_at->format('Y年m月d日') !!}</p>
                    </div>
                    <?php $total_money = 0; ?>
                    @foreach($shipping->shippingItems as $item)
                    <?php
                    $total_money += $item->sale_price * $item->quantity;
                    ?>
                    @endforeach
                    <div id="my_order_total_money">
                        <p>合計</p>
                        <p id="my_order_information">¥<?php echo number_format($total_money); ?></p>
                    </div>
                    <div id="my_order_shipping">
                        <p>お届け先</p>
                        <p id="my_order_information">{!! config('pref')[$shipping->shipping_xmpf] !!} {!! $shipping->shipping_address1 !!} {!! $shipping->shipping_address2 !!} </p>
                    </div>
                    <div id="my_order_detail_link">
                        {!! link_to_route('myOrderDetail', '注文の詳細', ['id' => $shipping->id]) !!}
                    </div>
                </div>
                @if(!empty($shipping->shippingItems))
                     @foreach($shipping->shippingItems as $shippingItem)
                <div id="my_order_items-box">
                    <div id="my_order_item-box">
                        <div id="my_order_item_picture">
                            <a><img src="{{ $shippingItem->item->image_url }}"></a>
                            @if($shippingItem->quantity >1)
                            <p class="circle">{{ $shippingItem->quantity }}</p>
                            @endif
                        </div>
                        <div id="my_order_item_information">
                            <p>{{ $shippingItem->item->item_name }}</p>
                            <div id="buy_again_button">
                                <!--<a href="">再購入する</a>-->
                                {!! link_to_route('item.show', '再購入する', ['id' => $shippingItem->item->id]) !!}
                            </div>
                        </div>
                        <div id="my_order_item_price">
                            <p>¥{{ $shippingItem->sale_price }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
            @if(!empty($shipping->shippingItems))
                     @foreach($shipping->shippingItems as $shippingItem)
            <div id="sp_my_order-box">
              <div id="sp_my_order_item-box">
                <div id="sp_my_order_item_picture">
                  <a><img src="{{ $shippingItem->item->image_url }}"></a>
                   @if($shippingItem->quantity >1)
                            <p class="circle">{{ $shippingItem->quantity }}</p>
                   @endif
                </div>
                <div id="sp_my_order_item_information">
                  <h5>{{ $shippingItem->item->item_name }}</h5>
                  <p>{!! $shipping->created_at->format('Y年m月d日') !!}に注文しました</p>
                </div>
                <div id="sp_my_order_item_detail_link">
                  <a href="{!! route('myOrderDetail', ['id' => $shippingItem->shipping->id]) !!}"><i class="fas fa-angle-right" style="color:#887f69; font-size:80px"></i></a>
                </div>
              </div>
            </div>
            @endforeach
            @endif
            @endforeach
            @if(is_null($shippings))
            <p>注文されていません。</p>
            @endif
        </div>
        <div class="search_progress-box">
            {{ $shippings->links() }}
            </div>
@endsection