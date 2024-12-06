<?php
$jsonData = file_get_contents('event-type-map.json');
$logsTableValueMap = json_decode($jsonData);

class LogRow{
  public $employeeID;
  public $name;
  public $cardNum;
  public $eventType;
  public $time;
  public $operation;
  public function __construct($employeeID, $name, $cardNum, $eventType, $time, $operation, ){
    $this->employeeID = $employeeID;
    $this->name = $name;
    $this->cardNum = $cardNum;
    $this->eventType = $eventType;
    $this->time = $time;
    $this->operation = $operation;
  }
}

function fetchAcsEvent($logsTableValueMap)
{
  $url = "https://192.168.0.116/ISAPI/AccessControl/AcsEvent?format=json&security=1&iv=90b54a4c844c94bfe780ecf7b535a00e";

  // Request body
  $data = json_encode([
    "AcsEventCond" => [
      "searchID" => "57f48f21928740cb86119fbb878c2c8f",
      "searchResultPosition" => 0,
      "maxResults" => 20,
      "major" => 0,
      "minor" => 0,
      "startTime" => "2024-12-06T00:00:00+08:00",
      "endTime" => "2024-12-06T23:59:59+08:00",
      "timeReverseOrder" => true
    ]
  ]);

  // Initialize cURL session
  $ch = curl_init($url);

  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for local testing
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

  // Set authentication credentials
  $username = "admin";
  $password = "12345678m";
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
  curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

  // Set additional headers
  $headers = [
    "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:132.0) Gecko/20100101 Firefox/132.0",
    "Accept: */*",
    "Accept-Language: en-US,en;q=0.5",
    "If-Modified-Since: 0",
    "SessionTag: WIF1HDYXZHMY3SYCYFKDGN7N7QU5TSKFESKVK18OOCUSXVAJFTA9TIIXHELXZIND",
    "X-Requested-With: XMLHttpRequest",
    "Pragma: no-cache",
    "Cache-Control: no-cache"
  ];
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  // Execute cURL request
  $response = json_decode(curl_exec($ch));

  // Check for errors
  if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
  }
  else {
    $processedLogs = [];
    $infos = (array)($response->AcsEvent->InfoList);
    foreach ($infos as $info) {
      $processedLogs[] = new LogRow(
        $info->employeeNoString??null,
        $info->name??null,
        $info->cardNo??null,
        $logsTableValueMap->majors->{$info->major}->minors->{$info->minor}??null,
        $info->time??null,
        "-"
      );
    }
  }

  // Close cURL session
  curl_close($ch);
  return $processedLogs;
}

// Call the function
$processedLogs = fetchAcsEvent($logsTableValueMap);
foreach ($processedLogs as $log) {
  echo "Employee ID: " . $log->employeeID . "<br>";
  echo "Name: " . $log->name . "<br>";
  echo "Card Number: " . $log->cardNum . "<br>";
  echo "Event Type: " . $log->eventType . "<br>";
  echo "Time: " . $log->time . "<br>";
  echo "Operation: " . $log->operation . "<br>";
  echo "<hr>";
}
