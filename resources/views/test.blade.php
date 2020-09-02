

@extends('layouts.app')

@section('content')
        <div class="text-center">
            <h1>Sample ECサイト</h1>
        </div>
        @if (Auth::check())
            <div class="text-left">
                <h2>最近チェックした商品</h2>
                @foreach($recently_items as $recently_item)
                <div class="card d-inline-block col-md-2">
                    <div>
                        <img class="card-img-top" src="{{ $recently_item->image_url }}" class="col-md-2" height="100"  alt="Card image cap">
                    </div>
                    <div>
                        <div class="card-body">
                        <h5 class="card-title">{!! $recently_item->item_name !!}</h5>
                        <h5 class="card-text">¥{!! $recently_item->sale_price !!}</h5>
                        {!! link_to_route('item.show', '詳細ページ', ['id' => $recently_item->id],['class' => 'btn btn-primary']) !!}
                        </div>
                    </div>
                    
                </div>
            @endforeach
                
            </div>
        @endif
        <div class="text-left">
            <h2>最近入荷された商品</h2>
        </div>
        <?php 
            $latest_items= \App\Item::orderBy('created_at', 'desc')->paginate(5);
        ?>
        @if(count($latest_items) > 0)
          <div class="row">
            @foreach($latest_items as $latest_item)
                <div class="card d-inline-block col-md-2">
                    <div>
                        <img class="card-img-top" src="{{ $latest_item->image_url }}" class="col-md-2" height="100"  alt="Card image cap">
                    </div>
                    <div>
                        <div class="card-body">
                        <h5 class="card-title">{!! $latest_item->item_name !!}</h5>
                        <h5 class="card-text">¥{!! $latest_item->sale_price !!}</h5>
                        {!! link_to_route('item.show', '詳細ページ', ['id' => $latest_item->id],['class' => 'btn btn-primary']) !!}
                        </div>
                    </div>
                    
                </div>
            @endforeach
        @endif
@endsection