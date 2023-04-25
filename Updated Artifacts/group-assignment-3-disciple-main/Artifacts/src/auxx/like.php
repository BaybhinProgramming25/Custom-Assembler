<?php
  require_once "../functions.php";
  if (isset($_POST["from"]) && isset($_POST["to"])) {
    // Query the database to create the like register
    likeMessage($connect, $_POST["from"], $_POST["to"]);
    // Check if operation went successfuly
    // Sent a true or false response whether the operation went ok or not
  }
?>