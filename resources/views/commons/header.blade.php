<header>
    <div class="container" id="top">
      <div class="row">
        <div class="six columns" id="header-left">
          <p id="title"><a href="/">Sample ECサイト</a></p>
          <!--<img src="{{ asset('images/top_sp/logo.png') }}">-->
        </div>
        <div class="six columns" id="header-right">
          <?php
            $top_url = url('');
            $facebook_share_url = 'https://www.facebook.com/sharer.php?src=bm&u=' . $top_url;
          ?>
          <div class="sp_navi">
            <ul class="sp_navi_li">
              <li><a href="{{ $facebook_share_url }}"><img src="{{ asset('images/top_sp/fb.png') }}"></a></li>
              <!--<li><a><img src="{{ asset('images/top_sp/insta.png') }}"></a></li>-->
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
              <li><a href="{{ $facebook_share_url }}"><img src="{{ asset('images/top/facebook.png') }}"></a></li>
              <!--<li><a><img src="{{ asset('images/top/insta.png') }}"></a></li>-->
            </ul>
        </div>
      </div>
    </div>
  </header>