<?php
include '../HttpRequest.class.php';

$http = new HttpRequest();

$param = array(
    'value_1' => 'Something, anything',
    'test' => 'another text',
    'utf8' => 'áéíóúàèìòùâãôõçäëïöüÿý'
);

$http->get('https://httpbin.org/get', $param);

header('content-type: text/plain');
echo $http->responseText;
