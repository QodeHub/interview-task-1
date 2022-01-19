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

if ($api == 'GET') {
    echo  $service->message("Method not allowed", true);
}

if ($api == 'POST') {
    $url = $service->test_input($_POST['url']);
//    echo $url;
    // Retrieve short code from URL
    $shortCode = str_replace("=", "", strpbrk($url, "="));
//    echo $shortCode;
    try {
        echo $service->shortCodeToUrl($shortCode);
    } catch (Exception $exception) {
        echo $service->message($exception->getMessage(), true);
    }
}