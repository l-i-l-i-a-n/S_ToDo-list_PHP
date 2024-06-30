<?php 
    global $DATA_VUE;
    if(isset($DATA_VUE['alert'])){
?>
        <div class="container">
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="background-color: #ff3e4f !important;">
                <strong>ERREUR : </strong> <?=$DATA_VUE['alert'] ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
<?php
    }
?>
