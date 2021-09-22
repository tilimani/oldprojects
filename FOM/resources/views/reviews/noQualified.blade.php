<div class="row">
    @forelse($noQualified as $review)
        <div class="col-md-12 col-lg-6 col-sm-12 col-xs-12 px-0">
            <div class="card">
                <div class="card-body">
                    @if($review[2]->image)
                        <img class="img-responsive rounded-circle img-shape-50" src="https://fom.imgix.net/{{$review[2]->image}}?w=500&h=500&fit=crop" alt="Foto del Huesped">
                    @elseif($review[2]->gender === '1')
                        <img class="img-responsive rounded-circle img-shape-50" src="../images/homemates/girl.png" alt="Foto del Huesped">
                    @else
                        <img class="img-responsive rounded-circle img-shape-50" src="../images/homemates/boy.png" alt="Foto del Huesped">
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
                        <div class="py-1" data-toggle="collapse" href="#user-dropdown{{$review[4]->id}}" role="button" aria-expanded="false" aria-controls="user-dropdown{{$review[4]->id}}">
                            <span class="arrow-container"><span class="icon-next-fom"></span></span>
                            <i class="star fs-rem-17"></i>
                            <span class="badge badge-light bold fs-rem-12 mx-1">
                                {{__(number_format(($review[4]->manager_comunication + $review[4]->manager_compromise)/2 , 1))}}
                            </span>
                        </div>
                        <a href="{{__('/booking/'.$review[3]->id.'/review/manager')}}" class="btn btn-outline-primary d-inline-block" role="button">
                            Reseña
                        </a>
                    </div>
                </div>
                <div id="user-dropdown{{$review[4]->id}}" class="collapse">
                    <div class="container-fluid">
                        <p class="h5 no-wrap text-center">
                            <b>Comentario público</b>
                        </p>
                        <blockquote class="blockquote">
                            <p class="h5 font-italic">
                                "{{__($review[4]->fom_comment.'.')}}"
                            </p>
                        </blockquote>
                        <p class="h5 no-wrap text-center">
                            <b>Comentario privado</b>
                        </p>
                        <blockquote class="blockquote">
                            <p class="h5 font-italic">
                                "{{__($review[4]->manager_comment.'.')}}"
                            </p>
                        </blockquote>
                        <div class="d-flex justify-content-center align-items-center py-2">
                            <button type="button" class="btn btn-outline-danger d-inline-block" data-toggle="modal" data-target="#userComplainModal-{{$review[3]->id}}">
                                Quejarme
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="userComplainModal-{{$review[3]->id}}" tabindex="-1">
                <form method="post" action="{{route('save_complain_user')}}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="manager_comment" value = "{{$review[4]->manager_comment}}">
                    <input type="hidden" name="fom_comment" value="{{$review[4]->fom_comment}}">
                    <input type="hidden" name="manager_comunication" value="{{$review[4]->manager_comunication}}">
                    <input type="hidden" name="manager_compromise" value="{{$review[4]->manager_compromise}}">
                    <input type="hidden" name="bookings_id" value="{{$review[4]->bookings_id}}">
                    <input type="hidden" name="qualification_date" value="{{$review[4]->created_at}}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title text-center">Tengo un reclamo</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-around align-content-center">
                                            <p class="h4 text-center">Correo</p>
                                            <p class="h4 text-center">Fecha</p>
                                        </div>
                                        <div class="col-12 d-flex justify-content-center align-content-center">
                                            <div class="input-group">
                                                <input type="email" name="email" class="form-control" placeholder="{{Auth::user()->email}}" aria-label="Email" aria-describedby="complain-addon1" value="{{Auth::user()->email}}" disabled aria-disabled="true">
                                                <input type="text" name="today_date" class="form-control" placeholder="{{date('d/m/Y')}}" aria-label="Date" value="{{date('d/m/Y')}}" disabled aria-disabled="true">
                                            </div>
                                        </div>
                                        <div class="col-12 pt-2 d-flex justify-content-around align-content-center">
                                            <p class="h4 text-center">Razón</p>
                                        </div>
                                        <div class="col-12 col-12 d-flex justify-content-around align-content-center">
                                            <div class="input-group">
                                                <textarea class="form-control" name="complainText" cols="30" rows="5"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-around align-content-center">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-link">Enviar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @empty
        NO HAY CALIFICACIONES PENDIENTES
    @endforelse
</div>

<div class="row">
    @forelse($noQualified as $review)
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
                        {{__(date('jS M', strtotime($review[3]->date_from)).'-'.date('jS M', strtotime($review[3]->date_to)))}}
                    </span>
                </p>
                <div class="card-text d-flex justify-content-center align-items-center">
                    <a class="btn btn-link edit-item" data-toggle="collapse" href="#no-dropdown{{$review[3]->id}}" role="button" aria-expanded="false" aria-controls="user-dropdown{{$review[3]->id}}">
                        <span class="arrow-container">Detalles<span class="icon-next-fom"></span></span>
                    </a>
                    <a href="{{__('/booking/'.$review[3]->id.'/review/manager')}}" class="btn btn-outline-primary d-inline-block" role="button">
                        Reseña
                    </a>
                </div>
            </div>
            <div id="no-dropdown{{$review[3]->id}}" class="collapse">
                <div class="container-fluid">
                    <p class="h5 no-wrap text-center">
                        Comentario privado
                    </p>
                    <blockquote class="blockquote">
                        <p class="h6 font-italic">
                            "{{__($review[3]->message.'.')}}"
                        </p>
                    </blockquote>
                    <div class="d-flex justify-content-around align-items-center py-2">
                        <button type="button" class="btn btn-outline-danger d-inline-block" data-toggle="modal" data-target="#noComplainModal-{{$review[3]->id}}">
                            Quejarme
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="noComplainModal-{{$review[3]->id}}">
            <form method="post" action="{{route('save_complain_booking')}}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="message" value="{{$review[3]->message}}">
                <input type="hidden" name="status" value="{{$review[3]->status}}">
                <input type="hidden" name="room_id" value="{{$review[3]->room_id}}">
                <input type="hidden" name="booking_date" value="{{$review[3]->created_at}}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title text-center">Tengo un reclamo</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-around align-content-center">
                                        <p class="h4 text-center">Correo</p>
                                        <p class="h4 text-center">Fecha</p>
                                    </div>
                                    <div class="col-12 d-flex justify-content-center align-content-center">
                                        <div class="input-group">
                                            <input type="email" name="email" class="form-control" placeholder="{{Auth::user()->email}}" aria-label="Email" aria-describedby="complain-addon1" value="{{Auth::user()->email}}" disabled aria-disabled="true">
                                            <input type="text" name="today_date" class="form-control" placeholder="{{date('d/m/Y')}}" aria-label="Date" value="{{date('d/m/Y')}}" disabled aria-disabled="true">
                                        </div>
                                    </div>
                                    <div class="col-12 pt-2 d-flex justify-content-around align-content-center">
                                        <p class="h4 text-center">Razón</p>
                                    </div>
                                    <div class="col-12 col-12 d-flex justify-content-around align-content-center">
                                        <div class="input-group">
                                            <textarea class="form-control" name="complainText" cols="30" rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-around align-content-center">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-link">Enviar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @empty

    @endforelse
</div>
