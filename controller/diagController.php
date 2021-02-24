<?php
    $req=retrieveDiag(htmlspecialchars($_GET['d']),$bdd);
    $resultat = $req->fetch();
    //$_SESSION['id_user']=1;
    $user=(isset($_SESSION['id_user'])?$_SESSION['id_user']:0);
    $perm=canSee($_GET['d'],$resultat['vis_diag'],$resultat['team_affili'],$user,$resultat["id_creator"],$bdd);

    // Checks the level of permission a user has on the diag
    // if not connected, idUser=0
    /* 0 : can't see
        1 : can see but can't edit
        2 : can see and edit */
    function canSee($idDiag,$idVisi,$idTeam,$idUser,$idCrea,$db)
    {   
        //Personal diag case
        if($idTeam==0){
            // If not creator
            if ($idUser!=$idCrea){
                if($idVisi==1 or $idVisi==0) return 1 ;
                else return 0;
            }
            // then creator
            else return 2 ;
        }
        // Non-personal diag case
        else if ($idUser!=0){
            $isIn=isInTeamID($idUser,$idTeam, $db);
            $letsCheck=$isIn->fetch();
            // if in team
            if($letsCheck['I_exist']==1) return 2 ;
            // not in team but for connected users
            else if ($idVisi==1 or $idVisi==0) return 1;
            // connected users - private
            else return 0;
        }
        // then not connected
        else {
            if($idVisi==0) return 1;
            else return 0;
        }

    }

    // Show avatar
    function showAvatar($idCreator)
    {
        echo "<img id='avatar' draggable='false'";
        echo (file_exists('./upload/ava/'.$idCreator.'.jpg'))?"src='./upload/ava/".$idCreator.".jpg' >":"src='./upload/ava/0.jpg' >";
    }

    // Show button
    function menuButton($idCreator,$idUser,$idTeam,$visibDiag,$db)
    {
        if ($idCreator==$idUser){
            echo 
            "<div class='dropdown'>
            <button class='btn dropdown-toggle' type='button' id='menubutton' data-bs-toggle='dropdown' aria-expanded='false'>Menu</button>
                <ul class='dropdown-menu' aria-labelledby='menubutton'>
                    <li><a data-toggle='modal' data-target='#ModalDiagDelete' class='dropdown-item'>".DIAG['menudelete']."</a></li>
                    <li><a data-toggle='modal' data-target='#ModalTeamChange' class='dropdown-item'>".DIAG['menuchangeteam']."</a></li>";
                    if ($idTeam!=0) echo" <li><a data-toggle='modal' data-target='#MenuChangeCreator' class='dropdown-item'>".DIAG['menuchangecreator']."</a></li>";
                echo"<li><a data-toggle='modal' data-target='#ModalVisibChange' class='dropdown-item'>".DIAG['menuchangevis']."</a></li>
                 </ul>
            </div>
              
            <!-- Delete Diag Modal -->
            <div class='modal fade' id='ModalDiagDelete' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                <div class='modal-dialog modal-dialog-centered' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title'>".DIAG['modal1title']."</h5>
                        </div>
                        <div class='modal-body'>
                        ".DIAG['modal1body']."
                        </div>
                        <div class='modal-footer'>
                            <button type='button' id='DeleteDiagYes' class='btn btn-primary'>".DIAG['modal1yes']."</button>
                            <button type='button' id='DeleteDiagNo' class='btn btn-secondary'>".DIAG['modal1no']."</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Change team Modal -->
            <div class='modal fade' id='ModalTeamChange' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                <div class='modal-dialog modal-dialog-centered' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title'>".DIAG['modal2title']."</h5>
                        </div>
                        <div class='modal-body'>
                        ".DIAG['modal2body']." <strong id='teamInCharge'></strong><br>
                            <label for='teams'>".DIAG['modal2team']."</label>
                            <select id='teamList' name='teams'>
                                <option value='0'>".DIAG['modal2noteam']."</option>";
                                $myTeams=retrieveTeamsFromUser($idUser,$db);
                                while($teams = $myTeams->fetch())
                                if($teams['id_team']==$idTeam)
                                echo "<option selected='selected' value='".$teams['id_team']."'>".$teams['name_team']."</option>";
                                else
                                echo "<option value='".$teams['id_team']."'>".$teams['name_team']."</option>";
                            echo "</select>
                        </div>
                        <div class='modal-footer'>
                            <button type='button' id='ChangeTeamYes' class='btn btn-primary'>".DIAG['modal2yes']."</button>
                            <button type='button' id='ChangeTeamNo' class='btn btn-secondary'>".DIAG['modal2no']."</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Change diag creator modal -->
            <div class='modal fade' id='MenuChangeCreator' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                <div class='modal-dialog modal-dialog-centered' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title'>".DIAG['modal3title']."</h5>
                        </div>
                        <div class='modal-body'>
                        ".DIAG['modal3body']."<br>
                            <label for='members'>".DIAG['modal3admin']."</label>
                            <select id='memberList' name='members'>";
                                $myTeammates=teamMembers($idTeam,$db);
                                while($membs = $myTeammates->fetch())
                                if($membs['id_user']==$idUser)
                                echo "<option selected='selected' value='".$membs['id_user']."'>".$membs['nickname_user']."</option>";
                                else
                                echo "<option value='".$membs['id_user']."'>".$membs['nickname_user']."</option>";
                            echo "</select>
                        </div>
                        <div class='modal-footer'>
                            <button type='button' id='ChangeAdminYes' class='btn btn-primary'>".DIAG['modal3yes']."</button>
                            <button type='button' id='ChangeAdminNo' class='btn btn-secondary'>".DIAG['modal3no']."</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Change visibility Modal -->
            <div class='modal fade' id='ModalVisibChange' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                <div class='modal-dialog modal-dialog-centered' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title'>".DIAG['modal4title']."</h5>
                        </div>
                        <div class='modal-body'>
                        ".DIAG['modal4body']."<strong id='currentVis'></strong><br>
                            <label for='visib'>Visibilité :</label>
                            <select id='visibList' name='visib'>";
                                if($visibDiag==0) echo"<option selected='selected' value='0'>".DIAG['modal4option1']."</option>";
                                else echo "<option value='0'>".DIAG['modal4option1']."</option>";
                                if($visibDiag==1) echo"<option selected='selected' value='1'>".DIAG['modal4option2']."</option>";
                                else echo "<option value='1'>".DIAG['modal4option2']."</option>";
                                if($visibDiag==2){
                                    if ($idTeam==0) echo "<option selected='selected' value='2'>".DIAG['modal4option3bis']."</option>";
                                    else "<option selected='selected' value='2'>".DIAG['modal4option3']."</option>";
                                }
                                else{
                                    if ($idTeam==0) echo "<option value='2'>".DIAG['modal4option3bis']."</option>";
                                    else "<option value='2'>".DIAG['modal4option3']."</option>";
                                }
                            echo "</select>
                        </div>
                        <div class='modal-footer'>
                            <button type='button' id='ChangeVisibYes' class='btn btn-primary'>".DIAG['modal4yes']."</button>
                            <button type='button' id='ChangeVisibNo' class='btn btn-secondary'>".DIAG['modal4no']."</button>
                        </div>
                    </div>
                </div>
            </div>";
        }
    }

    // Display diagram
    function displayDiag($idDiag,$permi,$db)
    {
        //Display of columns
        $colCursor = stackDisplay($idDiag,$db);
        while($donnees=$colCursor->fetch()){
            echo "<div class='colo color".(($donnees['order_stack']-1)%4 + 1)."'><svg class='noteholes' width='288px' height='33px'><use href='./public/images/diag/note.svg#holes'></use></svg>";
            if ($permi==2) echo "<i class='fas fa-times closeTask'></i>";
            echo "<div class='card'><div class='card-header stack-header'>".$donnees['name_stack']."</div>";
            echo "<ul class='list-group list-group-flush stack'>";
            /*Display of rows */
            $rowCursor=taskDisplay($donnees['id_stack'],$db);
            while($donnees2 = $rowCursor->fetch()){
                if ($permi==2) echo "<li id='task-".$donnees2['id_task']."' class='list-group-item task'><i class='fas fa-times closeTask'></i>".$donnees2['name_task']."</li>";
                else echo "<li id='task-".$donnees2['id_task']."' class='list-group-item task'>".$donnees2['name_task']."</li>";
            }
            $rowCursor->closeCursor(); 
            if ($permi==2) echo '</ul><input type="text" class="newTask" placeholder="'.DIAG['newtask'].'"></input>';
            echo "</div></div>";
        }
        $colCursor->closeCursor();
        if ($permi==2) echo "
            <div class='colo colnew'><svg id='newStackButton' width='100px' height='100px'><use href='./public/images/icons/plus.svg#plus'></use></svg></div>";
    }

    // Page building function. Will only be called if the user's permission is 1 or 2.
    function pageBuilder($idDiag,$userz,$res,$perm,$db)
    {
        echo "<h2 id='diagTitle'>".$res["name_diag"]."</h2>
        <div class='row'>
            <div class='col-6 col-md-3 order-1 order-md-1' id='avacanvas'>";
                showAvatar($res["id_creator"]);
                echo "</div>
            <div class='col-md-6 order-3 order-md-2'>
                <strong>".DIAG["objectives"]."</strong>
                <br><p id='descDiag'>".nl2br($res["desc_diag"])."</p>
            </div>

            <!-- Menu button + menu modals -->
            <div class='col-6 col-md-3 order-2 order-md-3' style='display: flex;align-items: center;'>";
                menuButton($res['id_creator'],$userz,$res['team_affili'],$res['vis_diag'],$db);
                echo "</div>
        </div>

        <!-- The diag's content -->
        <div id='diagcont'>
            <div class='row' id='diag'>";
                displayDiag($idDiag,$perm,$db); 
                if (isset($_SESSION['id_user'])) addView($idDiag,$_SESSION['id_user'],0, $db);
                echo "</div>
        </div>";
    }

    // Pre-page building function. Will display a text or show the diag.
    function prePageBuilder ($idDiag,$userz,$res,$perm,$db)
    {
        //var_dump($perm);
        // Diag doesn't exist
        if($res==false){
            echo "<div id='notauthorized'>".DIAG['secunonexistant']."</div>";
        }
        // Private personal diag
        else if ($perm==0 AND $res['id_creator']!=$userz and $res['team_affili']==0)
        {
            echo "<div id='notauthorized'>".DIAG['secuprivate']."</div>";
        }
        // Diag reserved to team members
        else if ($perm==0 and $res['vis_diag']==2)
        {
            echo "<div id='notauthorized'>".DIAG['secuteam']."</div>";
        }
        // Diag reserved to connected users
        else if ($perm==0 and $userz==0)
        {
            echo "<div id='notauthorized'>".DIAG['secuconnected']."</div>";
        }
        else PageBuilder ($idDiag,$userz,$res,$perm,$db);
    }
?>