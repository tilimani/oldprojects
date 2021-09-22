 {{-- Show WhatsAppNumber if Mode = 1 && manager view --}}
     @if($booking->mode!==1 && Request::is('booking/show/*') && $booking->status==1)
       <div class="card ml-0 w-100 position-static mt-3">
           <header class="card-header text-center alert-info">
              <h4 class="alert-heading">Intercambio de números</h4>
              <hr>
              <p class="text-justify">
                ¡{{$user->name}} ya se encuentra en Medellín! Le gustaría conocerte a tí y tu VICO personalmente. Así te compartimos su WhatsApp para que puedan organizar una reunión.
                En el caso que le gusta la casa, pueden terminar el proceso de reserva con el pago de la primera renta mensual.
              </p> 
              <a href="#" data-toggle="collapse" data-target="#whatsappNumber" aria-expanded="true" href="#" class="btn btn-process w-auto">Entendido, mostrame el número!</a>
           </header>
           <div class="collapse" id="whatsappNumber" style="background-color: white; border: white;">
               <p class="card-body col-lg-6 col-12 mx-lg-auto " style="border: 0px white; background-color: white; color: #3a3a3a;">
                   {{$user->name}} {{$user->last_name}}<br>
                   Whatsapp/Mobile: + {{$whatsappnumberforlink}}
                   <a href="https://api.whatsapp.com/send?phone={{$whatsappnumberforlink}}&text=Hola%20{{$user->name}}!%20Mi%20nombre%20es%20{{$booking->manager_info->name}}%20de%20la%20{{$house->name}}.%20Cuando%20podr%C3%ADas%20ir%20a%20verla?" class="mt-2 d-block whatsappNumber-Button" target="_blank"><span class="icon-whatsapp-black" style="color:white;"></span> Abrir Whatsapp
               </a>
               </p> <!-- card-body.// -->
           </div> <!-- collapse .// -->
       </div> <!-- card.// -->
     {{-- Show WhatsAppNumber if Mode = 1 && manager view --}}
     @endif
     @if($booking->mode!==1 && Request::is('booking/user/*') && $booking->status==1)
       <div class="card ml-0 w-100 position-static mt-3">
           <header class="card-header text-center alert-info">
              <h4 class="alert-heading">Intercambio de números</h4>
              <hr>
              <p class="text-justify">Como quieres ver la casa personalmente te compartimos el número de WhatsApp de {{$booking->manager_info->phone}} para establecer contacto. En el caso que le gusta la casa, puedes terminar el proceso de reserva con el pago de la primera renta mensual.</p> 
              <a href="#" data-toggle="collapse" data-target="#whatsappNumber" aria-expanded="true" href="#" class="btn btn-process w-auto">Entendido, mostrame el número!</a>
           </header>
           <div class="collapse" id="whatsappNumber" style="background-color: white; border: white;">
               <p class="card-body col-lg-6 col-12 mx-lg-auto " style="border: 0px white; background-color: white; color: #3a3a3a;">
                   {{$booking->manager_info->name}} {{$booking->manager_info->name}}<br>
                   Whatsapp/Mobile: + {{$whatsappnumberforlink}}
                   <a href="https://api.whatsapp.com/send?phone={{$whatsappnumberforlink}}&text=Hola%20{{$booking->manager_info->name}}!%20Mi%20nombre%20es%20{{$user->name}}.%20Cuando%20podr%C3%ADa%20ir%20a%20ver%20la%20VICO?" class="mt-2 d-block whatsappNumber-Button" target="_blank"><span class="icon-whatsapp-black" style="color:white;"></span> Abrir Whatsapp
               </a>
               </p> <!-- card-body.// -->
           </div> <!-- collapse .// -->
       </div> <!-- card.// -->
     @endif