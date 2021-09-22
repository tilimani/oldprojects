// Variables
var city = "not updated";
var url = "https://api.openweathermap.org/data/2.5/weather?q=";
var snowImage = "http://pngimg.com/uploads/snowflakes/snowflakes_PNG7577.png";
var unusualImage = "https://upload.wikimedia.org/wikipedia/commons/e/e0/Question-mark-blackandwhite.png";
var clearImage = "https://upload.wikimedia.org/wikipedia/commons/thumb/a/ad/Tifinagh_letter_Yar_alternate_form_by_Foucauld.svg/1024px-Tifinagh_letter_Yar_alternate_form_by_Foucauld.svg.png";
var mistImage = "http://icons.iconarchive.com/icons/icons8/ios7/512/Astrology-Aquarius-icon.png";
var rainImage = "https://icon-icons.com/icons2/423/PNG/512/raindrop6_41891.png";
var cloudImage ="http://images.clipartpanda.com/vector-clouds-png-5025-mobileme-logo-of-black-cloud-vector.png";
var yellow = "#fdfd96";
var grey = "#D3D3D3";
var blue ="#add8e6";
var beige = "#faf0e6";
var pink = "#ffb6c1";
var sunImage = "http://simpleicon.com/wp-content/uploads/sun.png";
var key = "c220141c66285ffe95e7d849ea350297";
// Load location
var temp;
$.getJSON("https://ipinfo.io", function (response) {
  var city = response.city;
  var country = response.country;
  $("#location").html("Weather in: " + city + ", " + country);
  $.getJSON(url+city+","+country + "&appid=" + key, function(weather){
    var weatherType = weather.weather[0].main;
    temp = Math.floor(weather.main.temp - 273.15);
    $("#weather").html(weatherType);
    $("#temp").html(temp + " °C");
    switch(weatherType) {
        case "Clouds":
          $("body").css("background-color", grey);
          $("#picture").attr("src",cloudImage);
          break;

        case "Sun":
          $("body").css("background-color", yellow);
          $("#picture").attr("src",sunImage);
          break;

        case "Rain":
          $("body").css("background-color", blue);
          $("#picture").attr("src",rainImage);
          break;

        case "Mist":
          $("body").css("background-color", beige);
          $("#picture").attr("src",mistImage);
          break;

        case "Fog":
          $("body").css("background-color", beige);
          $("#picture").attr("src",mistImage);
          break;

        case "Clear":
          $("body").css("background-color", pink);
          $("#picture").attr("src",clearImage);
          break;

        case "Snow":
          $("body").css("background-color", "white");
          $("#picture").attr("src",snowImage);
          break;

        default:
          $("body").css("background-color", pink);
          $("#picture").attr("src",unusualImage);
          $("#picture").attr("alt","weather conditions are unusual");
          break;
    }

  });

});

$("#temp").click(function(){
  var celcOrNot = $("#temp").html();
  if (celcOrNot.slice(-1) == "C") {
    $("#temp").html(Math.floor(((temp*9)/5)+32) + " °F");
  }
  else {$("#temp").html(temp +" °C");}
});
