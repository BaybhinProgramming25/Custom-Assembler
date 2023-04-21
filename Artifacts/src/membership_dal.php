<?php

  require_once 'functions.php';

  function doLogin($uname, $pwd, $db) {
      $username = $uname;
      $password = $pwd;

      //Grab the salt value that is used in the database from that user
      $passwordQuery = "SELECT pwd FROM users WHERE uname='$username'";
      $passwordFromDB = $db->query($passwordQuery); //Will use this value later
      $extractInfo = $passwordFromDB->fetch_assoc();
      $truePassInfo = $extractInfo['pwd'];
      $obtainSalt = substr($truePassInfo, 7, 22); //PHP standard uses a salt value of length 22
      $options = ['salt' => $obtainSalt];
      $password_hashed = password_hash($password, PASSWORD_BCRYPT, $options); //Hash the password

      //Perform Sanitization Here After Hashing
      $username = mysqli_real_escape_string($db, $username);
      $password = mysqli_real_escape_string($db, $password_hashed);

      // Query the database with the login values
      $authQuery = "select * from users where pwd='$password' and uname='$username' ";
      $response = $db->query($authQuery);
    return $response;
  }

  function registerNewUser($uname, $pwd, $db) {
        $username = $uname;
        $password = $pwd;

        //Hash the password, since it is in plaintext and store it in the database
        $passsword_hashed = password_hash($password, PASSWORD_DEFAULT);

        // Query the database with the login values to create a new user into the database
        $newUserQuery = "insert into users(uname, pwd) values('$username', '$password_hashed');";
    $response = $db->query($newUserQuery);
    return $response;
  }

  ?>


