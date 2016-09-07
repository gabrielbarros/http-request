<?php
include '../HttpRequest.class.php';

$http = new HttpRequest();

$binary = file_get_contents('image1.png');

$http->postContentType = 'image/png';
$http->post('https://httpbin.org/post', $binary);

header('content-type: text/plain');
echo $http->responseText;
