<?php

require '../model/connexion_bdd_ajax.php';

$mailUser = htmlspecialchars($_POST['email']);
$passwordUser = htmlspecialchars($_POST['password']);

//hashedPassword by password_default algo
$hashedPassword = password_hash($passwordUser, PASSWORD_DEFAULT);


//prepare request with 3 parameters values
$db = $bdd->prepare("SELECT * FROM user WHERE mail_user = '$mailUser'");

//execute request
$db->execute();

//recup $hashedPassword
$req = $db->fetch();

//check if password($_post['password']) match with pass_user
$result = password_verify($passwordUser, $req['pass_user']);

if ($result == true) {
    //start session 
    session_start();

    //assign session['id_user'] to $req['id_user']
    $_SESSION['id_user'] = $req['id_user'];
    header("Location: ../dashboard.php");
    exit();
} else {
    header('Location: ../login.php');
    exit();
}
