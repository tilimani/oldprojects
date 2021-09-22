@extends('layouts.app')

@section('title', 'Notificaciones')

@section('content')    
    <div id="react-communication" class="add-opacity"
        data-connection={{__(
            $user->id.",".
            Auth::user()->role_id.",".
            $pending.",".
            $unread.",".
            $accepted.",".
            $denied.",".
            $user->name.",").
            $payment.",".
            Lang::locale()}}>
    </div>
@endsection

@section('scripts')
    
@endsection