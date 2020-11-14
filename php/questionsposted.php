

<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == false || !isset($_SESSION["username"])) {
    header("Location: ./login.php");
}

require './util/db.php';
$results_classes = GetAllClasses();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CS Trivia</title>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../style/home.css">
    <link rel="stylesheet" href="../style/post.css">

    <!-- Ext. Libraries -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.5.9/dist/css/uikit.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.9/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.9/dist/js/uikit-icons.min.js"></script>

    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.5.9/dist/css/uikit.min.css" />

    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.9/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.9/dist/js/uikit-icons.min.js"></script>
</head>
<body>
<script>
    function RetrieveClassesAJAX(str) {

        var xhttp;
        if (str == "") {
            return;
        }
        xhttp = new XMLHttpRequest();
        document.getElementById("spinner").style = "display:block;"
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
            document.getElementById("spinner").style = "display:none;"
            document.getElementById("questions-output").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "classesajax.php?val="+str, true);
        xhttp.send();
    }
</script>
<?php require './navbar.php'; ?>

<div class="content-fit">
<form>
    <fieldset class="uk-fieldset">
        
        <legend class="uk-legend">Your Questions</legend>
        <div uk-spinner id="spinner"></div>

        <div class="uk-margin">
            <select class="uk-select" onchange="RetrieveClassesAJAX(this.value)">
                <option value="All">All</option>
                <?php while ($row = $results_classes->fetch_assoc()): ?>
                    <option value="<?php echo $row['id']; ?>">
                        <?php echo $row['class_name']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

    </fieldset>
    <div id="questions-output"></div>
    <script>RetrieveClassesAJAX("All")</script>
</form>
</div>
</body>
</html>

