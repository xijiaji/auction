<?php include_once("header.php");
  require("utilities.php");
  include("winner_script.php");
?>


<div class="container">

<h2 class="my-3">Item Bid History</h2>

<?php

if (!isset($_SESSION['account_type'])) {
  header('Location: browse.php');
}

require_once "database.php";

$auction_id = $_GET['auction_id'];

# page display logics
$readSql = "SELECT * FROM Bid WHERE auctionID = '$auction_id'";
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

# display profile
$sql2 = "SELECT * FROM Auction WHERE auctionID = '$auction_id'";
$result2 = mysqli_query($conn, $sql2);
$row2 = mysqli_fetch_assoc($result2);

$title = "$row2[title]";
$condition = "$row2[itemCondition]";
$description = "$row2[description]";
$imgName = "$row2[imgFileName]";

$sellerID = "$row2[sellerID]";
$seller = extract_userName($sellerID);

echo('<div class="p-2 mr-5"><img src="itemimg/'.$imgName.'" width="120px" height="120px"></div>');
echo('<div class="p-2 mr-5"><h5>Profile: '.$title.' | Seller: '.$seller.'</h5>
      <h6>'.$condition.'</h6>
      <h7>'.$description.'</h7>
      </div>
      '
);


$sql = "SELECT * FROM Bid WHERE auctionID = '$auction_id' ORDER BY price DESC LIMIT $p,10";
$result = mysqli_query($conn, $sql);
$count = mysqli_num_rows($result);

if($count > 0){
  while($row = mysqli_fetch_assoc($result)){
    $price = $row['price'];
    $nameid = $row['buyerID'];
    $name = extract_userName($nameid);
    $dtime = "$row[bidDate]";
  
    print_itembid_li($name, $price, $dtime);
  }
}else{
  echo("<h5>No bid on this item so far.</h5>");
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
      <a class="page-link" href="bid_history.php?' . $querystring . 'page=' . ($curr_page - 1) . '" aria-label="Previous">
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
      <a class="page-link" href="bid_history.php?' . $querystring . 'page=' . $i . '">' . $i . '</a>
    </li>');
  }
  
  if ($curr_page != $max_page) {
    echo('
    <li class="page-item">
      <a class="page-link" href="bid_history.php?' . $querystring . 'page=' . ($curr_page + 1) . '" aria-label="Next">
        <span aria-hidden="true"><i class="fa fa-arrow-right"></i></span>
        <span class="sr-only">Next</span>
      </a>
    </li>');
  }
?>

</ul>



<?php include_once("footer.php")?>