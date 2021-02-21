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

    //Check if a member is in a team
    function isInTeam($nameUser, $idTeam, $db)
    {
        $req=$db->prepare('SELECT EXISTS (SELECT * FROM user as u inner join team_affiliation as t on u.id_user=t.id_user WHERE u.nickname_user=:NAME and t.id_team=:TEAM) as I_exist');
        $req->execute(array(
            'NAME' => $nameUser,
            'TEAM' => $idTeam
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

    //Remove all affiliations with a team
    function removeAllAffilFromTeam($idTeam,$db)
    {
        $req=$db->prepare('DELETE FROM team_affiliation WHERE id_team=:TEAM');
        $req->execute(array('TEAM' => $idTeam));
    }