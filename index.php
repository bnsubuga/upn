<!doctype html>
<!--[if IE 8]><html class="ie8 lt-ie10"><![endif]-->
<!--[if IE 9]><html class="ie9 lt-ie10"><![endif]-->
<!--[if gt IE 9]><!--><html lang="en"><!--<![endif]-->
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="cleartype" content="on">
    <meta name="MobileOptimized" content="320">
    <meta name="HandheldFriendly" content="True">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link href="jquery/jquery-ui.min.css" rel="stylesheet">
<script src="jquery/external/jquery/jquery.js"></script>
<script src="jquery/jquery-ui.min.js"></script>
<script src="jquery/jquery.ui.touch-punch.min.js"></script>
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 90%;
      }
    </style>
</head>
<body>
<form method="post" enctype="multipart/form-data" id="SearchForm">
<input type="button" id="gcode" Value ="GET UPN"/>
<input type="text" class="input"  id="lng" name="lng"/>
<input type="text" class="input"  id="lat" name="lat"/>
<input type ="text" id="upn" name="upn" />
<input type="button" id="decode" value="Locate UPN"/>
</form>

<div id="results"></div>
<div id="current"></div>
<div id="map"></div>
<script>
var x = document.getElementById("lat");
var y = document.getElementById("lng");

function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -0.01, lng: 32.00},
          zoom: 18,
	  mapTypeId: 'satellite'
        });
        //var infoWindow = new google.maps.InfoWindow({map: map});
	var options = {
 	 enableHighAccuracy: true,
  	timeout: 5000,
 	 maximumAge: 0
	};
        //Try HTML5 geolocation.
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
	    map.setCenter(pos);

		var marker = new google.maps.Marker({
		    position: pos,
		    map: map,
		    draggable: true
		});
	 marker.addListener('drag', handleEvent);
    marker.addListener('dragend', handleEvent);

         }, function() {
	    }, options);
        } 

       else {
          // Browser doesn't support Geolocation
          //handleLocationError(false, infoWindow, map.getCenter());
        }
		    google.maps.event.addListener(myMarker, 'dragend', function (event) {
		    x.value = myMarker.lat();
		    y.value = myMarker.lng();
				});
      }

function handleEvent(event) {
    document.getElementById('lat').value = event.latLng.lat();
    document.getElementById('lng').value = event.latLng.lng();
}

function showPosition(position) {
x.value = position.coords.latitude; 
y.value = position.coords.longitude;
}

</script>
    
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCWTAUxq0j79KRmUaFoJSPT48z08-pDnOk&callback=initMap"
    async defer></script>

<script>
$(document).ready(function() 
{

$('#gcode').click(function()
{
var lat=$("#lat").val();
var lng=$("#lng").val();
var dataString = 'lat='+lat+'&lng='+lng;

$.ajax({
type: "POST",
url: "upntest.php",
data: dataString,
cache: false,
success: function(data){
	if(data)
	{
		$("#results").html(data);
		
}
	else
	{
		$("#results").val('Error');
	}
			}
	});

});

$('#decode').click(function()
{
var upn=$("#upn").val();
var dataString = 'upn='+upn;

$.ajax({
type: "POST",
url: "upntest.php",
data: dataString,
cache: false,
success: function(data){
	if(data)
	{
		$("#results").html(data);
				var marker = new google.maps.Marker({
                map: map,
                position: data
            });
	}
	else
	{
		$("#results").val('Error');
	}
			}
	});

});

});
</script>

</body>
</html>

