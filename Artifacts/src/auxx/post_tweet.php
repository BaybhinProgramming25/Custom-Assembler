<?php
  require_once "../msg_dal.php";
  session_start();

if (isset($_POST["txt_msg"]) && isset($_SESSION["userID"])) {
   if($_POST['csrf_token'] == $_SESSION['csrf_token']) {
      $msg_text = $_POST["txt_msg"];
      $author = $_SESSION["userID"];
      // Save the message into the database
      postNewMsg($author, $msg_text, $connect);
    }
}

redirect("../index.php");
?>
