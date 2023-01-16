<!DOCTYPE html>
<html>
<head>
<title>Get latitude and longitude from address google map & OSM</title>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<style>
.form-control {
	padding:8px;
	border:1px solid #000;
	width:400px;
}
</style>
</head>
<body>
<div>
  <h3> Enter an adress below: </h3>
  <input name="address" id="address" type="text" placeholder="Enter address here" class="form-control"/>
  <div>
    <h3>GOOGLE MAP </h3>
    <label class="label-control">Latitude</label>
    <br>
    <br>
    <input class="form-control" type="text" id="latitude" readonly />
    <br>
    <br>
    <label class="label-control">Longitude</label>
    <br>
    <br>
    <input class="form-control" type="text" id="longitude" readonly />
    <br>
    <br>
    <h3>OPENSTREET MAP </h3>
    <label class="label-control">Latitude</label>
    <br>
    <br>
    <input class="form-control" type="text" id="latitude_osm" readonly />
    <br>
    <br>
    <label class="label-control">Longitude</label>
    <br>
    <br>
    <input class="form-control" type="text" id="longitude_osm" readonly />
  </div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&key=AIzaSyCrFRe9Nze3occ3DdtErmkDUvDJHtf40oQ&libraries=places"></script> 
<script>
google.maps.event.addDomListener(window, 'load', initialize);
function initialize() {
var input = document.getElementById('address');
var autocomplete = new google.maps.places.Autocomplete(input);
autocomplete.addListener('place_changed', function () {
var place = autocomplete.getPlace();

document.getElementById("latitude").value  = place.geometry['location'].lat();
document.getElementById("longitude").value = place.geometry['location'].lng();

	var address  = document.getElementById('address').value;
	jQuery.ajax({
	type: "POST",
    url:'osm.php',
	dataType:'json',
	data:{address: address},
	success: function(data)
	{
	document.getElementById("latitude_osm").value  = data.lat;
	document.getElementById("longitude_osm").value = data.lng;

	}
	});

	


});
}
</script>
</body>
</html>