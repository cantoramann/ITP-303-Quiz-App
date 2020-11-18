<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == false || !isset($_SESSION["username"])) {
    header("Location: ./login.php");
}

require './util/db.php';

$id = $_SESSION["id"];
if (isset($_GET["pass"]) && !empty($_GET["pass"])) {
    $username = $_GET["pass"];
    if (UpdatePassword($id, $username)) {
        echo '<div class="uk-alert-success" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <p>Username: changed successfully!</p>
        </div>';
    } else {
        echo '<div class="uk-alert-danger" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <p>Username: soemthing went wrong</p>
        </div>';
    }
}
