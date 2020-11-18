<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == false || !isset($_SESSION["username"])) {
    header("Location: ./login.php");
}

require './util/db.php';

$questionid = $_GET["id"];
if (DeleteQuestion($questionid)) {
    echo "well";
} else {
    echo 'non well';
}
