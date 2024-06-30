<html>
    <head>
        <link rel="stylesheet" type="text/css" href="/styling/style-main.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/8100626722.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <?php
            global $vues,$DATA_VUE;
            if(isset($DATA_VUE)){
                $DATA_VUE['isInAccountPage'] = true;
            }
            require($vues['header']);
        ?>
        <?php
            global $DATA_VUE;
            if(isset($DATA_VUE) && isset($DATA_VUE['accountAlert'])){
        ?>
        <div class="container">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Great !</strong> <?=$DATA_VUE['accountAlert']?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        <?php
            }
        ?>
        <div class="container card" style="width: 25rem; background-color: #f7f7f7; margin-top: 8rem; padding-top: 1rem;">
            <h1 style="align-self: center;">My Account</h1>
            <form method="post" action="/user/updatePseudo">
                <label for="inputPseudo" style="font-weight: bold;">Pseudo
                    <?php
                        global $DATA_VUE;
                        
                        if(isset($DATA_VUE) && isset($DATA_VUE['pseudoERR'])){
                    ?>
                    <span class="badge badge-pill badge-danger"><?=$DATA_VUE['pseudoERR']?> </span>
                    <?php
                        }
                    ?>
                </label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                    </div>
                    <input name="inputPseudo" type="text" class="form-control" id="inputPseudo" value="<?php 
                        global $ACTIVE_USER;
                        if(isset($ACTIVE_USER) && isset($ACTIVE_USER['login'])){
                            echo $ACTIVE_USER['login'];
                        }
                        else{
                            echo 'error 500';
                        }
                    ?>">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit" id="button-addon2">Update pseudo</button>
                    </div>
                </div>
                
            </form>
            <div class="dropdown-divider"></div>
            <form method="post" action="/user/updatePassword">
                <div class="form-group">
                    <label for="inputPassword" style="font-weight: bold;">New Password (min: 5 char)
                        <?php
                            global $DATA_VUE;
                            if(isset($DATA_VUE) && isset($DATA_VUE['passwordERR'])){
                        ?>
                        <span class="badge badge-pill badge-danger"><?= $DATA_VUE['passwordERR']?></span>
                        <?php
                            }
                        ?></label>
                    
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                        </div>
                        <input name="inputPassword" minlength="5" type="password" class="form-control" id="inputPassword" placeholder="enter a new password"/>
                    </div>
                    <label for="inputPassword" style="font-weight: bold;">Confirm your new password (min: 5 char)</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                        </div>
                        <input name="inputPasswordConf" minlength="5" type="password" class="form-control" id="inputPassword" placeholder="enter a new password again"/>
                    </div>
                </div>
                <button type="submit" href="/user/updateAccount" class="btn btn-primary" style="float:right;">Update password</button>
            </form>
            <div class="dropdown-divider"></div>
            <a role="button" href="/user/deleteConfirmation" class="btn btn-danger" style="width: fit-content;color: white; margin-bottom: 1rem;">Delete account</a>
        </div>
        
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>