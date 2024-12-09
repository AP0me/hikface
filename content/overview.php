<?php require_once $_SERVER['DOCUMENT_ROOT'].'/door/get-status.php'; ?>
<?php
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
  .content-panel {
    padding: 20px;
    height: max-content;
    box-sizing: border-box;
    background-color: var(--content-bg);
  }

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
    height: 144px;
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

  .status-change{
    position: absolute;
    display: grid;
    grid-template-columns: 1fr;
    padding: 10px;
    background-color: var(--content-bg);
    box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.2);
    width: 200px;
    transform: translate(72px, calc(-50% - 25px));
  }
  .status-change-btn{
    display: grid;
    grid-template-columns: max-content auto;
    padding: 5px 10px;
    background-color: white;
    transition: background-color 0.1s ease-in-out;
    gap: 10px;
  }
  .status-change-btn:hover{
    background-color: lightgray;
  }
  .change-btn-svg{
    width: 20px;
    height: 20px;
    justify-self: center;
    align-self: center;
  }
  .change-btn-text{
    color: var(--content-text);
  }
</style>
<div class="door-n-logs content-panel">
  <div class="door-panel">
    <div class="dpanel-title">Door Status</div>
    <div class="dpanel-camera">
      <img class="stacked" src="/img/camera-img.png" alt="camera-img.png">
      <div class="stacked tight door-name">Door1</div>
    </div>
    <div class="dpanel-status">
      <details class="status-change-details" onmouseenter="this.open = true;" onmouseleave="this.open = false;">
        <summary class="grid"><img src="/img/<?php echo $doorStatus->svg ?>" alt="<?php echo $doorStatus->svg ?>"></summary>
        <div class="status-change">
          <a href="/door/open-door.php" class="status-change-btn un-a">
            <img class="change-btn-svg" src="/img/lock-locked.svg" alt="lock-locked.svg">
            <div class="change-btn-text">Open</div>
          </a>
          <a href="/door/close-door.php" class="status-change-btn un-a">
            <img class="change-btn-svg" src="/img/lock-unlocked.svg" alt="lock-unlocked.svg">
            <div class="change-btn-text">Close</div>
          </a>
          <a href="/door/remain-open.php" class="status-change-btn un-a">
            <img class="change-btn-svg" src="/img/door-open.svg" alt="door-open.svg">
            <div class="change-btn-text">Remain open</div>
          </a>
          <a href="/door/remain-closed.php" class="status-change-btn un-a">
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

  </div>
</div>