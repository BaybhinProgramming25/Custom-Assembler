<?php
  require_once 'functions.php';

  session_start();

  //We wanna use this to update the SameSite to have a value of Lax
  $current_value = session_id();
  header("Set-Cookie: PHPSESSID=$current_value; path=/; domain=baybhin.cse361-spring2023.com; SameSite=Lax");

  require_once 'msg_dal.php';
  require_once 'components/navbar.php';
?>
