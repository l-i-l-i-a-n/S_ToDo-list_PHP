<html>
    <head>
        <link rel="stylesheet" type="text/css" href="/styling/style-main.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/8100626722.js" crossorigin="anonymous"></script>
    </head>

	<body>
        <?php
            global $vues;
            $DATA_VUE['isInscription'] = true;
            require($vues['header']);
        ?>
            
        <div class="container card" style="width: 25rem; background-color: #f7f7f7; margin-top: 8rem; padding-top: 1rem;">
            <h1 style="align-self: center;">Sign up</h1>
            <form  method="post" action="/guest/inscription">
                <div class="form-group">
                  <label for="inputPseudo">Pseudo</label>
                  <?php
                    global $DATA_VUE;
                    if(isset($DATA_VUE) && isset($DATA_VUE['ERR_pseudo'])){
                  ?>
                  <span class="badge badge-pill badge-danger"><?=$DATA_VUE['ERR_pseudo']?></span>
                  <?php
                    }
                  ?>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                        </div>

                        <input type="text" required="true" value="<?=(isset($DATA_VUE) && isset($DATA_VUE['pseudoTMP'])) ? $DATA_VUE['pseudoTMP'] : ""?>" minlength="<?=(isset($INIT_PARAMS) && isset($INIT_PARAMS['pseudoMinLen']))?$INIT_PARAMS['pseudoMinLen']:3?>" maxlength="<?=(isset($INIT_PARAMS) && isset($INIT_PARAMS['pseudoMaxLen']))?$INIT_PARAMS['pseudoMaxLen']:20?>" class="form-control" id="inputPseudo" name="inputPseudo" placeholder="Pseudo">
                    </div>
                    <small id="emailHelp" class="form-text text-muted">Il vous servira à vous connecter.</small>
                </div>
                <div class="form-group">
                  <label for="inputPassword">Password</label>
                  <?php
                    global $DATA_VUE;
                    if(isset($DATA_VUE) && isset($DATA_VUE['ERR_password'])){
                  ?>
                  <span class="badge badge-pill badge-danger"><?=$DATA_VUE['ERR_password']?></span>
                  <?php
                    }
                  ?>
                  
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                        </div>
                        <input type="password" required="true" minlength="3" class="form-control" id="inputPassword" name="inputPassword" placeholder="Password">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputConfirmPassword">Confirm password</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                        </div>
                        <input type="password" required="true" minlength="3" class="form-control" id="inputConfirmPassword" name="inputConfirmPassword" placeholder="Confirm Password">
                    </div>
                </div>
                <div class="container" style="text-align: center;">
                    <button type="submit" class="btn btn-primary w-75">S'inscrire</button>
                </div>
              </form>
        </div>
	</body>
</html>