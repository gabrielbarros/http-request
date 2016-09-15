<?php
require 'autoload.php';

use HttpRequest\HttpRequest;

$http = new HttpRequest();

$http->connect = 5;
$http->get('https://google281928182812819289.com');

header('Content-Type: text/plain');

if ($http->error) {
    echo 'ERROR: ' . $http->errorMsg;
    // = ERROR: Could not resolve host: google281928182812819289.com
}
else {
    echo $http->responseText;
}
