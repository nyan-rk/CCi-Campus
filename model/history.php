<?php

    function addView($idDiag, $idUser,$mode, $db)
    {
        $req=$db->prepare('INSERT INTO history (id_diag, id_user,modif_type) VALUES (:DIAG,:USER,:MODIF);');
		$req->execute(array(
			'DIAG' => $idDiag,
			'USER' => $idUser,
            'MODIF' => $mode
		));
    }

    function getLatestModif($idDiag,$db)
    {
        $req=$db->prepare('SELECT * from history where id_diag=:DIAG AND modif_type!=0 ORDER BY date_viewed DESC');
        $req->execute(array('DIAG'=>$idDiag));
        return $req;
    }