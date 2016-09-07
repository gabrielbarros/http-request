<?php
include '../HttpRequest.class.php';

$http = new HttpRequest();

$http->get('https://httpbin.org/redirect/15');

header('content-type: text/plain');

if ($http->error) {
    // Maximum (10) redirects followed
    echo $http->errorMsg;
}

else {
    echo $http->responseText;
}
