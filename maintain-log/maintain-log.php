<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

enum Location
{
  case Web;
  case UI;
}

class MainTainlogRow
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
}

function logSearch($host, $body)
{
  $url = "https://$host/ISAPI/ContentMgmt/logSearch";

  // Initialize cURL session
  $ch = curl_init($url);

  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response instead of outputting
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Bypass host verification
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); // Set method to POST
  curl_setopt($ch, CURLOPT_POSTFIELDS, $body); // Set request body

  // Set authentication credentials
  $username = "admin";
  $password = "12345678m";
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
  curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

  // Execute cURL request
  $response = curl_exec($ch);

  // Check for errors
  if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
    return null;
  }

  // Close cURL session
  curl_close($ch);

  // Return response
  return xmlToJson($response);
}

$body = <<<XML
<?xml version="1.0" encoding="utf-8"?>
<CMSearchDescription>
    <searchID>2e74f9f96dcd44248126d655a9e6aa0a</searchID>
    <metaId>log.std-cgi.com</metaId>
    <timeSpanList>
        <timeSpan>
            <startTime>2024-12-16T00:00:00+08:00</startTime>
            <endTime>2024-12-16T23:59:59+08:00</endTime>
        </timeSpan>
    </timeSpanList>
    <maxResults>20</maxResults>
    <searchResultPostion>0</searchResultPostion>
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


?>
<style>
  table {
    width: 100%;
    border-collapse: collapse;
  }

  table,
  th,
  td {
    border: 1px solid black;
  }

  th,
  td {
    padding: 8px;
    text-align: left;
  }
</style>
<table>
  <thead>
    <tr>
      <th>No.</th>
      <th>Time</th>
      <th>Major Type</th>
      <th>Minor Type</th>
      <th>Channel No.</th>
      <th>Local/Remote</th>
      <th>Remote Host Ip</th>
      <th>Parameter</th>
      <th>Information</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($maintainLogs as $row) : ?>
      <tr>
        <td><?php echo $row->rowNumber; ?></td>
        <td><?php echo $row->time; ?></td>
        <td><?php echo $row->majorType; ?></td>
        <td><?php echo $row->minorType; ?></td>
        <td><?php echo $row->channelNumber ?? '--'; ?></td>
        <td><?php echo $row->location == Location::Web ? 'WEB' : 'UI'; ?></td>
        <td><?php echo $row->remoteHostIP; ?></td>
        <td><?php echo $row->parameter; ?></td>
        <td><?php echo $row->information; ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>