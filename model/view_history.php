<?php

    function addView($idDiag, $idUser, $db)
    {
        $req=$db->prepare('INSERT INTO view_history (id_diag, id_user, date_viewed) VALUES (:DIAG,:USER, NOW());');
		$req->execute(array(
			'DIAG' => $idDiag,
			'USER' => $idUser
		));
    }