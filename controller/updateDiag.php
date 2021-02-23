<?php
    include '../model/connexion_bdd_ajax.php';
    ($_POST['mode'])?$mode=$_POST['mode']:$mode=0;

    /*Update modes :
    1 : Title update
    2 : Desc update
    3 : Task add
    4 : Stack add
    5 : Task remove
    6 : Stack remove
    7 : Task reorder
    8 : Stack reorder
    */
    
    // 1 : Title update
    if ($mode==1 and $_POST['title']!=null){
        updateDiagName($_POST['diag'],htmlspecialchars($_POST['title']),$bdd);
        exit();
    }

    // 2 : Desc update
    if ($mode==2 and $_POST['text']!=null){
        updateDiagDesc($_POST['diag'],htmlspecialchars($_POST['text']),$bdd);
        exit();
    }

    // 3 : Task add
    if ($mode==3 and $_POST['pos']!=null and $_POST['col']!=null and $_POST['diag']!=null){
        $col=retrieveColFromOrder($_POST['diag'],$_POST['col'],$bdd);
        if ($col!=null)
        insertNewTask($col,$_POST['pos'],htmlspecialchars($_POST['text']),$bdd);
        exit();
    }

    // 4 : Stack add
    if ($mode==4 and $_POST['col']!=null and $_POST['diag']!=null){
        insertNewStack($_POST['diag'],htmlspecialchars($_POST['text']),$_POST['col'],$bdd);
        exit();
    }

    // 5 : Task remove
    if ($mode==5 and $_POST['task']!=null and $_POST['stack']!=null and $_POST['diag']!=null){
        //Searching the stack where the task is based on the stack order
        $colo=retrieveColFromOrder($_POST['diag'], $_POST['stack'],$bdd);
        //Removing the task by indicating which col to search
        deleteTask($_POST['task'],$colo,$bdd);
        exit();
    }
    // 6 : Stack remove
    if ($mode==6 and $_POST['stack']!=null and $_POST['diag']!=null){
        removeStack($_POST['diag'],$_POST['stack'],$bdd);
        reorderStacksFromIndex($_POST['diag'],$_POST['stack'],$bdd);
    }

    // 7 : Task reorder
    if ($mode==7 and $_POST['oldpos']!=null and $_POST['oldcol']!=null and $_POST['newpos']!=null and $_POST['newcol']!=null and $_POST['diag']!=null){
        $destCol=retrieveColFromOrder($_POST['diag'], $_POST['newcol'],$bdd);
        // If we're moving the task in the same stack
        if($_POST['oldcol']==$_POST['newcol']){
            updateTaskPosition($destCol, $_POST['oldpos'], 0,$bdd);
            if ($_POST['oldpos']<$_POST['newpos'])
            reorderTasksFromArray($destCol, $_POST['oldpos'], $_POST['newpos'], -1, $bdd);
            else reorderTasksFromArray($destCol, $_POST['newpos'], $_POST['oldpos'], +1, $bdd);
            updateTaskPosition($destCol,0, $_POST['newpos'],$bdd);
        }
        else{
            $originCol=retrieveColFromOrder($_POST['diag'], $_POST['oldcol'],$bdd);
            reorderTasksFromIndex($destCol,$_POST['newpos'],1, $bdd);
            updateTaskPositionAndStack($originCol,$destCol,$_POST['oldpos'],$_POST['newpos'],$bdd);
            reorderTasksFromIndex($originCol,$_POST['oldpos'],-1, $bdd);
        }
    }

    // 8 : Stack reorder
    if ($mode==8 and $_POST['oldpos']!=null and $_POST['newpos']!=null and $_POST['diag']!=null){
        updateStackPosition($_POST['diag'], $_POST['oldpos'], 0,$bdd);
        if ($_POST['oldpos']<$_POST['newpos'])
            reorderStacksFromArray($_POST['diag'], $_POST['oldpos'], $_POST['newpos'], -1, $bdd);
        else reorderStacksFromArray($_POST['diag'], $_POST['newpos'], $_POST['oldpos'], +1, $bdd);
        updateStackPosition($_POST['diag'],0, $_POST['newpos'],$bdd);
    }