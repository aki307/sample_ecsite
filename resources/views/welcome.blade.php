@extends('layouts.main')

@section('content')
  <div class="top_image-box">
    <div class="my-slider">
      <div><img src="{{ asset('images/top/ca_banner.jpg') }}"></div>
    </div>
  </div>
  <div class="new_items-box" id="category-box">
    <img src="{{ asset('images/top_sp/title_new_item.png') }}">
  </div>
  <div class="new_items_list-box" id="items_box">
    <?php 
      $latest_items= \App\Item::orderBy('created_at', 'desc')->paginate(6);
    ?>
    @if(count($latest_items) > 0)
      @foreach($latest_items as $latest_item)
        <div class="new_item" id="item_box">
          <div id="item_picture"><a href="{{ route('item.show', ['id' => $latest_item->id ]) }}" ><img src="{{ $latest_item->image_url }}"></a></div>
          <p id="item_title" >{!! link_to_route('item.show', e($latest_item->item_name), ['id' => $latest_item->id]) !!}</p>
          <p id="item_price">{!! link_to_route('item.show', '¥'.e($latest_item->sale_price).'(tax in)', ['id' => $latest_item->id]) !!}</p>
        </div>
      @endforeach
    @endif
  </div>
@endsection