<?php

require '../model/connexion_bdd_ajax.php';

$nicknameUser = htmlspecialchars($_POST['nickname']);
$mailUser = htmlspecialchars($_POST['email']);
$passwordUser = htmlspecialchars($_POST['password']);


//$passwordUser hashed by password_default algo
$hashedPassword = password_hash($passwordUser, PASSWORD_DEFAULT);

//verify if $nicknameUser and $mailUser exists in $bdd
$sql = $bdd->prepare('SELECT EXISTS (SELECT * FROM user WHERE mail_user = :MAIL) AS mail_exist, EXISTS (SELECT * FROM user WHERE nickname_user = :NICKNAME) AS nickname_exist;');

//execute $sql
$sql->execute([
    'MAIL' => $mailUser,
    'NICKNAME' => $nicknameUser,
]);

//catch $sql result
$result = $sql->fetch();

//check if user already exists
if ($result['mail_exist'] == 1 or $result['nickname_exist'] == 1) {

    //redirect to register
    header('Location: ../register.php'); //header("location:" .  $_SERVER['HTTP_REFERER']);

    exit();
} else {
    //insert into user values
    $db = $bdd->prepare('INSERT INTO user (nickname_user, mail_user, pass_user) VALUES (:NICKNAME, :MAIL, :PASS)');

    //execute request
    $db->execute([
        'NICKNAME' => $nicknameUser,
        'MAIL' => $mailUser,
        'PASS' => $hashedPassword
    ]);

    //start session 
    session_start();

    //assign lastInsertID to id_user session and open session[id_user]
    $_SESSION['id_user'] = $bdd->lastInsertId();

    //redirect to dashbord page
    header("Location: ../dashboard.php");
    exit();
}
