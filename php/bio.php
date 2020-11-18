<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == false || !isset($_SESSION["username"])) {
    header("Location: ./login.php");
}

require './util/db.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CS@USC Trivia</title>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../style/bio.css">

    <!-- Ext. Libraries -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.5.9/dist/css/uikit.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.9/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.9/dist/js/uikit-icons.min.js"></script>


</head>
<body>
    <?php require './navbar.php'; ?>
    <div class="content-fit">
        <form>
            <fieldset class="uk-fieldset">

                <legend class="uk-legend">Your Username</legend>
                <div class="uk-margin">
                    <p><?php echo $_SESSION["username"];?></p>
                </div>
                <legend class="uk-legend">Your Password</legend>
                <div uk-spinner class="spin-password" style="display:none;"></div>

                <div class="uk-margin">
                    <input class="uk-input password" type="password" placeholder="Type new password">
                </div>
                <div class="uk-margin">
                    <input class="uk-input passwordconfirm" type="password" placeholder="Confirm new password">
                </div>
                <div class="uk-margin" uk-margin>
                    <p class="error"></p>
                    <button class="uk-button uk-button-default" disabled>Submit</button>
                </div>
            </fieldset>
        </form>
        <p class="submission-message"></p>
    </div>

    <script>


        document.querySelector(".password").addEventListener("input", (e) => {
            entry = document.querySelector(".password").value;
            if (entry.includes("'") || entry.includes("\"") || entry.includes(" ") || entry.includes(",") || entry.includes("?") || entry.includes("!") || entry.includes("@")) {
                document.querySelector(".error").innerHTML = "Invalid character"
                document.querySelector(".uk-button").setAttribute("disabled", "")
                invalidchar = true;
                return;
            } else {
                document.querySelector(".error").innerHTML = ""
                document.querySelector(".uk-button").removeAttribute("disabled")
            }
            if (entry != document.querySelector(".passwordconfirm").value) {
                document.querySelector(".error").innerHTML = "Passwords do not match"
                document.querySelector(".uk-button").setAttribute("disabled", "");
                return;
            } else {
                document.querySelector(".error").innerHTML = ""
                document.querySelector(".uk-button").removeAttribute("disabled")
            }
            if (entry.trim() == "") {
                document.querySelector(".error").innerHTML = "Password is empty"
                document.querySelector(".uk-button").setAttribute("disabled", "");
                return;
            } else {
                document.querySelector(".error").innerHTML = ""
                document.querySelector(".uk-button").removeAttribute("disabled")
            }
        })

        document.querySelector(".passwordconfirm").addEventListener("input", (e) => {
            entry = document.querySelector(".passwordconfirm").value;
            if (entry.includes("'") || entry.includes("\"") || entry.includes(" ") || entry.includes(",") || entry.includes("?") || entry.includes("!") || entry.includes("@")) {
                document.querySelector(".error").innerHTML = "Invalid character"
                document.querySelector(".uk-button").setAttribute("disabled", "")
                invalidchar = true;
                return;
            } else {
                document.querySelector(".error").innerHTML = ""
                document.querySelector(".uk-button").removeAttribute("disabled")
            }
            if (entry != document.querySelector(".password").value) {
                document.querySelector(".error").innerHTML = "Passwords do not match"
                document.querySelector(".uk-button").setAttribute("disabled", "");
                return;
            } else {
                document.querySelector(".error").innerHTML = ""
                document.querySelector(".uk-button").removeAttribute("disabled")
            }
            if (entry.trim() == "") {
                document.querySelector(".error").innerHTML = "Password is empty"
                document.querySelector(".uk-button").setAttribute("disabled", "");
                return;
            } else {
                document.querySelector(".error").innerHTML = ""
                document.querySelector(".uk-button").removeAttribute("disabled")
            }
        })

        document.querySelector("form").addEventListener("submit", (e) => {
            e.preventDefault();
            password = document.querySelector(".password").value;
            if (password.length != 0) {
                var xhttp;
                xhttp = new XMLHttpRequest();
                document.querySelector(".spin-password").style = "display:block;"
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.querySelector(".spin-password").style = "display:none;"
                        document.querySelector(".submission-message").innerHTML = this.responseText;
                    }
                };
                xhttp.open("GET", "updatepasswordajax.php?pass="+password, true);
                xhttp.send();
            }
        })

    </script>
</body>
</html>