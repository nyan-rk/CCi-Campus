<?php 

    //Adding a new member to a team
    function addNewMember($idUser, $idTeam, $db)
    {
        $req=$db->prepare('INSERT INTO team_affiliation (id_team, id_user) VALUES (:TEAM,:USER)');
        $req->execute(array(
            'TEAM' => $idTeam,
            'USER' => $idUser
        ));
    }

    //Check if a member is in a team based on its name
    function isInTeam($nameUser, $idTeam, $db)
    {
        $req=$db->prepare('SELECT EXISTS (SELECT * FROM user as u inner join team_affiliation as t on u.id_user=t.id_user WHERE u.nickname_user=:NAME and t.id_team=:TEAM) as I_exist');
        $req->execute(array(
            'NAME' => $nameUser,
            'TEAM' => $idTeam
        ));
        return $req;
    }

    //Check if a member is in a team based on its name
    function isInTeamID($idUser, $idTeam, $db)
    {
        $req=$db->prepare('SELECT EXISTS (SELECT * FROM user as u inner join team_affiliation as t on u.id_user=t.id_user WHERE u.id_user=:USER and t.id_team=:TEAM) as I_exist');
        $req->execute(array(
            'USER' => $idUser,
            'TEAM' => $idTeam
        ));
        return $req;
    }

    // Check if a member is in a team or is the creator. Used for AJAX safeties.
    function isInTeamOrCreator($idUser,$idDiag,$db)
    {
        $req=$db->prepare('SELECT EXISTS (SELECT * from diag where id_diag=:DIAG and id_creator=:USER) As is_creator, EXISTS (select * from diag as d inner join team_affiliation as t on t.id_team=d.team_affili where d.id_diag=:DIAG and t.id_user=:USER) as is_in_team');
        $req->execute(array(
            'DIAG' => $idDiag,
            'USER' => $idUser
        ));
        return $req;
    }

    // Retrieve all team members
    function teamMembers($idTeam,$db)
    {
        $req=$db->prepare('SELECT u.id_user, u.nickname_user FROM user as u inner join team_affiliation as i on u.id_user=i.id_user inner join teams as t on t.id_team=i.id_team WHERE t.id_team=:TEAM');
        $req->execute(array('TEAM' => $idTeam));
        return $req;
    }

    // Remove one user from a team
    function removeUserFromTeam($idUser,$idTeam,$db)
    {
        $req=$db->prepare('DELETE FROM team_affiliation WHERE id_team=:TEAM AND id_user=:USER');
        $req->execute(array(
            'TEAM' => $idTeam,
            'USER' => $idUser
        ));
    }

    //Remove all affiliations with a team
    function removeAllAffilFromTeam($idTeam,$db)
    {
        $req=$db->prepare('DELETE FROM team_affiliation WHERE id_team=:TEAM');
        $req->execute(array('TEAM' => $idTeam));
    }