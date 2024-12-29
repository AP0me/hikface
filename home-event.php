<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/hostname.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/logs.php';

// Call the function
$logsTableValueMap = json_decode(file_get_contents('event-type-map.json'));
$data = json_encode([
  "AcsEventCond" => [
    "searchID" => "57f48f21928740cb86119fbb878c2c8f",
    "searchResultPosition" => 0,
    "maxResults" => 20,
    "major" => 0,
    "minor" => 0,
    // "startTime" => "2024-12-06T00:00:00+08:00",
    // "endTime" => "2024-12-06T23:59:59+08:00",
    "timeReverseOrder" => true
  ]
]);
$processedLogs = fetchAcsEvent($logsTableValueMap, $host, $data);
$numberOfEvents = count($processedLogs);

?>
<style>
  .img-icon-holder {
    height: 100%;
    box-sizing: border-box;
  }
  .img-icon-anchor{
    display: grid;
    justify-content: center;
    align-self: center;
  }
  .img-icon {
    width: 20px;
    height: 20px;
    border: 1px solid black;
    border-radius: 5px;
  }
  .event-log-table{
    justify-self: end;
    width: 100%;
  }
</style>
<table border="1" class="event-log-table">
  <thead>
    <tr>
      <th>Calisan Kimligi</th>
      <th>Isim</th>
      <th>Kart No.</th>
      <th>Olay Turleri</th>
      <th>Zaman</th>
      <th>Isletim</th>
    </tr>
  </thead>
  <tbody>
    <?php
    // Loop through the array of LogRow objects and display each object's properties in the table
    foreach ($processedLogs as $logRow) {
      require 'event-row.php';
    }
    ?>
  </tbody>
</table>
<script>
</script>