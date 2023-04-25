<?php
  require_once "../functions.php";

  followUser($connect, $_GET["from"], $_GET["to"]);
  if (isset($_GET["back"])) {
    redirect("../profile.php?user=" . $_GET["back"]);
  } else {
    redirect("../profile.php?user=" . $_GET["to"]);
  }
?>
