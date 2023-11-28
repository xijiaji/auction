<?php
mkdir("itemimg");
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
require_once ("database.php");
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
        $sellerID = "$row[sellerID]";

        $sqln = "SELECT userName FROM User WHERE id = '$sellerID'";
        $resultn = mysqli_query($conn, $sqln);
        $seller = mysqli_fetch_assoc($resultn)['userName'];

        $sqle = "SELECT email FROM User WHERE userName = '$seller'";
        $resulte = mysqli_query($conn, $sqle);
        $rowe = mysqli_fetch_assoc($resulte)['email'];

        $sqlii = "SELECT buyerID FROM Bid WHERE auctionID = '$auction_id' AND price = (SELECT MAX(price) FROM Bid WHERE 
        auctionID = '$auction_id')";
        $sqlA = "SELECT DISTINCT buyerID FROM Bid WHERE auctionID = '$auction_id'";

        if (($conn->query($sqlii) == TRUE) AND ($conn->query($sqlA) == TRUE)) {
          $resulti = mysqli_query($conn, $sqlii);
          $resultA = mysqli_query($conn, $sqlA);

          $winnerID = mysqli_fetch_assoc($resulti)['buyerID'];
          $sqlw = "SELECT userName FROM User WHERE id = '$winnerID'";
          $resultw = mysqli_query($conn, $sqlw);
          $winner = mysqli_fetch_assoc($resultw)['userName'];

          $sqlu = "UPDATE Auction SET winnerID = '$winnerID' WHERE auctionID = '$auction_id'";
          mysqli_query($conn, $sqlu);

          while ($rowA = mysqli_fetch_assoc($resultA)){
            $buyerID = "$rowA[buyerID]";
            $sqll = "SELECT userName FROM User WHERE id = '$buyerID'";
            $resultl = mysqli_query($conn, $sqll);
            $buyer = mysqli_fetch_assoc($resultl)['userName'];
            
            $sqlB = "SELECT email FROM User WHERE userName = '$buyer'";
            $resultB = mysqli_query($conn, $sqlB);
            $rowB = mysqli_fetch_assoc($resultB)['email'];

            # emails only send once after an auction is ended, update database from false to true for mailSent
            if ($sent == 'FALSE'){

                if ($winner == $buyer) {
                  $mail->addAddress("$rowB");
                  $mail->Subject = 'An auction has ended from TSPORT-Auction!';
                  $mail->Body = "Your bid item - '$title' (seller - '$seller') has ended, and you've won.";
                  $mail->send();
                  $mail->clearAddresses();
                } else{
                  $mail->addAddress("$rowB");
                  $mail->Subject = 'An auction has ended from TSPORT-Auction!';
                  $mail->Body = "Your bid item - '$title' (seller - '$seller') has ended, '$winner' won the auction.";
                  $mail->send();
                  $mail->clearAddresses();
                }
                $mail->addAddress("$rowe");
                $mail->Subject = 'Your auction has ended from TSPORT-Auction!';
                $mail->Body = "Your auction item - '$title' has ended, '$winner' won the auction.";
                $mail->send();
                $mail->clearAddresses();

                # create transaction between winner and seller
                $trans_dtime = date('Y-m-d H:i:s', $phptime);
                $sqlT = "INSERT INTO Transaction (date, status, auctionID) VALUES ('$trans_dtime', 'ongoing', '$auction_id')";
                $conn->query($sqlT);
                }
            }
          # update mailSent as email(s) have already been sent
          $sqlD = "UPDATE Auction SET mailSent = 'TRUE' WHERE auctionID = '$auction_id'";
          $conn->query($sqlD);
          }
         }
      }

      # delete second duplicate transaction after creation
      $sql_last = "SELECT auctionID FROM Transaction ORDER BY tID DESC LIMIT 1";
      $sql_2last = "SELECT auctionID FROM Transaction ORDER BY tID DESC LIMIT 1,1";
      $result_last = mysqli_query($conn, $sql_last);
      $result_2last = mysqli_query($conn, $sql_2last);

      if (mysqli_fetch_assoc($result_last)['auctionID'] == mysqli_fetch_assoc($result_2last)['auctionID']){
        $sql_del = "DELETE FROM Transaction ORDER BY tID DESC LIMIT 1";
        $conn->query($sql_del);
      }
  }

?>