<?php
require 'autoload.php';

use HttpRequest\HttpRequest;

$http = new HttpRequest();

$http->setQuery([
    'id' => '88900'
]);

$http->setBody([
    'name' => 'Paul',
    'age' => '20'
]);

$http->delete('https://httpbin.org/delete');

header('Content-Type: text/plain');
echo $http->responseText;
