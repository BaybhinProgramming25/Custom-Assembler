<?php
  require_once "../msg_dal.php";
  session_start();

  delMsg($_GET["msg"], $connect);
  redirect("../profile.php?user=" . $_SESSION["userID"]);
?>
