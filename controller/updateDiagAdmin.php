<?php
    include '../model/connexion_bdd_ajax.php';
    ($_POST['mode'])?$mode=$_POST['mode']:$mode=0;
    //$mode=5;$task=1;$stack=4;

    /*Update modes :
    9 : Delete diag NOT DONE
    10 : Change diag team NOT DONE
    11 : Change diag creator/owner NOT DONE
    */
    
    // 1 : Title update
    if ($mode==1 and $_POST['title']!=null){
        updateDiagName($_POST['diag'],htmlspecialchars($_POST['title']),$bdd);
        exit();
    }
