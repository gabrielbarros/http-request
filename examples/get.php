<?php
require 'autoload.php';

use HttpRequest\HttpRequest;

$http = new HttpRequest();

$http->setQuery([
    'value_1' => 'Something, anything',
    'test' => 'another text',
    'utf8' => 'áéíóúàèìòùâãôõçäëïöüÿý'
]);

$http->get('https://httpbin.org/get');

header('Content-Type: text/plain');
echo $http->responseText;
