<?php 

    // Retrieve a certain task from a certain column
    function taskDisplay($idCol,$db)
    {
        $gump= $db->prepare('SELECT * FROM task WHERE stack_linked =:col ORDER BY order_task');
        $gump->execute(array("col" => $idCol));
        return $gump;
    }

    // Insert a new task in a certain column
    function insertNewTask($idCol,$idPos,$text,$db)
    {
        $req=$db->prepare('INSERT INTO task (name_task, order_task,stack_linked) VALUES (:NAME, :ORDER, :COL)');
		$req->execute(array(
			'NAME' => $text,
            'ORDER' => $idPos,
            'COL' => $idCol
		));
    }

    // Delete a certain task
    function deleteTask($idPos,$idCol,$db)
    {
        $req=$db->prepare('DELETE from task WHERE stack_linked =:COL and order_task=:ORDER');
		$req->execute(array(
            'COL' => $idCol,
            'ORDER' => $idPos
		));
    }

    // Update a task's position
    function updateTaskPosition($idStack, $oldOrder, $newOrder,$db)
    {
        $req=$db->prepare('UPDATE task SET order_task=:NEWORD WHERE order_task=:OLDORD AND stack_linked=:STACK');
        $req->execute(array(
            'NEWORD' => $newOrder,
            'OLDORD' => $oldOrder,
            'STACK' => $idStack
        ));
    }

    // Update a task's position and stack
    function updateTaskPositionAndStack($idStack,$newStack, $oldOrder, $newOrder,$db)
    {
        $req=$db->prepare('UPDATE task SET order_task=:NEWORD, stack_linked=:NEWSTACK WHERE order_task=:OLDORD AND stack_linked=:OLDSTACK');
        $req->execute(array(
            'NEWORD' => $newOrder,
            'NEWSTACK' => $newStack,
            'OLDORD' => $oldOrder,
            'OLDSTACK' => $idStack
        ));
    }

    // Reorder the tasks from a certain index with a certain increment. +1 or -1
    function reorderTasksFromIndex($idStack, $idOrder, $incr, $db)
    {
        $req=$db->prepare('UPDATE task SET order_task=order_task+:INCR where stack_linked=:STACK and order_task>=:ORDER');
        $req->execute(array(
            'INCR' => $incr,
            'STACK' => $idStack,
            'ORDER' => $idOrder
        ));
    }

    // reorger tasks between ColMin and ColMax
    function reorderTasksFromArray($idStack, $idColMin, $idColMax, $incr, $db)
    {
        $req=$db->prepare('UPDATE task SET order_task=order_task+:INCR where stack_linked=:STACK and order_task BETWEEN :COLMIN and :COLMAX');
        $req->execute(array(
            'INCR' => $incr,
            'STACK' => $idStack,
            'COLMIN' => $idColMin,
            'COLMAX' => $idColMax
        ));
    }

?>