<table class="table no-margin text-secondary">
    <tbody>

        {{-- Anfitrion --}}
        <tr>
            <td class="contract-table-header">
                Anfitrión
            </td>
            <td  class="contract-table-information" >
                {{__($data['manager']->name . ' ' . $data['manager']->last_name)}} <br>
                <!-- ID. C.C.{{$data['manager']->id}} -->
                
            </td>
        </tr>

        {{-- INIVITADOS --}}
        <tr>
            <td class="contract-table-header">
                INVITADO 
            </td>
            <td class="contract-table-information" >
                {{$data['user']->name.' '.$data['user']->last_name}} <br>  
                <!-- ID. P.T. {{$data['user']->id}} -->
            </td>
        </tr>

        {{-- Start of stay --}}
        <tr>
            <td class="contract-table-header">
                FECHA DE INICIACIÓN DEL CONTRATO 
            </td>
            <td class="contract-table-information" >
                {{date("d.m.y", strtotime($data['booking']->date_from))}}
            </td>
        </tr>

        {{-- End of Stay --}}
        <tr>
            <td class="contract-table-header">
                TERMINACIÓN DEL CONTRATO    
            </td>
            <td class="contract-table-information" >
                {{date("d.m.y", strtotime($data['booking']->date_to))}}
            </td>
        </tr>

        {{-- VICO and Room Number --}}
        <tr>
            <td class="contract-table-header">
                OBJETO
            </td>
            <td class="contract-table-information" >
                Habitación {{$data['room']->number}}, {{$data['house']->name}}
            </td>
        </tr>

        {{-- Monthly Rent --}}
        <tr>
            <td class="contract-table-header">
                RENTA MENSUAL    
            </td>
            <td class="contract-table-information" >
              $ {{$data['room']->price}}
            </td>
        </tr>
    </tbody>
</table>