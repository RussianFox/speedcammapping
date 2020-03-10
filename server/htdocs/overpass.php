<?php

require "staff/functions.php";

cors_header();
header('Content-type: application/json');

$request_body = file_get_contents('php://input');
$url = 'https://www.overpass-api.de/api/interpreter';
$bbox = false;

if (isset($_REQUEST['quadr'])) {
    $bbox = coord_quadr($_REQUEST['quadr']);
    $bbox=$bbox['y1'].",".$bbox['x1'].",".$bbox['y2'].",".$bbox['x2'];
};

if (isset($_REQUEST['bbox'])) {
    $bbox=$_REQUEST['bbox'];
};

if (!$bbox) {
    add_error("Request failed");
}

$request_body='data=[out:json][timeout:60];relation["type"="enforcement"]["enforcement"~"maxheight|maxweight|maxspeed|mindistance|traffic_signals|check|access|road_marking"]('.$bbox.')->.a;(.a;node["highway"="speed_camera"]('.$bbox.');node(r.a:"to");node(r.a:"device"););out meta;';

// use key 'http' even if you send the request to https://...
$options = array(
    'http' => array(
        'header'  => "Content-type: application/json\r\n",
        'method'  => 'POST',
        'content' => $request_body
    ),
);

$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);

if ($result === FALSE) {
    /* Handle error */
    var_dump($options);
    echo "Error";
}

//var_dump($bbox);

echo $result;


?>