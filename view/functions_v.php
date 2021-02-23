<?php
//Fonction d'initialisation de la page, prenant en compte le titre de la page.
function initPage()
{
    require "../model/connexion_bdd.php";
    //On inclut le bon fichier de dico.
    $_SESSION['lang'] = (isset($_SESSION['lang']) ? htmlspecialchars($_SESSION['lang']) : 'fr');
    $nomPage = basename($_SERVER['PHP_SELF'], '.php');
    require "../view/lang/" . $nomPage . "/" . $_SESSION['lang'] . ".php";
    //On génère la page avec $title comme variable globale de chaque fichier $title
    echo "<!DOCTYPE html><html lang=\"" . $_SESSION['lang'] . "\"><head><meta charset=\"UTF-8\"><meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\"><title>" . $title . "</title>";
    require "../view/header.php";
    require "../view/" . $nomPage . ".php";
    require "../view/footer.php";
}

// Show avatar
function showAvatar($idCreator)
{
    echo "<img id='avatar' draggable='false'";
    echo (file_exists('./upload/ava/' . $idCreator . '.jpg')) ? "src='./upload/ava/" . $idCreator . ".jpg' >" : "src='./upload/ava/0.jpg' >";
}

// Display diagram
function displayDiag($idDiag, $bdd)
{
    $forrest = $bdd->prepare('SELECT * FROM col WHERE diag_linked =:diag ORDER BY order_col');
    $forrest->execute(array("diag" => $idDiag));
    /*Boucle d'affichage des colonnes*/
    while ($donnees = $forrest->fetch()) {
        /*echo "<div class='colo'><img class='noteholes' src='note.png'><div class='closeTask'>x</div><div class='card'><div class='card-header stack-header'>".$donnees['name_col']."</div>";*/
        echo "<div class='colo color" . (($donnees['order_col'] - 1) % 4 + 1) . "'><svg class='noteholes' width='288px' height='33px'><use href='./public/images/diag/note.svg#holes'></use></svg><div class='closeTask'>x</div><div class='card'><div class='card-header stack-header'>" . $donnees['name_col'] . "</div>";
        echo "<ul class='list-group list-group-flush stack' ondragover='onDragOver(event);'ondrop='onDrop(event);'>";
        /*Boucle d'affichage des lignes*/
        $gump = $bdd->prepare('SELECT * FROM task WHERE col_linked =:col ORDER BY order_row');
        $gump->execute(array("col" => $donnees['id_col']));
        while ($donnees2 = $gump->fetch()) {
            echo "<li id='task-" . $donnees2['id_row'] . "' class='list-group-item task' draggable='true' ondragstart='onDragStart(event);'><div class='closeTask'>x</div>" . $donnees2['name_row'] . "</li>";
        }
        $gump->closeCursor();
        echo '</ul><input type="text" class="newTask" placeholder="Nouvelle tâche..."></input></div></div>';
    }
    $forrest->closeCursor();
}
