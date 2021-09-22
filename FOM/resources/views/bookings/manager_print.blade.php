@extends('layouts.app')
@section('title', 'Print'.' '.$booking->id.' '.'de'.' '.$manager->name)
@section('meta')
  <meta name="robot" content="noindex, nofollow">
@stop
@section('content')
  @section('styles')

    <style type="text/css">

/**
 * Print Stylesheet fuer Deinewebsite.de
* @version         1.0
* @lastmodified    16.06.2016
*/

@media print {

/* Inhaltsbreite setzen, Floats und Margins aufheben */
/* Achtung: Die Klassen und IDs variieren von Theme zu Theme. Hier also eigene Klassen setzen */
#content, #page {
width: 100%;
margin: 0;
float: none;
}

/** Seitenränder einstellen */
@page { margin: 3cm }

/* Font auf 16px/13pt setzen, Background auf Weiß und Schrift auf Schwarz setzen.*/
/* Das spart Tinte */
body {
font: 14pt Georgia, "Times New Roman", Times, serif;
line-height: 1.5;
background: #fff !important;
color: #000;
}

h1 {
font-size: 24pt;
}

h2, h3, h4 {
font-size: 14pt;
margin-top: 25px;
}

/* Alle Seitenumbrüche definieren */
a {
    page-break-inside:avoid
}
blockquote {
    page-break-inside: avoid;
}
h1, h2, h3, h4, h5, h6 { page-break-after:avoid;
     page-break-inside:avoid }
img { page-break-inside:avoid;
     page-break-after:avoid; }
table, pre { page-break-inside:avoid }
ul, ol, dl  { page-break-before:avoid }

/* Linkfarbe und Linkverhalten darstellen */
a:link, a:visited, a {
background: transparent;
color: #520;
font-weight: bold;
text-decoration: underline;
text-align: left;
}

a {
    page-break-inside:avoid
}

a[href^=http]:after {
      content:" <" attr(href) "> ";
}

$a:after > img {
   content: "";
}

article a[href^="#"]:after {
   content: "";
}

a:not(:local-link):after {
   content:" <" attr(href) "> ";
}

/**
 * Eingebundene Videos verschwinden lassen und den Whitespace der iframes auf null reduzieren.
 */
.entry iframe, ins {
    display: none;
    width: 0 !important;
    height: 0 !important;
    overflow: hidden !important;
    line-height: 0pt !important;
    white-space: nowrap;
}
.embed-youtube, .embed-responsive {
  position: absolute;
  height: 0;
  overflow: hidden;
}

/* Unnötige Elemente ausblenden für den Druck */

#header-widgets, nav, aside.mashsb-container,
.sidebar, .mashshare-top, .mashshare-bottom,
.content-ads, .make-comment, .author-bio,
.heading, .related-posts, #decomments-form-add-comment,
#breadcrumbs, #footer, .post-byline, .meta-single,
.site-title img, .post-tags, .readability
{
display: none;
}

/* Benutzerdefinierte Nachrichten vor und nach dem Inhalt einfügen */
.entry:after {
content: "\ Alle Rechte vorbehalten. (c) 2014 - 2016 TechBrain - techbrain.de";
color: #999 !important;
font-size: 1em;
padding-top: 30px;
}
#header:before {
content: "\ Vielen herzlichen Dank für das Ausdrucken unseres Artikels. Wir hoffen, dass auch andere Artikel von uns Ihr Interesse wecken können.";
color: #777 !important;
font-size: 1em;
padding-top: 30px;
text-align: center !important;
}

/* Wichtige Elemente definieren */
p, address, li, dt, dd, blockquote {
font-size: 100%
}

/* Zeichensatz fuer Code Beispiele */
code, pre { font-family: "Courier New", Courier, mono}

ul, ol {
list-style: square; margin-left: 18pt;
margin-bottom: 20pt;
}

li {
line-height: 1.6em;
}

 .font-weight-bold{
  font-weight: 700;
 }

}

</style>
@endsection
{{--end section:styles--}}
<body>

  <div class="d-flex justify-content-end"><img src="{{asset("images/vico_logo_transition/VICO_VIVIR_orange.png")}}" style="width: 150px" class="h-100">
</div>
<br>
<br>
<br>
<br>
<div class="text-left">
{{$manager->name}} {{$manager->last_name}} <br>
{{$manager->email}}<br>
</div>

<div class="text-right">
  Medellín, {{date('d/m/y', strtotime($booking->created_at))}}.
</div>
<br>
<br>
<br>
<h1 class="text-center h1 font-weight-bold">¡Reserva exitosa!</h1>
<br><br><br>
<p>Hola <span class="font-weight-bold">{{$manager->name}}</span>,<br><br>
¡Felicitaciones! Tienes una nueva reserva exitosa. <br><br> 
<span class="font-weight-bold">{{$user->name}} {{ $user->last_name}} de {{$user->country}}</span> ha pagado exitosamente  <input  class="font-weight-bold" style="width: 117px; border: transparent;" type="text" value="{{$room->price}} COP">para reservar la habitación <span class="font-weight-bold"> {{$room->number}}</span> de la VICO <span class="font-weight-bold">{{$house->name}}</span> a partir de <span class="font-weight-bold">{{date('d/m/y', strtotime($booking->date_from))}}</span>. Ya hemos recibido el depósito y quedará guardado y seguro con nosotros. Te aseguramos, tranferirte el depósito ó partes del depósito en los siguientes casos: 1) {{$user->name}} no llega como acordado. 2) {{$user->name}} causa daños en el inventario de la VICO, cuyos arreglos requieren una inversión financiera.

</p>
<br>
<br>
<table style="width: 100%">
    <tr>
        <td><span style="font-size: larger;" class="font-weight-bold">Informacion del cliente:</span></td>
        <td><span style="font-size: larger;" class="font-weight-bold">Informacion de la habitacion:</span></td>
    </tr>
    <tr>
        <td><span class="font-weight-bold">Nombre Estudiante: </span> {{$user->name}} {{ $user->last_name}}</td>
        <td><span class="font-weight-bold">VICO: </span> {{$house->name}} </td>
    </tr>
    <tr>
        <td><span class="font-weight-bold">Nacionalidad:  </span> {{$user->country}}</td>
        <td><span class="font-weight-bold">Habitacion: </span> {{$room->number}}</td>
    </tr>
    <tr>
        <td><span class="font-weight-bold">Fecha de llegada: </span> {{$booking->date_from}}</td>
    </tr>
    <tr>
        <td><span class="font-weight-bold">Email: </span> {{$user->email}} </td>
    </tr>
    <tr>
        <td><span class="font-weight-bold">Whatsapp: </span> {{$user->phone}}</td>
    </tr>
</table>
<br>
<br>

<br>
    Recuerda que la habitación tiene que estar disponible y en las condiciones comunicadas a través de la plataforma de VICO para la llegada de {{$user->name}} el  {{date('d/m/y', strtotime($booking->date_from))}}.     
    Por cualquier inquietud no dudes en contactarnos. <br><br>
    Cordiales saludos, <br>
    VICO Team. 
</p>

</body>
  @endsection
  @section('scripts')

@endsection
