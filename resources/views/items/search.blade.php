@extends('layouts.main')

@section('content')

  <div class="top_image-box">
    <div class="owl-carousel owl-theme">
      <div><img src="{{ asset('images/list/cate_image_sp.jpg') }}" style="width:100%;"></div>
    </div>
  </div>
  @if(count($results) > 0)
    <div class="new_items_list-box" id="items_box">
      @foreach($results as $result)
        <div class="new_item" id="item_box">
          <div id="item_picture"><a href="{{ route('item.show', ['id' => $result->id ]) }}"><img src="{{ $result->image_url }}"></a></div>
          <p id="item_title" >{!! link_to_route('item.show', e($result->item_name), ['id' => $result->id]) !!}</p>
          <p id="item_price">{!! link_to_route('item.show', '¥'.e($result->sale_price).'(tax in)', ['id' => $result->id]) !!}</p>
        </div>
      @endforeach
    </div>
    <div class="search_progress-box">
      {{ $results->appends(request()->input())->links() }}
    </div>
  @else
    <p>一致する商品はありませんでした。</p>
  @endif
@endsection
