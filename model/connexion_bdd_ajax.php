<?php

try {

    $bdd = new PDO('mysql:host=localhost;port=3306;dbname=cardly;charset=utf8', 'admin', 'estelle_albuisson67');

} catch (Exception $a) {

    die('Erreur: ' . $a->getMessage());

}
require 'diag.php';
require 'guest_access.php';
require 'stack.php';
require 'task.php';
require 'team_affiliation.php';
require 'teams.php';
require 'user.php';
require 'view_history.php';
