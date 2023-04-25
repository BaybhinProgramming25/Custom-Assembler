<?php

  require_once 'functions.php';


   function postNewMsg($author, $message, $db) {
    //Perform Output-Encoding before the message gets saved onto the database
    $encoded_message = htmlentities($message, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $db->query("INSERT INTO messages(author, msg_text) VALUES($author, '$encoded_message');");
  }

  function delMsg($messageID, $db) {
    $db->query("DELETE FROM messages WHERE id=$messageID ;");
  }

  function getAllMsg($db) {
    $response = $db->query("SELECT * FROM messages");
    return turnQueryToReverseArray($response);
  }

  function getMsgByUserID($user, $db) {
    $response = $db->query("SELECT * FROM messages WHERE author IN (SELECT followed FROM followers WHERE follower=$user) ORDER BY id DESC;");
    return turnQueryToArray($response);
  }

  /**
   * Returns all messages that includes the text passed in the filter
   * @param database: object
   * @param filter: string
   */
  function filterMsgByText($filter, $db) {
    $response = $db->query("SELECT * FROM messages WHERE msg_text LIKE '%$filter%';");
    return turnQueryToReverseArray($response);
  }

  function filterMsgByUname($author, $db) {
    $response = $db->query("SELECT * FROM messages WHERE author=$author ;");
    return turnQueryToReverseArray($response);
  }

  function getAuthorName($db, $author) {
    $response = $db->query("SELECT uname FROM users WHERE id=$author;");
    return $response->fetch_array(MYSQLI_NUM)[0];
  }

  function updateMsgText($msg, $text, $db) {
    $response = $db->query("UPDATE messages SET msg_text='$text' WHERE id=$msg ;");
    return $response;
  }
  ?>
