
@for($i = 0; $i < 5; $i++)
    @if($i < 3)
        <span class="star1 on"></span>
    @elseif($i < 4)
        <span class="star1 half"></span>
    @else
        <span class="star1"></span>
    @endif
@endfor

{{-- @if($i < $house->average_house) --}}
