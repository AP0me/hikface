<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

enum Location
{
  case Web;
  case UI;
}

class MainTainlogRow implements JsonSerializable
{
  public int $rowNumber;
  public string $time;
  public string $majorType;
  public string $minorType;
  public int|null $channelNumber;
  public Location $location;
  public string $remoteHostIP;
  public string|null $parameter;
  public string|null $information;
  public function __construct(
    $rowNumber,
    $time,
    $majorType,
    $minorType,
    $channelNumber,
    $location,
    $remoteHostIP,
    $parameter,
    $information
  ) {
    $this->rowNumber = $rowNumber;
    $this->time = $time;
    $this->majorType = $majorType;
    $this->minorType = $minorType;
    $this->channelNumber = $channelNumber;
    $this->location = $location;
    $this->remoteHostIP = $remoteHostIP;
    $this->parameter = $parameter;
    $this->information = $information;
  }
  public function jsonSerialize(): mixed
  {
    return [
      'rowNumber' => $this->rowNumber,
      'time' => $this->time,
      'majorType' => $this->majorType,
      'minorType' => $this->minorType,
      'channelNumber' => $this->channelNumber,
      'location' => $this->location instanceof Location ? $this->location->name : $this->location,
      'remoteHostIP' => $this->remoteHostIP,
      'parameter' => $this->parameter,
      'information' => $this->information
    ];
  }
}

function logSearch($host, $body)
{
  $url = "https://$host/ISAPI/ContentMgmt/logSearch";
  return isAPI($url, 'POST', $body);
}

$CMSearchDescription = reqBody()['CMSearchDescription'];
$searchID = $CMSearchDescription['searchID'];
$metaId = $CMSearchDescription['metaId'];
$startTime = $CMSearchDescription['startTime'];
$endTime = $CMSearchDescription['endTime'];
$maxResults = $CMSearchDescription['maxResults'];
$searchResultPostion = $CMSearchDescription['searchResultPostion'];

$body = <<<XML
<?xml version="1.0" encoding="utf-8"?>
<CMSearchDescription>
    <searchID>$searchID</searchID>
    <metaId>$metaId</metaId>
    <timeSpanList>
        <timeSpan>
            <startTime>$startTime</startTime>
            <endTime>$endTime</endTime>
        </timeSpan>
    </timeSpanList>
    <maxResults>$maxResults</maxResults>
    <searchResultPostion>$searchResultPostion</searchResultPostion>
</CMSearchDescription>
XML;

$response = logSearch($host, $body)->matchList->searchMatchItem;

$counter = 0;
$maintainLogs = [];
foreach ($response as $key => $value) {
  $value = $value->logDescriptor;
  $metaId = $value->metaId;
  $metaId = str_replace('log.hikvision.com', '', $metaId);
  [$_, $majorType, $minorType] = explode('/', $metaId);
  $row = new MainTainlogRow(
    $counter,
    $value->StartDateTime,
    $majorType,
    $minorType,
    $value->channelNumber ?? null,
    $value->userName === 'Web' ? Location::Web : Location::UI,
    $value->ipAddress,
    null,
    ($value->additionInformation) == (object)[] ? '--' : json_encode($value->additionInformation),
  );
  $maintainLogs[] = $row;
  $counter++;
}

print_r(json_encode($maintainLogs, JSON_PRETTY_PRINT));

