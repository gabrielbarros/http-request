<?php
include '../HttpRequest.class.php';

$http = new HttpRequest();

$param_post = array(
    'value_1' => 'Something, anything',
    'test' => 'another text',
    'utf8' => 'áéíóúàèìòùâãôõçäëïöüÿý'
);

$param_get = array(
    'zum' => 'zim',
    'lala' => 'lo lo'
);

$http->post('https://httpbin.org/post', $param_post, $param_get);

header('content-type: text/plain');
echo $http->responseText;
