<?php include_once("header.php");
require("utilities.php");
?>

<div class="container my-5">

<?php

// This function takes the form data and adds the new auction to the database.

/* TODO #1: Connect to MySQL database (perhaps by requiring a file that
            already does this). */


/* TODO #2: Extract form data into variables. Because the form was a 'post'
            form, its data can be accessed via $POST['auctionTitle'], 
            $POST['auctionDetails'], etc. Perform checking on the data to
            make sure it can be inserted into the database. If there is an
            issue, give some semi-helpful feedback to user. */


/* TODO #3: If everything looks good, make the appropriate call to insert
            data into the database. */
            

// If all is successful, let user know.

session_start();
require_once "database.php";
$username = $_SESSION['username'];
$sellerID = extract_userID($username);

if (isset($_POST["submit"])) {
    $title = $_POST["title"];
    $condition = $_POST["condition"];
    $description = $_POST["description"];
    $category = $_POST["category"];
    $startprice = $_POST["startprice"];
    $reserveprice = $_POST["reserveprice"];
    $enddate = $_POST["enddate"];

    # variables for our upload img files
    $fileName = $_FILES['imgfile']['name'];
    $fileTmp = $_FILES['imgfile']['tmp_name'];
    $fileSize = $_FILES['imgfile']['size'];
    $fileError = $_FILES['imgfile']['error'];
    $fileType = $_FILES['imgfile']['type'];

    $currentdate = date('Y-m-d H:i:s', $phptime);
    $enddateSQL = date("Y-m-d H:i:s",strtotime($enddate));
    $errors = array();
    $msgs = array();

    $nameExt = explode('.', $fileName);  # extract filename format xxx.ext
    $actExt = strtolower(end($nameExt)); # extract the end of the filename ie. the extension name
    $extAllowed = array('jpg', 'jpeg', 'png');  # allow only jpg and jpeg format images

    if (in_array($actExt, $extAllowed)) {
        if ($fileError === 0) {
            # ensure image file size is less than 5mb
            if ($fileSize < 5000000) {
                # ensure we have a unique filename and save it onto a local path
                $fileNameUni = uniqid('', true).".".$actExt;
                $fileDest = '/var/www/auction/itemimg/'.$fileNameUni;
                move_uploaded_file($fileTmp, $fileDest);
            }else {
                array_push($errors, "File size exceeded (must be less than 5mb)!");
            }
        }else {
            echo "<div class='alert alert-danger'>Something went wrong :( Redirect in 5 secs.</div>";
            header("refresh:5;url=browse.php");
            exit();
        }
    } else {
        array_push($errors, "File format not accepted!");
    }

    if (empty($title) OR empty($description) OR empty($category) OR empty($startprice) OR empty($reserveprice) OR empty($fileName)
    OR empty($enddate) OR ($category === 'none') OR ($condition === 'none')){
        header("Location: create_auction.php");
        exit();  
    }
    if ((strlen($title)>100) OR (strlen($description)>500) OR (strlen($category)>100)) {
        array_push($errors, "User input length limit exceeded!");
    }
    if ($enddateSQL<=$currentdate) {
        array_push($errors, "Invalid auction end date!");
    }

    $sql = "SELECT * FROM Auction WHERE sellerID = '$sellerID' AND title = '$title'";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);
    if ($count>0) {
        array_push($errors, "Title already exists! (Each seller can't have multiple auctions with the same title)");
    }

    if (count($errors)>0) {
        foreach ($errors as $error) {
            array_push($msgs, "<div class='alert alert-danger'>$error</div>");
        }
        $_SESSION["messages"] = $msgs;
        header("Location: create_auction.php");
        exit();
    }else{
        $sqlA = "INSERT INTO Auction (title, itemCondition, description, category, startDate, startingPrice, reservePrice, winningPrice, 
        endDate, mailSent, numBid, winnerID, imgFileName, sellerID) VALUES ('$title', '$condition','$description', '$category', '$currentdate', 
        '$startprice', '$reserveprice', '$startprice', '$enddateSQL', 'FALSE', '1', 'None', '$fileNameUni', '$sellerID')";

        if ($conn->query($sqlA) === TRUE) {
            echo('<div class="alert alert-success">Auction successfully created! <a href="mylistings.php">View your 
            new listing.</a></div>');
            header("refresh:5;url=browse.php");
            exit();
        }else{
            echo "<div class='alert alert-danger'>Something went wrong :( Redirect in 5 secs.</div>";
            header("refresh:5;url=browse.php");
            exit();
        }
            $conn->close();
    }
}

?>

</div>


<?php include_once("footer.php")?>