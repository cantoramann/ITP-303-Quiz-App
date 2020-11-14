<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == false || !isset($_SESSION["username"])) {
    header("Location: ./login.php");
}
    $alertMessage = 0;
    //load util;
    require './util/db.php';
    require './util/hash.php';
    
    //Data needed for the form
    $results_classes = GetAllClasses();
    $error = "";

    //Check validity
    if (isset($_POST["question"]) && !empty($_POST["question"]) && isset($_POST["a"]) && !empty($_POST["a"]) &&
    isset($_POST["b"]) && !empty($_POST["b"]) && isset($_POST["c"]) && !empty($_POST["c"])
    && isset($_POST["d"]) && !empty($_POST["d"]) && isset($_POST["correct"]) && !empty($_POST["correct"]) && isset($_POST["classID"]) && !empty($_POST["classID"])) {
        $student_id = $_SESSION["id"];
        $success = CreateQuestion($_POST["question"], $_POST["a"], $_POST["b"], $_POST["c"], $_POST["d"], $_POST["correct"], $student_id, $_POST["classID"]);
        if ($success) {
            $alertMessage = 1;
        } else {
            $alertMessage = -1;
        }
    } else {
        $error = "Please fill all fields";
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
    <?php
        include './navbar.php';
    ?>
    <div id="alert-success"></div>
    <div class="content-fit">
        <?php
            if ($alertMessage == 1) {
                echo '<div class="uk-alert-success" uk-alert>';
                echo '<a class="uk-alert-close" uk-close></a>';
                echo '<p>Success! Question posted!</p>';
                echo '</div>';
            } elseif ($alertMessage == -1) {
                echo '<div class="uk-alert-danger" uk-alert>';
                echo '<a class="uk-alert-close" uk-close></a>';
                echo '<p>Failure! Question could not be posted :(</p>';
                echo '</div>';
            }
        ?>
   
    <form method="POST">
    <fieldset class="uk-fieldset">

        <p class="post-error-message uk-margin-medium-bottom">
            <?php
                if (!empty($error)) {
                    echo $error;
                }
            ?>
        </p>
        <legend class="uk-legend">Post Question</legend>

        <p class="uk-margin-medium-top">Associated Class</p>
        <div class="uk-margin">
            <select class="uk-select" name="classID">
                <?php while ($row = $results_classes->fetch_assoc()): ?>
                    <option value="<?php echo $row['id']; ?>">
                    <?php echo $row['class_name']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <p class="uk-margin-medium-top">Question</p>
        <div class="uk-margin">
            <textarea class="uk-textarea" rows="5" placeholder="Question" name="question"></textarea>
        </div>

        <p class="uk-margin-medium-top">Answer Choices</p>
        <div class="uk-margin">
            <textarea class="uk-textarea" rows="5" placeholder="Answer A" name="a"></textarea>
        </div>
        <div class="uk-margin">
            <textarea class="uk-textarea" rows="5" placeholder="Answer B" name="b"></textarea>
        </div>
        <div class="uk-margin">
            <textarea class="uk-textarea" rows="5" placeholder="Answer C" name="c"></textarea>
        </div>
        <div class="uk-margin">
            <textarea class="uk-textarea" rows="5" placeholder="Answer D" name="d"></textarea>
        </div>

        <p class="uk-margin-medium-top">Correct Answer</p>
        <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
            <label><input class="uk-radio" type="radio" name="correct" value="a"> A</label>
            <label><input class="uk-radio" type="radio" name="correct" value="b"> B</label>
            <label><input class="uk-radio" type="radio" name="correct" value="c"> C</label>
            <label><input class="uk-radio" type="radio" name="correct" value="d"> D</label>
        </div>

        <input type="submit" class="post-button uk-margin-medium-bottom">

    </fieldset>
    </form>
    </div>

</body>
</html>