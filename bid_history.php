<?php include_once("header.php")?>
<?php require("utilities.php")?>

<div class="container">

<h2 class="my-3">Item Bid History</h2>

<?php
$auction_id = $_GET['auction_id'];

require_once "database.php";
$sql = "SELECT * FROM Bid WHERE auctionID = '$auction_id'";
$result = mysqli_query($conn, $sql);

if ($result != null) {

    while($row = mysqli_fetch_assoc($result)) {

        $price = $row['price'];
        $name = $row['buyerName'];
        $dtime = "$row[bidDate]";

        $sql2 = "SELECT * FROM Auction WHERE auctionID = '$auction_id'";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);

        $title = "$row2[title]";
        $condition = "$row2[itemCondition]";
        $description = "$row2[description]";

        print_itembid_li($name, $title, $condition, $description, $price, $dtime);



    }
} 

?>



<?php include_once("footer.php")?>