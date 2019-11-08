<?php

$ymin=-85;
$ymax=85;
$xmin=0;
$xmax=360;
$xstep=0.1;
$ystep=0.1;

$penalty_show=5;

function cors_header() {
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Origin, Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers");
    header("Access-Control-Allow-Methods: GET, OPTIONS, POST, PUT");
    header("Access-Control-Allow-Credentials: true");
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
	exit;
    };
}

?>