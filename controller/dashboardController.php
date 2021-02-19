<?php

    // Gum creator for the diags
    function gumCreator($idDiag,$diagTitle,$diagDesc,&$gums)
    {
        echo "<a href='./diag.php?d=".$idDiag."'><div class='gum-cardly gumcolor".(($gums)%5 + 1)."'>
        <div class='gum-cardly1'>
            <img draggable='false'";
        echo (file_exists('./upload/diagmin/'.$idDiag.'.jpg'))?"src='./upload/diagmin/".$idDiag.".jpg' >":"src='./upload/diagmin/0.jpg' >";
        echo "</div><div class='gum-cardly2'>".$diagDesc."</div></div></a>";
        $gums++;
    }
    // Caroussel creator
    function gumCarCreator($idDiag,$diagTitle,$diagDesc,&$gums)
    {
        echo "<div class='splide__slide gum-car-cardly gumcolor".(($gums)%5 + 1)."'>
        <div class='gum-cardly1'>
            <img draggable='false'";
        echo (file_exists('./upload/diagmin/'.$idDiag.'.jpg'))?"src='./upload/diagmin/".$idDiag.".jpg' >":"src='./upload/diagmin/0.jpg' >";
        echo "</div><div class='gum-cardly2'>".$diagDesc."</div></div>";
        $gums++;
    }

    // Display of last 3 diags seen
    function showCaroussel($idUser,$db)
    {
        echo "<div id='caroussel' class='col splide' style='margin: 20px auto 0 auto'><div class='splide__track'><div class='splide__list'>";
        $count=0;
        $cardiag=retrieveLastThreeDiagSeen($idUser, $db);
        while($tabs = $cardiag->fetch()){
            //echo $tabs['name_diag'];
            gumCarCreator($tabs['id_diag'],$tabs['name_diag'],$tabs['desc_diag'],$gums);
            $count++;
        }
        while($count<3){
            echo "<div class='splide__slide gum-car-cardly gumcolor0'>
            <div class='gum-cardly1'></div><div class='gum-cardly2'></div></div>";
            $count++;
        }
        echo "</div></div></div>";
    }

    // Display of personal diags
    function showPersonalDiag($idUser,$dicoPers,$dicoPersSub,$dicoNoPers,$db,&$gums)
    {
        echo "<div class='col' style='text-align:center'><h2>".$dicoPers."</h2>".$dicoPersSub;
        $personal=retrievePersonalDiags($idUser, $db);
        if ($personal->rowCount()==null)
        echo "<div class='row' id='team-0' style='margin-top:20px'>".$dicoNoPers."</div>";
        else{
            echo "<div class='row' id='team-0' style='margin-top:20px'>";
            while($tabs = $personal->fetch()){
                //echo $tabs['name_diag'];
                gumCreator($tabs['id_diag'],$tabs['name_diag'],$tabs['desc_diag'],$gums);
            }
            echo "</div>";
        }
        echo "</div>";
    }

    // Display of team diags

    function showTeamDiag($idUser,$dicoTeam,$dicoTeamSub,$dicoNoTeam,$dicoNoThisTeam,$db,&$gums)
    {
        echo "<div class='col' style='text-align:center'><h2>".$dicoTeam."</h2>".$dicoTeamSub."</div>";
        $myTeams=retrieveTeamsFromUser($idUser,$db);
        if ($myTeams->rowCount()==null)
        echo "<br>".$dicoNoTeam;
        else{
            while($teams = $myTeams->fetch()){
                echo "<br><div class='row' style='align-items: center;'><div class='cardly-teamava'></div><h3>".$teams['name_team']."</h3></div>";
                $teamDiags=retrieveDiagFromTeam($teams['id_team'],$db);
                if ($teamDiags->rowCount()==null)
                    echo "<div class='row' id='team-".$teams['id_team']."' style='margin-top:20px'>".$dicoNoThisTeam."</div>";
                else{
                    echo "<div class='row' id='team-".$teams['id_team']."' style='margin-top:20px'>";
                    while($tabs = $teamDiags->fetch()){
                    gumCreator($tabs['id_diag'],$tabs['name_diag'],$tabs['desc_diag'],$gums);
                    }
                    echo "</div>";
                }
            }
        }
    }

    // Part with the two Create buttons
    function showCreatePart($idUser,$createIntro,$createIntroSub,$newProject,$newTeam,$createButton,$db)
    {
        echo "<div id='whitesquare'></div>
            <div class='col' style='text-align:center'>
                <h2>".$createIntro."</h2>".$createIntroSub."
            </div>
            <div class='row' style='justify-content: space-evenly;'>
                <div class='card cardly-create'>
                <strong>".$newProject."</strong>
                    <svg width='75px' height='62px'><use href='./public/images/dashboard/newteam.svg#newteam'></use></svg>
                    <a data-toggle='modal' data-target='#newProjectModal'><button id='newProject'>".$createButton."</button></a>
                </div>
                <div class='card cardly-create'>
                <strong>".$newTeam."</strong>
                    <svg width='63px' height='62px'><use href='./public/images/dashboard/newproject.svg#newproject'></use></svg>
                    <a data-toggle='modal' data-target='#newTeamModal'><button id='newTeam'>".$createButton."</button></a>
                </div>

                <!-- Modals -->
                <div class='modal fade' id='newProjectModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                        <div class='modal-dialog modal-dialog-centered' role='document'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title'>".$newProject."</h5>
                                </div>
                                <div class='modal-body'>
                                    <label for='teams'>Choisissez une équipe :</label>
                                    <select id='teamList' name='teams'>
                                        <option value='0'>Aucune (tableau personnel)</option>";
        $myTeams=retrieveTeamsFromUser($idUser,$db);
        while($teams = $myTeams->fetch())
            echo "<option value='".$teams['id_team']."'>".$teams['name_team']."</option>";
                                    echo "</select>
                                    <label for='projectname'>Nom du projet :</label>
                                    <input type='text' id='projectname' name='projectname'>
                                    <label for='projectdesc'>Description du projet :</label>
                                    <textarea id='projectdesc' name='projectdesc'></textarea>
                                </div>
                                <div class='modal-footer'>
                                    <button type='button' id='newProjectCreate' class='btn btn-primary'>Créer</button>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>";
    }