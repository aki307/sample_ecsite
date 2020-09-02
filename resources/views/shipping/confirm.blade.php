@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <h1>お届け先</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 ">
                
                <table class="table table-bordered">
                    <tr>
                        <td>姓名：（漢字）</td>
                        <td class="text-left">{{ $shipping['user_name'] }}</td>
                    </tr>
                    <tr>
                        <td>郵便番号：</td>
                        <td class="text-left">{{ $shipping['postal_corder'] }}</td>
                    </tr>
                    <tr>
                        <td>都道府県：</td>
                        <td class="text-left">{{ config('pref')[$shipping['xmpf']] }}</td>
                    </tr>
                    <tr>
                        <td>住所1：</td>
                        <td class="text-left">{{ $shipping['address1'] }}</td>
                    </tr>
                    <tr>
                        <td>住所2：</td>
                        <td class="text-left"> {{ $shipping['address2'] }}</td>
                    </tr>
                    
                </table>
                
            
            <div class="text">
                <h1>支払方法</h1>
                <p>{{ config('payment')[$shipping['payment']] }}</p>
            </div>
            <div class="text">
                <h1>注文商品一覧</h1>
            </div>
            <div class="container">
                <?php  $total = 0; ?>
              @if(count($my_carts) > 0)
                    @foreach($my_carts as $my_cart)
                      <div class="card">
                        <div>
                          <img class="card-img-top" src="{{ secure_asset($my_cart -> image_url) }}" width="200" height="130" alt="Card image cap">
                        </div>
                        <div class="col-sm-6">
                          <div class="card-body">
                            <h5 class="card-title">{!! $my_cart -> item_name !!} </h5>
                            <h5 class="card-text">¥{!! $my_cart -> sale_price !!}</h5>
                            <h5 class="card-text">{{Form::open(['route' => ['countItem', $my_cart-> id]]) }}
                                                      {{ Form::select('itemNumber', [0,1,2,3,4,5], $my_cart->pivot ->number, ['form-control']) }}個
                                                      {{ Form::submit('個数更新',['class' => "btn btn-primary btn-block"]) }}
                                                  {{Form::close() }}
                            </h5>
                            <?php
                                $total += $my_cart->sale_price * $my_cart->pivot->number;
                            ?>
                          </div>
                        </div>
                      </div>
                    @endforeach
              @else
                  <p>一致する商品がありませんでした。</p>
              @endif
           </div>             
        </div>
        <div class="offset-md-3 col-md-3">
            <div class="card">
                <h5 class="card-text">
                   ¥<?php echo $total; ?>
                </h5>
                <h5 class="card-text">
                    {!! Form::open(['route' => ['paymentRegister', $user->id]]) !!}
                      {!! Form::submit('確定する', ['class' => "btn btn-danger btn-block"]) !!}
                    {!! Form::close() !!}
                </h5>
            </div>
        </div>
    </div>
@endsection