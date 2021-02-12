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

?>