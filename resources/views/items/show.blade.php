@extends('layouts.main')

@section('content')
      <!--商品-->
      <div id="product-box">
        <div id="product_name-box">
          <h6>{{ $item->item_name }}</h6>
        </div>
        <div id="product_picture-box">
          <div id="display_img">
            <img src="{{ $item->image_url }}">
          </div>
          <ul id="list_img">
            <li><img src="{{ $item->image_url }}"></li>
            <?php $list = 9; ?>
            @for($i = 0; $i < 9; $i++)
              @if(!empty($sub_item_images[$i]))
              <li><img src="{{ $sub_item_images[$i]->image_url }}"></li>
              @else
              <li><img src=""></li>
              @endif
            @endfor
          </ul>
        </div>
        <div id="product_count_and_judge-box">
          <div id="product_count-box">
            <div id="product_price-box">
              <div id="product_price_image-box">
                <img src="{{ asset('images/products/title_price.png') }}">
              </div>
              <div id="product_price_number-box">
                <p>¥<font size="6">{{ number_format($item->sale_price) }}</font><span class="price_count">(tax in)</span></p>
              </div>
            </div>
          </div>
        <div id="product_judge-box">
          <div id="add_to_cart_image-box">
            <!--<img src="images/products/add_to_cart.png">-->
            <a href="{{ route('addItemButton', ['id' => $item->id ]) }}" ><img src="{{ asset('images/products/add_to_cart.png') }}"></a>
          </div>
        </div>
      </div>
      <div id="product_explanation-box">
        <h6>商品説明</h6>
      </div>
      <div id="product_detail_box">
        <p>{{ $item->description }}</p>
      </div>
    </div>
@endsection