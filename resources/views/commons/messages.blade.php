@if(isset($messages))
    @if(count($messages) > 0)
        <ul style="border:#9d1a2d solid 5px; background-color:#ffffff;">
            @foreach($messages->all() as $message)
            <li>{{ $message }}</li>
            @endforeach
        </ul>
    @endif
@endif