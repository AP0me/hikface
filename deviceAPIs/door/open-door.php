<?php require_once $_SERVER['DOCUMENT_ROOT'].'/hostname.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/deviceAPIs/door/door-command.php'; ?>
<?php
// Example usage
doorCommand($host, 'open', '../index.php?side=overview');