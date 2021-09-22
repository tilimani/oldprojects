<p class="contract-h1" style="background: orange;color: white; width: 100%;padding:1rem .5rem; ">
   Anexo 3.: Normas de la casa
</p>
{{-- Norms of the house --}}
<table class="table no-margin text-secondary">
    <tbody>

        {{-- Deposito --}}
            @if( $data['rules'][1])
                <tr>
                    <td class="contract-table-header">
                        El depósito para reservar una habitación se devolverá después de finalizar la estancia:
                    </td>
                    <td  class="contract-table-information" >
                        {{-- {{ $data['rules'][1]->description }}. --}}
                        1 renta mensual, a menos que se acuerde lo contrario entre el invitado y el anfitrión.
                    </td>
                </tr>
            @endif

        {{-- Tiempo minimo de estancia --}}
            @if( $data['rules'][2])
                <tr>
                    <td class="contract-table-header">
                        Tiempo minimo de estancia en días:
                    </td>
                    <td class="contract-table-information" >
                        {{ $data['rules'][2]->description }}
                    </td>
                </tr>
            @endif  

        {{-- Aseo en zonas sociales --}}
            @if( $data['rules'][3])
                <tr>
                    <td class="contract-table-header">
                         Aseo en zonas sociales:
                    </td>
                    <td class="contract-table-information" >
                        @if( $data['rules'][3]->description == 1) Si @else No @endif
                    </td>
                </tr>
            @endif

        {{-- Alimentación --}}
            {{-- @if( $data['rules'][5])
                <tr>
                    <td class="contract-table-header">
                        Alimentación incluida:   
                    </td>
                    <td class="contract-table-information" >
                        @if( $data['rules'][5]->description == 1) Si @else No @endif
                    </td>
                </tr>
            @endif --}}

        {{-- Valor extra por huesped  --}}
        @if( $data['rules'][6])
            <tr>
                <td class="contract-table-header">
                    Valor extra por huesped adicional por noche:
                </td>
                <td class="contract-table-information" >
                    {{ $data['rules'][6]->description }}
                </td>
            </tr>
        @endif

        {{-- Tiempo de preaviso --}}
            @if( $data['rules'][7])
                <tr>
                    <td class="contract-table-header">
                        Tiempo de preaviso para desocupar la habitación. En caso de no, el dueño se queda con el depósito: 
                    </td>
                    <td class="contract-table-information" >
                        {{ $data['rules'][7]->description }}
                    </td>
                </tr>
            @endif

        {{-- Reglas adicionales --}}
            @if( $data['rules'][12])
                <tr>
                    <td class="contract-table-header">
                        Reglas adicionales:    
                    </td>
                    <td class="contract-table-information" >
                      {{ $data['rules'][12]->description }}
                    </td>
                </tr>
            @endif

    </tbody>
</table>