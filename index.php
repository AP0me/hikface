<?php require_once  $_SERVER['DOCUMENT_ROOT'] . '/assets/css/root-css.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>


<style>
  .bodygrid {
    display: grid;
    grid-template-rows: max-content auto;
    height: 100vh;
    width: 100%;
    margin: 0;
    background-color: var(--content-bg);
    color: var(--content-text);
    font-family: Arial, Helvetica, sans-serif;
  }

  .navbar {
    padding: 20px;
    background-color: var(--navbar-bg);
    color: var(--navbar-text);
    user-select: none;
  }

  .pagemiddle {
    display: grid;
    grid-template-columns: max-content auto;
    background-color: var(--content-bg);
  }

  .content{
    display: grid;
    padding: 20px;
    background-color: var(--content-wrap-bg);
  }
</style>

<body class="bodygrid">
  <div class="navbar">
    HIKVISION
  </div>
  <div class="pagemiddle">
    <?php require_once  $_SERVER['DOCUMENT_ROOT'] . '/sidebar.php'; ?>
    <div class="content">
      <?php
        switch ($_GET['side']) {
          case 'overview':
            require $_SERVER['DOCUMENT_ROOT'].'/content/overview.php';
            break;
          case 'account':
            require $_SERVER['DOCUMENT_ROOT'].'/content/account.php';
            break;
          case 'logs':
            require $_SERVER['DOCUMENT_ROOT'].'/content/logs.php';
            break;
          case 'configuration':
            require $_SERVER['DOCUMENT_ROOT'].'/content/configuration.php';
            break;
          case 'maintenance':
            require $_SERVER['DOCUMENT_ROOT'].'/content/maintenance.php';
            break;
          default:
            require $_SERVER['DOCUMENT_ROOT'].'/content/overview.php';
            break;
        }
      ?>
    </div>
  </div>
</body>

</html>