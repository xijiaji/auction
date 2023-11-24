<?php include_once("header.php");
  require("utilities.php");
  include("winner_script.php");
?>

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
$username = $_SESSION['username']; 

# page display logic
require_once "database.php";
$sellerid = extract_userID($username);
$readSql = "SELECT * FROM Auction WHERE sellerID = '$sellerid'";
$result = mysqli_query($conn, $readSql);

$num_results = mysqli_num_rows($result);
$results_per_page = 10;
$max_page = ceil($num_results / $results_per_page);

$page = $_GET["page"];

if ($page=='' || $page=='1'){
  $p=0;
}else{
  $p=$page*10 - 10;
}


$readSql = "SELECT * FROM Auction WHERE sellerID = '$sellerid' LIMIT $p,10";

$result = mysqli_query($conn, $readSql);

if ($result != null) {

    while($row = mysqli_fetch_assoc($result)) {
      $auction_id = "$row[auctionID]";
      $title = "$row[title]";
      $condition = "$row[itemCondition]";
      $description = "$row[description]";
      $current_price = $row['winningPrice'];
      $num_bids = $row['numBid'];
      $end_date = new DateTime($row['endDate']);
      $imgName = "$row[imgFileName]";
      
      // This uses a function defined in utilities.php
      print_listing_li($auction_id, $title, $condition, $description, $current_price, $num_bids, $end_date, $imgName);
    }
}
  
?>

<!-- Pagination for results listings -->
<nav aria-label="Search results pages" class="mt-5">
  <ul class="pagination justify-content-center">
  
<?php

  // Copy any currently-set GET variables to the URL.
  $querystring = "";
  foreach ($_GET as $key => $value) {
    if ($key != "page") {
      $querystring .= "$key=$value&amp;";
    }
  }
  
  $high_page_boost = max(3 - $curr_page, 0);
  $low_page_boost = max(2 - ($max_page - $curr_page), 0);
  $low_page = max(1, $curr_page - 2 - $low_page_boost);
  $high_page = min($max_page, $curr_page + 2 + $high_page_boost);
  
  if ($curr_page != 1) {
    echo('
    <li class="page-item">
      <a class="page-link" href="mylistings.php?' . $querystring . 'page=' . ($curr_page - 1) . '" aria-label="Previous">
        <span aria-hidden="true"><i class="fa fa-arrow-left"></i></span>
        <span class="sr-only">Previous</span>
      </a>
    </li>');
  }
    
  for ($i = $low_page; $i <= $high_page; $i++) {
    if ($i == $curr_page) {
      // Highlight the link
      echo('
    <li class="page-item active">');
    }
    else {
      // Non-highlighted link
      echo('
    <li class="page-item">');
    }
    
    // Do this in any case
    echo('
      <a class="page-link" href="mylistings.php?' . $querystring . 'page=' . $i . '">' . $i . '</a>
    </li>');
  }
  
  if ($curr_page != $max_page) {
    echo('
    <li class="page-item">
      <a class="page-link" href="mylistings.php?' . $querystring . 'page=' . ($curr_page + 1) . '" aria-label="Next">
        <span aria-hidden="true"><i class="fa fa-arrow-right"></i></span>
        <span class="sr-only">Next</span>
      </a>
    </li>');
  }
?>

  </ul>

<?php include_once("footer.php")?>