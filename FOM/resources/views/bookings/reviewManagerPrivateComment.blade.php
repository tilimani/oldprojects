@extends('layouts.app')

@section('title', 'Mensaje Privado')

{{--STYLE SECTION--}}
@section('styles')

@endsection
{{--END STYLE SECTION--}}

{{--MAIN SECTION--}}
@section('content')
  {{--USER AUTHENTICATION--}}
  @if(true){{--@if(Auth::user())--}}
    @if(true) {{--Auth::user()->id === $booking->manager_id || Auth::user()->role_id === 1--}}
      <div class="container pt-5">
        <div class="row">
          <div class="col-12">
            <p class="text-center h1">
              {{trans('general.many_thanks')}} {{--Auth::user()->name--}}
            </p>
            <p class="h4 p-2 m-3">
              {{trans('general.optional_you_can_leave')}} {{$usuario->name}},
              {{trans('general.with_suggestions')}} <strong>({{trans('general.Este comentario es privado')}}
                {{trans('general.only_goes_to')}} {{$usuario->name}})</strong>
            </p>
          </div>
        </div>
        <form class="" action="{{route('post_private_comment', $booking)}}" method="post">
          {{csrf_field()}}
          {{--<input type="hidden" name="role_id" value="{{Auth::user()->role_id}}">
          <input type="hidden" name="user_id" value="{{Auth::user()->id}}">--}}
          <input type="hidden" name="role_id" value="1">
          <input type="hidden" name="user_id" value="{{$booking->user_id}}">
          <input type="hidden" name="manager_id" value="{{$manager_id}}">
          {{--THE COMMENT ITSELF--}}
          <div class="col-12 form-inline">
            <div class="col-12">
              <textarea name="private_comment" rows="8" cols="100" class="w-100"></textarea>
            </div>
          </div>

          {{--SUBMIT BUTTON--}}
          <p class="text-right pb-4">
            <button type="submit" class="btn btn-primary">{{trans('general.continue')}}</button>
          </p>
        </div>
        </form>
      </div>
    @else

    @endif
  @else
  {{--TEMPORAL SOLUTION TO UNAUTHENTICATED USER, NEED TO USE MIDDLEWARE--}}
  <script type="text/javascript">
    window.location = "{{url('/')}}";
  </script>
  @endif

@endsection
{{--END MAIN SECTION--}}

{{--SCRIPT SECTION--}}
@section('scripts')

@endsection
{{--END SCRIPT SECTION--}}
