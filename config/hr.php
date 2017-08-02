<?php
return [
    "addressServiceOnTest" => false,
    "useAddressService" => true,
    "locationServiceType" => env("LOCATION_TYPE", "nomatim"),
    "locationServices" => [
        "nomatim" => [
            "type" => "App\\Location\\LocationQueryNominatim",
            "url" => "http://nominatim.openstreetmap.org/reverse?format=json&lat=[lat]&lon=[lon]&zoom=18&addressdetails=1",
            "fields"=>[
                "country" => "country",
                "state" => "state",
                "city" => "city",
                "suburb" => "suburb"
            ]
        ],
        "db" => [
            "type" => "App\\Location\\LocationQueryDB",
            "connection" => "locationdb",
            "adminLevels"=>[
                "2" => "country",
                "4" => "state",
                "8" => "city",
                "10" => "suburb"
            ]
        ]
    ]
];

?>