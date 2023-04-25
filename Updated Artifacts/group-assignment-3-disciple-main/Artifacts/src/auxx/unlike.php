<?php
  require_once "../functions.php";
  if (isset($_POST["from"]) && isset($_POST["to"])) {
    unlikeMessage($connect, $_POST["from"], $_POST["to"]);
  }
?>