<?php

    function addView($idDiag, $idUser,$mode, $db)
    {
        $req=$db->prepare('INSERT INTO view_history (id_diag, id_user,modif_type) VALUES (:DIAG,:USER,:MODIF);');
		$req->execute(array(
			'DIAG' => $idDiag,
			'USER' => $idUser,
            'MODIF' => $mode
		));
    }