<?php include_once("header.php");
include("winner_script.php");
?>
<?php

// TODO: Extract $_POST variables, check they're OK, and attempt to login.
// Notify user of success/failure and redirect/give navigation options.

// For now, I will just set session variables and redirect.

$errors = array();
$msgs = array();


if (isset($_POST["submit"])) {
    $user = $_POST["user"];
    $password = $_POST["password"];
    require_once "database.php";
    $sql = "SELECT * FROM User WHERE userName ='$user'";
    $result = mysqli_query($conn, $sql);
    $key = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if (!$key) {
        array_push($errors, "Incorrect username!");
    }

    if (!password_verify($password, $key["password"])) {
        array_push($errors, "Incorrect passworld!");
    }

    if (count($errors)>0) {
        foreach ($errors as $error) {
            array_push($msgs, "<div class='alert alert-danger'>$error</div>");
        }
        $_SESSION["messages"] = $msgs;
        header("Location: http://localhost/register.php");
        exit();
    }else{
        session_start();
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $key["userName"];
        $_SESSION['account_type'] = $key["type"];
        
        echo('<div class="alert alert-success">You are now logged in! Redirect in 5 secs.</div>');
        header("refresh:5;url=index.php");
        exit();
     }

}

?>
<?php include_once("footer.php")?>