<?php
  // For now, index.php just redirects to browse.php, but you can change this
  // if you like.
  include_once("header.php");
  include("winner_script.php");

  session_start();
  if (!isset($_SESSION['logged_in'])) {
    header("Location: register.php");
  }else{
    header("Location: browse.php");
  }



  
  include_once("header.php");
?>