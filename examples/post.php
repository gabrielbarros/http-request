<?php
require 'autoload.php';

use HttpRequest\HttpRequest;

$http = new HttpRequest();

$http->setQuery(array(
    'zum' => 'zim',
    'lala' => 'lo lo'
));

$http->setBody(array(
    'value_1' => 'Something, anything',
    'test' => 'another text',
    'utf8' => 'áéíóúàèìòùâãôõçäëïöüÿý'
));

$http->post('https://httpbin.org/post');

header('Content-Type: text/plain');
echo $http->responseText;
