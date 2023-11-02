<?php include_once("header.php")?>

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
$userName = $_SESSION['username'];


if (isset($_POST["submit"])) {
    $title = $_POST["title"];
    $condition = $_POST["condition"];
    $description = $_POST["description"];
    $category = $_POST["category"];
    $startprice = $_POST["startprice"];
    $reserveprice = $_POST["reserveprice"];
    $enddate = $_POST["enddate"];

    
    $currentdate = date('Y-m-d H:i:s', $phptime);
    $enddateSQL = date("Y-m-d H:i:s",strtotime($enddate));
    $errors = array();
    $msgs = array();

    if (empty($title) OR empty($description) OR empty($category) OR empty($startprice) OR empty($reserveprice)
    OR empty($enddate) OR ($category === 'none') OR ($condition === 'none')){
        header("Location: create_auction.php");
        exit();  
    }
    if ((strlen($title)>100) OR (strlen($description)>200) OR (strlen($category)>100)) {
        array_push($errors, "User input length limit exceeded!");
    }
    if ($enddateSQL<=$currentdate) {
        array_push($errors, "Invalid auction end date!");
    }

    require_once "database.php";
    $sql = "SELECT * FROM Auction WHERE sellerName = '$userName' AND title = '$title'";
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
        $sqlA = "INSERT INTO Auction (title, itemCondition, description, category, startDate, startingPrice, reservePrice, 
        endDate, noBid, auctionStatus, sellerName) VALUES ('$title', '$condition','$description', '$category', '$currentdate', 
        '$startprice', '$reserveprice', '$enddateSQL', '0', 'Opened', '$userName')";

        if ($conn->query($sqlA) === TRUE) {
            echo('<div class="text-center">Auction successfully created! <a href="FIXME">View your new listing.</a></div>');
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