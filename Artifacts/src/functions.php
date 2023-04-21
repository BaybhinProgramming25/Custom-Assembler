<?php
  // Database configuration
  require_once 'dblogin.php';
  $appname = 'Twitter clone';

  /**
   * Connects to MySQL and creates an object to access it
   * @param host
   * @param username
   * @param password
   * @param database
   */
  global $connect;
  $connect = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

  if ($connect->connect_error) {
      die($connect->connect_error);
  }
  else { //Connecting to the database was a success
     //Go through the database and select passwords that are not hashed (i.e. not starting with 2y$ according to manual)
     $pwdQuery = "SELECT pwd FROM users WHERE pwd NOT LIKE '\$2y\$%'";
     $passwords = $connect->query($pwdQuery);
     while($row = $passwords->fetch_assoc()) {
         $password_hashed = password_hash($row['pwd'], PASSWORD_DEFAULT);
         $updateQuery = "UPDATE users SET pwd='$password_hashed'";
         $connect->query($updateQuery);
     }
  }

  /**
   * Receives a database response and converts it into an array
   * @param response: mysql response object
   */
  function turnQueryToArray($response) {
    $rows = $response->num_rows;
    $result = [];
    for ($i = 0; $i < $rows; $i++) {
      array_push($result, $response->fetch_array(MYSQLI_NUM));
    }
    return $result;
  }

  function turnQueryToReverseArray($response) {
    $rows = $response->num_rows;
    $result = [];
    for ($i = 0; $i < $rows; $i++) {
      array_unshift($result, $response->fetch_array(MYSQLI_NUM));
    }
    return $result;
  }

  function extractValuesFromNestedArray($array) {
    $newArray = [];
    foreach ($array as $value) {
      array_push($newArray, $value[0]);
    }
    return $newArray;
  }

  /**
   * Checks if a table already exists and if not create it
   * @param $name: String
   * @param $query: String
   */
  function createTable($db, $name, $query) {
    $db->query("CREATE TABLE $name($query)");
  }

  function createNewUser($db, $username, $password) {
    $db->query("INSERT INTO users(uname, pwd) VALUES('$username', '$password');");
  }

  function checkUserAuth($db, $username, $password) {

    //Check the sent in password with the database stored password
    //Grab the database hashed password
    $database_password = $db->query("SELECT pwd FROM users WHERE uname='$username'");

    if(password_verify($password, $database_password)) {

    //Create prepared statement after sanitizing
    $preparedResponse = $db->prepare("SELECT * FROM users WHERE uname=? AND pwd=?");
    $preparedResponse->bind_param("ss", $username, $password);
    $preparedResponse->execute();
    $response = $preparedResponse->get_result();
    return $response;
    }
 }


  // FOLLOW TABLE FUNCTIONS
  /**
   * Add a follow relation into the followers table
   * @param db: Database connection object
   * @param follower: Number (user's id)
   * @param followed: Number (user's id)
   */
  function followUser($db, $follower, $followed) {
    $db->query("INSERT INTO followers(follower, followed) VALUES('$follower', '$followed');");
  }

  /**
   * Removes a follow relation from the followers table
   * @param db: Database connection object
   * @param follower: Number (user's id)
   * @param followed: Number (user's id)
   */
  function unfollowUser($db, $follower, $followed) {
    $db->query("DELETE FROM followers WHERE follower=$follower AND followed=$followed ;");
  }

  function getNumOfFollowers($db, $user) {
    $response = $db->query("SELECT * FROM followers WHERE followed=$user ;");
    return $response->num_rows;
  }

  /**
   * Returns an array with the id's of the users the current user follows
   */
  function checkCurrentUserFollows($db, $user) {
    $response = $db->query("SELECT followed FROM followers WHERE follower=$user ;");
    return turnQueryToArray($response);
  }

  function getUserFollowers($db, $user) {
    $response = $db->query("SELECT follower FROM followers WHERE followed=$user ;");
    return turnQueryToArray($response);
  }

  function checkIfUserFollowsUser($db, $user1, $user2) {
    $response = $db->query("SELECT * FROM followers WHERE follower=$user1 AND followed=$user2 ;");
    return $response->num_rows;
  }

  // LIKES TABLE FUNCTIONS

  /**
   *
   */
  function likeMessage($db, $user, $msg) {
    $response = $db->query("INSERT INTO likes(user, message) VALUES('$user', '$msg');");
    // $arrayResponse = turnQueryToArray($response);
    // $jsonResponse = json_encode($arrayResponse);
    echo $response;
  }

  function unlikeMessage($db, $user, $msg) {
    $response = $db->query("DELETE FROM likes WHERE user=$user AND message=$msg ;");
    echo $response;
  }

  function checkIfMessageHasLike($db, $user, $msg) {
    $response = $db->query("SELECT * FROM likes WHERE user=$user AND message=$msg ;");
    return $response->num_rows;
  }

  function getMessageLikes($db, $msg) {
    $response = $db->query("SELECT * FROM likes WHERE message=$msg");
    return $response->num_rows;
  }

  function getUserLikes($db, $user) {
    $response = $db->query("SELECT message FROM likes WHERE user=$user ;");
    $arrayResponse = turnQueryToArray($response);
    return extractValuesFromNestedArray($arrayResponse);
  }

  function turnLikesArrayToMessages($db, $likes) {
    $response = [];
    foreach($likes as $like) {
      $content = $db->query("SELECT * FROM messages WHERE id=$like");
      array_push($response, $content->fetch_array(MYSQLI_NUM));
    }
    return $response;
  }

  //  OTHER FUNCTIONS

  function redirect($url) {
    header('Location: ' . $url);
  }


?>


