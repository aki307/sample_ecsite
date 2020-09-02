@extends('layouts.main')

@section('content')

        <div id="my_shippings-box">
            <h4>出品一覧</h4>
            @if(count($my_items) > 0)
            @foreach($my_items as $my_item)
            <div id="pc_my_shipping-box">
              
                <div id="my_shipping_items-box">
                    <div id="my_shipping_item-box">
                        <div id="my_shipping_item_picture">
                            <a><img src="{{ $my_item->image_url }}"></a>
                        </div>
                        <div id="my_shipping_item_information">
                            <p>{!! $my_item->item_name !!}</p>
                            <p>出品日：{!! $my_item->created_at->format('Y/m/d') !!}</p>
                            <p>値段：　¥{{ number_format($my_item->sale_price) }}</p>
                        </div>
                        <div id="my_shipping_button-box">
                            <div id="shipping_button">
                                {!! link_to_route('showMyItemDesign', 'デザインを見る', ['id' => $my_item->id]) !!}
                            </div>
                            <div id="shipping_button">
                                {!! link_to_route('orderMyItem', '注文をみる', ['id' => $my_item->id]) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="sp_my_shipping-box">
              <div id="sp_my_shipping_item-box">
                <div id="sp_my_shipping_item_picture">
                  <a><img src="{{ $my_item->image_url }}"></a>
                </div>
                <div id="sp_my_shipping_item_information">
                  <h5>{!! $my_item->item_name !!}</h5>
                  <p>{!! $my_item->created_at->format('Y/m/d') !!}に出品しました</p>
                </div>
                <div id="sp_my_shipping_item_detail_link">
                  <a href="{!! route('orderMyItem', ['id' => $my_item->id]) !!}"><i class="fas fa-angle-right" style="color:#887f69; font-size:80px"></i></a>
                </div>
              </div>
            </div>
            @endforeach
            <div class="search_progress-box">
            {{ $my_items->links() }}
            
            </div>
        </div>
        @else
        <p>出品していません。</p>
        @endif
@endsection