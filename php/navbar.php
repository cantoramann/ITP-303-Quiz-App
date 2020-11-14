<head>
    <link rel="stylesheet" href="../style/reset.css">
    <link rel="stylesheet" href="../style/navstyle.css">
</head>

<nav class="uk-margin-medium-bottom">
    <div class="half">
        <?php if (!isset($_SESSION["loggedin"]) || !$_SESSION["loggedin"]): ?>
            <h1 id="logo"><a href="./index.php">CS@USC Trivia</a></h1>
            <?php
        else: ?>
            <h1 id="logo"><a href="./home.php">CS@USC Trivia</a></h1>
        <?php
        endif; ?>
        </div>
        <div class="half">
            <ul>
                <?php if (!isset($_SESSION["loggedin"]) || !$_SESSION["loggedin"]): ?>
                    <li><a href="./credentials.php">Login</a></li>
                <?php
                else: ?>
                    <li><a href="./home.php"><?php echo $_SESSION["username"]; ?></a></li>
                    <li><a href="./logout.php">Logout</a></li>
                <?php
                endif; ?>

            </ul>
        </div>
    </div>
</nav>
