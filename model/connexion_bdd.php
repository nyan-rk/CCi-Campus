<?php

try {

    $bdd = new PDO('mysql:host=localhost;port=3306;dbname=cardly;charset=utf8', 'root', ''); //J8qD3ogRYe6kTi&&

} catch (Exception $a) {
    
    die('Erreur: ' . $a->getMessage());
}

require './model/diag.php';
require './model/guest_access.php';
require './model/history.php';
require './model/stack.php';
require './model/task.php';
require './model/team_affiliation.php';
require './model/teams.php';
require './model/user.php';
