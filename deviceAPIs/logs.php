<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/logs.php';

$logsTableValueMap = json_decode(file_get_contents('../event-type-map.json'));
print_r(json_encode(fetchAcsEvent($logsTableValueMap, $host)));
