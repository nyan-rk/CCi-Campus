<?php
    include '../model/connexion_bdd_ajax.php';
    ($_POST['mode'])?$mode=$_POST['mode']:$mode=0;
    //$mode=5;$task=1;$stack=4;

    /*Update modes :
    9 : Delete diag
    10 : Change diag team
    11 : Change diag creator/owner
    12 : Change diag visibility
    */
    $checky=isInTeamOrCreator(htmlspecialchars($_POST['user']),htmlspecialchars($_POST['diag']),$bdd);
    $checkyMacCheckington=$checky->fetch();

    // Check of permission
    if($checkyMacCheckington['is_creator']==1)
    {

        // 9 : Delete diag
        if ($mode==9 and $_POST['diag']!=null){
            deleteDiagFromId($_POST['diag'],$bdd);
            exit();
        }

        // 10 : Change diag team
        if ($mode==10 and $_POST['diag']!=null AND $_POST['team']!=NULL){
            updateDiagTeam($_POST['diag'],$_POST['team'],$bdd);
            exit();
        }

        // 11 : Change diag creator/owner
        if ($mode==11 and $_POST['diag']!=null AND $_POST['newuser']!=NULL){
            updateDiagCreator($_POST['diag'],$_POST['newuser'],$bdd);
            exit();
        }

        // 12 : Change diag visibility
        if ($mode==12 and $_POST['diag']!=null AND $_POST['visi']!=NULL){
            updateDiagVisib($_POST['diag'], $_POST['visi'],$bdd);
            exit();
        }
    }