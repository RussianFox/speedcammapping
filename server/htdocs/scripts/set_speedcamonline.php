<?php

include "../staff/functions.php";

echo "Start ".date('Y-m-d H:i:s')."\r\n";

$index="speedcammapping_speedcamonline";

// Create a stream
$opts = [
    "http" => [
        "method" => "GET",
        "header" => "Accept-language: en\r\n" .
        "User-Agent: Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.102011-10-16 20:23:10\r\n" // i.e. An iPad
    ]
];

$context = stream_context_create($opts);

$files=array();
$files[] = "https://speedcamonline.ru/primo/Rus/nomobile/";
$files[] = "https://speedcamonline.ru/primo/Ukraine/nomobile/";
$files[] = "https://speedcamonline.ru/primo/Latvija/nomobile/";
$files[] = "https://speedcamonline.ru/primo/GE/nomobile/";
$files[] = "https://speedcamonline.ru/primo/uz/nomobile/";
$files[] = "https://speedcamonline.ru/primo/tm/nomobile/";
$files[] = "https://speedcamonline.ru/primo/kz/nomobile/";
$files[] = "https://speedcamonline.ru/primo/by/nomobile/";
$files[] = "https://speedcamonline.ru/primo/Fin/nomobile/";
$files[] = "https://speedcamonline.ru/primo/EU/nomobile/";

foreach ($files as $file) {
    echo $file."\r\n";
    $filec = file('https://speedcamonline.ru/primo/Ukraine/nomobile/',false,$context);
    foreach ($filec as $line) {
        $cam = explode(",", $line);
        if (count($cam)==7) {
    	    $id=1*trim($cam[0]);
	    $lng=1*trim($cam[1]);
	    $lat=1*trim($cam[2]);
	    $speed=1*trim($cam[4]);
	    $direction=1*trim($cam[5]);
	    if ( ($speed>0) and ($direction>0) ) {
		$text="Speed: ".$speed." ".($direction==1?"one way":"in both direction");
		update_object_int($file.$id,$lng,$lat,"cam",$text,null,"http://speedcamonline.ru/point/$file/$id",$index);
	    }
	}
    }
};

echo "Finish ".date('Y-m-d H:i:s')."\r\n";
echo "----------------------------------------\r\n";
?>