    
    <div class="card mb-3">
        <img class="card-img-top" src="{{ $recent_items->image_url" alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title">{!! $recent_items->item_name !!}</h5>
              <p class="card-text">{!! nl2br(e($recent_items->description)) !!}</p>
              <a href="#" class="btn btn-primary">カートに入れる</a>
            </div>
    </div>