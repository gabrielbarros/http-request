<?php
require 'autoload.php';

use HttpRequest\HttpRequest;

$http = new HttpRequest();
$http->ignoreInvalidCert = true;
$http->get('https://expired.badssl.com');

header('Content-Type: text/plain');

if ($http->error) {
    echo $http->errorMsg;
}

else {
    echo $http->responseText;
}
