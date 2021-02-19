<?php 

    //Adding a new member to a team
    function createNewTeam($idUser, $idTeam, $db)
    {
        $req=$db->prepare('INSERT INTO team_affiliation (id_team, id_user) VALUES (:TEAM,:USER)');
        $req->execute(array(
            'TEAM' => $idTeam,
            'USER' => $idUser
        ));
    }