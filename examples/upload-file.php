<?php
include '../HttpRequest.class.php';

$http = new HttpRequest();

$param = array(
    'name' => 'Mario',
    'age' => '30'
);

$http->uploadFile('photo1', realpath('image1.png'), 'image/png');
$http->uploadFile('photo2', realpath('image2.png'), 'image/png');

$http->post('https://httpbin.org/post', $param);

header('content-type: text/plain');
echo $http->responseText;
