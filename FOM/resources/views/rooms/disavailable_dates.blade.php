<div id="info_dates_{{$id}}_popover" style="display:none">
    <div class="create">
        <div class="create-vico">
            <div class="nb-prog-content" style="width: 15px; height: 15px; background-color: orange; border-radius: 50%">
                <span class="navbar-progress"></span>
            </div>
            <span class="navbar-progress" style="position: absolute;top: 40px; left: 3.3rem;" >No disponible</span>
        </div>
    </div>
    <div class="container">
        <h5 class="progress-label"></h5>
        <div class="row text-center">
            @foreach ($months as $month)
                @if($month->day == 1)
                <div class="col" style="padding: 0; padding-right: 5px; font-size: 8px; ">
                    @if($month->last==false)
                    {{$month->month}}
                    @endif
                </div>      
                @endif        
            @endforeach
        </div>
        <div class="row" style="margin-left: -4px; margin-right: 1px">
            <div class="col" style="padding: 0;">
                <div class="progress">
                    @foreach ($months as $month)
                        @if($month->last==false)
                            @if($month->bussy == true)
                                <div class="progress-bar" role="progressbar" style="width: {{100/(sizeof($months) - 2)}}%" aria-valuenow="{{100/(sizeof($months) - 2)}}" aria-valuemin="0" aria-valuemax="100"></div>
                            @else
                                <div class="progress-bar" role="progressbar" style="background-color: lightgray;  width: {{100/(sizeof($months) - 2)}}%" aria-valuenow="{{100/(sizeof($months) - 2)}}" aria-valuemin="0" aria-valuemax="100"></div>
                            @endif
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>