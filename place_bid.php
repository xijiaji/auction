<?php include_once("header.php")?>

<?php
# Access PHPMailer server for handling email functionalities
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
            
require '/usr/share/php/libphp-phpmailer/src/PHPMailer.php';
require '/usr/share/php/libphp-phpmailer/src/Exception.php';
require '/usr/share/php/libphp-phpmailer/src/SMTP.php';

// TODO: Extract $_POST variables, check they're OK, and attempt to make a bid.
// Notify user of success/failure and redirect/give navigation options.
session_start();
$userName = $_SESSION['username'];
$id = $_SESSION['auction_id'];

require_once "database.php";
$sqlA = "SELECT reservePrice FROM Auction WHERE auctionID = '$id'";
$resultA = mysqli_query($conn, $sqlA);
$rowA = mysqli_fetch_assoc($resultA);
$priceA = $rowA['reservePrice'];

$sqlB = "SELECT startingPrice FROM Auction WHERE auctionID = '$id'";
$resultB = mysqli_query($conn, $sqlB);
$rowB = mysqli_fetch_assoc($resultB);
$priceB = $rowB['startingPrice'];



if (isset($_POST["submit"])) {
    $bid = $_POST["bid"];
    $errors = array();
    $msgs = array();
    $currentdate = date('Y-m-d H:i:s', $phptime);

    if (empty($bid)){
        header("Location: listing.php?auction_id=$id");
        exit(); 
    }
    if ($bid < (float)$priceA){
        array_push($errors, "Bid must be at least £$priceA (reserve)!");
    }
    if ($bid <= (float)$priceB){
        array_push($errors, "Bid must be higher than current price!");
    }

    if (count($errors)>0) {
        foreach ($errors as $error) {
            array_push($msgs, "<div class='alert alert-danger'>$error</div>");
        }
        $_SESSION["messages"] = $msgs;
        header("Location: listing.php?auction_id=$id");
        exit();
    }else {
        $sql = "UPDATE Auction SET startingPrice = '$bid', noBid = noBid + '1' WHERE auctionID = '$id'";
        $sql2 = "INSERT INTO Bid (price, bidDate, buyerName, auctionID) VALUES ('$bid','$currentdate','$userName',
        '$id')";

        if (($conn->query($sql) === TRUE) AND ($conn->query($sql2) === TRUE)) {

            # check outbid conditions and send emails accordingly when called
            $sqlC = "SELECT buyerName FROM Bid WHERE price = (SELECT max(price) FROM Bid WHERE price < (SELECT max(price)
            FROM Bid WHERE auctionID = '$id'))";
            
            if (($conn->query($sqlC) === TRUE)) {
                $resultC = $mysqli_query($conn, $sqlC);
                $rowC = mysqli_fetch_assoc($resultC)['buyerName'];

                $sqlD = "SELECT email FROM User WHERE name = '$rowC'";
                $resultD = mysqli_query($conn, $sqlD);
                $rowD = mysqli_fetch_assoc($resultD)['email'];
            } else{
                $resultC = null;
            }


            $sqlI = "SELECT * FROM Auction WHERE auctionID = '$id'";
            $resultI = mysqli_query($conn, $sqlI);
            $rowI = mysqli_fetch_assoc($resultI);
            $title = "$rowI[title]";
            $seller = "$rowI[sellerName]";

            # Setup send email variables 
            $mail = new PHPMailer(true);
            
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'cmcjas1994@gmail.com';
            $mail->Password = 'yswn rjrc reny gzfw';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            
            $mail->setFrom('cmcjas1994@gmail.com');
            if ($result != null){
                $mail->addAddress("$rowD");
            } else{
                $sql = "SELECT email FROM User WHERE name = '$userName'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result)['email'];
                $mail->addAddress("$row");
            }
            
            $mail->Subject = 'Bid Notification From E-Auction!';

            if (($rowC == $userName) or ($result != null)) {
                $mail->Body = "You've sucessfully create a bid for - '$title' (seller - '$seller') with the value of chr(163)$bid.";
            }else{
                $mail->Body = "Your bid item - '$row_title' (seller - '$row_seller') has been outbid by $userName for chr(163)$bid.";
            }
            
            $mail->send();

            echo('<div class="alert alert-success">Bid successfully submitted! Redirect in 5 secs.</a></div>');
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
