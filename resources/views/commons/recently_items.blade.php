@if(Auth::check())
    @if(@empty($recently_items))
    @else
    <div class="recent_items-box" id="category-box">
        <img src="{{ asset('images/list/title_recent_pro.png') }}" class="title_recent_pro">
    </div>
    <div class="recent_items_list-box" id="items_box">
        @foreach($recently_items as $recently_item)
            <div class="new_item" id="item_box">
              <div id="item_picture"><a href="{{ route('item.show', ['id' => $recently_item->id ]) }}" ><img src="{{ $recently_item->image_url }}"></a></div>
              <p id="item_title" >{!! link_to_route('item.show', e($recently_item->item_name), ['id' => $recently_item->id]) !!}</p>
              <p id="item_price">{!! link_to_route('item.show', '¥'.e($recently_item->sale_price).'(tax in)', ['id' => $recently_item->id]) !!}</p>
            </div>
        @endforeach
    </div>
    @endif
@endif