<tr>
  <td><?php echo $logRow->employeeID ?></td>
  <td><?php echo htmlspecialchars($logRow->name) ?></td>
  <td><?php echo htmlspecialchars($logRow->cardNum) ?></td>
  <td><?php echo htmlspecialchars($logRow->eventType) ?></td>
  <td><?php echo htmlspecialchars($logRow->time) ?></td>
  <td class='img-icon-holder'>
  <a href="<?php echo $logRow->operation ?>">
    <img class='img-icon' src='./img/face-auth-img.svg'>
  </a>
  </td>
</tr>