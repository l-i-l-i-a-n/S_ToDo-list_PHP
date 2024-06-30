<?php
global $INIT_PARAMS, $DATA_VUE, $ACTIVE_USER;

$titleMinLen = 1;
$titleMaxLen = 20;
$todoMinLen = 1;
$todoMaxLen = 20;
if (isset($INIT_PARAMS)) {
    $titleMinLen = $INIT_PARAMS['titleMinLen'];
    $titleMaxLen = $INIT_PARAMS['titleMaxLen'];
    $todoMaxLen = $INIT_PARAMS['todoMaxLen'];
    $todoMinLen = $INIT_PARAMS['todoMinLen'];
}
$pageVue=1;
if(isset($page)){
    $pageVue = $page;
}

$listId = -1;
$titleList = "";
$listIdUser = -1;
$listIsPublic = false;
if (isset($list)) {
    $listId = $list->getId();
    $titleList = $list->getTitle();
    $listIdUser = $list->getIdUser();
    $listIsPublic = $list->isPublic();
}
?>
<?php
if (isset($list) && isset($ACTIVE_USER) && isset($ACTIVE_USER['role']) && $ACTIVE_USER['role'] != 'guest' && $ACTIVE_USER['uid'] == $listIdUser) {
    ?>
    <h6>
        <span class="badge badge-pill badge-secondary list-ispublic-badge"><?= $listIsPublic ? "Public" : "Private" ?></span>
    </h6>
    <?php
    /* INTERACTIVE BUTTON VERSION
        <form method="post" action="/user/switchIsPublic">
            <input type="hidden" name="idList" value="<?= $list->getId() ?>"/>
            <button type="submit"
                    class="badge badge-pill badge-secondary list-ispublic-badge"><?= $list->isPublic() ? "Public" : "Private" ?>
            </button>
        </form>
    */
    ?>
    <?php
}
?>
<div class="list-group w-25-custom m-0 p-0 px-2 my-1 todoList">
    <div class="container bg-lightdark-grey">
        <div class="row">
            <div class="col">
                <?php
                if (isset($DATA_VUE) && isset($DATA_VUE['isEditTitle']) && !empty($DATA_VUE['isEditTitle']) && $DATA_VUE['isEditTitle'] == $listId) {
                    ?>
                    <form method="post"
                          action="<?= (isset($DATA_VUE) && isset($DATA_VUE['page']) && $DATA_VUE['page'] != "private") ? '/guest/publicEditTitle/' : '/user/privateEditTitle/' ?><?=$pageVue?>">
                        <div class="input-group mb-3" style="margin-top: 1rem;">
                            <input type="text" minlength="<?= isset($titleMinLen) ? $titleMinLen : 1 ?>"
                                   maxlength="<?= isset($titleMaxLen) ? $titleMaxLen : 20 ?>" name="title"
                                   class="form-control" placeholder="insérer un titre"
                                   aria-label="Title" aria-describedby="basic-addon2"
                                   value="<?= $titleList ?>"/>
                            <input type="hidden" name="idList" value="<?= $listId ?>"/>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-check"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <?php
                } else {
                    ?>
                    <h4 class='text-capitalize list-group-item active d-flex bg-lightdark-grey border-0'
                        style="z-index: auto; padding-left: 0;">
                        <a class="popover-dismiss" tabindex="0" role="button" data-toggle="popover" data-placement="top"
                           data-content="<?= $titleList ?>"
                           style="color:#76b8ff!important;">
                            <?php
                            if (isset($list)) {
                                echo '| ' . (strlen($titleList) > 20 ? substr($titleList, 0, 20) . ".." : $titleList);
                            } else {
                                echo 'none';
                            }
                            ?>
                        </a>
                    </h4>
                    <?php
                }
                ?>

            </div>
            <div class="col-auto" style="align-self: center;">
                <div class="m-0 p-0 " style="width: min-content;">
                    <div class="row">
                        <div class="col-sm">
                            <div class="dropdown">
                                <a class="btn btn-secondary dropdown-toggle" href="#" role="button"
                                   id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                   aria-expanded="false">
                                    <i class="fas fa-bars"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                    <form class="todolist-tools-form" method="post"
                                          action="<?= (isset($DATA_VUE) && isset($DATA_VUE['page']) && $DATA_VUE['page'] == "private") ? "/user/showPrivate" : "/guest/showPublic" ?>EditTitle/<?=$pageVue?>">
                                        <input type="hidden" name="idList" value="<?= $listId ?>"/>
                                        <button type="submit" class="dropdown-item"><i class="fas fa-pen"></i> Change
                                            Title
                                        </button>
                                    </form>
                                    <?php
                                    if (isset($list) && isset($ACTIVE_USER) && isset($ACTIVE_USER['role']) && $ACTIVE_USER['role'] != 'guest') {
                                        if ($listIdUser == $ACTIVE_USER['uid']) {
                                            ?>
                                            <form method="post" action="/user/switchIsPublic/<?=$pageVue?>"
                                                  class="todolist-tools-form">
                                                <input type="hidden" name="idList" value="<?= $listId ?>"/>
                                                <button type="submit"
                                                        class="dropdown-item">
                                                    <i class="fas fa-arrow-down"></i>Turn <?= $listIsPublic ? "Private" : "Public" ?>
                                                </button>
                                            </form>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <form class="todolist-tools-form" method="post" action="<?php
                                    if (isset($ACTIVE_USER) && isset($ACTIVE_USER['role']) && isset($list)) {
                                        if ($listIsPublic) {
                                            echo '/guest/delPublicList/'.$pageVue;
                                        } else {
                                            if ($ACTIVE_USER['role'] == 'user' || $ACTIVE_USER['role'] == 'admin') {
                                                echo '/user/delPrivateList/'.$pageVue;
                                            } else {
                                                echo '/';
                                            }
                                        }
                                    } else {
                                        echo '/';
                                    }
                                    ?>">
                                        <input type="hidden" name="idList" value="<?= $listId ?>"/>
                                        <input type="hidden" name="page" value="<?php
                                        $oldNbPages = $nbPages;
                                        $newNbPages = ceil(($nbLists - 1) / $limit);
                                        if ($newNbPages < 1)
                                            echo "1";
                                        elseif ($newNbPages == $oldNbPages)
                                            echo $page;
                                        elseif ($newNbPages < $oldNbPages && $page == $oldNbPages)
                                            echo $newNbPages;
                                        else
                                            echo $page;
                                        ?>"/>

                                        <button type="submit" class="dropdown-item"><i class='fa fa-trash'></i>
                                            Supprimer
                                        </button>
                                    </form>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="<?= $listId ?>" class="border-todos bg-dark-custom todos-scrollable column">
            <?php
            if (isset($list)) {
                $todos = $list->getTodos();
                if (empty($todos) || !isset($todos)) {
                    ?>
                    <li class="list-group-item d-flex justify-content-around">Cette liste de todos est vide</li>
                    <?php
                } else {
                    foreach ($todos as $todo) {
                        require($rep . $vues['todo']);
                    }
                }
            } else {
                ?>
                <li class="list-group-item d-flex justify-content-around">
                    Cette liste de todos est vide
                </li>
                <?php
            }
            ?>
        </div>

        <div class='list-group-item bg-lightdark-grey border-0'>
            <form class='d-flex justify-content-between m-0 todolistAdd' method='post' action="<?php
            if (isset($DATA_VUE) && isset($DATA_VUE['page'])) {
                if ($DATA_VUE['page'] == 'public') {
                    echo '/guest/addPublicTodo/'.$pageVue;
                } else {
                    echo '/user/addPrivateTodo/'.$pageVue;
                }
            } else {
                echo '/';
            }
            ?>">
                <input type='text' maxlength="<?= isset($todoMaxLen) ? $todoMaxLen : 20 ?>"
                       minlength="<?= isset($todoMinLen) ? $todoMinLen : 1 ?>" class='form-control' name='descript'
                       id='submitTodo'
                       placeholder='Entrer une nouvelle mission'>
                <input type="hidden" name="idList" value="<?= $listId ?>"/>
                <button type='submit' class='btn btn-dark-custom mx-3-custom btnSubmit'>Submit</button>
            </form>
        </div>
    </div>
</div>
