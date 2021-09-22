@extends('layouts.app')

@section('title', 'Ver puntos de interes genéricos')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12 mx-auto">
            <h1>Puntos de interés genéricos</h1>
            @include('layouts.errors')
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{trans('general.interest_name')}}</th>
                        <th scope="col">{{trans('general.description')}}</th>
                        <th scope="col"># {{trans('general.associated_house')}}</th>
                        <th scope="col">{{trans('general.created_the')}}</th>
                        <th scope="col"><a href="{{route('genericInterestPoints.create')}}"><button class="btn btn-primary">{{trans('general.create')}}</button></a></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($interest_points as $interest_point)
                        <tr class="neighborhood-selectable">
                            <th scope="row">{{ $interest_point->id }}</th>
                            <form method="post" action="{{route('genericInterestPoints.update', $interest_point)}}"  class="updateneighborhood">
                                <td>
                                    @csrf
                                    @method('put')
                                    <input type="text" name="name" value="{{$interest_point->name}}" id="{{__('neighborhoodInput' . $interest_point->id)}}" class="form-control" autocomplete="off">
                                    <small id="neighborhoodInputHelpBlock" class="form-text text-muted">
                                        {{trans('general.name_of_interest_point')}}
                                    </small>
                                    <button type="submit" class="btn btn-success btn-small btnSave">Guardar</button>
                                </td>
                                <td>
                                    <input type="text" name="description" value="{{$interest_point->description}}" id="{{__('neighborhoodInput' . $interest_point->id)}}" class="form-control" autocomplete="off">
                                    <small id="neighborhoodInputHelpBlock" class="form-text text-muted">
                                        {{trans('general.description_of_interest')}}
                                    </small>
                                </td>
                                <td>{{count($interest_point->houses)}}</td>
                                <td>{{$interest_point->created_at}}</td>

                            </form>
                            <td>
                                <form action="{{ route('genericInterestPoints.destroy', $interest_point)}}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger btn-small">{{trans('general.eliminate')}}</button>
                                </form>
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
@endsection
