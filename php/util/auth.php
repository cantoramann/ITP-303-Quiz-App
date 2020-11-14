<?php
if (!isset($_SEESION["username"]) && !isset($_SESSION["logged_in"]) && $_SEESION["logged_in"] == false) {
    header('Location: ../login.php');
}
