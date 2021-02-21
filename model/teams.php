<?php 

    //Creation of a new team
    function createNewTeam($nameTeam, $db)
    {
        $req=$db->prepare('INSERT INTO teams (name_team) VALUES (:NAME)');
        $req->execute(array('NAME' => $nameTeam));
        return $db->lastInsertId();
    }

    // Delete a team
    function deleteTeam($idTeam,$db)
    {
        $req=$db->prepare('DELETE FROM TEAMS WHERE id_team=:TEAM');
        $req->execute(array('TEAM' => $idTeam));
    }

    // Retrieve all teams from a user
    function retrieveTeamsFromUser($idUser,$db)
    {
        $req=$db->prepare('SELECT t.id_team, t.name_team from teams as t inner join team_affiliation as a on t.id_team=a.id_team where a.id_user=:USER');
        $req->execute(array('USER' => $idUser));
        return $req;
    }