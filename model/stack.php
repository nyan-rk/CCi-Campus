<?php 

    // Insert a new stack in a diag
    function insertNewStack($idDiag,$text,$idColOrder,$db)
    {
        $req=$db->prepare('INSERT INTO stack (name_stack, order_stack,diag_linked) VALUES (:NAME, :ORDER, :DIAG)');
		$req->execute(array(
			'NAME' => $text,
            'ORDER' => $idColOrder,
            'DIAG' => $idDiag
		));
    }

    // Delete a stack from a diag
    function removeStack($idDiag,$idColOrder,$db){
        $req=$db->prepare('DELETE FROM stack WHERE diag_linked =:DIAG AND order_stack=:ORDER');
		$req->execute(array(
			'DIAG' => $idDiag,
            'ORDER' => $idColOrder,
		));
    }

    // Update a stack's position
    function updateStackPosition($idDiag, $oldOrder, $newOrder,$db)
    {
        $req=$db->prepare('UPDATE stack SET order_stack=:NEWCOL WHERE order_stack=:OLDCOL AND diag_linked=:DIAG');
        $req->execute(array(
            'OLDCOL' => $oldOrder,
            'NEWCOL' => $newOrder,
            'DIAG' => $idDiag
        ));
    }

    // Get the info of a stack for display
    function stackDisplay($idDiag,$db)
    {
        $forrest = $db->prepare('SELECT * FROM stack WHERE diag_linked =:diag ORDER BY order_stack');
        $forrest->execute(array("diag" => $idDiag));
        return $forrest;
    }

    // Retrieve a stack's ID from its order
    function retrieveColFromOrder($idDiag, $idColOrder,$db)
    {
        $req=$db->prepare('SELECT id_stack FROM diag as d inner join stack as s on d.id_diag=s.diag_linked WHERE s.order_stack=:COL and d.id_diag=:DIAG');
        $req->execute(array(
			'DIAG' => $idDiag,
            'COL' => $idColOrder
		));
        $resultat = $req->fetch();
        ($resultat['id_stack']!=null)?$col=$resultat['id_stack']:$col=0;
        return $col;
    }

    // Reorder stacks from an index
    function reorderStacksFromIndex($idDiag, $idColOrder,$db)
    {
        $req=$db->prepare('UPDATE stack SET order_stack=order_stack-1 WHERE order_stack>:COL AND diag_linked=:DIAG');
        $req->execute(array(
            'COL' => $idColOrder,
            'DIAG' => $idDiag
        ));
    }

    // Function to reorder a sample of stacks in a certain way based on the increment.
    function reorderStacksFromArray($idDiag, $idColMin, $idColMax, $incr, $db)
    {
        $req=$db->prepare('UPDATE stack SET order_stack=order_stack+:INCR where diag_linked=:DIAG and order_stack BETWEEN :COLMIN and :COLMAX');
        $req->execute(array(
            'INCR' => $incr,
            'DIAG' => $idDiag,
            'COLMIN' => $idColMin,
            'COLMAX' => $idColMax
        ));
    }
?>