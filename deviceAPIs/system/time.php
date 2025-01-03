<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

class SystemTime
{
  public $datetime;
  public $zone;
  public $syncMode;
  public function __construct($datetime, $zone, $syncMode)
  {
    $this->datetime = $datetime;
    $this->zone = $zone;
    $this->syncMode = $syncMode;
  }
}
function fetchSystemTime($host)
{
  $url = "https://$host/ISAPI/System/time";

  // Initialize cURL session
  $ch = curl_init($url);

  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response instead of outputting it
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for testing
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Bypass host verification
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); // Set method to GET

  $ch = deviceAuth($ch);

  // Execute cURL request
  $response = curl_exec($ch);

  // Check for errors
  if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
  } else {
    return xmlToJson($response);
  }

  // Close cURL session
  curl_close($ch);
}

$timeData = fetchSystemTime($host);
$systemTime = new SystemTime(
  $timeData->localTime,
  $timeData->timeZone,
  $timeData->timeMode
);
foreach ($systemTime as $key => $value) {
  print_r($key . ": " . $value . "<br>");
}
?>

<style>
  .dlt-panel{
    display: grid;
    grid-template-columns: repeat(5, max-content);
  }
</style>

<label for="set-time">Set</label>
<input type="date" for="set-time">
<input type="submit" value="Sync with computer">


<form action="sync-comp-time.php">
  <input type="text" name="datetime" value="<?= $systemTime->datetime ?>">
  <input type="text" name="zone" value="<?= $systemTime->zone ?>">
  <input type="text" name="syncMode" value="<?= $systemTime->syncMode ?>">
  <input type="submit" value="Save">
</form>

<label for="daylight-savings">Daylight savings</label>
<input type="checkbox" id="daylight-savings" onchange="toggleDLTPanel()">

<div class="dlt-panel">
  <label class="start-time">Start time</label>
  <input type="text" class="dlt-item">
  <input type="text" class="dlt-item">
  <input type="text" class="dlt-item">
  <input type="text" class="dlt-item">

  <label class="end-time">End time</label>
  <input type="text" class="dlt-item">
  <input type="text" class="dlt-item">
  <input type="text" class="dlt-item">
  <input type="text" class="dlt-item">

  <label class="dlt-bias-title">DLT Bias</label>
  <input type="radio" name="dlt-bias-value" class="dlt-item">
  <input type="radio" name="dlt-bias-value" class="dlt-item">
  <input type="radio" name="dlt-bias-value" class="dlt-item">
  <input type="radio" name="dlt-bias-value" class="dlt-item">
</div>

<script>
  function updateTime() {
    const date = new Date();
    const offset = -date.getTimezoneOffset() / 60; // Timezone offset in hours
    const formattedOffset = (offset >= 0 ? "+" : "-") +
      String(Math.abs(offset)).padStart(2, "0") + ":00";

    // Format the date and time as `YYYY-MM-DDTHH:mm:ss+HH:MM`
    const formattedTime = date.toISOString().split(".")[0] + formattedOffset;

    // Update the input field with the current time
    const datetimeInput = document.querySelector('input[name="datetime"]');
    if (datetimeInput) {
      datetimeInput.value = formattedTime;
    }
  }

  // Update time every second
  setInterval(updateTime, 1000);

  // Run the function on page load to set the initial value
  updateTime();
</script>
<script>
  function toggleDLTPanel(){
    let daylightSavingsBtn = document.querySelector('#daylight-savings');
    let daylightSavingsOn = daylightSavingsBtn.checked;
  }
</script>