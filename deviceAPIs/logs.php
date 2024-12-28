<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/logs.php';

$logsTableValueMap = json_decode(file_get_contents('../event-type-map.json'));
$data = json_encode([
  "AcsEventCond" => reqBody()["AcsEventCond"],
]);
echo json_encode(fetchAcsEvent($logsTableValueMap, $host, $data));
