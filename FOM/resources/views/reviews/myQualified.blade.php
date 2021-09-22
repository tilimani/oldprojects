<div class="row">
    @forelse($myQualified as $review)
    <div class="col-md-12 col-lg-6 col-sm-12 col-xs-12 px-0">
        <div class="card">
            <div class="card-body">
                @if($review[2]->image)
                    <img class="img-responsive rounded-circle img-shape-50" src="https://fom.imgix.net/{{$review[2]->image}}?w=500&h=500&fit=crop" alt="Foto del Administrador">
                @elseif($review[2]->gender === '1')
                    <img class="img-responsive rounded-circle img-shape-50" src="../images/homemates/girl.png" alt="Foto del Administrador">
                @else
                    <img class="img-responsive rounded-circle img-shape-50" src="../images/homemates/boy.png" alt="Foto del Administrador">
                @endif
                <p class="h4 card-tittle text-center">
                    {{__($review[0]->name)}}
                    <span class="badge badge-secondary">
                        {{__('Hab. #'.$review[1]->number)}}
                    </span>
                </p>
                <p class="h5 card-subtittle text-center">
                    <span class="text-left">
                        {{__($review[2]->name.' '.$review[2]->lastname)}}
                    </span>
                    <span class="h6 card-subtittle text-muted text-right">
                        {{__(date('jS M', strtotime($review[3]->date_from)).'/'.date('jS M', strtotime($review[3]->date_to)))}}
                    </span>
                </p>
                <div class="card-text d-flex justify-content-around align-items-center">
                    <div class="py-1" data-toggle="collapse" href="#my-dropdown{{$review[4]->id}}" role="button" aria-expanded="false" aria-controls="user-dropdown{{$review[4]->id}}">
                        <span class="arrow-container"><span class="icon-next-fom"></span></span>
                        <i class="star fs-rem-17"></i>
                        <span class="badge badge-light bold fs-rem-12 mx-1">
                            {{__(number_format(($review[4]->clean + $review[4]->communication + $review[4]->rules)/3, 1))}}
                        </span>
                    </div>
                    {{--  <a href="{{__('/booking/'.$review[3]->id.'/review/manager')}}" class="btn btn-outline-primary d-inline-block" role="button">
                        Reseña
                    </a>  --}} // la reseña ya esta echa
                </div>
            </div>
            <div id="my-dropdown{{$review[4]->id}}" class="collapse">
                <div class="container-fluid">
                    <p class="h5 no-wrap text-center">
                        <b>Comentario público</b>
                    </p>
                    <blockquote class="blockquote">
                        <p class="h5 font-italic">
                            "{{__($review[4]->public_comment.'.')}}"
                        </p>
                    </blockquote>
                    <p class="h5 no-wrap text-center">
                        <b>Comentario privado</b>
                    </p>
                    <blockquote class="blockquote">
                        <p class="h5 font-italic">
                            "{{__($review[4]->private_comment.'.')}}"
                        </p>
                    </blockquote>
                </div>
            </div>
        </div>
    </div>
    @empty

    @endforelse
</div>
