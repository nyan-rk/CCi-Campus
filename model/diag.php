<?php 

    function updateDiagName($idDiag,$newName,$db)
    {
        $req=$db->prepare('UPDATE diag SET name_diag=:TITLE WHERE id_diag=:DIAG;');
		$req->execute(array(
			'TITLE' => $newName,
			'DIAG' => $idDiag
		));
    }

    function updateDiagDesc($idDiag,$newDesc,$db)
    {
        $req=$db->prepare('UPDATE diag SET desc_diag=:DESC WHERE id_diag=:DIAG;');
		$req->execute(array(
			'DESC' => $newDesc,
			'DIAG' => $idDiag
		));
    }

    function retrieveLastThreeDiagSeen($idUser, $db)
    {
        $req=$db->prepare('SELECT v.id_diag, max(date_viewed) FROM view_history as v INNER JOIN diag as d on v.id_diag=d.id_diag INNER JOIN teams as t on t.id_team=d.team_affili INNER JOIN team_affiliation as t2 on t2.id_team=t.id_team INNER JOIN user as u on t2.id_user=u.id_user WHERE u.id_user=:USER GROUP BY v.id_diag ORDER BY max(date_viewed) DESC LIMIT 3');
		$req->execute(array('USER' => $idUser));

    }

    function retrievePersonalDiags($idUser, $db)
    {
        $req=$db->prepare('SELECT * FROM diag WHERE id_creator=:USER AND team_affili=0');
        $req->execute(array('USER' => $idUser));
        return $req;
    }

    function retrieveDiagFromTeam($idTeam,$db)
    {
        $req=$db->prepare('SELECT * FROM diag WHERE team_affili=:TEAM');
        $req->execute(array('TEAM' => $idTeam));
        return $req;
    }
?>