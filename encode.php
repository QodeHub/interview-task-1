<?php

// Include CORS headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With');
header('Content-Type: application/json');

// Include action.php file
include_once  'Service/Shortener.php';

$service = new Shortener();

// api variable to get HTTP method dynamically
$api = $_SERVER['REQUEST_METHOD'];

if ($api == 'POST') {
    $url = $service->test_input($_POST['url']);
    try{
        echo $service->urlToShortCode($url);
    }catch (Exception $exception){
        echo $service->message($exception->getMessage(), true);
    }
}else{
    echo  $service->message("Method not allowed", true);
}