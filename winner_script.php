<?php

require_once "database.php";

# Access PHPMailer server for handling email functionalities
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
            
require '/usr/share/php/libphp-phpmailer/src/PHPMailer.php';
require '/usr/share/php/libphp-phpmailer/src/Exception.php';
require '/usr/share/php/libphp-phpmailer/src/SMTP.php';

# set up phpmailer
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

# check who won after an auction ended
$now = new DateTime();
$sqli = "SELECT * FROM Auction";
$result = mysqli_query($conn, $sqli);

if ($result != null) {
  while($row = mysqli_fetch_assoc($result)) {
      $endDate = new DateTime($row['endDate']);
      $auction_id = "$row[auctionID]";

      if ($now > $endDate) {
        $sent = "$row[mailSent]";
        $title = "$row[title]";
        $seller = "$row[sellerName]";

        $sqle = "SELECT email FROM User WHERE name = '$seller'";
        $resulte = mysqli_query($conn, $sqle);
        $rowe = mysqli_fetch_assoc($resulte)['email'];

        $sqlii = "SELECT buyerName FROM Bid WHERE auctionID = '$auction_id' AND price = (SELECT MAX(price) FROM Bid WHERE 
        auctionID = '$auction_id')";
        $sqlA = "SELECT DISTINCT buyerName FROM Bid WHERE auctionID = '$auction_id'";

        if (($conn->query($sqlii) == TRUE) AND ($conn->query($sqlA) == TRUE)) {
          $resulti = mysqli_query($conn, $sqlii);
          $resultA = mysqli_query($conn, $sqlA);

          $winner = mysqli_fetch_assoc($resulti)['buyerName'];
          $sqlu = "UPDATE Auction SET winner = '$winner' WHERE auctionID = '$auction_id'";
          mysqli_query($conn, $sqlu);

          while ($rowA = mysqli_fetch_assoc($resultA)){
            $buyer = "$rowA[buyerName]";

            $sqlB = "SELECT email FROM User WHERE name = '$buyer'";
            $resultB = mysqli_query($conn, $sqlB);
            $rowB = mysqli_fetch_assoc($resultB)['email'];


            // echo $rowB;
            // echo $rowI;

             # emails only send once after an auction is ended, update database from false to true for mailSent
            if ($sent == 'FALSE'){

                if ($winner == $buyer) {
                  $mail->addAddress("$rowB");
                  $mail->Subject = 'An auction has ended From E-Auction!';
                  $mail->Body = "Your bid item - '$title' (seller - '$seller') has ended, and you've won.";
                  $mail->send();
                  $mail->clearAddresses();
                } else{
                  $mail->addAddress("$rowB");
                  $mail->Subject = 'An auction has ended From E-Auction!';
                  $mail->Body = "Your bid item - '$title' (seller - '$seller') has ended, $winner won the auction.";
                  $mail->send();
                  $mail->clearAddresses();
                }
                $mail->addAddress("$rowe");
                $mail->Subject = 'Your auction has ended From E-Auction!';
                $mail->Body = "Your auction item - '$title' has ended, '$winner' won the auction.";
                $mail->send();
                $mail->clearAddresses();
                }
            }
          # update mailSent as email(s) have already been sent
          $sqlD = "UPDATE Auction SET mailSent = 'TRUE' WHERE auctionID = '$auction_id'";
          mysqli_query($conn, $sqlD);
          }
         }
      }
  }





?>