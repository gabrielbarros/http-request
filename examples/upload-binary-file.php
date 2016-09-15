<?php
require 'autoload.php';

use HttpRequest\HttpRequest;

$http = new HttpRequest();

$binary = file_get_contents('image1.png');

$http->setBody($binary);

$http->contentType = 'image/png';
$http->post('https://httpbin.org/post');

header('Content-Type: text/plain');
echo $http->responseText;
