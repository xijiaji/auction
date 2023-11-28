<?php include_once("header.php");
require("utilities.php");
?>

<?php
# Access PHPMailer server for handling email functionalities
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
            
require '/usr/share/php/libphp-phpmailer/src/PHPMailer.php';
require '/usr/share/php/libphp-phpmailer/src/Exception.php';
require '/usr/share/php/libphp-phpmailer/src/SMTP.php';

# Setup send email variables 
$mail = new PHPMailer(true);
            
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->isHTML(true);
$mail->Username = 'cmcjas1994@gmail.com';
$mail->Password = 'yswn rjrc reny gzfw';
$mail->SMTPSecure = 'ssl';
$mail->Port = 465;
            
$mail->setFrom('cmcjas1994@gmail.com');

// TODO: Extract $_POST variables, check they're OK, and attempt to make a bid.
// Notify user of success/failure and redirect/give navigation options.
session_start();
$username = $_SESSION['username'];
$id = $_SESSION['auction_id'];

require_once "database.php";
$sqlA = "SELECT winningPrice FROM Auction WHERE auctionID = '$id'";
$resultA = mysqli_query($conn, $sqlA);
$rowA = mysqli_fetch_assoc($resultA);
$priceA = $rowA['winningPrice'];

if (isset($_POST["submit"])) {
    $bid = $_POST["bid"];
    $errors = array();
    $msgs = array();
    $currentdate = date('Y-m-d H:i:s', $phptime);

    if (empty($bid)){
        header("Location: listing.php?auction_id=$id");
        exit(); 
    }
    if ($bid <= (float)$priceA){
        array_push($errors, "Bid must be higher than the last bidding price £$priceA!");
    }
   
    if (count($errors)>0) {
        foreach ($errors as $error) {
            array_push($msgs, "<div class='alert alert-danger'>$error</div>");
        }
        $_SESSION["messages"] = $msgs;
        header("Location: listing.php?auction_id=$id");
        exit();
    }else {
        $buyerid = extract_userID($username);
        $sql1 = "UPDATE Auction SET winningPrice = '$bid', numBid = numBid + '1' WHERE auctionID = '$id'";
        $sql2 = "INSERT INTO Bid (price, bidDate, buyerID, auctionID) VALUES ('$bid','$currentdate','$buyerid','$id')";

        # send updated email to previous winning bidder/or generic creation bid msg emial
        if (($conn->query($sql1) === TRUE) AND ($conn->query($sql2) === TRUE)) {

            # check outbid conditions and send emails accordingly when called
            $sqlC = "SELECT buyerID FROM Bid WHERE price = (SELECT max(price) FROM Bid WHERE price < (SELECT max(price) FROM Bid 
            WHERE auctionID = '$id'))";
            $resultC = mysqli_query($conn, $sqlC);
            $count = mysqli_num_rows($resultC);
            # check if bid data exist in the first place - exception handling
            if ($count > 0) {
                $rowC = mysqli_fetch_assoc($resultC)['buyerID'];
                # email for the last highest bidder
                $buyername = extract_userName($rowC);
                $sqlD = "SELECT email FROM User WHERE userName = '$buyername'";
                $resultD = mysqli_query($conn, $sqlD);
                $rowD = mysqli_fetch_assoc($resultD)['email'];
            } else{
                $resultC = 'None';
            }

            $sqlI = "SELECT * FROM Auction WHERE auctionID = '$id'";
            $resultI = mysqli_query($conn, $sqlI);
            $rowI = mysqli_fetch_assoc($resultI);
            $title = "$rowI[title]";

            $sellerid = "$rowI[sellerID]";
            $seller = extract_userName($sellerid);

            # email for current user
            $sql = "SELECT email FROM User WHERE userName = '$username'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result)['email'];

            # if bid exists, inform previous highest bidder that he/she's been outbid, otherwise create a generic bid email msg
            if ($resultC != 'None'){
                $mail->addAddress("$rowD");
            } else{
                $mail->addAddress("$row");
            }

            $pound = '<h7>&pound</h7>';
            $mail->Subject = 'Bid Notification From TSPORT-Auction!';

            if ($buyername != $username){
                if ($resultC == 'None'){
                    # generic msg when first time created a bid - exception handling
                    $mail->Body = "You've sucessfully created a bid for - '$title' (seller - '$seller') with the value of $pound$bid.";
                    $mail->send();
                    $mail->clearAddresses();
                }else{
                    # create an outbid warning msg to the last highest bidder
                    $mail->Body = "Your bid on the item - '$title' (seller - '$seller') has been outbidded by $username for $pound$bid.";
                    $mail->send();
                    $mail->clearAddresses();
                    # also create a generic bid msg to the current user
                    $mail->addAddress("$row");
                    $mail->Body = "You've sucessfully created a bid for - '$title' (seller - '$seller') with the value of $pound$bid.";
                    $mail->send();
                    $mail->clearAddresses();
                }
            }else{
                # send msg when user created a newer bid upon previous bids
                $mail->Body = "You've sucessfully created a bid for - '$title' (seller - '$seller') with the value of $pound$bid.";
                $mail->send();
                $mail->clearAddresses();
            }

            # send email to users with this item on their watchlists
            $sqlw = "SELECT W.*, A.* FROM Watchlist AS W, Auction AS A WHERE W.auctionID = A.auctionID";
            $resultw = mysqli_query($conn, $sqlw);
            $countw = mysqli_num_rows($resultw);

            if ($countw > 0){
                while($roww = mysqli_fetch_assoc($resultw)){
                    $watcher_id = "$roww[buyerID]";
                    $seller_id = "$roww[sellerID]";
                    $seller = extract_userName($seller_id);

                    if ($id == $roww['auctionID']) {
                        $sqle = "SELECT email FROM User WHERE id= '$watcher_id'";
                        $resulte = mysqli_query($conn, $sqle);
                        $rowe = mysqli_fetch_assoc($resulte)['email'];

                        $mail->addAddress("$rowe");
                        $mail->Subject = 'Watchlist Notification From TSPORT-Auction!';
                        $mail->Body = "'$username' created a bid for - '$title' (seller - '$seller') with the value of $pound$bid.";
                        $mail->send();
                        $mail->clearAddresses();
                    }
                }
            }

            echo('<div class="alert alert-success">Bid successfully created! Redirect in 5 secs.</a></div>');
            header("refresh:5;url=browse.php");
            exit();
        }else{
            echo "<div class='alert alert-danger'>Something went wrong :( Redirect in 5 secs.</div>";
            header("refresh:5;url=browse.php");
            exit();
        }
            $conn->close();
    }
}

?>

<?php include_once("footer.php")?>
