<?php

namespace controleur;

use config\ReturnENUM;
use Exception;
use modeles\AdminModel;
use modeles\LogModel;

class AdminController
{
    /**
     * AdminController constructor.
     */
    public function __construct()
    {
        global $rep, $vues, $DATA_VUE;
        $DATA_VUE['page'] = "private";
    }

    public function logs($params): void
    {
        global $rep, $vues, $DATA_VUE;
        $DATA_VUE['page'] = "logs";
        try {
            $mod = new LogModel();
            $tabTodolistLogs = $mod->FindAllTodolistLogs();
            $tabTodoLogs = $mod->FindAllTodoLogs();
            $tabUserLogs = $mod->FindAllUserLogs();
            $dataVue = array();
            require($rep . $vues['Admin']);
        } catch (Exception $ex) {
            ReturnENUM::handleEnum(ReturnENUM::ERROR_500);
        }
    }
}