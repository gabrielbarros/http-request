<?php
include '../HttpRequest.class.php';

$http = new HttpRequest();

$param = array(
    'value' => '1',
);

$http->request('PATCH', 'https://httpbin.org/patch', $param);

header('content-type: text/plain');
echo $http->responseText;
