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
        <td><?=$log->getList()->getId()?></td>
        <td><?=$log->getList()->getTitle()?></td>
        <td><?=$log->getList()->isPublic()?></td>
        <td><?=$log->getList()->getIdUser()?></td>
    </tr>
    <?php
}
?>