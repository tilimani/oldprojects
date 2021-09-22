@extends('layouts.app')
@section('title', 'Mis reseñas')

@section('content')

<div class="container mt-5" style="overflow-x:auto;" >
    <div class="row">
        <div class="col-12 mx-auto">
            <table class="table table-hover w-100">
                <thead>
                    <tr>
                        <th scope="col">{{trans('general.experience')}}</th>
                        <th scope="col">{{trans('general.accurate_info')}}</th>
                        <th scope="col">{{trans('general.devices')}}</th>
                        <th scope="col">{{trans('general.wifi')}}</th>
                        <th scope="col">{{trans('general.bath')}}</th>
                        <th scope="col">{{trans('general.roomies')}}</th>
                        <th scope="col">{{trans('general.loud_parties')}}</th>
                        <th scope="col">{{trans('general.recommend')}}</th>
                        <th scope="col">{{trans('general.house_comment')}}</th>
                        <th scope="col">{{trans('general.loud_house')}}</th>
                        <th scope="col">{{trans('general.info')}}</th>
                        <th scope="col">{{trans('general.general')}}</th>
                        <th scope="col">{{trans('general.barrio_shopping')}}</th>
                        <th scope="col">{{trans('general.access')}}</th>
                        <th scope="col">{{trans('general.neighbourhood')}}</th>
                        <th scope="col">{{trans('general.man_com')}}/th>
                        <th scope="col">{{trans('general.man_compromise')}}</th>
                        <th scope="col">{{trans('general.man_comment')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews as $review)
                        <tr class="city-selectable">

                                <td>{{$review->review_house->experience }}
           
                                </td>
                            
                                <td> {{$review->review_house->data }}
                                </td>
                            
                                <td> {{$review->review_house->devices }}
                                </td>
                            
                                <td>{{$review->review_house->wifi }}
                                </td>
                            
                                <td>{{$review->review_house->bath }}
           
                                </td>
                            
                                <td> {{$review->review_house->roomies }}
                                </td>
                            
                                <td>{{$review->review_house->loudparty }}
                                </td>
                            
                                <td>{{$review->review_house->recommend }}
                                </td>
                            
                                <td> {{$review->review_house->house_comment }}
                                </td>
                            
                                <td> {{$review->review_room->loud }}
          
           
                                </td>
                            
                                <td>  {{$review->review_room->data }}
                                </td>
                            
                                <td> {{$review->review_room->general }}
                                </td>
                            
                                <td>{{$review->review_neighborhoods->general}}
           
           
                                </td>
                            
                                <td> {{$review->review_neighborhoods->shopping}}
                                </td>
                            
                                <td> {{$review->review_neighborhoods->access}}
                                </td>
                            
                                <td> {{$review->review_manager->manager_comunication}}
                                </td>
                            
                                <td> {{$review->review_manager->manager_compromise}}
                                </td>
                            
                                <td>{{$review->review_manager->manager_comment}}
                                </td>
                        </tr>
                    @empty
                        <tr>
                            <th scope=row>N/N</th>
                            <td coslpan="4">{{trans('general.without_info')}}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@stop
