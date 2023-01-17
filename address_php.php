<?php
if(isset($_GET['address']))
{
$address_get = $_GET['address'];	
$address = str_replace(' ','%2C+',$address_get);	
	

$url = "https://maps.google.com/maps/api/geocode/json?key=AIzaSyCrFRe9Nze3occ3DdtErmkDUvDJHtf40oQ&address=$address";
$geocode = file_get_contents($url);
$json = json_decode($geocode);
		
$lat_google  = $json->results[0]->geometry->location->lat;
$lng_google  = $json->results[0]->geometry->location->lng;
       
	   

$search_url = "https://nominatim.openstreetmap.org/search?q=".$address."&format=json";
$httpOptions = ["http" => ["method" => "GET","header" => "User-Agent: Nominatim-Test"]];
$streamContext = stream_context_create($httpOptions);
$json = file_get_contents($search_url, false, $streamContext);
$decoded = json_decode($json, true);

$lat_osm = $decoded[0]["lat"];
$lng_osm = $decoded[0]["lon"];
}
else
{
	$address_get = '';
}
?>

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
.btn-submit
{
background: #a50404;
color: #FFF;
padding: 7px 10px;
border-radius: 8px;
border-color: #a50404;
margin-top: 2em;	
}
</style>
</head>
<body>
<form method="get">
<div>
  <h3> Enter an adress below: </h3>
  <input name="address" id="address" type="text" placeholder="Enter address here" value="<?php echo $address_get;?>" class="form-control"/>
<?php
if(isset($_GET['address']))
{
?>
  <div>
    <h3>GOOGLE MAP </h3>
    <label class="label-control">Latitude</label>
    <br>
    <br>
    <input class="form-control" type="text" id="latitude" value="<?php echo $lat_google;?>" readonly />
    <br>
    <br>
    <label class="label-control">Longitude</label>
    <br>
    <br>
    <input class="form-control" type="text" id="longitude" value="<?php echo $lng_google;?>" readonly />
    <br>
    <br>
    <h3>OPENSTREET MAP </h3>
    <label class="label-control">Latitude</label>
    <br>
    <br>
    <input class="form-control" type="text" id="latitude_osm" value="<?php echo $lat_osm;?>" readonly />
    <br>
    <br>
    <label class="label-control">Longitude</label>
    <br>
    <br>
    <input class="form-control" type="text" id="longitude_osm" value="<?php echo $lng_osm;?>" readonly />
  </div>
  
 <?php } ?> 
  
</div>
<button class="btn-submit" type="submit" name="submit">SUBMIT</button>
</form>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&key=AIzaSyCrFRe9Nze3occ3DdtErmkDUvDJHtf40oQ&libraries=places"></script> 
<script>
google.maps.event.addDomListener(window, 'load', initialize);
function initialize()
 {
var input = document.getElementById('address');
var autocomplete = new google.maps.places.Autocomplete(input);
autocomplete.addListener('place_changed', function () {
var place = autocomplete.getPlace();
});
}
</script>
</body>
</html>