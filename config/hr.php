<?php 
return [
	"addressServiceOnTest"=>false
,	"useAddressService"=>true
,	"locationServiceType"=>env("LOCATION_TYPE","nomatim")
,	"locationServices"=>[
		"nomatim"=>[
				"type"=>"App\\Location\\LocationQueryNominatim"
			,	"url"=>"http://nominatim.openstreetmap.org/reverse?format=json&lat=[lat]&lon=[lon]&zoom=18&addressdetails=1"
		],
		"db"=>[
				"type"=>"App\\Location\\LocationQueryDB"
				,"connection"=>"locationdb"
		]
	]	
];

?>