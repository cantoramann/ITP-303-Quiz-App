<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == false || !isset($_SESSION["username"])) {
    header("Location: ./login.php");
}

$classID = $_GET["classID"];

require './util/db.php';
require './question.php';

$questions;
$questions_returned = GetRandomQuestionsWithID($classID);
$classname = GetClassName($classID);


$questions_array = [];
while ($row = mysqli_fetch_row($questions_returned)) {
    $qs = new question;
    $qs->qs = $row[0];
    $qs->a = $row[1];
    $qs->b = $row[2];
    $qs->c = $row[3];
    $qs->d = $row[4];
    $qs->answer = $row[5];
    array_push($questions_array, $qs);
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../style/home.css">
    <link rel="stylesheet" href="../style/post.css">
    <link rel="stylesheet" href="../style/takequiz.css">

    <!-- Ext. Libraries -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.5.9/dist/css/uikit.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.9/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.9/dist/js/uikit-icons.min.js"></script>
</head>
<body>
    <?php include './navbar.php'?>
    <div class="content-fit">
        <section class="quiz-header">
            <h1 class="uk-text-large">Quiz Time!</h1>
            <h2 class="class-name uk-text-medium type-lover" animation-delay="100">
                <?php echo $classname; ?>
            </h2>
        </section>
        <div class="question-div uk-margin-large">
            <div class="question-details-div">
                <div class="question-text"></div>
                <p class="question-option a"></p>
                <p class="question-option b"></p>
                <p class="question-option c"></p>
                <p class="question-option d"></p>
                <p class="answer"></p>
            </div>
        </div>
        <div class="question-div uk-margin-large">
            <div class="question-details-div">
                <div class="question-text"></div>
                <p class="question-option a"></p>
                <p class="question-option b"></p>
                <p class="question-option c"></p>
                <p class="question-option d"></p>
                <p class="answer"></p>
            </div>
        </div>
        <div class="question-div uk-margin-large">
            <div class="question-details-div">
                <div class="question-text"></div>
                <p class="question-option a"></p>
                <p class="question-option b"></p>
                <p class="question-option c"></p>
                <p class="question-option d"></p>
                <p class="answer"></p>
            </div>
        </div>
        <p class="score uk-margin-large-bottom uk-text-large"></p>
        <button class="uk-button uk-button-default uk-margin-large-bottom submit-test">Submit</button>
        <button class="uk-button uk-button-default uk-margin-large-bottom again">Again</button>
        <button class="uk-button uk-button-default uk-margin-large-bottom back-button">Back</button>



    </div>
    
    <script src="../js/typeLover.js"></script>
    <script>
        let questions = document.querySelectorAll(".question-details-div");
            
        questions.forEach( 
        function(currentValue, currentIndex, listObj) { 
            if (currentIndex == 0) {
                currentValue.children[0].innerHTML = '<?php echo($questions_array[0]->qs) ?>';
                currentValue.children[1].innerHTML = '<?php echo($questions_array[0]->a) ?>';
                currentValue.children[2].innerHTML = '<?php echo($questions_array[0]->b) ?>';
                currentValue.children[3].innerHTML = '<?php echo($questions_array[0]->c) ?>';
                currentValue.children[4].innerHTML = '<?php echo($questions_array[0]->d) ?>';
                currentValue.children[5].innerHTML = '<?php echo($questions_array[0]->answer) ?>';
            }
            if (currentIndex == 1) {
                currentValue.children[0].innerHTML = '<?php echo($questions_array[1]->qs) ?>';
                currentValue.children[1].innerHTML = '<?php echo($questions_array[1]->a) ?>';
                currentValue.children[2].innerHTML = '<?php echo($questions_array[1]->b) ?>';
                currentValue.children[3].innerHTML = '<?php echo($questions_array[1]->c) ?>';
                currentValue.children[4].innerHTML = '<?php echo($questions_array[1]->d) ?>';
                currentValue.children[5].innerHTML = '<?php echo($questions_array[1]->answer) ?>';


            }
            if (currentIndex == 2) {
                currentValue.children[0].innerHTML = '<?php echo($questions_array[2]->qs) ?>';
                currentValue.children[1].innerHTML = '<?php echo($questions_array[2]->a) ?>';
                currentValue.children[2].innerHTML = '<?php echo($questions_array[2]->b) ?>';
                currentValue.children[3].innerHTML = '<?php echo($questions_array[2]->c) ?>';
                currentValue.children[4].innerHTML = '<?php echo($questions_array[2]->d) ?>';
                currentValue.children[5].innerHTML = '<?php echo($questions_array[1]->answer) ?>';
            }
        }
    );
    </script>
    <script>
        let all_options = document.querySelectorAll(".question-option");

        for (let i = 0; i < all_options.length; i++) {
            
            all_options.item(i).addEventListener("click", () => {
                let current = all_options.item(i);
                let parent = current.parentNode;
                for (let j = 0; j < parent.children.length; j++) {
                    parent.children.item(j).classList.remove("selected");
                }
                current.classList.add("selected");
            })
        }

        let button = document.querySelector(".submit-test");
        button.addEventListener("click", () => {
            //check if the question has a selected
            let all_divs = document.querySelectorAll(".question-details-div");

            var correct = 0;
            for (let i = 0; i < all_divs.length; i++) {
                let current = all_divs.item(i);

                var selected;
                let answer_char = current.children[5].innerHTML;
                answer_char.trim();
                var answer;

                for (let j = 0; j < current.children.length; j++) {
                    if (current.children[j].classList.contains("selected")) {
                        selected = current.children[j];
                    } if (current.children[j].classList.contains(answer_char)) {
                        answer = current.children[j];
                    }
                }

                if (selected == answer) {
                    selected.classList.add("selected-correct");
                    selected.classList.remove("selected");
                    correct ++;
                } else {
                    answer.classList.add("selected-wrong");
                }
            }
            document.querySelector(".score").innerHTML = "Your score is " + correct + " out of 3";
            if (correct == 3 || correct == "3") {
                document.querySelector(".score").classList.add("green");
            }
            else if (correct == 2 || correct == "2") {
                document.querySelector(".score").classList.add("yellow");
            }
            else {
                document.querySelector(".score").classList.add("red");
            }

        })

        let again = document.querySelector(".again");
        again.addEventListener("click", () => {
            document.querySelector(".score").innerHTML = "";
            let options = document.querySelectorAll(".question-option");
            for (let i = 0; i < options.length; i++) {
                document.querySelector(".score").classList.remove("red");
                document.querySelector(".score").classList.remove("yellow");
                document.querySelector(".score").classList.remove("green");

                options.item(i).classList.remove("selected")
                options.item(i).classList.remove("selected-correct")
                options.item(i).classList.remove("selected-wrong")
            }
        })

        let back = document.querySelector(".back-button");
        back.addEventListener("click", () => {
            window.location.href = "./quiz.php";
        })

    </script>

</body>
</html>