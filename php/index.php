<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>CS@USC Trivia</title>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../style/index.css">

    <!-- Ext. Libraries -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.5.9/dist/css/uikit.min.css" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../style/cardrotate.css">
    <script src="../js/flip.js"></script>
    <script src="https://d3js.org/d3-selection.v2.js"></script>
    
</head>
<body>
    <?php include 'navbar.php' ?>


        <div class="content-fit">
            <div class="uk-child-width-1-1@s uk-child-width-1-3@l uk-margin-medium-bottom" uk-grid="masonry: false">
                <div>
                    <div class="flipCard"> 
                        <div class="card" onclick="this.classList.toggle('flipped');"> 
                            <div class="side front">
                                <p class="class-title"></p>
                                <p class="qs-title"></p>
                            </div> 
                            <div class="side back">
                                <p class="a1"></p>
                                <p class="a2"></p>
                                <p class="a3"></p>
                                <p class="a4"></p>
                            </div> 
                        </div> 
                    </div>
                </div>        
                <div>
                    <div class="flipCard"> 
                        <div class="card" onclick="this.classList.toggle('flipped');"> 
                            <div class="side front">
                                <p class="class-title"></p>
                                <p class="qs-title"></p>
                            </div> 
                            <div class="side back">
                                <p class="a1"></p>
                                <p class="a2"></p>
                                <p class="a3"></p>
                                <p class="a4"></p>
                            </div> 
                        </div> 
                    </div>
                </div>        
                <div>
                    <div class="flipCard"> 
                        <div class="card" onclick="this.classList.toggle('flipped');"> 
                            <div class="side front">
                                <p class="class-title"></p>
                                <p class="qs-title"></p>
                            </div> 
                            <div class="side back">
                                <p class="a1"></p>
                                <p class="a2"></p>
                                <p class="a3"></p>
                                <p class="a4"></p>
                            </div> 
                        </div> 
                    </div>
                </div>             
            </div>

            <div class="about-title">
                <div>
                    <h3 class="about-header">About CS@USC Trivia</h3>
                </div>
            </div>
            <div class="about uk-margin-medium-bottom">
                <div class="about-text uk-grid-divider uk-child-width-1-1@s uk-child-width-1-3@m uk-text-center" uk-grid>
                <div>Did you ever wonder how well you know your own department? Have the test!</div>
                <div>Are there interesting/amazing facts you know about out department and faculty? Add those to our databse by posting questions!</div>
                <div>Your exact place to fully experience the computer science community at our school! <a href="./credentials.php">Join now!</a></div>
                </div>
            </div>

            <div class="uk-child-width-1-1@m uk-child-width-1-2@l uk-grid-match uk-margin-medium-top" uk-grid>
                <div>
                    <div class="uk-card uk-card uk-card-body sample-questions-card-home" style="background-color: rgb(218, 221, 216);">
                        <h3 class="uk-card-title uk-margin-small-bottom">Example Questions</h3>
                        <ul class="home-sample-questions-list">
                            <li><p>Which award has our department chair won?</p></li>
                            <li><p>Which startup founded in USC sells its products to military and aerospace communities?</p></li>
                            <li><p>With what clotes did Joe Bebel come to class with the first day of his teaching as a lecturer?</p></li>
                            <li><p>Do you want to post your own questions? <a href="./credentials.php">Post now!</a></p></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>


    <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.9/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.9/dist/js/uikit-icons.min.js"></script>
    
</body>
</html>
<?php
    require './util/db.php';
    require './question.php';
    // require '../';
    $result = GetRandomQuestions();

    $questions = [];
    while ($row = mysqli_fetch_row($result)) {
        $qs = new question;
        $qs->qs = $row[0];
        $qs->a = $row[1];
        $qs->b = $row[2];
        $qs->c = $row[3];
        $qs->d = $row[4];
        $qs->answer = $row[5];
        $qs->class_name = $row[6];
        array_push($questions, $qs);
    }
?>

<script>
    const front = d3.selectAll(".side.front");
    const front_array = front._groups[0];

    front_array.forEach( 
        function(currentValue, currentIndex, listObj) { 
            if (currentIndex == 0) {
                title = '<?php echo($questions[0]->class_name) ?>';
                currentValue.children[0].innerHTML= title;
                currentValue.children[1].innerHTML = "<?php echo($questions[0]->qs) ?>";

            }
            if (currentIndex == 1) {
                title = '<?php echo($questions[0]->class_name) ?>';
                currentValue.children[0].innerHTML= title;
                currentValue.children[1].innerHTML = "<?php echo($questions[1]->qs) ?>";

            }
            if (currentIndex == 2) {
                title = '<?php echo($questions[0]->class_name) ?>';
                currentValue.children[0].innerHTML= title;
                currentValue.children[1].innerHTML= "<?php echo($questions[2]->qs) ?>";

            }
        }
    );


    const back = d3.selectAll(".side.back");
    const back_array = back._groups[0];

    back_array.forEach( 
        function(currentValue, currentIndex, listObj) { 
            if (currentIndex == 0) {
                p1 = '<?php echo($questions[0]->a) ?>';
                p2 = '<?php echo($questions[0]->b) ?>';
                p3 = '<?php echo($questions[0]->c) ?>';
                p4 = '<?php echo($questions[0]->d) ?>';
                currentValue.children[0].innerHTML = p1;
                currentValue.children[1].innerHTML = p2;
                currentValue.children[2].innerHTML = p3;
                currentValue.children[3].innerHTML = p4;
            }
            if (currentIndex == 1) {
                p1 = '<?php echo($questions[1]->a) ?>';
                p2 = '<?php echo($questions[1]->b) ?>';
                p3 = '<?php echo($questions[1]->c) ?>';
                p4 = '<?php echo($questions[1]->d) ?>';
                currentValue.children[0].innerHTML = p1;
                currentValue.children[1].innerHTML = p2;
                currentValue.children[2].innerHTML = p3;
                currentValue.children[3].innerHTML = p4;
            }
            if (currentIndex == 2) {
                p1 = '<?php echo($questions[2]->a) ?>';
                p2 = '<?php echo($questions[2]->b) ?>';
                p3 = '<?php echo($questions[2]->c) ?>';
                p4 = '<?php echo($questions[2]->d) ?>';
                currentValue.children[0].innerHTML = p1;
                currentValue.children[1].innerHTML = p2;
                currentValue.children[2].innerHTML = p3;
                currentValue.children[3].innerHTML = p4;
            }
        }
    );
</script>