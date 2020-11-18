
<?php

// Server-side input validation

if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true) {
    header('Location: ./home.php');
}

$error = "";
if (!isset($_POST['email']) || !isset($_POST['username']) || !isset($_POST["password"]) || !isset($_POST["passwordconfirm"])) {
} elseif (empty($_POST['email']) || empty($_POST['username']) || empty($_POST["password"]) || empty($_POST["passwordconfirm"])) {
    $error = "Please fill all required fields";
} else {

    //requires
    require './util/db.php';
    require './util/hash.php';

    //hash password
    $passwordhashed = hashPassword($_POST["password"]);

    if ($_POST["password"] != $_POST["passwordconfirm"]) {
        $error = "Please fill all required fields";
    } else {
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
                    <input class="uk-input uk-form-width-large email-input" type="email" placeholder="USC email" name="email">
                </div>
            </div>
            <div class="uk-margin">
                <div class="uk-inline">
                    <span class="uk-form-icon" uk-icon="icon: commenting"></span>
                    <input class="uk-input uk-form-width-large username-input" type="text" placeholder="username" name="username">
                </div>
            </div>
            <div class="uk-margin">
                <div class="uk-inline">
                    <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
                    <input class="password-input uk-input uk-form-width-large password-input" type="password" placeholder="password" name="password">
                </div>
            </div>
            <div class="uk-margin">
                <div class="uk-inline">
                    <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
                    <input class="password-match-input uk-input uk-form-width-large passwordconfirm-input" type="password" placeholder="confirm password" name="passwordconfirm">
                    </div>
                </div>
                <button type="submit" class="login-form-button">Submit</button>
                <p class="login-error-message"><?php echo $error ?></p>
            </div>
        </form>
    </div>
    </div>
    <script>
        message = document.querySelector(".login-error-message");

        document.querySelector('form').addEventListener("submit", (e) => {
            email = document.querySelector(".email-input").value;
            username = document.querySelector(".username-input").value;
            password = document.querySelector(".password-input").value;
            passwordmatch = document.querySelector(".passwordconfirm-input").value;
            username = username.trim();
            password = password.trim();
            console.log(email, username, password, passwordmatch)

            if (email.length == 0 || username.length == 0 || password.length == 0 || passwordmatch.length == 0) {
                console.log(email, username, password, passwordmatch)
                e.preventDefault();
                message.innerHTML = "Please fill all required fields";
            } else if (password != passwordmatch) {
                e.preventDefault();
                message.innerHTML = "Passwords do not match";
            }
        })
    </script>

</body>
</html>
