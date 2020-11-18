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
    if (!isset($_POST["question"]) || !isset($_POST["a"]) || !isset($_POST["b"]) || !isset($_POST["c"]) || !isset($_POST["d"]) || !isset($_POST["classID"])) {
        $error = "";
    } else {
        if (empty($_POST["question"]) || empty($_POST["a"]) || empty($_POST["b"]) || empty($_POST["c"]) || empty($_POST["d"]) || empty($_POST["correct"]) || empty($_POST["classID"])) {
            $error = "Please fill all fields";
        } else {
            $student_id = $_SESSION["id"];
            $success = CreateQuestion($_POST["question"], $_POST["a"], $_POST["b"], $_POST["c"], $_POST["d"], $_POST["correct"], $student_id, $_POST["classID"]);
            if ($success) {
                $alertMessage = 1;
            } else {
                $alertMessage = -1;
            }
        }
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
            <textarea class="uk-textarea question" rows="5" placeholder="Question" name="question"></textarea>
        </div>

        <p class="uk-margin-medium-top">Answer Choices</p>
        <div class="uk-margin">
            <textarea class="uk-textarea a" rows="5" placeholder="Answer A" name="a"></textarea>
        </div>
        <div class="uk-margin">
            <textarea class="uk-textarea b" rows="5" placeholder="Answer B" name="b"></textarea>
        </div>
        <div class="uk-margin">
            <textarea class="uk-textarea c" rows="5" placeholder="Answer C" name="c"></textarea>
        </div>
        <div class="uk-margin">
            <textarea class="uk-textarea d" rows="5" placeholder="Answer D" name="d"></textarea>
        </div>

        <p class="uk-margin-medium-top">Correct Answer</p>
        <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
            <label><input class="uk-radio" type="radio" name="correct" value="a"> A</label>
            <label><input class="uk-radio" type="radio" name="correct" value="b"> B</label>
            <label><input class="uk-radio" type="radio" name="correct" value="c"> C</label>
            <label><input class="uk-radio" type="radio" name="correct" value="d"> D</label>
        </div>

        <input type="submit" class="post-button uk-margin-medium-bottom" id="post-button">

    </fieldset>
    </form>
    </div>

    <script>
        document.querySelector("form").addEventListener("submit", (e) => {
            question = document.querySelector(".question").value;
            a = document.querySelector(".a").value
            b = document.querySelector(".b").value
            c = document.querySelector(".c").value
            d = document.querySelector(".d").value

            var correct = null;
            var radios = document.getElementsByName('correct');     
            for(i = 0; i < radios.length; i++) { 
                if(radios[i].checked) {
                    correct = radios[i];
                }
            }
            if (correct == null || question.length == 0 || a.length == 0 || b.length == 0 || c.length == 0 || d.length == 0) {
                e.preventDefault();
                document.querySelector(".post-error-message").innerHTML = "Please fill all fields";
                console.log(correct, question, a, b, c, d);
            }
            
        })

    </script>

</body>
</html>