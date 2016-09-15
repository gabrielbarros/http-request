<?php
require 'autoload.php';

use HttpRequest\HttpRequest;

$http = new HttpRequest();

$param = array(
    'value_1' => 'Something, anything',
    'test' => 'another text',
    'utf8' => 'áéíóúàèìòùâãôõçäëïöüÿý'
);

$json = json_encode($param);

$http->setBody($json);

$http->contentType = 'application/json';
$http->post('https://httpbin.org/post');

header('Content-Type: text/plain');
echo $http->responseText;
