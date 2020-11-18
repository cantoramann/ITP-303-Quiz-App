<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == false || !isset($_SESSION["username"])) {
    header("Location: ./login.php");
}

require './util/db.php';

$questionid;
$question_text;
$classname;
$question_a;
$question_b;
$question_c;
$question_d;
if (isset($_GET["details_direct_transfer"])) {
    $questionid = $_GET["questiondetailsid"];
    $question = GetQuestion($questionid);

    $question_text = $question[1];
    $question_text = trim($question_text);
    $classname = $question[10];

    $question_a = $question[2];
    $question_b = $question[3];
    $question_c = $question[4];
    $question_d = $question[5];
    $correct = $question[6];

    $_SESSION["details_questionid"] = $questionid;
    $_SESSION["details_question_text"] = $question_text;
    $_SESSION["details_classname"] = $classname;
    $_SESSION["details_question_a"] = $question_a;
    $_SESSION["details_question_b"] = $question_b;
    $_SESSION["details_question_c"] = $question_c;
    $_SESSION["details_question_d"] = $question_d;
    $_SESSION["details_correct"] = $correct;
} else {
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CS Trivia</title>

    <title>CS@USC Trivia</title>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../style/home.css">
    <link rel="stylesheet" href="../style/questiondetails.css">

    <!-- Ext. Libraries -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.5.9/dist/css/uikit.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.9/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.9/dist/js/uikit-icons.min.js"></script>

</head>
<body>
    <script>
        function DeleteQuestion() {
            
            questionid = document.getElementById("question-id").innerHTML;
            document.getElementById("spinner").classList.remove("hidden");
            document.getElementById("message").innerHTML = "";

            var xhttp;
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("spinner").classList.add("hidden");
                    window.location.href = "./questionsposted.php";
                } else {
                    document.getElementById("spinner").classList.add("hidden");
                }
            };
            questionid.trim();
            xhttp.open("GET", "deletequestion.php?id=" + questionid, true);
            xhttp.send();
        }
    </script>
    <?php include 'navbar.php';?>
    <div class="content-fit">
        <form>
            <div class="hidden">Question id <p id="question-id"><?php echo $_SESSION["details_questionid"]; ?></p></div>
            <fieldset class="uk-fieldset">

                <legend class="uk-legend">Edit Question</legend>
                <span class="uk-badge"><?php echo $_SESSION["details_classname"]; ?></span>

                <div uk-spinner id="spinner"></div>

                <div class="uk-margin">
                    <p id="question-text"><?php echo $_SESSION["details_question_text"];?></p>
                </div>
                <div class="choices">
                    <h1><a class="a">Choice A: </a><?php echo $_SESSION["details_question_a"]; ?></h1>
                    <h1><a class="b">Choice B: </a><?php echo $_SESSION["details_question_b"]; ?></h1>
                    <h1><a class="c">Choice C: </a><?php echo $_SESSION["details_question_c"]; ?></h1>
                    <h1><a class="d">Choice D: </a><?php echo $_SESSION["details_question_d"]; ?></h1>
                    <h1><a class="correct">Correct Choice: </a><?php echo $_SESSION["details_correct"]; ?></h1>
                </div>

                <p uk-margin>
                    <button type="submit" class="uk-button uk-button-danger" onclick="DeleteQuestion()">Delete Question</button>
                </p>
                <p id="message"></p>

            </fieldset>
        </form>
    </div>

    <script>
        let form = document.getElementById("question-text");
        document.querySelector("button").addEventListener("click", (e) => {    
            e.preventDefault();
        })      

        
    </script>
</body>
</html>