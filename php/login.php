<?php

if (isset($_SESSION["username"]) && !empty($_SESSION["username"])) {
    header("Location: ./home.php");
}

// Server-side input validation
$error = "";
if (!isset($_POST['username']) || !isset($_POST['password'])) {
    $error = "";
} elseif (empty($_POST['username']) || empty($_POST['password'])) {
    $error = "Please fill all required fields";
} else {

    // connect to db
    require './util/db.php';
    require './util/hash.php';


    //hash password
    $passwordhashed = hashPassword($_POST["password"]);

    // Check if username and password exist (aka exists in the users table)
    if (CheckIfExists($_POST['username'], $passwordhashed)) {
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $_POST["username"];
        $_SESSION['id'] = GetID($_POST['username']);
        header("Location: ./home.php");
    } else {
        $error = "No account found";
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
    <link rel="stylesheet" href="../style/login.css">

    <!-- Ext. Libraries -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.5.9/dist/css/uikit.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.9/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.9/dist/js/uikit-icons.min.js"></script>
<body>
    <?php include './navbar.php' ?>

    <div class="content-fit">
    <div class="form-div">
        <form action="" class="login" method="POST">
            <h1>Create Account</h1>
            <div class="uk-margin">
                <div class="uk-inline">
                    <span class="uk-form-icon" uk-icon="icon: user"></span>
                    <input class="uk-input uk-form-width-large username-input" type="text" placeholder="username" name="username">
                </div>
            </div>

            <div class="uk-margin">
                <div class="uk-inline">
                    <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
                    <input class="password-match-input uk-input uk-form-width-large password-input" type="password" placeholder="password" name="password">
                    </div>
                </div>
                <input type="submit" class="login-form-button"></button>
                <p class="login-error-message"><?php
                    if (!empty($error)) {
                        echo $error;
                    }
                ?>
                </p>
            </div>
        </form>
    </div>
    </div>
    <script>

        message = document.querySelector(".login-error-message");

        document.querySelector('form').addEventListener("submit", (e) => {
            username = document.querySelector(".username-input").value;
            password = document.querySelector(".password-input").value;
            username = username.trim();
            password = password.trim();

            if (username.length == 0 || password.length == 0) {
                console.log("username", username);
                console.log("password", password);
                e.preventDefault();
                message.innerHTML = "Please fill all required fields";
            }
        })

    </script>
</body>
</html>

