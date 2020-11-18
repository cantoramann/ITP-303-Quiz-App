<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == false || !isset($_SESSION["username"])) {
    header("Location: ./login.php");
}

require './util/db.php';
    $questionsPosted = QuestionNumberPosted($_SESSION['id']);
    $uniqueClassesPosted = SelectDistinctClassesByUser($_SESSION['id']);
    $description = GetDescription($_SESSION["id"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CS@USC Trivia</title>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../style/home.css">

    <!-- Ext. Libraries -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.5.9/dist/css/uikit.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.9/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.9/dist/js/uikit-icons.min.js"></script>

</head>
<body>
    <?php include './navbar.php' ?>
    <div class="content-fit">
    <div class="uk-child-width-1-2@m uk-text-center uk-flex-center" uk-grid>
        <ul uk-accordion>
        <li class="uk-open">
            <a class="uk-accordion-title" href="#">Questions posted</a>
            <div class="uk-accordion-content">
                <p>You have posted <a href="questionsposted.php" id="numberofqsposted"><?php echo $questionsPosted; ?></a> questions! Great job!</p>
            </div>
        </li>
        <li>
            <a class="uk-accordion-title" href="#">Classes</a>
            <div class="uk-accordion-content">
                <p>You have posted questions about <?php echo $uniqueClassesPosted ?> different classes!</p>
            </div>
        </li>
        <li>
            <a class="uk-accordion-title" href="#">Your Bio!</a>
            <div class="uk-accordion-content">
                <p><?php echo $description; ?></p>
                <a href="bio.php">Update your bio!</a>
            </div>
        </li>
        </ul>
    </div>
    

    <div class="uk-child-width-1-2@s uk-text-center" uk-grid>
        <div>
            <div class="uk-card uk-card-default uk-card-body">
                <h3 class="uk-card-title">Post Questions</h3>
                <p>Want to post your <a href="post.php">own questions</a> to the server? Yes, you can! Absolutely! Make sure they are about the department!</p>
            </div>
        </div>
        <div>
        <div class="uk-card uk-card-default uk-card-body">
                <h3 class="uk-card-title">Take Quiz</h3>
                <p>Want to take a quiz from random questions about your department? <a href="quiz.php">Take it now!</a></p>
            </div>
        </div>
        <div>

    </div>
    </div>
</body>
</html>