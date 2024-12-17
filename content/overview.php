<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/deviceAPIs/door/get-status.php'; ?>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/deviceAPIs/method-user-count.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/access-methods.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/deviceAPIs/event-number.php';

$doorStatusMap = [
  'controlled' => (object)[
    'svg' => 'door-controlled.svg',
    'text' => 'Controlled',
  ],
  'remainOpen' => (object)[
    'svg' => 'door-open.svg',
    'text' => 'Remain Open',
  ],
  'remainClose' => (object)[
    'svg' => 'door-controlled.svg',
    'text' => 'Remain Closed',
  ],
];
$doorStatusNumberMap = [
  4 => 'controlled',
  2 => 'remainOpen',
  3 => 'remainClose',
];
$doorStatusNumber = fetchAcsWorkStatus($host);
$doorStatus = $doorStatusMap[$doorStatusNumberMap[$doorStatusNumber]];
?>
<style>
  .door-n-logs {
    display: grid;
    grid-template-columns: max-content 1px auto;
    gap: 20px;
  }

  .dpanel-status {
    padding: 50px;
    justify-self: center;
    align-self: center;
  }

  .dpanel-camera {
    display: grid;
  }

  .dpanel-camera img {
    width: 100%;
    height: 100%;
  }

  .door-name {
    align-self: flex-end;
    padding: 10px;
    font-weight: bolder;
    color: white;
  }

  .door-panel {
    display: grid;
  }

  .dpanel-status {
    display: grid;
  }

  .dpanel-status summary img {
    width: 50px;
    height: 50px;
    justify-self: center;
    align-self: center;
  }

  .status-change {
    position: absolute;
    display: grid;
    grid-template-columns: 1fr;
    padding: 10px;
    background-color: var(--content-bg);
    box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.2);
    width: 200px;
    transform: translate(72px, calc(-50% - 25px));
  }

  .status-change-btn {
    display: grid;
    grid-template-columns: max-content auto;
    padding: 5px 10px;
    background-color: white;
    transition: background-color 0.1s ease-in-out;
    gap: 10px;
  }

  .status-change-btn:hover {
    background-color: lightgray;
  }

  .change-btn-svg {
    width: 20px;
    height: 20px;
    justify-self: center;
    align-self: center;
  }

  .change-btn-text {
    color: var(--content-text);
  }

  .logs-panel {
    max-height: 50vh;
    overflow: auto;
  }

  .device-info-overview-panel{
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
  }
</style>
<div class="door-n-logs content-panel">
  <div class="door-panel">
    <div class="dpanel-title">Door Status</div>
    <div class="dpanel-camera">
      <img class="stacked camera-img" src="/img/camera-img.png" alt="camera-img.png">
      <div class="stacked tight door-name">Door1</div>
    </div>
    <div class="dpanel-status">
      <details class="status-change-details" onmouseenter="this.open = true;" onmouseleave="this.open = false;">
        <summary class="grid"><img src="/img/<?php echo $doorStatus->svg ?>" alt="<?php echo $doorStatus->svg ?>"></summary>
        <div class="status-change">
          <a href="deviceAPIs/door/open-door.php" class="status-change-btn un-a">
            <img class="change-btn-svg" src="/img/lock-locked.svg" alt="lock-locked.svg">
            <div class="change-btn-text">Open</div>
          </a>
          <a href="deviceAPIs/door/close-door.php" class="status-change-btn un-a">
            <img class="change-btn-svg" src="/img/lock-unlocked.svg" alt="lock-unlocked.svg">
            <div class="change-btn-text">Close</div>
          </a>
          <a href="deviceAPIs/door/remain-open.php" class="status-change-btn un-a">
            <img class="change-btn-svg" src="/img/door-open.svg" alt="door-open.svg">
            <div class="change-btn-text">Remain open</div>
          </a>
          <a href="deviceAPIs/door/remain-closed.php" class="status-change-btn un-a">
            <img class="change-btn-svg" src="/img/door-controlled.svg" alt="door-controlled.svg">
            <div class="change-btn-text">Remain closed</div>
          </a>
        </div>
      </details>
      <div class="dpanel-status-text align"><?php echo $doorStatus->text ?></div>
    </div>
  </div>
  <div style="background-color: lightgray"></div>
  <div class="logs-panel">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/home-event.php'; ?>
  </div>

</div>
<div class="content-panel">
  Person Information
  <?php
  $response = userAccessMethods($host);
  $numberOfusersWithAccessMethod = new NumberOfUsersWithAccessMethod($response);
  print_r($numberOfusersWithAccessMethod);
  ?>
</div>
<div class="content-panel device-info-overview-panel">
  <div>
    Network Status
  </div>
  <div>
    Basic information
  </div>
  <div>
    Device Capacity
    <?php
    $AccessMethodCounts = new AccessMethodCounts($response);
    print_r($AccessMethodCounts);
    echo '<br>';
    $numberOfEvents = fetchAcsEventTotalNum($host);
    print_r('numberOfEvents: ' . $numberOfEvents . '<br>');
    ?>
  </div>
</div>