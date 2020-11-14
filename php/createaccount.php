
<?php

// Server-side input validation

if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true) {
    header('Location: ./home.php');
}

if (!isset($_POST['email']) || empty($_POST['email'])
    || !isset($_POST['username']) || empty($_POST['username'])
    || !isset($_POST["password"]) || empty($_POST['password'])
    || !isset($_POST["passwordconfirm"]) || empty($_POST["passwordconfirm"])) {
} else {

    //requires
    require './util/db.php';
    require './util/hash.php';

    //hash password
    $passwordhashed = hashPassword($_POST["password"]);

    if (!CheckIfExists($_POST['username'], $passwordhashed)) {
        if (CreateStudent($_POST['username'], $_POST['email'], $passwordhashed)) {
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $_POST["username"];
            $_SESSION['id'] = GetID($_POST['username']);
            header("Location: ./home.php");
        } else {
            $error = "Something wrong happened!";
        }
    } else {
        $error = "username/email already exist.";
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
    <link rel="stylesheet" href="../style/createaccount.css">

    <!-- Ext. Libraries -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.5.9/dist/css/uikit.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.9/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.9/dist/js/uikit-icons.min.js"></script>

</head>
<body>
    <?php include 'navbar.php' ?>

    <div class="content-fit">
    <div class="form-div">
        <form action="" class="login" method="POST">
            <h1>Create Account</h1>
            <h3 class="hey">hey, USC emails only.</h3>
            <div class="uk-margin">
                <div class="uk-inline">
                    <span class="uk-form-icon" uk-icon="icon: mail"></span>
                    <input class="uk-input uk-form-width-large" type="text" placeholder="USC email" name="email">
                </div>
            </div>
            <div class="uk-margin">
                <div class="uk-inline">
                    <span class="uk-form-icon" uk-icon="icon: commenting"></span>
                    <input class="uk-input uk-form-width-large" type="text" placeholder="username" name="username">
                </div>
            </div>
            <div class="uk-margin">
                <div class="uk-inline">
                    <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
                    <input class="password-input uk-input uk-form-width-large" type="password" placeholder="password" name="password">
                </div>
            </div>
            <div class="uk-margin">
                <div class="uk-inline">
                    <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
                    <input class="password-match-input uk-input uk-form-width-large" type="password" placeholder="confirm password" name="passwordconfirm">
                    </div>
                </div>
                <button type="submit" class="login-form-button">Submit</button>
                <p class="login-error-message"><?php
                if (isset($error) && !empty($error)) {
                    echo $error;
                }
                ?></p>
            </div>
        </form>
    </div>
    </div>

</body>
</html>
