<?php
  require_once "../functions.php";
  session_start();

  // Remove user's session
  unset($_SESSION);
  session_destroy();

  // Redirect to home page
  redirect("../index.php");