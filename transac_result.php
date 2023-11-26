<?php include_once("header.php");
?>
<?php

session_start();
require_once("database.php");
$auction_id = $_SESSION['auction_id'];

if (isset($_POST["accept"])) {
    $sql = "UPDATE Transaction SET status = 'accepted' WHERE auctionID = '$auction_id'";
    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Payment accepted! Redirect in 5 secs.</div>";
        header("refresh:5;url=browse.php");
        exit();
    }
}

if (isset($_POST["reject"])) {
    $sql = "UPDATE Transaction SET status = 'rejected' WHERE auctionID = '$auction_id'";
    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Payment rejected! Redirect in 5 secs.</div>";
        header("refresh:5;url=browse.php");
        exit();
    }
}



?>
<?php include_once("footer.php")?>