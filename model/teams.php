<?php 

    // Retrieve all teams from a user
    function retrieveTeamsFromUser($idUser,$db)
    {
        $req=$db->prepare('SELECT t.id_team, t.name_team from teams as t inner join team_affiliation as a on t.id_team=a.id_team where a.id_user=:USER');
        $req->execute(array('USER' => $idUser));
        return $req;
    }