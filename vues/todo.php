<?php
$todoId = -1;
$descTodo = "ERROR";
$todoIdList = -1;
$todoIsDone = false;
if (isset($todo)) {
    $todoId = $todo->getId();
    $descTodo = $todo->getDescription();
    $todoIdList = $todo->getIdList();
    $todoIsDone = $todo->getIsDone();
}
?>
<div id="<?= $todoId ?>" class="portlet">
    <div class="list-group-item d-flex justify-content-between text-capitalize overflow-hidden portlet-header"
         style="line-height: 30px;">
        <div class="todoSpan ">
            <i class="fas fa-grip-vertical" style="margin-left:-10px; margin-right: 5px;"></i>
            <span class="todoSpan mr-3"
                  style="<?= $todoIsDone ? "text-decoration : line-through;" : "" ?>">
                <?= $descTodo ?>
            </span>
        </div>
        <?php
        if ($todoIsDone) {
        ?>
        <div class="row justify-content-end align-content-start"
             style="min-width:max-content; align-self: center; align-items: center;">
            <form method="post" action="<?php
            global $DATA_VUE;
            if (isset($DATA_VUE) && isset($DATA_VUE['page'])) {
                if ($DATA_VUE['page'] == "private") {
                    echo '/user/switchIsDonePrivate/' . ((isset($page)) ? $page : 0);
                } else {
                    echo '/guest/switchIsDone/' . ((isset($page)) ? $page : 0);
                }
            } else {
                echo '/';
            }
            ?>" class="m-0 p-0">
                <input type="hidden" name="idTodo" value="<?= $todoId ?>"/>
                <button type="submit" class="badge badge-pill badge-success"
                        style="margin-bottom: 3px;margin-right: 5px;">Done
                </button>
            </form>
            <?php
            }
            else {
            ?>
            <div class="row justify-content-end align-content-start" style="align-items: center;">
                <form method="post" action="<?php
                global $DATA_VUE;
                if (isset($DATA_VUE) && isset($DATA_VUE['page'])) {
                    if ($DATA_VUE['page'] == "private") {
                        echo '/user/switchIsDonePrivate/' . ((isset($page)) ? $page : 0);
                    } else {
                        echo '/guest/switchIsDone/' . ((isset($page)) ? $page : 0);
                    }
                } else {
                    echo '/';
                }


                ?>" class="m-0 p-0">

                    <input type="hidden" name="idTodo" value="<?= $todoId ?>"/>
                    <button type="submit" class="border-0 btn-transition btn btn-outline-success">
                        <i class="fa fa-check"></i>
                    </button>

                </form>
                <?php
                }
                ?>
                <form method="post" action="<?php
                global $DATA_VUE;
                if (isset($DATA_VUE) && isset($DATA_VUE['page'])) {
                    if ($DATA_VUE['page'] == "private") {
                        echo '/user/delPrivateTodo/' . ((isset($page)) ? $page : 0);
                    } else {
                        echo '/guest/delPublicTodo/' . ((isset($page)) ? $page : 0);
                    }
                } else {
                    echo '/';
                }
                ?>" class="m-0 p-0 ">
                    <input type="hidden" name="idTodo" value="<?= $todoId ?>"/>
                    <button type="submit" class="border-0 btn-transition btn btn-outline-danger">
                        <i class="fa fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>