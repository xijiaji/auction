 <?php require("utilities.php"); ?>


 <?php
 session_start();
 require_once("database.php");
 $username = $_SESSION['username'];
 $user_id = extract_userID($username);

if (!isset($_POST['functionname']) || !isset($_POST['arguments'])) {
  return;
}

// Extract arguments from the POST variables:
$item_id = $_POST['arguments'];
$string_id = trim(json_encode($item_id, JSON_NUMERIC_CHECK), '[]');
$auction_id = (int)$string_id;

if ($_POST['functionname'] == "add_to_watchlist") {
  // TODO: Update database and return success/failure.
  $sql = "INSERT INTO Watchlist (buyerID, auctionID) VALUES ('$user_id', '$auction_id')";
  $conn->query($sql);
  $res = "success";

}
else if ($_POST['functionname'] == "remove_from_watchlist") {
  // TODO: Update database and return success/failure.
  $sql = "DELETE FROM Watchlist WHERE buyerID = '$user_id' AND auctionID = '$auction_id'";
  $conn->query($sql);
  $res = "success";

}

// Note: Echoing from this PHP function will return the value as a string.
// If multiple echo's in this file exist, they will concatenate together,
// so be careful. You can also return JSON objects (in string form) using
// echo json_encode($res).
echo($res);
?>