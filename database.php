<?php

// connecting php to mysql database
$conn = mysqli_connect('localhost', 'cmcjas', 'Cmc19940815.', 'testing');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>