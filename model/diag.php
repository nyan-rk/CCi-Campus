<?php 

    function createDiag($idUser,$nameDiag,$descDiag,$visDiag,$idTeam,$db)
    {
        $req=$db->prepare('INSERT INTO diag (name_diag, desc_diag, id_creator,vis_diag, team_affili) VALUES (:NAME,:DESC,:CREATOR, :VISI, :TEAM)');
		$req->execute(array(
			'NAME' => $nameDiag,
            'DESC' => $descDiag,
            'CREATOR' => $idUser,
            'VISI' => $visDiag,
			'TEAM' => $idTeam
		));
        echo $db->lastInsertId();
    }

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

    function updateDiagTeam($idDiag, $newTeam,$db)
    {
        $req=$db->prepare('UPDATE diag SET team_affili=:TEAM WHERE id_diag=:DIAG;');
		$req->execute(array(
			'TEAM' => $newTeam,
			'DIAG' => $idDiag
		));
    }

    function updateDiagCreator($idDiag, $newCreator,$db)
    {
        $req=$db->prepare('UPDATE diag SET id_creator=:CREA WHERE id_diag=:DIAG;');
		$req->execute(array(
			'CREA' => $newCreator,
			'DIAG' => $idDiag
		));
    }

    function updateDiagVisib($idDiag, $newVis,$db)
    {
        $req=$db->prepare('UPDATE diag SET vis_diag=:VISI WHERE id_diag=:DIAG;');
		$req->execute(array(
			'VISI' => $newVis,
			'DIAG' => $idDiag
		));
    }

    function updateAllDiagsToPersonal($idUser,$oldTeam,$db)
    {
        $req=$db->prepare('UPDATE diag SET team_affili=0 AND id_creator=:USER WHERE team_affili=:OLD;');
		$req->execute(array(
			'USER' => $idUser,
			'OLD' => $oldTeam
		));
    }

    function retrieveDiag($idDiag,$db)
    {
        $req=$db->prepare('SELECT * FROM diag WHERE id_diag=:DIAG');
        $req->execute(array('DIAG' => $idDiag));
        return $req;
    }

    function retrieveLastThreeDiagSeen($idUser, $db)
    {
        //$req=$db->prepare('SELECT v.id_diag,d.name_diag,d.desc_diag, max(date_viewed) FROM view_history as v INNER JOIN diag as d on v.id_diag=d.id_diag INNER JOIN teams as t on t.id_team=d.team_affili INNER JOIN team_affiliation as t2 on t2.id_team=t.id_team INNER JOIN user as u on t2.id_user=u.id_user WHERE u.id_user=:USER GROUP BY v.id_diag ORDER BY max(date_viewed) DESC LIMIT 3');5
        $req=$db->prepare('SELECT v.id_diag,d.name_diag,d.desc_diag, DATE_FORMAT(max(date_viewed),"%d %m %Y") as last_modif FROM history as v INNER JOIN diag as d on v.id_diag=d.id_diag WHERE v.id_user=:USER and v.modif_type=0 GROUP BY v.id_diag ORDER BY max(date_viewed) DESC LIMIT 3');
		$req->execute(array('USER' => $idUser));
        return $req;

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

    function deleteDiagFromTeam($idTeam,$db)
    {
        $req=$db->prepare('DELETE FROM diag WHERE team_affili=:TEAM');
        $req->execute(array('TEAM' => $idTeam));
    }

    function deleteDiagFromId($idUser,$db)
    {
        $req=$db->prepare('DELETE FROM diag WHERE id_diag=:USER');
        $req->execute(array('USER' => $idUser));
    }
?>