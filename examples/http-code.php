<?php
require 'autoload.php';

use HttpRequest\HttpRequest;

$http = new HttpRequest();

$http->get('https://httpbin.org/status/500');

header('Content-Type: text/plain');
echo $http->status;
