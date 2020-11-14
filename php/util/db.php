<?php

require '../config/config.php';


// SELECT STATEMENTS
function GetID($username)
{
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($mysqli->connect_errno) {
        echo $mysqli->connect_error;
        exit();
    }

    $query = "SELECT id FROM Students WHERE username = '" . $username . "'";
    $result = $mysqli->query($query);
    if (!$result) {
        echo $mysqli->error;
        return -1;
        exit();
    } else {
        if ($result->num_rows > 0) {
            $row = mysqli_fetch_row($result);
            return ($row[0]);
        } else {
            return -1;
        }
    }
    $mysqli->close();
}

function CheckIfExists($username, $password)
{
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($mysqli->connect_errno) {
        echo $mysqli->connect_error;
        exit();
    }

    $query = "SELECT id FROM Students WHERE username = '" . $username . "' AND password = '" . $password . "';";
    $result = $mysqli->query($query);
    if (!$result) {
        echo $mysqli->error;
        return false;
        exit();
    } else {
        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
    $mysqli->close();
}

function GetAllClasses()
{
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($mysqli->connect_errno) {
        echo $mysqli->connect_error;
        exit();
    }
    $query = "SELECT * FROM Classes;";
    $result = $mysqli->query($query);
    $mysqli->close();
    return $result;
}

function GetClassQuestions($classID)
{
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($mysqli->connect_errno) {
        echo $mysqli->connect_error;
        exit();
    }
    $query = "SELECT * FROM Questions WHERE Classes_id = '" . $classID . "';";
    $result = $mysqli->query($query);
    $mysqli->close();
    return $result;
}


// INSERT STATEMENTS
function CreateStudent($username, $email, $password)
{
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($mysqli->connect_errno) {
        echo $mysqli->connect_error;
        exit();
    }

    $success = true;
    $description = "Nothing for now. Edit if you want to!";
    $query = "INSERT INTO Students(username, email, password, user_description) VALUES ('" . $username . "', '" . $email . "', '" . $password . "', '" . $description . "');";
    $result = $mysqli->query($query);
    if (!$result) {
        echo $mysqli->error;
        return false;
        exit();
    } else {
        return true;
    }
    $mysqli->close();
}

function CreateQuestion($qs, $a, $b, $c, $d, $correct, $Students_id, $Classes_id)
{
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($mysqli->connect_errno) {
        echo $mysqli->connect_error;
        exit();
        return false;
    }

    $query = "INSERT INTO Questions(question, a, b, c, d, answer, Students_id, Classes_id) 
    VALUES ('" . $qs ."', '" . $a ."', '" . $b ."', '" . $c ."', '" . $d ."', '" . $correct ."', '" . $Students_id ."', '" . $Classes_id ."');";
    $result = $mysqli->query($query);

    if (!$result) {
        echo $mysqli->error;
        return false;
        exit();
    } else {
        return true;
    }
    $mysqli->close();
}


// UPDATE STATEMENTS
function UpdateStudentDescription()
{
}


// returns if the student has posted any questions
function QuestionNumberPosted($id)
{
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($mysqli->connect_errno) {
        echo $mysqli->connect_error;
        exit();
    }

    $query = "SELECT COUNT(question) FROM Questions WHERE Students_id = '" . $id  . "';";
    $result = $mysqli->query($query);

    if (!$result) {
        echo $mysqli->error;
        return -1;
        exit();
    } else {
        if ($result->num_rows > 0) {
            $row = mysqli_fetch_row($result);
            return ($row[0]);
        } else {
            return -1;
        }
    }
    $mysqli->close();
}

function GetAllStudentQuestions($user_id)
{
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($mysqli->connect_errno) {
        echo $mysqli->connect_error;
        exit();
    }
    $query = "SELECT question, a, b, c, d, answer, Classes.class_name AS name
    FROM Questions
    JOIN Classes
        ON Questions.Classes_id = Classes.id
    WHERE Students_id = " . $user_id . ";";
    $result = $mysqli->query($query);

    $result = $mysqli->query($query);
    if (!$result) {
        echo $mysqli->error;
        return null;
        exit();
    } else {
        if ($result->num_rows > 0) {
            return ($result);
        } else {
            return null;
        }
    }
    $mysqli->close();
}

function GetRandomQuestionsWithID($classID)
{
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($mysqli->connect_errno) {
        echo $mysqli->connect_error;
        exit();
    }

    $query = "SELECT question, a, b, c, d, answer FROM Questions WHERE Classes_id = " . $classID . ";";
    $result = $mysqli->query($query);
    if (!$result) {
        echo $mysqli->error;
        return null;
        exit();
    } else {
        if ($result->num_rows > 0) {
            return ($result);
        } else {
            return null;
        }
    }

    $mysqli->close();
}


function GetRandomQuestions()
{
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($mysqli->connect_errno) {
        echo $mysqli->connect_error;
        exit();
    }

    $query = "SELECT question, a, b, c, d, answer, Classes.class_name AS name
    FROM Questions
    JOIN Classes
        ON Questions.Classes_id = Classes.id
    ORDER BY RAND() LIMIT 3;";
    $result = $mysqli->query($query);
    if (!$result) {
        echo $mysqli->error;
        return null;
        exit();
    } else {
        if ($result->num_rows > 0) {
            return ($result);
        } else {
            return null;
        }
    }
    $mysqli->close();
}

function GetQuestionsFromUserGivenClass($class_id, $user_id)
{
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($mysqli->connect_errno) {
        echo $mysqli->connect_error;
        exit();
    }
    $query = "SELECT question, a, b, c, d, answer, Classes.class_name AS name
    FROM Questions
    JOIN Classes
        ON Questions.Classes_id = Classes.id
    WHERE Classes.id = " . $class_id . " AND Students_id = " . $user_id . ";";
    
    $result = $mysqli->query($query);
    if (!$result) {
        echo $mysqli->error;
        return null;
        exit();
    } else {
        if ($result->num_rows > 0) {
            return ($result);
        } else {
            return null;
        }
    }
    $mysqli->close();
}

function SelectDistinctClassesByUser($user_id)
{
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($mysqli->connect_errno) {
        echo $mysqli->connect_error;
        exit();
        return -1;
    }
    $query = "SELECT COUNT(DISTINCT (Classes_id))
    FROM Questions
    WHERE Students_id = " . $user_id . ";";

    $result = $mysqli->query($query);
    if (!$result) {
        echo $mysqli->error;
        return -1;
        exit();
    } else {
        if ($result->num_rows > 0) {
            $row = mysqli_fetch_row($result);
            return ($row[0]);
        } else {
            return -1;
        }
    }
}
