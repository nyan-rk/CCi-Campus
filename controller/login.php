<?php

session_start();

require '../model/connexion_bdd_ajax.php';

//SQL request => select all from users table
$ru = $bdd->query("SELECT * FROM user WHERE mail_user = '". $_POST['email']  ."' AND pass_user = '". $_POST['password'] . "'");

//step test condition if my request is false
if ($ru === false) {
    echo $bdd->errorInfo()[2]; //msg index 2 come from errorInfo :  database
    exit();
};

// fetch data from $ru
$user = $ru->fetchAll(PDO::FETCH_ASSOC); 

//check login
if($_POST['email'] === $user[0]['mail_user'] and $_POST['password'] === $user[0]['pass_user']) 
{ 
    $_SESSION ['id'] = $user['id_user'] ; // logged
    header('Location: ../index.php'); // redirect index.php 

} else {
    header('Location: ../index.php');

    if( $_POST['email'] != $user[0]['mail_user'] and $_POST['password'] != $user[0]['pass_user']){
        $_SESSION['errors'] = [
            'Email not valid',
            'Password not valid'
        ];

    } elseif ($_POST['email'] != $user['mail_user']){
        $_SESSION['errors'] =[
            'Email not valid'
        ];

    } else {
        $_SESSION['errors'] =[
            'Password not valid'
        ];

    }
}
