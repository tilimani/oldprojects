@component('mail::message')
# Request to change house features.
## VICO Name: {{ $house_name }}
## VICO Id: {{ $house_id }}
## VICO Manager: {{ $house_owner_name }}, Id: {{ $house_owner_id }}

----------------------------------------------------------------

### Request information
@component('mail::table')
|Feature      | Old info         | New Info      |
|:-----------:|:----------------:|:-------------:|
|  Romms      | {{ $OldRooms }}  | {{$newRooms}} |
|  Bathers    | {{ $OldBaths }}  | {{$OldBaths}} |
|  Type       | {{ $OldType }}   | {{$newType}}  |
|  Address    | {{ $OldAddress }}|{{$newAddress}}|

@endcomponent

### Reasons for change it
@component('mail::panel')
{{ $message }}
@endcomponent

{{ config('app.name') }}
@endcomponent
