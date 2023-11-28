<?php
// display_time_remaining:
// Helper function to help figure out what time to display

function display_time_remaining($interval) {

    if ($interval->days == 0 && $interval->h == 0) {
      // Less than one hour remaining: print mins + seconds:
      $time_remaining = $interval->format('%im %Ss');
    }
    else if ($interval->days == 0) {
      // Less than one day remaining: print hrs + mins:
      $time_remaining = $interval->format('%hh %im');
    }
    else {
      // At least one day remaining: print days + hrs:
      $time_remaining = $interval->format('%ad %hh');
    }

  return $time_remaining;

}

// print_listing_li:
// This function prints an HTML <li> element containing an auction listing
function print_listing_li($auction_id, $title, $cond, $desc, $price, $num_bids, $end_time, $imgName)
{

  // Truncate long descriptions
  if (strlen($desc) > 250) {
    $desc_shortened = substr($desc, 0, 250) . '...';
  }
  else {
    $desc_shortened = $desc;
  }
  
  // Fix language of bid vs. bids
  if (($num_bids == 1) or ($num_bids == 0)) {
    $bid = ' bid';
  }
  else {
    $bid = ' bids';
  }
  
  // Calculate time to auction end
  $now = new DateTime();
  if ($now > $end_time) {
    $time_remaining = 'This auction has ended';

  }
  else {
    // Get interval:
    $time_to_end = date_diff($now, $end_time);
    $time_remaining = display_time_remaining($time_to_end) . ' remaining';
  }
  
  // Print HTML
  echo('
  <li class="list-group-item d-flex justify-content-between">
    <div class="p-2 mr-5"><img src="itemimg/'.$imgName.'" width="120px" height="120px"></div>
    <div class="p-2 mr-5"><h5><a href="listing.php?auction_id=' . $auction_id . '">' . $title . '</a></h5> <h6>' . $cond. '</h6> ' . $desc_shortened . '</div>
    <div class="text-center text-nowrap"><span style="font-size: 1.5em">£' . number_format($price, 2) . '</span><br/>' . $num_bids . $bid . '<br/>' . $time_remaining . '</div>
  </li>'
  );
}

function print_bid_li($auction_id, $title, $cond, $desc, $price, $status, $imgName)
{
  // Truncate long descriptions
  if (strlen($desc) > 250) {
    $desc_shortened = substr($desc, 0, 250) . '...';
  }
  else {
    $desc_shortened = $desc;
  }
  
  
  // Print HTML
  echo('
    <li class="list-group-item d-flex justify-content-between">
    <div class="p-2 mr-5"><img src="itemimg/'.$imgName.'" width="120px" height="120px"></div>
    <div class="p-2 mr-5"><h5><a href="listing.php?auction_id=' . $auction_id . '">' . $title . '</a></h5> <h6>' . $cond. '</h6> ' . $desc_shortened . '</div>
    <div class="text-center text-nowrap"><span style="font-size: 1.5em">£' . number_format($price, 2) . '</span><br/>' . $status . '</div>
  </li>'
  );
}

function print_itembid_li($name, $price, $dtime)
{
  // Truncate long descriptions
  if (strlen($desc) > 250) {
    $desc_shortened = substr($desc, 0, 250) . '...';
  }
  else {
    $desc_shortened = $desc;
  }
  
  // Print HTML
  echo('
  <li class="list-group-item d-flex justify-content-between">
    <div class="p-2 mr-5"><h6>Bidder: ' . $name . '</h6></div>
    <div class="text-center text-nowrap"><span style="font-size: 1.5em">£' . number_format($price, 2) . '</span><br/>'. $dtime .'</div>
  </li>'
  );
}

function print_transac_li($title, $condition, $desc, $payer, $payee, $price, $payer_add, $payee_add, $date, $status)
{
  // Truncate long descriptions
  if (strlen($desc) > 250) {
    $desc_shortened = substr($desc, 0, 250) . '...';
  }
  else {
    $desc_shortened = $desc;
  }
  
  // Print HTML
  echo('
  <li class="list-group-item d-flex justify-content-between">
    <div class="alert alert-success"><h6>Payer: ' . $payer . '</h6><h5>Address: ' . $payer_add . '</h5></div>
    <div class="p-2 mr-5"><span style="font-size: 1.5em">Payment amount: £' . number_format($price, 2) . '</span>
    <br/>'. $dtime .'<h6>Item: ' . $title . '</h6><h6>' . $condition . '</h6><h7>Description: ' . $desc . '</h7>
    <h6>Transaction status: ' . $status . '</h6></div>
    <div class="alert alert-danger"><h6>Payee: ' . $payee . '</h6><h5>Address: ' . $payee_add . '</h5></div>
  </li>'
  );
}

# extract userid from username, useful in many cases
function extract_userID($username){
  require "database.php";
  $sql = "SELECT id FROM User WHERE userName = '$username'";
  $result = mysqli_query($conn, $sql);
  return mysqli_fetch_assoc($result)['id'];
}
# extract username from userid, useful in many cases
function extract_userName($id){
  require "database.php";
  $sql = "SELECT userName FROM User WHERE id = '$id'";
  $result = mysqli_query($conn, $sql);
  return mysqli_fetch_assoc($result)['userName'];
}

?>
