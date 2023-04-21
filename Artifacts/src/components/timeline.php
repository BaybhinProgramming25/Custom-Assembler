<div class="row my-4">
  <div class="container col-12">
  <?php
  foreach($messages as $value) {
    $author = getAuthorName($connect, $value[0]);
    $userID = $value[0];
    $message = $value[1];
    $msgID = $value[2];
    $delete = $deleteTweet;
    $editMode = $edit;
    include "message.php";
  }
  ?>
  </div>
</div>