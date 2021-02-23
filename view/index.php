<?php

//check if user is connected
if (isset($_SESSION['id_user'])) {
    header('Location: dashboard.php');
    exit();
};

?>

<body>

    <h1>Cardly</h1>

    <br>

    <a href="index.php">Accueil</a>

    <br>

    <a href="login.php">Connexion</a>

    <br>

    <a href="register.php">Inscription</a>


</body>