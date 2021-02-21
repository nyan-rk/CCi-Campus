<?php
    include '../model/connexion_bdd_ajax.php';
    ($_POST['mode'])?$mode=$_POST['mode']:$mode=0;
    //$mode=5;$task=1;$stack=4;

    /*Update modes :
    9 : Delete diag
    10 : Change diag team NOT DONE
    11 : Change diag creator/owner NOT DONE
    */
    
    // Future verification of access
    {

        // 9 : Delete diag
        if ($mode==9 and $_POST['diag']!=null){
            deleteDiagFromId($_POST['diag'],$bdd);
            exit();
        }

        if ($mode==10 and $_POST['diag']!=null AND $_POST['team']!=NULL){
            updateDiagTeam($_POST['diag'],$_POST['team'],$bdd);
            exit();
        }
    }