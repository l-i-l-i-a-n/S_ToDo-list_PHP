<?php
    global $DATA_VUE;
    if(isset($DATA_VUE)){
        if(isset($DATA_VUE['ERR_ps_pw'])){
            $alert = $DATA_VUE['ERR_ps_pw'];
        }
    }
    $DATA_VUE['isConnexion'] = true;
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="/styling/style-main.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/8100626722.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <?php
            global $vues;
            require($vues['header']);
        ?>
        <?php
            if(isset($alert)){
        ?>
        <div class="container">
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="background-color: #ff3e4f !important;">
                <strong>ERREUR : </strong> <?=$alert ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        <?php 
            }
        ?>
        <div class="container card" style="width: 25rem; background-color: #f7f7f7; margin-top: 8rem; padding-top: 1rem;">
            <h1 style="align-self: center;">Sign in</h1>
            <form method="post" action="/guest/connect">
                <label for="inputPseudo">Pseudo</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                    </div>
                    
                    <input name="inputPseudo" required="true" type="text" class="form-control" id="inputPseudo" placeholder="Enter your pseudo">
                </div>
                <label for="inputPassword">Password</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                    </div>
                    
                    <input name="inputPassword" required="true" type="password" class="form-control" id="inputPassword" placeholder="Enter your password">
                </div>
                <div class="container p-0" style="text-align: center; margin-top: 1.5rem;">
                    <button type="submit" class="btn btn-primary w-100">Sign In</button>
                </div>
                
                    
                
            </form>
        </div>
        
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>