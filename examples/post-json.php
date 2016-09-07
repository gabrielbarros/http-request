<?php
include '../HttpRequest.class.php';

$http = new HttpRequest();

$param = array(
    'value_1' => 'Something, anything',
    'test' => 'another text',
    'utf8' => 'áéíóúàèìòùâãôõçäëïöüÿý'
);

$json = json_encode($param);

$http->postContentType = 'application/json';
$http->post('https://httpbin.org/post', $json);

header('content-type: text/plain');
echo $http->responseText;
