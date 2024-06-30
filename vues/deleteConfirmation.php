<html>
    <head>
        <link rel="stylesheet" type="text/css" href="/styling/style-main.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>

    <body>
        <?php
            global $vues, $DATA_VUE;
            if(isset($DATA_VUE)){
                $DATA_VUE['isInAccountPage'] = true;
            }
            require($vues['header']);
        ?>
        <div class="container card" style="width: 25rem; background-color: #f7f7f7; margin-top: 8rem; padding-top: 1rem;">
            <form method="post" action="/guest/connect">
                <label> You are going to delete your account, and all your private lists! Are you sure ?</label>
                
                <a role="button" href="/user/deleteAccount" class="btn btn-danger" style="color: white;">Yes Delete My Account</a>
                <a role="button" href="/" class="btn btn-success" style="color: white; float: right;">Cancel</a>
            </form>
        </div>
    </body>
</html>