<?php
    //Fonction d'initialisation de la page, prenant en compte le titre de la page.
    function initPage()
    {
        include "./model/connexion_bdd.php";
        //On inclut le bon fichier de dico.
        $_SESSION['lang']=(isset($_SESSION['lang'])? htmlspecialchars($_SESSION['lang']):'fr');
        $nomPage=basename($_SERVER['PHP_SELF'],'.php');
        require "./view/lang/".$nomPage."/".$_SESSION['lang'].".php";
        require "./controller/".$nomPage."Controller.php";
        //On génère la page avec $title comme variable globale de chaque fichier $title
        echo"<!DOCTYPE html><html lang=\"".$_SESSION['lang']."\"><head><meta charset=\"UTF-8\"><meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\"><title>".$title."</title>";
        require "./view/header.php";
        require "./view/".$nomPage.".php";
        require "./view/footer.php";
    }

?>