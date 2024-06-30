<?php
if (!isset($log)) {
    ?>
    <div>ERROR : log does not exist</div>
    <?php
} else {
    ?>
    <tr>
        <td><?=$log->getDate()->format('Y-m-d')?></td>
        <td><?=$log->getAction()?></td>
        <td><?=$log->getTodo()->getId()?></td>
        <td><?=$log->getTodo()->getDescription()?></td>
        <td><?=$log->getTodo()->getIsDone()?></td>
        <td><?=$log->getTodo()->getIdList()?></td>
    </tr>
    <?php
}
?>