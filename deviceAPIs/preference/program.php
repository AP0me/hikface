<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/helper/functions.php';

function fetchPrograms($host)
{
  $url = "https://$host/ISAPI/Publish/ProgramMgr/program";

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
    return null;
  }

  // Close cURL session
  curl_close($ch);

  // Return response
  return $response;
}

$response = fetchPrograms($host);
echo "Response: <pre>" . htmlspecialchars($response) . "</pre>";

?>
<form action="program-add.php" method="get">
  <input type="text" name="program_name" placeholder="Program Name">
  <input type="submit" value="Add">
</form>

<form action="program-rename.php" method="get">
  <input type="text" name="program_name" placeholder="Program Name">
  <input type="submit" value="Rename">
</form>

<a href="program-delete.php">
  <button>Delete</button>
</a>

<form action="program-save.php" method="get">
  <input type="number" name="interval" placeholder="Slide Show Interval">
  <input type="input" name="schedule_start" placeholder="Schedule Start">
  <input type="input" name="schedule_end" placeholder="Schedule End">
  <button>Save</button>
</form

