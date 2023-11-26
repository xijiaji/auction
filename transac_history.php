<?php include_once("header.php");
require("utilities.php");
include("winner_script.php");
?>
<?php
require_once("database.php");
session_start();
$username = $_SESSION['username'];
$userID = extract_userID($username);


$sql = "SELECT T.*, A.* FROM Transaction AS T, Auction AS A WHERE A.auctionID = T.auctionID";
$result = mysqli_query($conn, $sql);
$count = mysqli_num_rows($result);

if ($count > 0){
    while($row = $result->fetch_assoc()){
        $winner_id = $row['winnerID'];
        $seller_id = $row['sellerID'];
        $title = $row['title'];

        if (($winner_id == $userID) OR ($seller_id == $userID)){

            # auction item info from Auction table
            $title = $row["title"];
            $condition = $row["itemCondition"];
            $description = $row["description"];
            $price = $row["amount"]; # amount from Transaction table
            $date = $row["date"]; # date from Transaction table

            $stat = $row["status"]; # status from Transaction table
            $seller = extract_userName($seller_id);
            $winner = extract_userName($winner_id);

            $sql_a = "SELECT shippingAddress FROM User WHERE id = '$seller_id'";
            $sql_b = "SELECT shippingAddress FROM User WHERE id = '$winner_id'";

            if (($conn->query($sql_a) == TRUE) AND ($conn->query($sql_b) == TRUE)){
                $result_a = mysqli_query($conn, $sql_a);
                $result_b = mysqli_query($conn, $sql_b);

                $payer_add = mysqli_fetch_assoc($result_b)['shippingAddress'];
                $payee_add = mysqli_fetch_assoc($result_a)['shippingAddress'];

                print_transac_li($title, $condition, $description, $winner, $seller, $price, $payer_add, $payee_add, $date, $stat);
            }
           
        }

    }

}


?>
<?php include_once("footer.php")?>