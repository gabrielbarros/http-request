<?php
require 'autoload.php';

use HttpRequest\HttpRequest;

$http = new HttpRequest();

$http->get('https://httpbin.org/redirect/15');

header('Content-Type: text/plain');

if ($http->error) {
    // Maximum (10) redirects followed
    echo $http->errorMsg;
}

else {
    echo $http->responseText;
}
