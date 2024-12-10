<style>
  .sidebar {
    display: grid;
    grid-template-rows: repeat(auto-fit, 1fr);
    align-content: baseline;
    background-color: var(--sidebar-bg);
    user-select: none;
  }

  .side-item {
    display: grid;
    grid-template-rows: max-content max-content;
    width: 90px;
    height: 90px;
    align-content: center;
    background-color: var(--sidebar-item-bg);
    color: var(--sidebar-text);
  }

  .side-item[chosen="yes"] {
    background-color: var(--sidebar-item-chosen);
    color: var(--navbar-text);
  }

  .side-item:hover {
    background-color: var(--sidebar-item-hover);
  }

  .side-item-img {
    display: grid;
  }

  .side-item-img>img {
    width: 30px;
    height: 30px;
    justify-self: center;
    filter: grayscale(100%);
  }

  .side-item:hover .side-item-img>img {
    filter: grayscale(0%);
  }

  .side-item-text {
    width: 100%;
    text-align: center;
    font-size: 14px;
    color: var(--sidebar-text);
  }
</style>
<div class="sidebar">
  <a href="/index.php?side=overview" class="side-item un-a" chosen="<?= ($side == 'overview') ? 'yes' : 'no' ?>">
    <div class="side-item-img">
      <img src="/img/presentation-chart.svg" alt="presentation-chart.svg">
    </div>
    <div class="side-item-text">Overview</div>
  </a>
  <a href="/index.php?side=account" class="side-item un-a" chosen="<?= ($side == 'account') ? 'yes' : 'no' ?>">
    <div class="side-item-img">
      <img src="/img/account.svg" alt="account.svg">
    </div>
    <div class="side-item-text">Person Management</div>
  </a>
  <a href="/index.php?side=logs" class="side-item un-a" chosen="<?= ($side == 'logs') ? 'yes' : 'no' ?>">
    <div class="side-item-img">
      
      <img src="/img/logs.svg" alt="logs.svg">
    </div>
    <div class="side-item-text">Event Search</div>
  </a>
  <a href="/index.php?side=configuration" class="side-item un-a" chosen="<?= ($side == 'configuration') ? 'yes' : 'no' ?>">
    <div class="side-item-img">
      <img src="/img/gear.svg" alt="gear.svg">
    </div>
    <div class="side-item-text">Configuration</div>
  </a>
  <a href="/index.php?side=maintenance" class="side-item un-a" chosen="<?= ($side == 'maintenance') ? 'yes' : 'no' ?>">
    <div class="side-item-img">
      <img src="/img/computer-sec.svg" alt="computer-sec.svg">
    </div>
    <div class="side-item-text">Maintenance and Security</div>
  </a>
</div>