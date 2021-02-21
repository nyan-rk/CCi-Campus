<?php
    // Show avatar
    function showAvatar($idCreator)
    {
        echo "<img id='avatar' draggable='false'";
        echo (file_exists('./upload/ava/'.$idCreator.'.jpg'))?"src='./upload/ava/".$idCreator.".jpg' >":"src='./upload/ava/0.jpg' >";
    }

    // Show button
    function menuButton($idCreator, $idUser,$idTeam,$db)
    {
        if ($idCreator==$idUser){
            echo 
            "<div class='dropdown'>
            <button class='btn dropdown-toggle' type='button' id='menubutton' data-bs-toggle='dropdown' aria-expanded='false'>Menu</button>
                <ul class='dropdown-menu' aria-labelledby='menubutton'>
                    <li><a data-toggle='modal' data-target='#ModalDiagDelete' class='dropdown-item' href='#'>".DIAG['menudelete']."</a></li>
                    <li><a data-toggle='modal' data-target='#ModalTeamChange' class='dropdown-item' href='#'>".DIAG['menuchangeteam']."</a></li>
                    <li><a data-toggle='modal' data-target='#MenuChangeCreator' class='dropdown-item' href='#'>".DIAG['menuchangecreator']."</a></li>
                </ul>
            </div>
              
            <!-- Delete Diag Modal -->
            <div class='modal fade' id='ModalDiagDelete' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                <div class='modal-dialog modal-dialog-centered' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title'>Supprimer le tableau ?</h5>
                        </div>
                        <div class='modal-body'>
                            Êtes-vous sûr(e) de vouloir supprimer le tableau ? Cette action est irréversible !
                        </div>
                        <div class='modal-footer'>
                            <button type='button' id='DeleteDiagYes' class='btn btn-primary'>Oui</button>
                            <button type='button' id='DeleteDiagNo' class='btn btn-secondary'>Non</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Change team Modal -->
            <div class='modal fade' id='ModalTeamChange' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                <div class='modal-dialog modal-dialog-centered' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title'>Changer l'équipe en charge ?</h5>
                        </div>
                        <div class='modal-body'>
                            Actuellement : <strong id='teamInCharge'></strong><br>
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
                            <button type='button' id='ChangeTeamYes' class='btn btn-primary'>Changer</button>
                            <button type='button' id='ChangeTeamNo' class='btn btn-secondary'>Annuler</button>
                        </div>
                    </div>
                </div>
            </div>";
        }
    }

    // Display diagram
    function displayDiag($idDiag,$db)
    {
        /*Boucle d'affichage des colonnes
        while($donnees = $forrest->fetch()){*/
        $colCursor = stackDisplay($idDiag,$db);
        while($donnees=$colCursor->fetch()){
            /*echo "<div class='colo'><img class='noteholes' src='note.png'><div class='closeTask'>x</div><div class='card'><div class='card-header stack-header'>".$donnees['name_col']."</div>";*/
            echo "<div class='colo color".(($donnees['order_stack']-1)%4 + 1)."'><svg class='noteholes' width='288px' height='33px'><use href='./public/images/diag/note.svg#holes'></use></svg><i class='fas fa-times closeTask'></i><div class='card'><div class='card-header stack-header'>".$donnees['name_stack']."</div>";
            echo "<ul class='list-group list-group-flush stack'>";
            /*Boucle d'affichage des lignes*/
            $rowCursor=taskDisplay($donnees['id_stack'],$db);
            while($donnees2 = $rowCursor->fetch()){
                echo "<li id='task-".$donnees2['id_task']."' class='list-group-item task'><i class='fas fa-times closeTask'></i>".$donnees2['name_task']."</li>";
            }
            $rowCursor->closeCursor(); 
            echo '</ul><input type="text" class="newTask" placeholder="'.DIAG['newtask'].'"></input></div></div>';
        }
        $colCursor->closeCursor();
    }
?>