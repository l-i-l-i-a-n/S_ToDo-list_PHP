<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="/styling/style-main.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/8100626722.js" crossorigin="anonymous"></script>
</head>

<body>
<?php
global $vues;
require($vues['header']);
?>
<div class="bg-dark-grey-custom">
    <?php global $vues;
    require($vues['errorPopUp']); ?>
    <div class="list-group padding-lists">
        <div class="px-2 my-1 mb-2">
            <div class="bg-lightdark-grey m-0 p-0 pb-2 list-group-item">
                <h4 class='text-capitalize list-group-item active bg-lightdark-grey border-0 text-center'>Logs
                    Todolists</h4>
                <div class="table-responsive list-group-item bg-lightdark-grey m-0 px-0 pt-0 border-todos todos-scrollable padding-bottom-0">
                    <table class="table bg-white border-radius-custom m-0">
                        <?php
                        if (isset($tabTodolistLogs)) {
                            if (empty($tabTodolistLogs)) echo "<tr><td>No log</td></tr>";
                            else {
                                ?>
                                <thead>
                                <tr class="logHeader">
                                    <th scope="col">DATE</th>
                                    <th scope="col">ACTION</th>
                                    <th scope="col">LIST ID</th>
                                    <th scope="col">TITLE</th>
                                    <th scope="col">IS PUBLIC</th>
                                    <th scope="col">USER ID</th>
                                </tr>
                                </thead>
                                <?php
                            }
                            foreach ($tabTodolistLogs as $log) {
                                require($rep . $vues['TodolistLog']);
                            }
                        } else
                            $dataVue['errorPopUp'] = 'ERROR: unknown variable $tabTodolistLogs';
                        require($vues['errorPopUp']);
                        ?>
                    </table>
                </div>
            </div>
        </div>

        <div class="px-2 my-1 mb-2">
            <div class="bg-lightdark-grey m-0 p-0 pb-2 list-group-item">
                <h4 class='text-capitalize list-group-item active bg-lightdark-grey border-0 text-center'>Logs
                    Todos</h4>
                <div class="table-responsive list-group-item bg-lightdark-grey m-0 px-0 pt-0 border-todos todos-scrollable padding-bottom-0">
                    <table class="table bg-white border-radius-custom m-0">
                        <?php
                        if (isset($tabTodoLogs)) {
                            if (empty($tabTodoLogs)) echo "<tr><td>No log</td></tr>";
                            else {
                                ?>
                                <thead>
                                <tr class="logHeader">
                                    <th scope="col">DATE</th>
                                    <th scope="col">ACTION</th>
                                    <th scope="col">TODO ID</th>
                                    <th scope="col">DESCRIPTION</th>
                                    <th scope="col">IS DONE</th>
                                    <th scope="col">LIST ID</th>
                                </tr>
                                </thead>
                                <?php
                            }
                            foreach ($tabTodoLogs as $log) {
                                require($rep . $vues['TodoLog']);
                            }
                        } else
                            $dataVue['errorPopUp'] = 'ERROR: unknown variable $tabTodoLogs';
                        require($vues['errorPopUp']);
                        ?>
                    </table>
                </div>
            </div>
        </div>

        <div class="px-2 my-1 mb-1">
            <div class="bg-lightdark-grey m-0 p-0 pb-2 list-group-item">
                <h4 class='text-capitalize list-group-item active bg-lightdark-grey border-0 text-center'>Logs
                    Users</h4>
                <div class="table-responsive list-group-item bg-lightdark-grey m-0 px-0 pt-0 border-todos todos-scrollable padding-bottom-0">
                    <table class="table bg-white border-radius-custom m-0">
                        <?php
                        if (isset($tabUserLogs)) {
                            if (empty($tabUserLogs)) echo "<tr><td>No log</td></tr>";
                            else {
                                ?>
                                <thead>
                                <tr class="logHeader">
                                    <th scope="col">DATE</th>
                                    <th scope="col">ACTION</th>
                                    <th scope="col">USER ID</th>
                                    <th scope="col">PSEUDO</th>
                                </tr>
                                </thead>
                                <?php
                            }
                            foreach ($tabUserLogs as $log) {
                                require($rep . $vues['UserLog']);
                            }
                        } else
                            $dataVue['errorPopUp'] = 'ERROR: unknown variable $tabUserLogs';
                        require($vues['errorPopUp']);
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
/*
    global $vues;
    require($vues['footer']);
*/
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
</body>
</html>
