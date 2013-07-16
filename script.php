<html>
<head>
<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.6.2/leaflet.css">
<style type="text/css">
#map { height: 680px; }
</style>
</head>
<script src="http://cdn.leafletjs.com/leaflet-0.6.2/leaflet.js"></script>


<body>
<div id="map"></div>
<script>
var map = L.map('map').setView([21.6, 79], 5);
  	L.tileLayer('	http://{s}.tile.cloudmade.com/5d205a745590448bbb2598e28fd70844/997/256/{z}/{x}/{y}.png', {
	    attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://cloudmade.com">CloudMade</a>',
    	maxZoom: 18
	}).addTo(map);
	var markers = L.markerClusterGroup();
		
	for (var i = 0; i < addressPoints.length; i++) {
	var a = addressPoints[i];
	var title = a[2];
	var marker = L.marker(new L.LatLng(a[0], a[1]), { title: title });
	marker.bindPopup(title);
	markers.addLayer(marker);
		}
map.addLayer(markers);
</script>
<?php

$con=mysqli_connect("localhost","root","","mydata");

if (mysqli_connect_errno($con))
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

//////////////DISTRICT-DATA////////////////////////////////////////////

mysqli_query($con,"create table district_data(Sid int,ID int,District text,Percentage decimal,Latitude float,Longitude float)");


$dstt=mysqli_query($con,"select distinct district from mydata.gujdata");

while($row_dstt=mysqli_fetch_array($dstt))
{

$dstt_val=$row_dstt['district'];

$dstt_avg=mysqli_query($con,"select avg(percentage) from mydata.gujdata where district='$dstt_val'");
$dstt_avg_row=mysqli_fetch_array($dstt_avg);
$dstt_avg_val=$dstt_avg_row['avg(percentage)'];

$sid=mysqli_query($con,"select sid from mydata.gujdata where district='$dstt_val'");
$row_sid=mysqli_fetch_array($sid);
$sid_val=$row_sid['sid'];

$id=mysqli_query($con,"select id from mydata.gujdata where district='$dstt_val'");
$row_id=mysqli_fetch_array($id);
$id_val=$row_id['id'];

$std=mysqli_query($con,"select state from `gujdata` where sid='$sid_val'");
$row_std=mysqli_fetch_array($std);
$std_val=$row_std['state'];


$vald=$dstt_val.", ".$std_val;
$addd = urlencode($vald);
$urld = "http://maps.googleapis.com/maps/api/geocode/json?address=$addd&sensor=false";
$getmapd = file_get_contents($urld);
$googlemapd = json_decode($getmapd);
foreach($googlemapd->results as $resd)
{
	$addressd = $resd->geometry;
	$latlngd = $addressd->location;
}



mysqli_query($con,"insert into mydata.district_data (sid,ID,District,Percentage,Latitude,Longitude) values ('$sid_val','$id_val','$dstt_val','$dstt_avg_val','$latlngd->lat','$latlngd->lng')");

}



//////////////BLOCK-DATA////////////////////////////////////////////

mysqli_query($con,"create table block_data(Sid int,ID int,Block text,Percentage decimal,Latitude float,Longitude float)");


$blk=mysqli_query($con,"select distinct block from mydata.gujdata");

while($row_blk=mysqli_fetch_array($blk))
{

$blk_val=$row_blk['block'];

$blk_avg=mysqli_query($con,"select avg(percentage) from mydata.gujdata where block='$blk_val'");
$blk_avg_row=mysqli_fetch_array($blk_avg);
$blk_avg_val=$blk_avg_row['avg(percentage)'];

$sid=mysqli_query($con,"select sid from mydata.gujdata where block='$blk_val'");
$row_sid=mysqli_fetch_array($sid);
$sid_val=$row_sid['sid'];

$id=mysqli_query($con,"select id from mydata.gujdata where block='$blk_val'");
$row_id=mysqli_fetch_array($id);
$id_val=$row_id['id'];

$stb=mysqli_query($con,"select state from `gujdata` where sid='$sid_val'");
$row_stb=mysqli_fetch_array($stb);
$stb_val=$row_stb['state'];


$valb=$blk_val.", ".$stb_val;
$addb = urlencode($valb);
$urlb = "http://maps.googleapis.com/maps/api/geocode/json?address=$addb&sensor=false";
$getmapb = file_get_contents($urlb);
$googlemapb = json_decode($getmapb);
foreach($googlemapb->results as $resb)
{
	$addressb = $resb->geometry;
	$latlngb = $addressb->location;
}



mysqli_query($con,"insert into mydata.block_data (sid,ID,Block,Percentage,Latitude,Longitude) values ('$sid_val','$id_val','$blk_val','$blk_avg_val','$latlngb->lat','$latlngb->lng')");

}




mysqli_close($con);
?>
pt>

</body>
</html>

