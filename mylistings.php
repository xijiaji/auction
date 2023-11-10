<?php include_once("header.php")?>
<?php require("utilities.php")?>

<div class="container">

<h2 class="my-3">My listings</h2>

<?php
  // This page is for showing a user the auction listings they've made.
  // It will be pretty similar to browse.php, except there is no search bar.
  // This can be started after browse.php is working with a database.
  // Feel free to extract out useful functions from browse.php and put them in
  // the shared "utilities.php" where they can be shared by multiple files.
  
  
  // TODO: Check user's credentials (cookie/session).
  
  // TODO: Perform a query to pull up their auctions.
  
  // TODO: Loop through results and print them out as list items.

if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 'seller') {
  header('Location: browse.php');
}

session_start();
$userName = $_SESSION['username']; 


require_once "database.php";
$readSql = "SELECT * FROM Auction WHERE sellerName = '$userName'";

$result = mysqli_query($conn, $readSql);

if ($result != null) {

    while($row = mysqli_fetch_assoc($result)) {
      $auction_id = "$row[auctionID]";
      $title = "$row[title]";
      $condition = "$row[itemCondition]";
      $description = "$row[description]";
      $current_price = $row['startingPrice'];
      $num_bids = $row['noBid'];
      $end_date = new DateTime($row['endDate']);
      
      // This uses a function defined in utilities.php
      print_listing_li($auction_id, $title, $condition, $description, $current_price, $num_bids, $end_date);
    }
}
  
?>

<?php include_once("footer.php")?>