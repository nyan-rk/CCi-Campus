<?php

    session_start();

    require '../model/connexion_bdd_ajax.php';
    
    // Starts the condition
    if (isset($_SESSION['id_user']))

    {
        $req = $bdd->prepare('SELECT id_user FROM user WHERE id_user = ?');
        $req->execute(array($_SESSION['id_user']));
     
        $donnees = $req->fetchAll();

        // Checks if one or more fields are empty
        if(isset($_POST['phone_user']) AND isset($_POST['gender_user']) AND isset($_POST['birth_user']) AND isset($_POST['biography_user']) AND (empty($_POST['phone_user']) OR empty($_POST['gender_user']) OR empty($_POST['birth_user']) OR empty($_POST['biography_user'])))
        {
            echo 'Tu as laissé un ou plusieurs champs vide(s).';
        }
        
        // Updates the data inputted in the form in the database
        elseif(isset($_POST['phone_user']) AND isset($_POST['gender_user']) AND isset($_POST['birth_user']) AND isset($_POST['biography_user']) AND !empty($_POST['phone_user']) AND !empty($_POST['gender_user']) AND !empty($_POST['birth_user']) AND !empty($_POST['biography_user']))
        {
        $req_2 = $bdd->prepare('UPDATE user SET phone_user = :phone_user, gender_user = :gender_user, birth_user = :birth_user, biography_user = :biography_user WHERE id_user = :id_user');
        $req_2->execute(array(
         
        'phone_user' => $_POST['phone_user'],
        'gender_user' => $_POST['gender_user'],
        'birth_user' => $_POST['birth_user'],
        'biography_user' => $_POST['biography_user'],
        'id_user' => $_SESSION['id_user']
         
        ));
         
        // Redirects the user to the initial page
        header("location:".  $_SERVER['HTTP_REFERER']);

        } else
    
            {
                echo 'Vous devez être connecté pour avoir accés à cette page';
            }
         
    }

?>