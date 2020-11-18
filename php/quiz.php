<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == false || !isset($_SESSION["username"])) {
    header("Location: ./login.php");
}

    //load util;
    require './util/db.php';
    require './util/hash.php';
    
    //Data needed for the form
    $results_classes = GetAllClasses();
    $error = "";

    //Check validity
    if (isset($_GET["classID"]) && !empty($_GET["classID"])) {
        $questions;
        if ($_GET["classID"] != "-1") {
            $questions = GetClassQuestions($_GET["classID"]);
        } else {
            $questions = GetRandomQuestions();
        }
        if ($questions->num_rows < 3) {
            $error = "There are not enough questions for a quiz for the selected course. <a href='./post.php'>Wanna post?</a>";
        } else {
            header("Location: ./takequiz.php?classID='" . $_GET["classID"] . "'");
        }
    } else {
        $error = "Select a class";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CS@USC Trivia</title>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../style/home.css">
    <link rel="stylesheet" href="../style/post.css">

    <!-- Ext. Libraries -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.5.9/dist/css/uikit.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.9/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.9/dist/js/uikit-icons.min.js"></script>

</head>
<body>
    <?php include './navbar.php' ?>
    <div class="content-fit">

        <div class="uk-section uk-section-muted uk-margin-small-bottom">
            <div class="uk-container">
                <div class="uk-margin">

                    <form method="GET">
                        <fieldset class="uk-fieldset">
                            <legend class="uk-legend">Select Class</legend>
                            <div class="uk-margin">
                                <select class="uk-select" id="select" name="classID">
                                    <?php while ($row = $results_classes->fetch_assoc()): ?>
                                        <option value="<?php echo $row['id']; ?>">
                                        <?php echo $row['class_name']; ?>
                                    </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <button class="uk-button uk-button-default">Go!</button>
                            <p class="uk-margin-medium-top post-error-message">
                                <?php
                                if (!empty($error)) {
                                    echo $error;
                                }
                                ?>
                            </p>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>