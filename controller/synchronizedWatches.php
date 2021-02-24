<?php
    include '../model/connexion_bdd_ajax.php';

    // AJAX request to check the latest modif
    $modif=getLatestModif($_POST['diag'],$bdd);
        if($modif->rowCount()==0) echo 0;
        else{
            $modified=$modif->fetch();
            echo $modified['id_view'];
        }
    exit();