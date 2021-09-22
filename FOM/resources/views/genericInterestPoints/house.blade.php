@extends('layouts.app')

@section('title', 'Relación casa/punto de interés')

@section('content')
    <div class="container mx-auto pt-5">
        @include('layouts.errors')
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">{{trans('general.name')}}</th>
                    <th scope="col">{{trans('general.address')}}</th>
                    <th scope="col">{{trans('general.type')}}</th>
                    <th scope="col">{{trans('general.status')}}</th>
                    <th scope="col">{{trans('general.created_in')}}</th>
                    <th scope="col"><a href="{{route('show_house', $house)}}"><button class="btn btn-primary">{{trans('general.ver')}}</button></a></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$house->name}}</td>
                    <td>{{$house->address}}</td>
                    <td>{{$house->type}}</td>
                    <td>{{$house->status}}</td>
                    <td>{{$house->created_at}}</td>
                    <td><a href="{{route('edit_show', $house)}}"><button class="btn btn-success btn-small">{{trans('general.edit')}}</button></a></th></td>
                </tr>
            </tbody>
        </table>
        <form action="{{route('genericInterestPoint.house.create', $house)}}" method="post">
            @csrf
            <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label col-form-label-lg">{{trans('general.add_new_interest_point')}}</label>
                <div class="col-sm-10">
                    @foreach($genericInterestPoints as $genericInterestPoint)
                        <div class="form-check form-check">
                            <input class="form-check-input" name="inputunchecked[]" type="checkbox" id="{{__('inlineCheckbox'.$genericInterestPoint->id)}}" value="{{$genericInterestPoint->id}}">
                            <label class="form-check-label" for="{{__('inlineCheckbox'.$genericInterestPoint->id)}}">{{$genericInterestPoint->name . '/' . $genericInterestPoint->description}}</label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label col-form-label-lg">{{trans('general.erase_old_interest')}}</label>
                <div class="col-sm-10">
                   @foreach($houseGenericInterestPoints as $houseGenericInterestPoint)
                        <div class="form-check form-check">
                            <input class="form-check-input" name="inputchecked[]" type="checkbox" id="{{__('inlineCheckbox'.$houseGenericInterestPoint->id)}}" value="{{$houseGenericInterestPoint->id}}" checked>
                            <label class="form-check-label" for="{{__('inlineCheckbox'.$houseGenericInterestPoint->id)}}">{{$houseGenericInterestPoint->name . ' ' . $houseGenericInterestPoint->description}}</label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <a href="{{ route('genericInterestPoints.index')}}" class="btn btn-link">{{trans('general.go_back_to_interest')}}</a>
                    <button type="submit" class="btn btn-primary">{{trans('general.confirm')}}</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')

@endsection
