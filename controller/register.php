<?php

require '../model/connexion_bdd_ajax.php';

$nickname = $_POST['nickname'];
$email = $_POST['email'];
$password = $_POST['password'];


//SQL request => insert into users
$ru = $bdd->query("INSERT INTO user (nickname_user, mail_user, pass_user) VALUES ('$nickname', '$email', '$password')");

//condition if false
if ($ru === false) {
    echo $bdd->errorInfo()[2];
    exit();
};

// fetch data from $ru
$ru->fetchAll(PDO::FETCH_ASSOC);


// Vérifier si le nom existe / mdp existe / mail existe / format mail existe

//check login
if($email === $user[0]['mail_user'] and $_POST['password'] === $user[0]['pass_user']) 
{ 
    $_SESSION ['id'] = $user['id_user'] ; // logged
    header('Location: ../accueil'); // redirect index.php 

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