<?php
require 'autoload.php';

use HttpRequest\HttpRequest;

$http = new HttpRequest();

$http->setQuery([
    'zum' => 'zim',
    'lala' => 'lo lo'
]);

$http->setBody([
    'value_1' => 'Something, anything',
    'test' => 'another text',
    'utf8' => 'áéíóúàèìòùâãôõçäëïöüÿý'
]);

$http->post('https://httpbin.org/post');

header('Content-Type: text/plain');
echo $http->responseText;
