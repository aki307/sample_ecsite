@extends('layouts.main_only')
@section('content')
      <div class="twelve columns">
        <div id="pc_my_item_order-box">
          <div id="pc_my_item_order_title">
            <h3>出品状態</h3>
          </div>
          <div id="pc_my_item_order_table-box">
            <div id="pc_my_item_order_table">
               <table>
                <thead>
                    <th id="pc_my_item_table_order_number">#</th>
                    <th id="pc_my_item_order_time">注文時刻</th>
                    <th>商品名</th>
                    <th id="pc_my_item_order_customer_name">顧客名</th>
                    <th id="pc_my_item_order_quantity">個数</th>
                    <th id="pc_my_item_order_total_price">合計金額</th>
                    <th id="pc_my_iten_order_how_to_pay">支払</th>
                    <th id="pc_my_item_order_payment_state">配送状態</th>
                    <th id="pc_my_item_order_detail_button"></th>
                </thead>
                @for($i = 0; $i<count($my_item_status); $i++)
                <tbody>
                    <th id="pc_my_item_table_order_number">{{ $i+1 }}</th>
                    <th id="pc_my_item_order_time">{{ $my_item_status[$i]->created_at->format('Y/m/d') }}</th>
                    <th>{{ $my_item_status[$i]->item->item_name }}</th>
                    <th id="pc_my_item_order_customer_name">{{ $my_item_status[$i]->shipping->user->name_kanji }}</th>
                    <th id="pc_my_item_order_quantity">{{ $my_item_status[$i]->quantity }}</th>
                    <th id="pc_my_item_order_total_price">¥{{ $my_item_status[$i]->sale_price* $my_item_status[$i]->quantity }}</th>
                    <th id="pc_my_iten_order_how_to_pay">{!! config('payment')[$my_item_status[$i]->shipping-> payment] !!}<br>{{ config('money_transfer')[$my_item_status[$i]->money_transfer] }}</th>
                    <th id="pc_my_item_order_payment_state">{!! config('delivery_status')[$my_item_status[$i]->delivery_status] !!}</th>
                    <th id="pc_my_item_order_detail_button">
                      <div id="watch_my_customer_button">
                        {!! link_to_route('myItemOrderDetail', '詳細を見る', ['id' => $my_item_status[$i]->id]) !!}
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
          </div>
          @for($i = 0; $i<count($my_item_status); $i++)
          <div id="sp_my_item_order_columns-box">
            <div id="sp_my_item_order_column">
              <div id="sp_my_item_order_column-information">
                <h4><i class="fas fa-user" style="color:#887f69; padding-right:2%"></i>{{ $my_item_status[$i]->item->user->name_kanji }}</h4>
                <p>{{ $my_item_status[$i]->created_at->format('Y/m/d') }}に注文しました</p>
                <p>商品名:{{ $my_item_status[$i]->item->item_name }}</p>
                <p>個数：{{ $my_item_status[$i]->quantity }}</p>
                <p>¥{{ $my_item_status[$i]->sale_price* $my_item_status[$i]->quantity }}</p>
                <p>配送状態：{!! config('delivery_status')[$my_item_status[$i]->delivery_status] !!}</p>
              </div>
              <div id="sp_my_item_order_column-status">
                <!--phpの条件分岐で対応する-->
                @if($my_item_status[$i]-> money_transfer===2)
                <div id="sp_my_item_order_column_status-box" style="background-color:#887f69;">
                  <p>支払済み</p>
                </div>
                @else
                <div id="sp_my_item_order_column_status-box" style="background-color:#9d1a2d;">
                  @if($my_item_status[$i]-> money_transfer ===1)
                  <p>支払待ち</p>
                  @elseif($my_item_status[$i]-> money_transfer ===3)
                  <p>支払予定</p>
                  @endif
                </div>
                @endif
                <p id="sp_my_item_order_column_payment">（{!! config('payment')[$my_item_status[$i]->shipping-> payment] !!}）</p>
                <p style="text-align:right;"><a href="{!! route('myItemOrderDetail', ['id' => $my_item_status[$i]->id]) !!}"><i class="fas fa-angle-right" style="color:#887f69; font-size:80px;"></i></a></p>
              </div>
            </div>
            @endfor
          </div>
        </div>
@endsection