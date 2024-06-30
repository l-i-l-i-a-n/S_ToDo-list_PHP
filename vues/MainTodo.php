<html>
<head>
    <link rel="stylesheet" type="text/css" href="/styling/style-main.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/8100626722.js" crossorigin="anonymous"></script>
</head>

<body>
<?php
global $vues, $DATA_VUE, $ACTIVE_USER;

require($vues['header']);
?>
<div class="bg-dark-grey-custom" style="padding-bottom: 3.2em !important;">
    <?php
    require($vues['errorPopUp']); ?>
    <div class="d-flex justify-content-start padding-lists listsDiv">
        <?php
        if (isset($tabLists)) {
            if (empty($tabLists)) echo "<div style='color: white; text-align: center; width: 100%; position: fixed; top: 0; left: 0; height: 100%; transform: translateY(50%);'>Il n'y a aucune liste ici actuellement</div>";
            foreach ($tabLists as $list) {
                require($rep . $vues['TodoList']);
            }
        } else{
            $DATA_VUE['alert'] = "error";
        }
        ?>
    </div>
</div>
<?php
require($vues['footer']);
?>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
<script>
    $(function () {
        $('[data-toggle="popover"]').popover()
    });
    $('.popover-dismiss').popover({
        trigger: 'focus'
    });
</script>

<script
        src="https://code.jquery.com/jquery-3.4.1.js"
        integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
        crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(function () {
        let hasUpdated = false;
        let oldListId;
        let newListId;
        $(".column").sortable({
            connectWith: ".column",
            handle: ".portlet-header",
            placeholder: "portlet-placeholder ui-corner-all",

            stop: function (event, ui) {
                console.log("STOP");
                const todoId = $(this).data().uiSortable.currentItem[0].id;
                //console.log(todoId);
                if (todoId !== undefined && newListId !== undefined) {
                    console.log("old list : " + oldListId);
                    console.log("new list : " + newListId);
                    window.location.href = `/guest/dragDropTodo/${todoId}/${newListId}`;
                }
            },
            update: function (event, ui) {
                if (!hasUpdated) {
                    hasUpdated = true;
                    oldListId = event.target.id;
                    //console.log("old list : " + oldListId);
                } else {
                    newListId = event.target.id;
                    //console.log("new list : " + newListId);
                }
                console.log("UPDATE");
            }
        });
    });
</script>
</body>
</html>
