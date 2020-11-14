<?php
session_start();
$classId = $_GET["classID"];

require './util/db.php';
$questions = ReturnRandomQuestions($classId);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>