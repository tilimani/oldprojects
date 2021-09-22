@extends('layouts.app')
@section('title', 'Bienvenidos a VICO')

@section('styles')
<style>
    @media screen and (min-width:1024px){
        .title{
            font-family: NunitoBold;
            color: rgb(130, 130, 130);
            font-size: 2rem;
            color: #ea960f;
        }
        .sub-title{
            color: black;
            color: rgb(79, 79, 79);
            display: flex;
            flex-direction: column;
            margin-bottom: 10px;
            width: 90%;
        }
        .description-data-text{
            display: -moz-inline-box;
            display: -webkit-inline-box;
            color: rgb(114, 114, 113);
        }
        .description-data-text img{
            margin-right: 10px;
        }
        .description-text.padding{
            padding: 15px 30px;
            text-align: justify;
        }

        .description-image{
            border-radius: 10px;
            margin: 30px 10px;
            height: 290px;
        }
        .header-container {
            width: 100%;
            min-height: calc(60vh);
            position: relative;
        }
        .header-container .header{
            width: 100%;
            position: relative;
            height: 60vh;
            background: url({{asset('images/UNAL_Header.png')}}) no-repeat bottom;
            background-size: cover;
            margin-bottom: 20px;
        }
        .header-container .title{
            position: absolute;
            left: 10%;
            bottom: 15%;
            color: white;
            font-family: NunitoBold;
        }
        .header-container .logo{
            position: absolute;
            right: 10%;
            top: 10%;
            width: 20%;
        }
        .title-footer{
            position: absolute;
            left: 10%;
            bottom: 5%;
            font-size: 1.7rem;
            color: white;
            font-family: NunitoRegular;
        }
        .sub-section{
            display: flex;
            justify-content: space-between;
        }
        .column-display{
            display: flex;
            flex-direction: column;
        }
        .unal-body{
            margin: 0 10%;
            margin-bottom: 25px;
        }
        
        .houses{
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .house{
            width: 30%;
            box-sizing: border-box;
            position: relative;
            margin-bottom: 10px;
        }
        
        .house .image{
            border-radius: 25px;
            width: 100%;
        }
        .house .location-icon{
            width: 0.8rem; 
        }
        .house .name_price{
            position: absolute;
            color: white;
            bottom: 0;
            left: 50%;
            right: 0;
            transform: translateX(-50%);
            background: #ffa50069;
            width: 100%;
            border-radius: 0 0 25px 25px;
            height: 55px;
            padding: 10px;
        }
        .house .house-info{
            position: relative;
        }
    }
    @media screen and (max-width:1024px){
        .unal-body{
            margin: 10%;
        }
        .title{
            font-family: NunitoBold;
            color: rgb(130, 130, 130);
            font-size: 1.3rem;
            color: #ea960f;
        }
        .sub-title{
            color: black;
            color: rgb(79, 79, 79);
            display: flex;
            flex-direction: column;
            margin-bottom: 10px;
            margin-left: 10px;
        }
        .description-data-text{
            display: -moz-inline-box;
            display: -webkit-inline-box;
            color: rgb(114, 114, 113);
        }
        .description-data-text img{
            margin-right: 10px;
        }
        .description-image{
            border-radius: 10px;
            width: 100%;
        }
        .house{
            width: 100%;
            box-sizing: border-box;
            position: relative;
            margin-bottom: 10px;
        }
        .sub-section.sub-section-1{
            display: flex;
            justify-content: space-between;
            flex-direction: column-reverse;
            position: relative;
        }
        .sub-section.sub-section-1 .description-image{
            display: none;
        }
        .sub-section.sub-section-2{
            display: flex;
            justify-content: space-between;
            flex-direction: column;
            position: relative;
            margin-bottom: 25px;
        }
        .sub-section.sub-section-2 iframe{
            width: 100%;
        }
        .sub-section.sub-section-3{
            display: flex;
            justify-content: space-between;
            flex-direction: row;
            position: relative;
            margin-bottom: 25px;
        }
        .sub-section.sub-section-3 .btn-primary{
            min-height: 25px;
            max-height: 25px;
            padding: 0 20px;
            line-height: 25px;
        }
        .description-text.padding{
            padding: 0;
        }
        .description-text{
            text-align: justify;
            font-size: 0.9rem;
        }
        .header-container{
            width: 100%;
            position: relative;
        }
        .header-container .header{
            width: 100%;
            position: relative;
            height: 50vh;
            background: url({{asset('images/UNAL_Header.png')}}) bottom;
        }
        .header-container .title{
            position: absolute;
            left: 50%;
            top: 50%;
            color: white;
            font-family: NunitoBold;
            text-align: center;
            width: 75%;
            transform: translateX(-50%);
            font-size: 1.5rem;
        }
        .header-container .logo{
            height: 50px;
            position: absolute;
            top: 5%;
            right: 5%;
        }
        .title-footer{
            position: absolute;
            top: 75%;
            font-size: 1rem;
            color: white;
            font-family: NunitoRegular;
            width: 50%;
            text-align: center;
            left: 50%;
            transform: translateX(-50%);
        }
        .houses{
            display: flex;
            flex-wrap: wrap;
            flex-direction: column
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .house{
            width: 100%;
            box-sizing: border-box;
            position: relative;
            margin-bottom: 10px;
        }
        
        .house .image{
            border-radius: 25px;
            width: 100%;
        }
        .house .location-icon{
            width: 0.8rem; 
        }
        .house .name_price{
            position: absolute;
            color: white;
            bottom: 0;
            left: 50%;
            right: 0;
            transform: translateX(-50%);
            background: #ffa50069;
            width: 100%;
            border-radius: 0 0 25px 25px;
            height: 55px;
            padding: 10px;
        }
        .house .house-info{
            position: relative;
        }
    }
</style>
@endsection

@section('content')
<section class="header-container">
    <div class="header"></div>
    <img src={{ asset('images/UNAL_Bog.png') }} class="logo" />
    <p class="title">¿VAS A ESTUDIAR EN LA UNAL?</p>
    <p class="title-footer">Aquí encuentras la vivienda perfecta</p>
</section>
<section class="unal-body">

    <section class="who-we-are">
    <p class="title">¿Dónde debería vivir si estudio en la Universidad Nacional?</p>
        <article class="sub-section sub-section-1">
            <img class="description-image" src={{asset('images/ORI_quienes.jpg')}} />
                La Universidad Nacional Sede Bogotá está ubicada muy estratégicamente.
                 Queda en la localidad de Teusaquillo, una localidad importante de la 
                 ciudad en la cual también está ubicada la embajada Americana. También 
                 cuenta con varios alojamientos estudiantiles. 
                Si eres estudiantiles de la Universidad Nacional, las mejores zonas para 
                encontrar tu vivienda compartida son Chapinero y Teusaquillo. Son localidades
                 seguras que ofrecen una amplia oferta cultural y de vida nocturna. Adicionalmente, 
                 están conectadas excelentemente con el resto de la ciudad a través de transporte público. 
            </p>
        </article>
        <section class="vicos mb-4">
            <div class="sub-section sub-section-3">
                        
                <span class="title d-inline-block">Viviendas cerca de la UN</span>
                <a class="btn btn-primary" href="/vicos/Bogota">Abrir Mapa</a>
            </div>
            <div class="houses">
                @foreach ($favorite_houses as $favorite_house)
                <div class="house">
                    <a href="/houses/{{$favorite_house->id}}" target="_blank">
                        <div class="house-info">
                            <img class="image" src="{{'https://fom.imgix.net/'.$favorite_house->imageHouses->first()->image}}?w=450&h=300&fit=crop"/>
                            <span class="name_price">
                                {{$favorite_house->name}}
                            </span>
                        </div>
                    </a>
                    <div class="d-flex justify-content-between">
                        <p>
                            <img class="location-icon" src={{asset('images/map_icon.svg')}} /> 
                            {{$favorite_house->neighborhood->name}} 
                        </p>
                        <a href="/houses/{{$favorite_house->id}}">Mas <i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
                @endforeach
            <a class="btn btn-primary d-block mx-auto" href="/vicos/Bogota">Ver todas las VICOs</a>
    
        </section>
        <article class="sub-section sub-section-2">
            {{-- <div class="column-display">
                <p class="description-text">
                    <span class="sub-title">
                        Programas académicos
                    </span>
                    50 de pregrado, 36 de especialización, 40 de especialización, 101 maestrias y 35 doctorados.
                </p>
                <p class="description-data-text">
                    <img src={{asset('images/map_icon.svg')}} />
                    <span class="sub-title">
                        <span>Ubicación</span>
                        <span class="description">
                            Carrera 45 # 26-85 Edif. Uriel Gutierrez, Bogotá D.C., Colombia.
                        </span>
                    </span>
                </p>
                <p class="description-data-text">
                    <img src={{asset('images/map_icon.svg')}} />
                    <span class="sub-title">
                        <span>
                            Barrios cercanos
                        </span>
                        <span class="description">
                            Kennedy, Chapinero, Barrios Unidos, Santa fé, Los Mártires.
                        </span>
                    </span>
                </p>
            </div> --}}
            <div class="column-display">
                <p class="title">Conoce el campus de la Universidad Nacional - Sede Bogotá.</p>
                <p class="description-text">
                    <span class="sub-title">
                    </span>
                    La Universidad Nacional es la universidad más importante y 
                    representativa de Colombia por su tradición, prestigio, calidad 
                    y selectividad. Su campus insignia, la Ciudad Universitaria de Bogotá,
                     es el más grande del país y cuenta con 17 edificios declarados monumento nacional.
                      Es la Universidad con el mayor número de estudiantes del país y la sede de Bogotá 
                      recibe más de 50% de ellos en Colombia. Conoce más sobre el campus en el video. 
                </p>
                {{-- <p class="description-data-text">
                    <img src={{asset('images/map_icon.svg')}} />
                    <span class="sub-title">
                        <span>Ubicación</span>
                        <span class="description">
                            Carrera 45 # 26-85 Edif. Uriel Gutierrez, Bogotá D.C., Colombia.
                        </span>
                    </span>
                </p>
                <p class="description-data-text">
                    <img src={{asset('images/map_icon.svg')}} />
                    <span class="sub-title">
                        <span>
                            Barrios cercanos
                        </span>
                        <span class="description">
                            Kennedy, Chapinero, Barrios Unidos, Santa fé, Los Mártires.
                        </span>
                    </span>
                </p> --}}
            </div>
            <div>
                <iframe width="500" height="400"
                    src="https://www.youtube.com/embed/V37xAMOgbLI">
                </iframe>
            </div>
        </article>
    </section>
</section>
{{-- <img class="map" src={{asset('images/UNAL_Map.png')}} /> --}}
<div class="map" id="map"></div>
@endsection

@section('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD4_XvxW91t7uHIL6tzmacsoIX17gHUIgM" defer></script>
    
<script type="text/javascript">
	var map;
	let interestPoints;
	let school;
	$(document).ready(function(){
		ajax_houses();
	});
	function changeOther(value, id){
		var itemName = "otherDiv" + id;
		var item = document.getElementById(itemName);
		if(value == "{{trans('houses/show.an_other')}}"){
			item.style.display = "block";
		}
		else{
			item.style.display = "none";
		}
	}
	function ajax_houses() {
        houses_address = <?php print json_encode($houses) ?>;
        
        school = <?php echo json_encode($school) ?>;
        
		if (houses_address.length > 0) {
			myMap();
		}
	}
	function myMap() {        
        var myCenter = new google.maps.LatLng(school.lat, school.lng);
        
		var mapCanvas = document.getElementById("map");
		var mapOptions = {center: myCenter, zoom: 15};
		var map = new google.maps.Map(mapCanvas, mapOptions);
        var bounds = new google.maps.LatLngBounds();
        
		for (let index = 0; index < houses_address.length; index++) {
			let latlng = {
				lat: Number(houses_address[index].coordinates.lat),
				lng: Number(houses_address[index].coordinates.lng)
            }
            
			var price_min_room = Number(houses_address[index].min_price).toLocaleString('de-DE');
			var contentString = `
			<div id="content">
				<a href="/houses/${houses_address[index].id}" target="_blank">
					<h4 id="firstHeading" class="firstHeading">${houses_address[index].name}</h3>
					<div id="bodyContent">
						<p>Precios desde: $  ${price_min_room} COP<br>
							<a target="_blank" href="/houses/${houses_address[index].id}">Click para ver más...</a>
						</p>
					</div>
				</a>
			</div>`
			let infowindow = new google.maps.InfoWindow({
				content: contentString
			})
			let iconBase = '/images/vico_marker.png'
			let marker = new google.maps.Marker({
				map: map,
				position: latlng,
				draggable: false,
				icon: iconBase
			})
			bounds.extend(marker.position);
			marker.addListener('click', function() {
				infowindow.open(map, marker)
			});
			var idcarousel=houses_address[index].id;
			try{
				document.getElementById("house-container"+idcarousel).addEventListener('mouseover',function(){
					infowindow.open(map, marker)
					//marker.setAnimation(google.maps.Animation.BOUNCE);
				});
				document.getElementById("house-container"+idcarousel).addEventListener('mouseout',function(){
					infowindow.close(map, marker)
					//marker.setAnimation(null)
				});
			}
			catch(err){
				//alert(server error)
			}
		}
    }
</script>
@endsection