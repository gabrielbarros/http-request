<?php
require 'autoload.php';

use HttpRequest\HttpRequest;

$http = new HttpRequest();

$http->setBody([
    'name' => 'Mario',
    'age' => '30'
]);

$http->uploadFile('photo1', realpath('image1.png'), 'image/png');
$http->uploadFile('photo2', realpath('image2.png'), 'image/png');

$http->post('https://httpbin.org/post');

header('Content-Type: text/plain');
echo $http->responseText;
