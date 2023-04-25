<?php
  require_once "../msg_dal.php";

  if (isset($_POST["msgID"]) && isset($_POST["msg_txt"])) {
    $result = updateMsgText($_POST["msgID"], $_POST["msg_txt"], $connect);
    echo $result;
  }
?>