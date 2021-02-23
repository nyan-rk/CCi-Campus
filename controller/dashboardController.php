<?php
    $_SESSION['id_user']=(isset($_SESSION['id_user'])?$_SESSION['id_user']:1);
    if ((isset($_SESSION['id_user'])!=true))
    {
        header('Location: ../index.php');
        exit();
    }
    $gums=0;

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
        // Intro text
        echo' <div class="col" style="text-align:center">
                <h2>'.DASH['intro1'].'</h2>'.DASH['intro2'].'
            </div>';
        // Adding the caroussel
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
    function showPersonalDiag($idUser,$db,&$gums)
    {
        echo "<div class='col' style='text-align:center'><h2>".DASH['personal']."</h2>".DASH['personalsub'];
        $personal=retrievePersonalDiags($idUser, $db);
        if ($personal->rowCount()==null)
        echo "<div class='row' id='team-0' style='margin-top:20px'>".DASH['nopersonal']."</div>";
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

    function showTeamDiag($idUser,$db,&$gums)
    {
        echo "<div class='col' style='text-align:center'><h2>".DASH['team']."</h2>".DASH['teamsub']."</div>";
        $myTeams=retrieveTeamsFromUser($idUser,$db);
        if ($myTeams->rowCount()==null)
        echo "<br>".DASH['noteam'];
        else{
            while($teams = $myTeams->fetch()){
                echo "<div class='row teamheader' style='align-items: center;'><div class='cardly-teamava'></div><h3>".$teams['name_team']."</h3><i class='fas fa-plus'></i><i class='fas fa-times'></i><i class='fas fa-sign-out-alt'></i></div>";
                $teamDiags=retrieveDiagFromTeam($teams['id_team'],$db);
                if ($teamDiags->rowCount()==null)
                    echo "<div class='row' id='team-".$teams['id_team']."' style='margin-top:20px'>".DASH['nothisteam']."</div>";
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

    function teamModals($db)
    {
        echo 
        "<div class='modal fade' id='addMemberModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
            <div class='modal-dialog modal-dialog-centered' role='document'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h5 class='modal-title'>".DASH['membername']."</h5>
                    </div>
                    <div class='modal-body'>
                        <label for='membername'>".DASH['addmember']."</label>
                        <input type='text' id='membername' name='membername'>
                    </div>
                    <div class='modal-footer'>
                        <button type='button' id='addMemberButton' class='btn btn-primary'>".DASH['addbutton']."</button>
                    </div>
                </div>
            </div>
        </div>
        <div class='modal fade' id='removeTeamModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
            <div class='modal-dialog modal-dialog-centered' role='document'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h5 class='modal-title'>".DASH['removeteam']."</h5>
                    </div>
                    <div class='modal-body'>".DASH['removeteambody']."<br>
                        <input type='radio' id='removeChoice1' name='removeChoice' value='1'>
                        <label for='removeChoice1'>".DASH['removeteam1']."</label>
                        <input type='radio' id='removeChoice2' name='removeChoice' value='2'>
                        <label for='removeChoice1'>".DASH['removeteam2']."</label>
                    </div>
                    <div class='modal-footer'>
                        <button type='button' id='removeTeamButton' class='btn btn-primary'>".DASH['removeteambutton']."</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class='modal fade' id='exitTeamModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
            <div class='modal-dialog modal-dialog-centered' role='document'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h5 class='modal-title'>".DASH['quitteam']."</h5>
                    </div>
                    <div class='modal-body'>".DASH['quitteambody']."
                    </div>
                    <div class='modal-footer'>
                        <button type='button' id='exitTeamYes' class='btn btn-primary'>".DASH['quitteamyes']."</button>
                        <button type='button' id='exitTeamNo' class='btn btn-primary'>".DASH['quitteamno']."</button>
                    </div>
                </div>
            </div>
        </div>";
    }

    // Part with the two Create buttons
    function showCreatePart($idUser, $db)
    {
        echo "<div id='whitesquare'></div>
            <div class='col' style='text-align:center'>
                <h2>".DASH['createintro']."</h2>".DASH['createintrosub']."
            </div>
            <div class='row' style='justify-content: space-evenly;'>
                <div class='card cardly-create'>
                <strong>".DASH['newproject']."</strong>
                    <svg width='75px' height='62px'><use href='./public/images/dashboard/newteam.svg#newteam'></use></svg>
                    <a data-toggle='modal' data-target='#newProjectModal'><button id='newProject'>".DASH['createbutton']."</button></a>
                </div>
                <div class='card cardly-create'>
                <strong>".DASH['newteam']."</strong>
                    <svg width='63px' height='62px'><use href='./public/images/dashboard/newproject.svg#newproject'></use></svg>
                    <a data-toggle='modal' data-target='#newTeamModal'><button id='newTeam'>".DASH['createbutton']."</button></a>
                </div>

                <!-- Modals -->
                <div class='modal fade' id='newProjectModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                    <div class='modal-dialog modal-dialog-centered' role='document'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title'>".DASH['newproject']."</h5>
                            </div>
                            <div class='modal-body'>
                                <label for='teams'>".DASH['modal1projectteam']."</label>
                                <select id='teamList' name='teams'>
                                    <option value='0'>".DASH['modal1noteam']."</option>";
        $myTeams=retrieveTeamsFromUser($idUser,$db);
        while($teams = $myTeams->fetch())
            echo "<option value='".$teams['id_team']."'>".$teams['name_team']."</option>";
                                echo "</select>
                                <label for='projectname'>".DASH['modal1projectname']."</label>
                                <input type='text' id='projectname' name='projectname'>
                                <label for='projectdesc'>".DASH['modal1projectdesc']."</label>
                                <textarea id='projectdesc' name='projectdesc'></textarea>
                                <label for='visibility'>".DASH['modal1visib']."</label>
                                <select id='projectVisib' name='visibility'>
                                    <option value='0'>".DASH['modal1visib0']."</option>
                                    <option value='1'>".DASH['modal1visib1']."</option>
                                    <option value='2'>".DASH['modal1visib2']."</option>
                                </select>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' id='newProjectCreate' class='btn btn-primary'>".DASH['modalbutton']."</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class='modal fade' id='newTeamModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                    <div class='modal-dialog modal-dialog-centered' role='document'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title'>".DASH['newteam']."</h5>
                            </div>
                            <div class='modal-body'>
                                <label for='newteamname'>".DASH['modal2teamname']."</label>
                                <input type='text' id='newteamname' name='newteamname'>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' id='newTeamCreate' class='btn btn-primary'>".DASH['modalbutton']."</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>";
    }