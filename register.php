<?php
// include our connect script
require_once("conf.php");

// check to see if there is a user already logged in, if so redirect them
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['userid']))
    header("Location: ./index.php");  // redirect the user to the home page
if (isset($_POST['registerBtn'])){
    // get all of the form data
    $username = $_POST['username'];
   $passwd = $_POST['passwd'];
    $passwd_again = $_POST['passwd_again'];


    // query the database to see if the username is taken
    global $yhendus;
    $query = mysqli_query($yhendus, "SELECT * FROM kasutajad WHERE nimi='{$username}'");
    if (mysqli_num_rows($query) == 0){
        // create and format some variables for the database
        $id = '';
        $passwd = md5($passwd);
        $date_created = time();
        $last_login = 0;
        $status = 1;



        // verify all the required form data was entered
        if ($username != "" && $passwd != "" && $passwd_again != ""){
            // make sure the two passwords match
            if ($passwd === $passwd_again){
                // make sure the password meets the min strength requirements
                if ( strlen($passwd) >= 5 && strpbrk($passwd, "!#$.,:;()") != false ){
                    // next code block
                }
                else
                    $error_msg = 'Your password is not strong enough. Please use another.';
            }
            else
                $error_msg = 'Your passwords did not match.';
        }
        else
            $error_msg = 'Please fill out all required fields.';
    }
    else
        $error_msg = 'The username <i>'.$username.'</i> is already taken. Please use another.';
}
// insert the user into the database
mysqli_query($yhendus, "INSERT INTO kasutajad (nimi, parool) VALUES ({'$username}', '{$passwd}')");

// verify the user's account was created
$query = mysqli_query($yhendus, "SELECT * FROM kasutajad WHERE nimi='{$username}'");
if (mysqli_num_rows($query) == 1){

    /* IF WE ARE HERE THEN THE ACCOUNT WAS CREATED! YAY! */
    /* WE WILL SEND EMAIL ACTIVATION CODE HERE LATER */

    $success = true;
}
else
    $error_msg = 'An error occurred and your account was not created.';


?>




<form action="./register.php" class="form" method="POST">

    <h1>Registreeri uus kasutaja</h1>

    <div class="">
        <?php
        // check to see if the user successfully created an account
        if (isset($success) && $success == true){
            echo '<p color="green">Yay!! Your account has been created. <a href="./login.php">Click here</a> to login!<p>';
        }
        // check to see if the error message is set, if so display it
        else if (isset($error_msg))
            echo '<p color="red">'.$error_msg.'</p>';

        ?>
    </div>

    <div class="">
        <input type="text" name="username" value="" placeholder="enter a username" autocomplete="off" required />
    </div>
        <div class="">
        <input type="password" name="passwd" value="" placeholder="enter a password" autocomplete="off" required />
    </div>
    <div class="">
        <p>password must be at least 5 characters and<br /> have a special character, e.g. !#$.,:;()</font></p>
    </div>
    <div class="">
        <input type="password" name="confirm_password" value="" placeholder="confirm your password" autocomplete="off" required />
    </div>

    <div class="">
        <input class="" type="submit" name="registerBtn" value="create account" />
    </div>

    <p class="center"><br />
        Already have an account? <a href="login.php">Login here</a>
    </p>
</form>
