<?php
    include '../model/connexion_bdd_ajax.php';
    ($_POST['mode'])?$mode=$_POST['mode']:$mode=0;
    /* Interact modes :
    1 - Insert new project
    2 - Insert new team
    3 - Insert new member to team
    4 - Delete team and managing team diags
    5 - Leave team */

    // 2 - Insert new team
    if ($mode==2 and $_POST['user']!=null and $_POST['name']!=null){
        $newTeam=createNewTeam($_POST['name'], $bdd);
        addNewMember($_POST['user'], $newTeam, $bdd);
        echo $newTeam;
        exit();
    }

    // Permission check for team manipulation
    // The user can only manage team stuff if he/she is in the team
    $vladimir=isInTeamID(htmlspecialchars($_POST['user']), htmlspecialchars($_POST['team']), $bdd);
    $poutine=$vladimir->fetch();
    if(($_POST['team']!=0 and $poutine['I_exist']==1) or $_POST['team']==0){

        // 1 - Insert new project
        if ($mode==1 and $_POST['user']!=null and $_POST['name']!=null and $_POST['visi']!=null and $_POST['team']!=null){
            createDiag($_POST['user'],$_POST['name'],$_POST['desc'],$_POST['visi'],$_POST['team'],$bdd);
            exit();
        }

        // 3 - Insert new member to team 
        if ($mode==3 and $_POST['user']!=null and $_POST['team']!=null and $_POST['name']!=null){
            $isIn=isInTeamID(htmlspecialchars($_POST['user']), $_POST['team'], $bdd);
            $letsCheck=$isIn->fetch();
            if($letsCheck['I_exist']==0){
                $user=getFromNickName(htmlspecialchars($_POST['user']),$bdd);
                $userId=$user->fetch();
                addNewMember($userId['id_user'],$_POST['team'], $bdd);
                exit();
            }
            else{
            }
        }

        // 4 - Delete team and managing team diags
        if ($mode==4 and $_POST['submode']!=null and $_POST['user']!=null and $_POST['team']!=null){
            deleteTeam($_POST['team'],$bdd);
            removeAllAffilFromTeam($_POST['team'],$bdd);
            // Deleting all team diags
            if($_POST['submode']==1){
                deleteDiagFromTeam($_POST['team'],$bdd);
            }
            // Moving all team diags to the user who's doing the request
            else if ($_POST['submode']==2){
                updateAllDiagsToPersonal($_POST['user'],$_POST['team'],$bdd);
            } 
        }

        // 5 - Leave team
        if ($mode==5 and $_POST['user']!=null and $_POST['team']!=null){
            $ifAlone=teamMembers(1,$bdd);
            // Deleting all team diags if only 1
            if($ifAlone->rowCount()==1){
                deleteDiagFromTeam($_POST['team'],$bdd);
                deleteTeam($_POST['team'],$bdd);
            }
            removeUserFromTeam($_POST['user'],$_POST['team'],$bdd);
        }
    }