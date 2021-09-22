
{{-- Intercom --}}
@if (App::environment('production'))
	<script>
	  window.intercomSettings = {
	    app_id: "p3hjzaj9",
	}

	let loggedX = "@php if(Auth::check()){echo '1';} else{echo '0';}@endphp";
	 if (loggedX=='1') {


	 	window.intercomSettings["name"] = "@php if(Auth::check()){echo Auth::user()->name;} else{echo '0';}@endphp";
	 	window.intercomSettings["email"] = "@php if(Auth::check()){echo Auth::user()->email;} else{echo '0';}@endphp"; // Full name
	 	window.intercomSettings["id"] = "@php if(Auth::check()){echo Auth::user()->id;} else{echo '0';}@endphp"; // ID
	 	window.intercomSettings["role"] = "@php if(Auth::check()){echo Auth::user()->role()->first()->name_role;} else{echo '0';}@endphp"; // Role
	 }

	</script>
	<script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',w.intercomSettings);}else{var d=document;var i=function(){i.c(arguments);};i.q=[];i.c=function(args){i.q.push(args);};w.Intercom=i;var l=function(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/p3hjzaj9';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);};if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();</script>
@endif
