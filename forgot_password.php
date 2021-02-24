<?php
// On démarre la session AVANT toute chose
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "./controller/initPage.php";
initPage();
