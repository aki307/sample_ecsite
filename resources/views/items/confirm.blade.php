<!DOCTYPE html>
<html lang="ja">
<head>

  <!-- Basic Page Needs
  -------------------------------------------------- -->
  <meta charset="utf-8">
  <title>Sample ECサイト</title>
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Mobile Specific Metas
  -------------------------------------------------- -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSS
  -------------------------------------------------- -->
  <!--<link rel="stylesheet" href="css/normalize.css">-->
  <!--<link rel="stylesheet" href="{{ asset('/css/vendors/normalize.css') }}">-->
  <!--<link rel="stylesheet" href="{{ asset('/css/vendors/skeleton.css') }}">-->
  
  
  <!-- Owl Carousel CSS -->
  <!--<link rel="stylesheet" href="owlcarousel/assets/owl.carousel.min.css">-->
  <!--<link rel="stylesheet" href="{{ asset('/css/vendors/owl.carousel.min.css') }}">-->
  <!--<link rel="stylesheet" href="owlcarousel/assets/owl.theme.default.min.css">-->
  <!--<link rel="stylesheet" href="{{ asset('/css/vendors/owl.theme.default.min.css') }}">-->  
  <!--<link rel="stylesheet" href="css/sample.css">-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/tiny-slider.css">
  
  <link rel="stylesheet" href="{{ asset('/css/all.css') }}">
  <!--<link rel="stylesheet" href="{{ asset('/assets/css/welcome.css') }}">-->
  
<meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Favicon
  -------------------------------------------------- -->
  <link rel="icon" type="image/png" href="images/favicon.png">
  <script src="https://js.stripe.com/v3/"></script>
</head>




<body>
  <header>
    <div class="container" id="top">
      <div class="row">
        <div class="six columns" id="header-left">
          <p id="title"><a href="/">Sample ECサイト</a></p>
          <!--<img src="{{ asset('images/top_sp/logo.png') }}">-->
        </div>
        <div class="six columns" id="header-right">
          <div class="sp_navi">
            <ul class="sp_navi_li">
              <li><img src="{{ asset('images/top_sp/fb.png') }}"></li>
              <li><img src="{{ asset('images/top_sp/insta.png') }}"></li>
              <li id="sp_navi_toggle"><img src="{{ asset('images/top_sp/menu_icon.png') }}" ></li>
            </ul>
            <ul class="sp_navi_toggle">
              @if (Auth::check())
              <li><a href="{!! route('myCart', ['id' => Auth::id()]) !!}" class="nav-link">カート<i class="fas fa-shopping-cart"></i>{{ Auth::user()->userCarts()->sum("number") }}</a></li>
              <li>{!! link_to_route('registerItem.get', '出品する',[]) !!}</li>
              <li>{!! link_to_route('paymentTable', '注文一覧', ['id' => Auth::id()]) !!}</li>
              <li>{!! link_to_route('showMyItems', '出品一覧', ['id' =>Auth::id()]) !!}</li>
              <li>{!! link_to_route('showMyItemsStatus', '出品状態', ['id' =>Auth::id()]) !!}</li>
              <li>{!! link_to_route('logout.get', 'ログアウト',[]) !!}</li>
              @else
              <li>{!! link_to_route('signup.get', '登録する', []) !!}</li>
              <li>{!! link_to_route('login', 'ログイン', [], ['class' => 'nav-link']) !!}</li>
              @endif
            </ul>
          </div>
            <ul class="pc_navi_li">
              @if (Auth::check())
              <li><a href="{!! route('myCart', ['id' => Auth::id()]) !!}" class="nav-link">カート<i class="fas fa-shopping-cart"></i>{{ Auth::user()->userCarts()->sum("number") }}</a></li>
              <li>{!! link_to_route('registerItem.get', '出品する',[]) !!}</li>
              <li>{!! link_to_route('paymentTable', '注文一覧', ['id' => Auth::id()]) !!}</li>
              <li>{!! link_to_route('showMyItems', '出品一覧', ['id' =>Auth::id()]) !!}</li>
              <li>{!! link_to_route('showMyItemsStatus', '出品状態', ['id' =>Auth::id()]) !!}</li>
              <li>{!! link_to_route('logout.get', 'ログアウト',[]) !!}</li>
              @else
              <li>{!! link_to_route('signup.get', '登録する', []) !!}</li>
              <li>{!! link_to_route('login', 'ログイン', []) !!}</li>
              @endif
              <li><img src="{{ asset('images/top/facebook.png') }}"></li>
              <li><img src="{{ asset('images/top/insta.png') }}"></li>
            </ul>
        </div>
      </div>
    </div>
  </header>
  <div class="container">
      <div class="nine columns" style="background-color:#ffffff; ">
          <div class="text-center">
        <h1>出品する</h1>
    </div>

    <div class="row" >
        <div>

            {!! Form::open(['route' => 'registerItem.complete', 'files' => true]) !!}
            
                <table class="table table-bordered">
                    <tr>
                        <td>商品名:</td>
                        <td class="text-left">{{ $data['item_name'] }}</td>
                    </tr>
                    <tr>
                        <td>定価：</td>
                        <td class="text-left">{{ $data['list_price'] }}</td>
                    </tr>
                    <tr>
                        <td>売値：</td>
                        <td class="text-left"> {{ $data['sale_price'] }}</td>
                    </tr>
                    <tr>
                        <td>メイン画像：</td>
                        <td class="text_left"><img src="{{ $data['item_image'] }}" width="200" height="130"></td>
                    </tr>
                    @if(@empty($data['sub_item_images']))
                    @else
                    <tr>
                        <td>サブ画像：</td>
                        <td class="text-left">
                            @foreach($data['sub_item_images'] as $sub_item_image)
                            <img src="{{ $sub_item_image }}" width="200" height="130">
                            @endforeach
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td>商品の説明</td>
                        <td class="text_left">{{ $data['description'] }}</td>
                    </tr>
                </table>
               

            {!! Form::submit('利用規約に同意して、登録する', ['class' => 'btn btn-primary btn-block']) !!}
        {!! Form::close() !!}
        </div>
    </div>
      </div>
  </div>
  <div class="container">
    <div class="nine columns" style="background-color:#ffffff ">
  <div id="title_sample">
    <h4 style="color:#887f69; font-weight:600">Sample Image</h4>
  </div>
  </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="nine columns" style="border:5px solid #887f69">
        <!--商品-->
        <div id="product-box">
            <div id="product_name-box">
              <h6>{{ $data['item_name'] }}</h6>
            </div>
            <div id="product_picture-box">
              <div id="display_img">
                <img src="{{ $data['item_image'] }}">
              </div>
              
              <ul id="list_img">
                <li><img src="{{ $data['item_image'] }}"></li>
                @for ($i = 0; $i < 9; $i++)
                    @if(!empty( $data['sub_item_images'][$i] ))
                        <li><img src="{{ $data['sub_item_images'][$i] }}"></li>
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
                    <p>¥<font size="6">{{ $data['sale_price'] }}</font><span class="price_count">(tax in)</span></p>
                  </div>
                </div>
              </div>
              <div id="product_judge-box">
                <div id="add_to_cart_image-box">
                  <img src="{{ asset('images/products/add_to_cart.png') }}">
                </div>
              </div>
            </div>
            <div id="product_explanation-box">
              <h6>商品説明</h6>
            </div>
            <div id="product_detail_box">
              <p>{{ $data['description'] }}</p>
            </div>
        </div>
        <!--SHOPPING GUIDE-->
        <div class="shopping_guide-box" id="category-box">
          <img src="{{ asset('images/top_sp/title_guide.png') }}" class="title_guide_img">
        </div>
        <div id="shopping_guide-list-box">
          <div id="delivery-box">
            <h6>お届けについて</h6>
            <img src="{{ asset('images/top/otodoke_banner.png') }}">
            <p id="how_to_deliver">■️◯◯運輸️</p>
            <p >送料 ¥000</p>
            <p id="how_to_deliver">■️ゆうパケット</p>
            <p>ポスト投函となります。日時指定不可</p>
          </div>
          <div id="payment-box">
            <h6>決済について</h6>
            <p id="how_to_pay">■カード決済️</p>
            <img src="{{ asset('images/top/cards.png') }}">
            <p id="how_to_pay">■️代金引換</p>
            <p>代引き手数料がかかります</p>
            <p id="how_to_pay">■️銀行振込</p>
            <p>ご入金後の発送となります。</p>
          </div>
        </div>
      </div>
      <div class="three columns">
          <div class="item_search ">
            <form name="searchform"  id="searchform" method="get" action="#">
              <label for="search_name" id="search_name"><img src="{{ asset('images/top/itemserch.png') }}"></label>
              <input name="keywords" id="keywords" value="" type="text" placeholder="Search.." >  
              <input type="image" src="{{ asset('images/top/search_icon.png') }}" alt="検索" name="searchBtn" id="searchBtn" >  
            </form>
          </div>
        <div id="pagelink">
          <p><img src="{{ asset('images/top/pagelink.png') }}" id="pagelink-image"><img src="{{ asset('images/top/next_icon.png') }}" id="nexticon-image"></p>
        </div>
        <div id="about">
          <p><img src="{{ asset('images/top/about.png') }}" id="about-image"></p>
        </div>
        <div id="article">
          <div id="article-box">
            <div id="articleimage-box">
              <img src="{{ asset('images/top/about_img.jpg') }}" class="u-full-width" id="article-image">
              <p>記事の内容記事の内容</p>
            </div>
          </div>
          <div id="moreButton-box"><a><img src="{{ asset('images/top/more_btn.png') }}" id="moreButton-image"></a>
          </div>
        </div>
        <div id="shopinfo">
          <p><img src="{{ asset('images/top/shop_info.png') }}" id="shop_info-image"></p>
        </div>
        <div id="article">
        <div id="article-box">
          <div id="articleimage-box">
            <img src="{{ asset('images/top/shopinfo_img.jpg') }}" class="u-full-width" id="article-image">
            <p>記事の内容記事の内容</p>
          </div>
        </div>
        <div id="moreButton-box"><a><img src="{{ asset('images/top/more_btn.png') }}" id="moreButton-image"></a>
        </div>
      </div>
      </div>
    </div>
  </div>
</body>
<footer>
  <div class="container">
    <div class="row">
      <div id="footer_top">
        <img src="{{ asset('images/top/pagetop.png') }}" id="pagetop_screen">
      </div>
      <ul id="footer_list">
        <li>特定商取引に基づく表記</li>
        <li>プライバシーポリシー</li>
        <li>マイページ</li>
      </ul>
      <p id="copyright">Copyright © Sample ECサイト. All rights reserved.</p>
     </div>
 </div>
</footer>

<script src="{{ asset('/js/app.js') }} "></script>


</html>
