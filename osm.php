<?php
$address = $_POST['address'];	
$address = str_replace(' ','%2C+',$address);	
$search_url = "https://nominatim.openstreetmap.org/search?q=".$address."&format=json";
$httpOptions = ["http" => ["method" => "GET","header" => "User-Agent: Nominatim-Test"]];
$streamContext = stream_context_create($httpOptions);
$json = file_get_contents($search_url, false, $streamContext);
$decoded = json_decode($json, true);

$lat = $decoded[0]["lat"];
$lng = $decoded[0]["lon"];

$data=array("lat"=>$lat,"lng"=>$lng);
echo json_encode($data);	
		
?>