<?php
global $ACTIVE_USER, $DATA_VUE;
?>
<header class="bg-blue-custom">
    <nav class="navbar navbar-dark navbar-expand-lg bg-dark">
        <!-- w-100 -0 m-0 navbar  navbar-light-->
        <a class="navbar-brand" href="/"><i class="fas fa-list-ul"></i> ToutDoux List</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item <?php if (isset($DATA_VUE) && isset($DATA_VUE['page']) && $DATA_VUE['page'] == 'public') {
                    echo 'active';
                } ?>">
                    <a class="nav-link" href="/guest/publiclists">Public lists<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item <?php if (isset($DATA_VUE) && isset($DATA_VUE['page']) && $DATA_VUE['page'] == 'private') {
                    echo 'active';
                } ?>">
                    <a class="nav-link" href="/user/privatelists">Private lists</a>
                </li>
                <?php
                if ($ACTIVE_USER['role'] == "admin") {
                    ?>
                    <li class="nav-item <?php if (isset($DATA_VUE) && isset($DATA_VUE['page']) && $DATA_VUE['page'] == 'logs') {
                        echo 'active';
                    } ?>">
                        <a class="nav-link" href="/admin/logs">Logs</a>
                    </li>
                    <?php
                }
                ?>
            </ul>
            <?php
                if ($DATA_VUE['page'] != "logs" && $DATA_VUE['page'] != "account" && !isset($DATA_VUE['isConnexion']) && !isset($DATA_VUE['isInscription']) && !isset($DATA_VUE['isInAccountPage'])) {
                    ?>
                    <div id="headerCenter">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalAjoutListe">
                            Ajouter une liste <?php
                                echo(isset($DATA_VUE) && $DATA_VUE['page'] == 'private' ? 'privée' : 'publique');
                                ?>
                          </button>

                          <!-- Modal -->
                          <div class="modal fade" id="ModalAjoutListe" tabindex="-1" role="dialog" aria-labelledby="Ajout liste" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel" style="margin:auto;">Ajouter une liste <?php
                                echo(isset($DATA_VUE) && $DATA_VUE['page'] == 'private' ? 'privée' : 'publique');
                                ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-left:0px;">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                    <form class="px-4 py-3 m-0" method="post" action="
                                        <?php
                                        global $ACTIVE_USER;
                                        if (isset($DATA_VUE) && isset($DATA_VUE['page'])) {
                                            if ($DATA_VUE['page'] == 'private') {
                                                echo '/user/addPrivateList';
                                            } else {
                                                echo '/guest/addPublicList';
                                            }
                                        } else {
                                            echo '/';
                                        }
                                        ?>">
                                            <div class="form-group">
                                                <label for="submitList">Titre</label>
                                                <input type="hidden" name="page" value="<?php
                                                if (isset($nbLists) && isset($limit) && isset($nbPages)) {
                                                    echo ($nbLists >= $limit * $nbPages) ? ($nbPages + 1) : ($nbPages);
                                                } else {
                                                    echo '0';
                                                }
                                                ?>"/>
                                                <input type='text' required="true" class='form-control' name='listTitle' id='submitList'
                                                       placeholder='Entrer un titre'>
                                            </div>
                                        <div class="modal-footer" style="justify-content:center;">
                                            <button type="submit" class="btn btn-blue-custom" style="width:75%;">Ajouter</button>
                                            </div>
                                    </form>
                                </div>
                                
                              </div>
                            </div>
                          </div>
                    </div>
                <?php
                }
                ?>
                <div id="headerCompte" class="d-flex">
                    <?php
                    if (isset($ACTIVE_USER) && isset($ACTIVE_USER['role']) && $ACTIVE_USER['role'] == 'guest' && isset($ACTIVE_USER['login'])) {
                        ?>
                        <a role="button" class="btn btn-outline-primary btn-connexion" href="/guest/signIn"
                           style="margin-right: 1rem;">Sign in</a>
                        <a role="button" class="btn btn-outline-light" href="/guest/inscription">Sign up</a>
                        <?php
                    } else { // si le role est user :
                        ?>
                        <a role="button" class="btn btn-light btn-outline-dark mx-3-custom headerBtn"
                           href="/user/disconnect">Sign out (<?= $ACTIVE_USER['login'] ?>)
                        </a>
                        <a role="button" class="btn btn-dark-custom btn-outline-dark headerBtn" href="/user/account">
                            Mon compte (<?= $ACTIVE_USER['login'] ?>)
                        </a>
                        <?php
                    }
                    ?>
                </div>
        </div>
    </nav>
</header>