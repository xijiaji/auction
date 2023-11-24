<?php include_once("header.php");
?>
<?php

// TODO: Extract $_POST variables, check they're OK, and attempt to create
// an account. Notify user of success/failure and redirect/give navigation 
// options.

if (isset($_POST["submit"])) {
    $email = $_POST["email"];
    $username = $_POST["username"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $address = $_POST["address"];
    $phone = $_POST["phone"];
    $password = $_POST["password"];
    $passwordConf = $_POST["passwordconf"];

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $accountType = $_POST["accounttype"];

    $errors = array();
    $msgs = array();

    if (empty($email) OR empty($password) OR empty($passwordConf) OR empty($firstname) OR empty($lastname) OR empty($phone) OR empty($address)) {
        header("Location: http://localhost/register.php");
        exit();  
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Invalid email!");
    }
    if (strlen($password)<8) {
        array_push($errors, "Password must be at least 8 characters long!");
    }
    if ($password !== $passwordConf) {
        array_push($errors, "Password does not match!");
    }
    if ((is_numeric($phone) != 1) OR (strlen($phone)<11)) {
        array_push($errors, "Phone number must be numeric and 11 characters long!");
    }


    require_once "database.php";
    $sql = "SELECT * FROM User WHERE email = '$email'";
    $sql2 = "SELECT * FROM User WHERE userName = '$username'";

    $result = mysqli_query($conn, $sql);
    $result2 = mysqli_query($conn, $sql2);

    $count = mysqli_num_rows($result);
    $count2 = mysqli_num_rows($result2);

    if (($count>0) OR ($count2>0)) {
        array_push($errors, "Email or username already exists!");
    }

    if (count($errors)>0) {
        foreach ($errors as $error) {
            array_push($msgs, "<div class='alert alert-danger'>$error</div>");
        }
        $_SESSION["messages"] = $msgs;
        header("Location: register.php");
        exit();
    }else{
        $sql = "INSERT INTO User (type, email, userName, firstName, lastName, password, phone, shippingAddress) VALUES 
        ('$accountType', '$email', '$username', '$firstname', '$lastname', '$passwordHash', '$phone', '$address')";
        if ($conn->query($sql) === TRUE) {
            echo "<div class='alert alert-success'>Registered successfully! Redirect in 5 secs.</div>";
            header("refresh:5;url=register.php");
            exit();
        }else{
            echo "<div class='alert alert-danger'>Something went wrong :( Redirect in 5 secs.</div>";
            header("refresh:5;url=register.php");
            exit();
        }
        $conn->close();      
        }
    }
?>
<?php include_once("footer.php")?>
