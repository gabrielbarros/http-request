<?php
include '../HttpRequest.class.php';

$http = new HttpRequest();

$http->get('https://httpbin.org/status/500');

header('content-type: text/plain');
echo $http->status;
