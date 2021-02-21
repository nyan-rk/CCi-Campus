<?php
    // Building the page according to the page name
    function initPage()
    {
        include "./model/connexion_bdd.php";
        // Including the right dictionaries.
        $_SESSION['lang']=(isset($_SESSION['lang'])? htmlspecialchars($_SESSION['lang']):'fr');
        //$_SESSION['lang']='fr';
        $nomPage=basename($_SERVER['PHP_SELF'],'.php');
        require "./view/lang/".$_SESSION['lang'].".php";
        require "./view/lang/".$nomPage."/".$_SESSION['lang'].".php";
        if (file_exists("./controller/".$nomPage."Controller.php")) require "./controller/".$nomPage."Controller.php";
        //The page is generated with its $title as a Metatitle
        echo"<!DOCTYPE html><html lang=\"".$_SESSION['lang']."\"><head><meta charset=\"UTF-8\"><meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\"><title>".$title."</title>";
        require "./view/head.html";
        if (file_exists("./public/css/".$nomPage.".css")) echo "<link rel='stylesheet' href='./public/css/".$nomPage.".css'>";

        // Including the right header
        if(in_array($nomPage,array("login","register"))) echo "</head>";
        else if (in_array($nomPage,array("index"))) require "./view/headerother.php";
            else require "./view/header.php";

        require "./view/".$nomPage.".php";

        // Including the right footer
        if(in_array($nomPage,array("login","register"))) require "./view/footeralt.php";
        else if (in_array($nomPage,array("index"))) require "./view/footerother.php";
            else require "./view/footer.php";
    }

?>