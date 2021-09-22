<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <link href="{{ public_path('\css\app.css?version=5') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Contrato de VICO</title>
</head>
<style>
            body{
                margin: 2cm;
            } 
            table tr{
                border:0px;
            }        
            .contract-table-header{
                font-weight: 700;
                color: black !important;
                width: auto;
                text-transform: uppercase;
            }
            .contract-table-information{
                color: black !important;
            }
            .contract-h1{
                font-weight: 900;
                font-size: 1.75rem;
                text-align: center;
                text-transform: uppercase;

            }
            .contract-h2{
                font-weight: 900;
                color: #ef8e01;
                text-decoration: underline;
                text-transform: uppercase;
                text-align: center;
                font-size: 1.25rem;
            }
            .contract-h3{
                color: black; 
                font-weight: 700;
                text-transform: uppercase;

            }
            .contract-h4{
                color: black;  
                font-weight: 700;

            }
            .contract-strong{
                color: black;
                font-weight: 700;

            }
            ul{
                margin-left: .5rem;
            }
             .new-page {
                page-break-before: always;
              }
            p{
                text-align: justify;
            }
            li{
                text-align: justify;
            }


            /*Table*/
            .cell_green{
                width: 30px;
                background-color: lightgreen; 
                
            }

            .cell_yellow{
                width: 30px;
                background-color: yellow;
                
            }

            .cell_pink{
                width: 30px;
                background-color: pink;
                
            }

            .cell_gray{
                background-color: lightgray;
                
            }

            .cell_darkgray{
                background-color: gray;
                
            }

            /*.w_cell{
                width: 760px;
            }*/
            .sub-header{
                font-size: 10px;
            }

            #col_1{
                width: 30%;
            }
            #col_2{
                width:10%;
            }
            #col_6{
                width: 60%;
            }

            #tbl_1 table, td, tr {
              border: 1px solid black;
              font-size: 14px;
            }

            #tbl_1 td{
                height: 30px;
                /*padding: 0px;*/
            }
            #tbl_1 p{
                font-size: : 14px;
                /*padding: 0px;*/
            }

            #tbl_2 table, td, tr {
              border: 1px solid black;
              font-size: 14px;
            }

            #tbl_2 td{
                height: 30px;
                /*padding: 0px;*/
            }

            #tbl_2 p{
                font-size: 14px;
                /*padding: 0px;*/
            }

            #tbl_3 table, td, tr {
              border: 1px solid black;
              font-size: 14px;
            }

            #tbl_3 td{
                height: 30px;
                /*padding: 0px;*/
            }
            #tbl_3 p{
                font-size: 14px;
                /*padding: 0px;*/
            }
        </style>
<body>


{{-- Titulo --}}
    <p class="contract-h1" style="background: orange;color: white; width: 100%;padding:1rem .5rem; ">
        Contrato de Vivienda Compartida.
    </p>

{{-- Contract information table --}}
    @include('termsandconditions.contract._informationtable')

{{-- Contract Text --}}
    <span class="new-page"></span>
    @include('termsandconditions.contract._contract_text')


{{-- Anexos --}}
    <ul>
        <li>
            ANEXO 1. INVENTARIO Y CONFIRMACIÓN DE ENTREGA.
        </li>

        <li>
            ANEXO 2. NORMAS DE LA CASA
        </li>

        <li>
            ANEXO 3. REGLAMENTO DE DEPOSITO.
        </li>

        <li>
            ANEXO 4. TÉRMINOS Y CONDICIONES DE USO DEL SITIO – ANFITRIÓN. 
        </li>

        <li>
            ANEXO 5. TÉRMINOS Y CONDICIONES DE USO DEL SITIO – INVITADO
        </li>
    </ul>


{{-- Inventario y confirmación de entrega --}}
    <span class="new-page"></span>
    @include('termsandconditions.contract._contract_inventario')

{{-- Norms of the house --}}
    <span class="new-page"></span>
    @include('termsandconditions.contract._houserules')

{{-- Rules for the deposit --}}
    <span class="new-page"></span>
    @include('termsandconditions.contract._deposit_rules')


<p class="contract-h3">Constancia de aprobación</p>
<p class="contract-h4" style="padding-top: 20px">Anfitrión</p>
<p class="contract-h4" style="padding-top: 20px">Invitado</p>

</body>
</html>