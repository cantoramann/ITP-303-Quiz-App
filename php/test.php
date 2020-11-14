<?php
$myemail = "comments@myemail.com";
$errors  = array();
$values  = array();
$errmsg  = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        $values[$key] = trim(stripslashes($value)); // basic input filter
    }

    if (check_input($values['yourname']) == false) {
        $errors['yourname'] = 'Enter your name!';
    }

    if (check_input($values['email']) == false) {
        $errors['email'] = 'Please enter your email address.';
    } elseif (!preg_match('/([\w\-]+\@[\w\-]+\.[\w\-]+)/', $values['email'])) {
        $errors['email'] = 'Invalid email address format.';
    }

    if (check_input($values['comments']) == false) {
        $errors['comments'] = 'Write your comments!';
    }

    if (sizeof($errors) == 0) {
        // you can process your for here and redirect or show a success message
        $values = array(); // empty values array
        echo "Form was OK!  Good to process...<br />";
    } else {
        // one or more errors
        foreach ($errors as $error) {
            $errmsg .= $error . '<br />';
        }
    }
}

function check_input($input)
{
    if (strlen($input) == 0) {
        return false;
    } else {
        // TODO: other checks?

        return true;
    }
}
?>
<!doctype html>
<html>
<body>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
 <?php if ($errmsg != ''): ?>
 <p style="color: red;"><b>Please correct the following errors:</b><br />
 <?php echo $errmsg; ?>
 </p>
 <?php endif; ?>

 <p>Name: <input type="text" name="yourname" value="<?php echo htmlspecialchars(@$values['yourname']) ?>" /></P>
 <P>Email: <input type="text" name="email" value="<?php echo htmlspecialchars(@$values['email']) ?>" /></p>
 <P>Phone: <input type="text" name="phone" value="<?php echo htmlspecialchars(@$values['phone']) ?>"/></p><br />
 <P>Subject: <input type="text" style="width:75%;" name="subject" value="<?php echo htmlspecialchars(@$values['subject']) ?>" /></p>
 <p>Comments:<br />
 <textarea name="comments" rows="10" cols="50" style="width: 100%;"><?php echo htmlspecialchars(@$values['comments']) ?></textarea></p>
 <p><input type="submit" value="Submit"></p>
</form>
</body>
</html>