<?php

require "staff/functions.php";

cors_header();
header('Content-type: application/json');

$request_body = file_get_contents('php://input');
$url = 'https://www.overpass-api.de/api/interpreter';
$bbox = false;

if ($_GET['quadr']) {
    $bbox = coord_quadr($_GET['quadr']);
    $bbox=$bbox['y1'].",".$bbox['x1'].",".$bbox['y2'].",".$bbox['x2'];
};

if (isset($_GET['bbox'])) {
    $bbox=$_GET['bbox'];
};

if (!$bbox) {
    add_error("Request failed");
}

$request_body="data=[out:json][timeout:60];(node[highway=speed_camera]($bbox);relation[type=enforcement][enforcement=maxspeed]($bbox););(._;>;);out;";

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
    echo "Error";
}

//var_dump($bbox);

echo $result;


?>