<?php include_once("header.php")?>
<?php require("utilities.php")?>

<div class="container">

<h2 class="my-3">My bids</h2>

<?php
  // This page is for showing a user the auctions they've bid on.
  // It will be pretty similar to browse.php, except there is no search bar.
  // This can be started after browse.php is working with a database.
  // Feel free to extract out useful functions from browse.php and put them in
  // the shared "utilities.php" where they can be shared by multiple files.
  
  
  // TODO: Check user's credentials (cookie/session).
  
  // TODO: Perform a query to pull up the auctions they've bidded on.
  
  // TODO: Loop through results and print them out as list items.


if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 'buyer') {
  header('Location: browse.php');
}

session_start();
$userName = $_SESSION['username']; 

require_once "database.php";
$readSql = "SELECT DISTINCT auctionID FROM Bid WHERE buyerName = '$userName'";

$result = mysqli_query($conn, $readSql);

if ($result != null) {

  while($row = mysqli_fetch_assoc($result)) {
    $auction_id = "$row[auctionID]";

    $sql = "SELECT MAX(price) FROM Bid WHERE buyerName = '$userName' AND auctionID = '$auction_id'";
    $result1 = mysqli_query($conn, $sql);
    $row1 = mysqli_fetch_assoc($result1);
    
    $sql2 = "SELECT MAX(price) FROM Bid WHERE auctionID = '$auction_id'";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($result2);

    if ($row1['MAX(price)'] >= $row2['MAX(price)']) {
      $status = "Winning";
    } else {
      $status = "Outbide";
    }

    $nextSql = "SELECT * FROM Auction WHERE auctionID = '$auction_id'";
    $result3 = mysqli_query($conn, $nextSql);

    while($row3 = mysqli_fetch_assoc($result3)){
      $title = "$row3[title]";
      $condition = "$row3[itemCondition]";
      $description = "$row3[description]";
      print_bid_li($auction_id, $title, $condition, $description, $row1['MAX(price)'], $status);
    }
  }
}





  
?>

<?php include_once("footer.php")?>