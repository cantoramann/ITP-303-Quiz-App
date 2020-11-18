<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == false || !isset($_SESSION["username"])) {
    header("Location: ./login.php");
}

require './util/db.php';

$class_id = $_GET["val"];
$result;
if ($class_id == "All") {
    $result = GetAllStudentQuestions($_SESSION["id"]);
} else {
    $result = GetQuestionsFromUserGivenClass($class_id, $_SESSION["id"]);
}

if ($result == null) {
    echo'<p style="color:red">You have no question yet for this class</p>';
} else {
    echo '<div class="uk-overflow-auto">';
    echo '<table class="uk-table uk-table-small uk-table-divider">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>Class</th>';
    echo '<th>Question</th>';
    echo '</tr>';
    echo '</thead>';
    echo'<tbody>';
    while ($row = mysqli_fetch_row($result)) {
        echo '<tr>';
        $qs = $row[0];
        $class_name = $row[6];
        $question_id = $row[7];
        echo '<td>' . $question_id . '</td>';
        echo '<td>' . $class_name . '</td>';
        echo '<td><a href="questiondetails.php?details_direct_transfer=true&questiondetailsid=' . $question_id . '">'. $qs . '</a></td>';
        echo '</tr>';
    }
    
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
}
