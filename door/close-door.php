<?php require_once $_SERVER['DOCUMENT_ROOT'].'/hostname.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/door/door-command.php'; ?>

<?php
doorCommand($host, 'close', '../index.php?side=overview');
