<?php
    // Show avatar
    function showAvatar($idCreator)
    {
        echo "<img id='avatar' draggable='false'";
        echo (file_exists('./upload/ava/'.$idCreator.'.jpg'))?"src='./upload/ava/".$idCreator.".jpg' >":"src='./upload/ava/0.jpg' >";
    }

    // Display diagram
    function displayDiag($idDiag,$placeholderTask,$bdd)
    {
        /*Boucle d'affichage des colonnes
        while($donnees = $forrest->fetch()){*/
        $colCursor = stackDisplay($idDiag,$bdd);
        while($donnees=$colCursor->fetch()){
            /*echo "<div class='colo'><img class='noteholes' src='note.png'><div class='closeTask'>x</div><div class='card'><div class='card-header stack-header'>".$donnees['name_col']."</div>";*/
            echo "<div class='colo color".(($donnees['order_stack']-1)%4 + 1)."'><svg class='noteholes' width='288px' height='33px'><use href='./public/images/diag/note.svg#holes'></use></svg><i class='fas fa-times closeTask'></i><div class='card'><div class='card-header stack-header'>".$donnees['name_stack']."</div>";
            echo "<ul class='list-group list-group-flush stack'>";
            /*Boucle d'affichage des lignes*/
            $rowCursor=taskDisplay($donnees['id_stack'],$bdd);
            while($donnees2 = $rowCursor->fetch()){
                echo "<li id='task-".$donnees2['id_task']."' class='list-group-item task'><i class='fas fa-times closeTask'></i>".$donnees2['name_task']."</li>";
            }
            $rowCursor->closeCursor(); 
            echo '</ul><input type="text" class="newTask" placeholder="'.$placeholderTask.'"></input></div></div>';
        }
        $colCursor->closeCursor();
    }
?>