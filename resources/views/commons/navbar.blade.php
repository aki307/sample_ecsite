<header class="mb-4">
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark"> 
        <a class="navbar-brand" href="/">Sample ECサイト</a>
         {!! Form::open(['route' => 'searchItem' , 'class' =>'form-inline', 'method' => 'get' ]) !!}
          <div class="form-group">
           {{ Form::text('search', '' , ['class' => 'form-control', 'placeholder' =>'Search Store']) }}
          </div>
           
           {{ Form::button('検索', ['class' => 'btn btn-info', 'id' => '1', 'type' => 'submit']) }}
　　　　{!! Form::close() !!}
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#nav-bar">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="nav-bar">
            <!--<ul class="navbar-nav mr-auto"></ul>-->
            <ul class="navbar-nav">
              @if (Auth::check())
                <li class="nav-item"><a href="{!! route('myCart', ['id' => Auth::id()]) !!}" class="nav-link"><i class="fas fa-shopping-cart"></i>{{ Auth::user()->userCarts()->sum("number") }}</a></li>
                <li class="nav-item">{!! link_to_route('registerItem.get', '出品する',[],['class' => 'nav-link']) !!}</li>
                <li class="nav-item">{!! link_to_route('paymentTable', '注文一覧', ['id' => Auth::id()], ['class' => 'nav-link']) !!}</li>
                <li class="nav-item">{!! link_to_route('showMyItems', '出品一覧', ['id' =>Auth::id()], ['class' => 'nav-link']) !!}</li>
                <li class="nav-item">{!! link_to_route('showMyItemsStatus', '出品状態', ['id' =>Auth::id()], ['class' => 'nav-link']) !!}</li>
                <li class="nav-item">{!! link_to_route('logout.get', 'ログアウト',[], ['class' => 'nav-link']) !!}</li>
              @else
                <li class="nav-item">{!! link_to_route('signup.get', '登録する', [], ['class' => 'nav-link']) !!}</li>
                <li class="nav-item">{!! link_to_route('login', 'ログイン', [], ['class' => 'nav-link']) !!}</li>
              @endif
            </ul>
        </div>
    </nav>
  
</header>