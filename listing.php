<?php include_once("header.php");
  require("utilities.php");
  include("winner_script.php");
?>

<?php
  session_start();

  foreach ($_SESSION["messages"] as $msg) {
    echo $msg;
  }
  $_SESSION["messages"]=""; # reset messages

  // Get info from the URL:
  $auction_id = $_GET['auction_id'];
  $_SESSION['auction_id'] = $auction_id;
  $username = $_SESSION['username'];


  require_once "database.php";
  // TODO: Use item_id to make a query to the database.

  $sql = "SELECT * FROM Auction WHERE auctionID = '$auction_id'";
  $sql2 = "SELECT buyerID FROM Bid WHERE auctionID = '$auction_id' AND price = (SELECT MAX(price) FROM Bid WHERE 
  auctionID = '$auction_id')";
  $result = mysqli_query($conn, $sql);
  $result2 = mysqli_query($conn, $sql2);

  $row = mysqli_fetch_assoc($result);
  $row2 = mysqli_fetch_assoc($result2);

  $lastBidderID = $row2['buyerID'];
  $sellerID = "$row[sellerID]";
  $lastBidder = extract_userName($lastBidderID);

  $title = "$row[title]";
  $condition = "$row[itemCondition]";
  $description = "$row[description]";
  $current_price = $row['winningPrice'];
  $num_bids = $row['numBid'];
  $end_time = new DateTime($row['endDate']);
  $seller = extract_userName($sellerID);
  $imgName = "$row[imgFileName]";

  // TODO: Note: Auctions that have ended may pull a different set of data,
  //       like whether the auction ended in a sale or was cancelled due
  //       to lack of high-enough bids. Or maybe not.
  
  // Calculate time to auction end:
  $now = new DateTime();
  
  if ($now < $end_time) {
    $time_to_end = date_diff($now, $end_time);
    $time_remaining = ' (in ' . display_time_remaining($time_to_end) . ')';
  }
  
  // TODO: If the user has a session, use it to make a query to the database
  //       to determine if the user is already watching this item.
  //       For now, this is hardcoded.
  $has_session = true;
  $watching = false;
?>


<div class="container">

<div class="row"> <!-- Row #1 with auction title + watch button -->
  <div class="col-sm-8"> <!-- Left col -->
    <h2 class="my-3"><?php echo($title); ?></h2>
    <?php echo '<div class="p-2 mr-5"><img src="itemimg/'.$imgName.'" width="250px" height="250px"></div>'?>
  </div>
  <div class="col-sm-4 align-self-center"> <!-- Right col -->
<?php
  /* The following watchlist functionality uses JavaScript, but could
     just as easily use PHP as in other places in the code */

  if (($now < $end_time) AND (isset($_SESSION['logged_in']) && $_SESSION['account_type'] == 'buyer'))  :
?>
    <div id="watch_nowatch" <?php if ($has_session && $watching) echo('style="display: none"');?> >
      <button type="button" class="btn btn-outline-secondary btn-sm" onclick="addToWatchlist()">+ Add to watchlist</button>
    </div>
    <div id="watch_watching" <?php if (!$has_session || !$watching) echo('style="display: none"');?> >
      <button type="button" class="btn btn-success btn-sm" disabled>Watching</button>
      <button type="button" class="btn btn-danger btn-sm" onclick="removeFromWatchlist()">Remove watch</button>
    </div>

    
<?php endif /* Print nothing otherwise */ ?>
<?php
# check if the winner of the auction belongs to the user, if yes, display transaction button.
  $winnerID = $row['winnerID'];
  $userID = extract_userID($username);
  $reserve_price = $row['reservePrice'];
  $winner_price = $row['winningPrice'];

  $pound = '<h7>&pound</h7>';

  $sql_bid = "SELECT status FROM Transaction WHERE auctionID = '$auction_id'";

  if ($conn->query($sql_bid) == TRUE){
    $result_bid = mysqli_query($conn, $sql_bid);
    $stat = mysqli_fetch_assoc($result_bid)['status'];

    if ($stat == 'ongoing'){
      
      if ($winnerID == $userID){
        if ($winner_price < $reserve_price){
          echo("<h6 class='alert alert-success'>Congratulation! However, your bid is less than the reserve price. Therefore, 
          you're offered a value of $pound$reserve_price for the purchase of this item.</h6>");
          echo("<h6 class='alert alert-success'>Will you accept it?</h6>");
          ?>
          <form method="POST" action="transac_result.php">
            <button type="submit" name="accept">Accept payment</button>
            <button type="submit" name="reject">Reject payment</button>
          </form>
        <?php
        }else{
          echo("<h6 class='alert alert-success'>Congratulations, you have won the auction for an offer price of $pound$winner_price.</h6>");
          echo("<h6 class='alert alert-success'>Would you like to accept it?</h6>");
          ?>
          <form method="POST" action="transac_result.php">
            <button type="submit" name="accept">Accept payment</button>
            <button type="submit" name="reject">Reject payment</button>
          </form>
        <?php
        }
      }
    }
  }

?>
  </div>
</div>

<div class="row"> <!-- Row #2 with auction description + bidding info -->
  <div class="col-sm-8"> <!-- Left col with item info -->

    <div class="itemDescription">
    <?php echo("<h6>$condition</h6>"); ?>
    <?php echo($description); ?>
    </div>
    <?php echo("<h6>Seller: $seller | Last bidder: $lastBidder</h6>"); ?>
    <?php 
    if (isset($_SESSION['account_type'])) {
      echo('<a href="bid_history.php?auction_id=' . $auction_id . '"><input type="submit" value="Bid History" /></a>');
    }
    ?>

  </div>

  <div class="col-sm-4"> <!-- Right col with bidding info -->

  
<?php if ($now > $end_time): ?>
     This auction ended <?php echo(date_format($end_time, 'j M H:i')) ?>
     <!-- TODO: Print the result of the auction here? -->
     <?php 
      $sql = "SELECT winnerID FROM Auction WHERE auctionID = '$auction_id'";
      $result = mysqli_query($conn, $sql);
      $winnerID = mysqli_fetch_assoc($result)['winnerID'];
      $winner = extract_userName($winnerID);
      echo($winnerID);
      if (empty($winner)){#
        echo ("<h4> There's zero bidder for this auction.</h4>");
      }else{
        echo ('<h4>"' .$winner. '" won this auction.</h4>');
      }
  ?>

<?php else: ?>
     Auction ends <?php echo(date_format($end_time, 'j M H:i') . $time_remaining) ?></p> 
    <p class="lead">Number of bids: <?php echo(number_format($num_bids)) ?></p> 
    <p class="lead">Current bid: £<?php echo(number_format($current_price, 2)) ?></p>
<?php endif ?>

<?php if (($now < $end_time) AND (isset($_SESSION['logged_in']) && $_SESSION['account_type'] == 'buyer')): ?>
    <!-- Bidding form -->
    <form method="POST" action="place_bid.php">
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text">£</span>
        </div>
	    <input type="number" name="bid" class="form-control" id="bid">
      </div>
      <button type="submit" name="submit" class="btn btn-primary form-control">Place bid</button>
    </form>


<?php endif ?>

<?php 

?>
  </div> <!-- End of right col with bidding info -->

</div> <!-- End of row #2 -->

<!-- check if the current item already exist in the watchlist for the user, if yes, pass true to javascript, so watchlist button stay -->
<?php
  $sql = "SELECT * FROM Watchlist";
  $result = mysqli_query($conn, $sql);
  $count = mysqli_num_rows($result);

  $user_id = extract_userID($username);
  $yes = '';

  if ($count > 0){
    while ($row = mysqli_fetch_assoc($result)){

      $buyer_id = $row["buyerID"];
      $trancitem_id = $row["auctionID"];
      if (($buyer_id == $user_id) AND ($trancitem_id == $auction_id)){
        $yes = 'true';
      } 
    }
  }
?>


<?php include_once("footer.php")?>


<script> 
// JavaScript functions: addToWatchlist and removeFromWatchlist.

// Ensure watchlist button stay unchanged by checking php passed argument
var doesExist = <?php echo(json_encode($yes))?>;
if (doesExist == "true"){
  $("#watch_nowatch").hide();
  $("#watch_watching").show();
}



function addToWatchlist(button) {
  // This performs an asynchronous call to a PHP function using POST method.
  // Sends auction ID as an argument to that function.
  $.ajax('watchlist_funcs.php', {
    type: "POST",
    data: {functionname: 'add_to_watchlist', arguments: [<?php echo($auction_id);?>]},

    success: 
      function (obj, textstatus) {
        // Callback function for when call is successful and returns obj
        console.log("Success");
        var objT = obj.trim();

        if (objT == "success") {
          $("#watch_nowatch").hide();
          $("#watch_watching").show();
        }
        else {
          var mydiv = document.getElementById("watch_nowatch");
          mydiv.appendChild(document.createElement("br"));
          mydiv.appendChild(document.createTextNode("Add to watch failed. Try again later."));
        }
      },

    error:
      function (obj, textstatus) {
        console.log("Error");
      }
  }); // End of AJAX call

} // End of addToWatchlist func

function removeFromWatchlist(button) {
  // This performs an asynchronous call to a PHP function using POST method.
  // Sends auction ID as an argument to that function.
  $.ajax('watchlist_funcs.php', {
    type: "POST",
    data: {functionname: 'remove_from_watchlist', arguments: [<?php echo($auction_id);?>]},

    success: 
      function (obj, textstatus) {
        // Callback function for when call is successful and returns obj
        console.log("Success");
        var objT = obj.trim();
 
        if (objT == "success") {
          $("#watch_watching").hide();
          $("#watch_nowatch").show();
        }
        else {
          var mydiv = document.getElementById("watch_watching");
          mydiv.appendChild(document.createElement("br"));
          mydiv.appendChild(document.createTextNode("Watch removal failed. Try again later."));
        }
      },

    error:
      function (obj, textstatus) {
        console.log("Error");
      }
  }); // End of AJAX call


} // End of addToWatchlist func
</script>