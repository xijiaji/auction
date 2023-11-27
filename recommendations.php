<?php include_once("header.php");
include("winner_script.php");
require("utilities.php");
?>

<div class="container">

<h2 class="my-3">Recommendations for you</h2>

<?php
  // This page is for showing a buyer recommended items based on their bid 
  // history. It will be pretty similar to browse.php, except there is no 
  // search bar. This can be started after browse.php is working with a database.
  // Feel free to extract out useful functions from browse.php and put them in
  // the shared "utilities.php" where they can be shared by multiple files.
  
  
  // TODO: Check user's credentials (cookie/session).
  
  // TODO: Perform a query to pull up auctions they might be interested in.
  
  // TODO: Loop through results and print them out as list items.

session_start();
$username = $_SESSION['username']; 
$user_id = extract_userID($username);

if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 'buyer') {
  header('Location: browse.php');
}

# page display logic
if (!isset($_GET['page'])) {
  $curr_page = 1;
}
else {
  $curr_page = $_GET['page'];
}

$page = $_GET["page"];

if ($page=='' || $page=='1'){
  $p=0;
}else{
  $p=$page*10 - 10;
}

require_once "database.php";

$num_results = 10; # limit recommendations to the top 10 results
$results_per_page = 10;
$max_page = ceil($num_results / $results_per_page);

# actual recommendation logics, recommending based on type of previous bid items
$sqlA = "SELECT DISTINCT A.category FROM Bid AS B, Auction AS A WHERE buyerID = '$user_id' AND B.auctionID = A.auctionID";
$resultA = mysqli_query($conn, $sqlA);
$count = mysqli_num_rows($resultA);

$current_date = new datetime();

if ($count > 0) {
  while ($rowA = mysqli_fetch_assoc($resultA)) {

    $type = $rowA['category'];

    $sqlB = "SELECT * FROM Auction ORDER BY numBid DESC";
    $resultB = mysqli_query($conn, $sqlB);

    while ($rowB = mysqli_fetch_assoc($resultB)){
      $num_bid = $rowB['numBid'];
      $auction_id = $rowB['auctionID'];

      $title = "$rowB[title]";
      $condition = "$rowB[itemCondition]";
      $description = "$rowB[description]";
      $current_price = $rowB['winningPrice'];
      $num_bids = $rowB['numBid'];
      $end_date = new DateTime($rowB['endDate']);
      $imgName = "$rowB[imgFileName]";
      $category = "$rowB[category]";

      # make sure it's an item that the buyer hasn't bid yet
      $sql = "SELECT * FROM Bid WHERE buyerID = '$user_id' AND auctionID = '$auction_id'";
      $result = mysqli_query($conn, $sql);
      $countb = mysqli_num_rows($result);

      if (($num_bid > 1) AND ($countb === 0) AND ($type === $category) AND ($current_date < $end_date)){
        print_listing_li($auction_id, $title, $condition, $description, $current_price, $num_bids, $end_date, $imgName);
      }
    }
  }
}else{
  # if user has no bids, then recommending based on the number of bid for each item
  $sqlB = "SELECT * FROM Auction ORDER BY numBid DESC";
  $resultB = mysqli_query($conn, $sqlB);

  while ($rowB = mysqli_fetch_assoc($resultB)){
    $num_bid = $rowB['numBid'];
    $auction_id = $rowB['auctionID'];
    
    $title = "$rowB[title]";
    $condition = "$rowB[itemCondition]";
    $description = "$rowB[description]";
    $current_price = $rowB['winningPrice'];
    $num_bids = $rowB['numBid'];
    $end_date = new DateTime($rowB['endDate']);
    $imgName = "$rowB[imgFileName]";

    if ($num_bid > 1) {
      print_listing_li($auction_id, $title, $condition, $description, $current_price, $num_bids, $end_date, $imgName);
    }
    
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
      <a class="page-link" href="mybids.php?' . $querystring . 'page=' . ($curr_page - 1) . '" aria-label="Previous">
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
      <a class="page-link" href="mybids.php?' . $querystring . 'page=' . $i . '">' . $i . '</a>
    </li>');
  }
  
  if ($curr_page != $max_page) {
    echo('
    <li class="page-item">
      <a class="page-link" href="mybids.php?' . $querystring . 'page=' . ($curr_page + 1) . '" aria-label="Next">
        <span aria-hidden="true"><i class="fa fa-arrow-right"></i></span>
        <span class="sr-only">Next</span>
      </a>
    </li>');
  }
?>

  </ul>



<?php include_once("footer.php")?>