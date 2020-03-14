<header class="mb-4">
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark"> 
        <a class="navbar-brand" href="/">Sample ECサイト</a>
         <form class="navbar-form">
          <div class="form-group">
           <input type="text" class="form-control" placeholder="キーワード">
          </div>
           <button type="submit" class="btn btn-info" style="color: red;">検索</button>
　　　　</form>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#nav-bar">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="nav-bar">
            <ul class="navbar-nav mr-auto"></ul>
            <ul class="navbar-nav">
                <li class="nav-item">{!! link_to_route('signup.get', '登録する', [], ['class' => 'nav-link']) !!}</li>
                <li class="nav-item"><a href="#" class="nav-link">Login</a></li>
            </ul>
        </div>
    </nav>
  
<!--    <p class="navbar-text">在庫検索</p>-->
<!--<form class="navbar-form">-->
<!--    <div class="form-group">-->
<!--        <input type="text" class="form-control" placeholder="キーワード">-->
<!--    </div>-->
<!--    <button type="submit" class="btn btn-info">検索</button>-->
<!--</form>-->
</header>