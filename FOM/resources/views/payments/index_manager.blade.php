@extends('layouts.app')
@section('title', 'Resumen de pagos')
{{--SECTION: META--}}
@section('meta')
<meta name="description" content="">
<meta name="robot" content="noindex, nofollow">
<meta property="og:title" content=""/>
<meta property="og:image" content="" />
<meta property="og:site_name" content="VICO"/>
<meta property="og:description" content=""/>

@endsection

@section('content')
	@section('styles')
	<style type="text/css">
		tr:nth-child(even){
			background-color: #f2f2f2;
		}

		tr:hover{
			background-color: #f5f5f5;
		}
		th, td {
		  padding: 15px;
		  text-align: left;
		  border-bottom: 1px solid #ddd;
		}
		th {
		  background-color: #ea960f;
		  color: white;
		}
	</style>
	@endsection
<div style="overflow-x:auto;" class="container">
  <table class="w-100">
    <tr>
      <th>Referencia</th>
      <th>Fecha de pago</th>
      <th>Monto</th>
      <th>Nombre</th>
      <th>Llegada</th>
      <th>Salida</th>
      <th>Status</th>
    </tr>
	@foreach($payments as $payment)
	<tr>
		 <td><a href="/booking/show/{{ $payment->booking->id }}">{{ $payment->payment->id }}</a></td>
		 <td>{{date('d/m/Y', strtotime($payment->payment->created_at))}}</td>
		 <td>$ {{ number_format($payment->payment->amountCop,0,'','.') }} COP</td>
		 <td>{{ $payment->user->name }} {{ $payment->user->last_name }}</td>
		 <td>{{date('d/m/Y', strtotime($payment->booking->date_from))}}</td>
		 <td>{{date('d/m/Y', strtotime($payment->booking->date_to))}}</td>
		 @if($payment->payment->status===1)
		 <td style="color:green; text-transform:uppercase;">Consignado</td>
		 @else	 
		 <td style="color:orange; text-transform:uppercase;">En proceso</td>
		 @endif
	</tr>	
	@endforeach
  </table>
</div>

@endsection
@section('scripts')
@endsection




