<?php
    include '../model/connexion_bdd_ajax.php';
    ($_POST['mode'])?$mode=$_POST['mode']:$mode=0;
    /* Interact modes :
    1 - Insert new project
    2 - Insert new team */

    if ($mode==1 and $_POST['user']!=null and $_POST['name']!=null and $_POST['desc']!=null and $_POST['team']!=null){
        createDiag($_POST['user'],$_POST['name'],$_POST['desc'],$_POST['team'],$bdd);
        exit();
    }