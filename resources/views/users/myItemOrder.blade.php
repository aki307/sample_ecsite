@extends('layouts.main_only')
@section('content')
      <div class="twelve columns">
        <div id="pc_my_item_order-box">
          <div id="pc_my_item_order_title">
            <h3>注文を見る</h3>
          </div>
          <div id="pc_my_item_name">
            <div id="pc_my_item_picture">
              <a><img src="{{ $item->image_url }}"></a>
            </div>
            <div id="pc_my_item_title">
              <h4>{{ $item->item_name }}</h4>
              <p>出品日：{{ $item->created_at->format('Y/m/d') }}</p>
              <p>値段：　¥{{ $item->sale_price }}</p>
            </div>
          </div>
          <div id="pc_my_item_order_table-box">
            <div id="pc_my_item_order_table">
               <table>
                <thead>
                    <th id="pc_my_item_table_order_number">#</th>
                    <th id="pc_my_item_order_time">注文時刻</th>
                    <th id="pc_my_item_order_customer_name">顧客名</th>
                    <th id="pc_my_item_order_quantity">個数</th>
                    <th id="pc_my_item_order_total_price">合計金額</th>
                    <th id="pc_my_iten_order_how_to_pay">支払方法</th>
                    <th id="pc_my_item_order_payment_state">支払状態</th>
                    <th id="pc_my_item_order_detail_button"></th>
                </thead>
                @for($i = 0; $i<count($shipping_items); $i++)
                <tbody>
                    <th id="pc_my_item_table_order_number">{{ $i+1 }}</th>
                    <th id="pc_my_item_order_time">{{ $shipping_items[$i]->created_at->format('Y/m/d') }}</th>
                    <th id="pc_my_item_order_customer_name">{{ $users[$i]->name_kanji }}</th>
                    <th id="pc_my_item_order_quantity">{{ $shipping_items[$i]->quantity }}</th>
                    <th id="pc_my_item_order_total_price">¥{{ $shipping_items[$i]->sale_price* $shipping_items[$i]->quantity }}</th>
                    <th id="pc_my_iten_order_how_to_pay">{!! config('payment')[$shippings[$i]-> payment] !!}</th>
                    <th id="pc_my_item_order_payment_state">{!! config('money_transfer')[$shipping_items[$i]-> money_transfer] !!}</th>
                    <th id="pc_my_item_order_detail_button">
                      <div id="watch_my_customer_button">
                        {!! link_to_route('myItemOrderDetail', '詳細を見る', ['id' => $shipping_items[$i]->id]) !!}
                      </div>
                    </th>
                </tbody>
                @endfor
              </table>
            </div>
          </div>
        </div>
        <div id="sp_my_item_order-box">
          <div id="sp_my_item_order-box">
            <div id="sp_my_item_order_title">
              <h3>注文を見る</h3>
            </div>
            <div id="sp_my_item_name">
            <div id="sp_my_item_picture">
              <a><img src="{{ $item->image_url }}"></a>
            </div>
            <div id="sp_my_item_title">
              <h4>{{ $item->item_name }}</h4>
              <p>出品日：{{ $item->created_at->format('Y/m/d') }}</p>
              <p>値段：　¥{{ $item->sale_price }}</p>
            </div>
          </div>
          </div>
          @for($i = 0; $i<count($shipping_items); $i++)
          <div id="sp_my_item_order_columns-box">
            <div id="sp_my_item_order_column">
              <div id="sp_my_item_order_column-information">
                <h4><i class="fas fa-user" style="color:#887f69; padding-right:2%"></i>{{ $users[$i]->name_kanji }}</h4>
                <p>{{ $shipping_items[$i]->created_at->format('Y/m/d') }}に注文しました</p>
                <p>個数：{{ $shipping_items[$i]->quantity }}</p>
                <p>¥{{ $shipping_items[$i]->sale_price* $shipping_items[$i]->quantity }}</p>
                
              </div>
              <div id="sp_my_item_order_column-status">
                <!--phpの条件分岐で対応する-->
                @if($shipping_items[$i]-> money_transfer===1)
                <div id="sp_my_item_order_column_status-box" style="background-color:#887f69;">
                  <p>支払済み</p>
                </div>
                @else
                <div id="sp_my_item_order_column_status-box" style="background-color:#9d1a2d;">
                  @if($shipping_items[$i]-> money_transfer ===2)
                  <p>支払待ち</p>
                  @elseif($shipping_items[$i]-> money_transfer ===3)
                  <p>支払予定</p>
                  @endif
                </div>
                @endif
                <p id="sp_my_item_order_column_payment">（{!! config('payment')[$shippings[$i]-> payment] !!}）</p>
                <p style="text-align:right;"><a href="{!! route('myItemOrderDetail', ['id' => $shipping_items[$i]->id]) !!}"><i class="fas fa-angle-right" style="color:#887f69; font-size:80px;"></i></a></p>
              </div>
            </div>
            @endfor
          </div>
        </div>
@endsection