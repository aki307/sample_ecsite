<!DOCTYPE html>
<html lang="ja">
<head>

  <!-- Basic Page Needs
  -------------------------------------------------- -->
  <meta charset="utf-8">
  <title>Sample ECサイト</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSS
  -------------------------------------------------- -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/tiny-slider.css">
  
  <link rel="stylesheet" href="{{ asset('/css/all.css') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Favicon
  -------------------------------------------------- -->
  <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
</head>

<body>
  @include('commons.header')
  <div class="container">
      @include('commons.error_messages')
    <div class="row">
      <div class="eight columns">
        @yield('content')
        <!--最近見た商品-->
        @include('commons.recently_items')
        <!--SHOPPING GUIDE-->
        @include('commons.shopping_guide')
      </div>
      <div class="four columns">
          @yield('pc_cart_navi')
          @include('commons.item_search')
          @include('commons.side')
      </div>
    </div>
  </div>
  @include('commons.footer')
  <script src="{{ asset('/js/app.js') }} "></script>
  <script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>
  <script src="{{ asset('/js/test.js') }}"></script>
</body>
</html>