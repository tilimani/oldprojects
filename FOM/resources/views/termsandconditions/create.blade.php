@extends('layouts.app')
{{-- SECTION: TITLE  --}}
@section('title', 'Actualizar terminos y condiciones')
{{--SECTION: META--}}
@section('meta')
<meta name="description" content="">
{{-- PRIVATE SITE: NOINDEX NO FOLLOW IN ORDER TO PREVENT LOOKUP IN GOOLGE --}}
<meta name="robot" content="noindex, nofollow">
<meta property="og:title" content=""/>
<meta property="og:image" content="" />
<meta property="og:site_name" content="VICO"/>
<meta property="og:description" content=""/>
@endsection
{{-- SECTION: STYLES --}}
@section('styles')
@endsection
{{-- SECTION: CONTENT --}}
@section('content')
<div class="container">
	<div class="card uper mt-4">
	  <div class="card-header">
	    Add new terms and conditions. Please make shure that you have created a file named version1.X or version2 in the termsandconditions folder before updating to new terms and conditions.  
	  </div>
	  <div class="card-body">
	    @if ($errors->any())
	      <div class="alert alert-danger">
	        <ul>
	            @foreach ($errors->all() as $error)
	              <li>{{ $error }}</li>
	            @endforeach
	        </ul>
	      </div><br />
	    @endif



	      <form class="js-create-new" method="post" action="{{ route('termsandconditions.storenewversion') }}">
	          <div class="form-group">
	              @csrf
	              <label for="name">Version:</label>
	              <input type="text" class="form-control" name="version" required/>
	          </div>
	          <button type="submit" class="btn btn-primary" >Add</button>
	      </form>
	  </div>
	</div>
</div>
@endsection
{{-- SECTION: SCRIPTS --}}
@section('scripts')
<script>
    $(".js-create-new").on("submit", function(){
        return confirm("¿Estas seguro que quieres crear nuevos terminos y condiciones?");
    });
</script>
@endsection