<div class="jumbotron mb-1">
  <h1 class="display-4"><?php echo getAuthorName($connect, $_GET["user"]) ?></h1>
  <p class="lead"><?php echo count(filterMsgByUname($_GET["user"], $connect)) . " tweets"; ?></p>
  <p class="lead"><?php echo getNumOfFollowers($connect, $_GET["user"]) . " followers"; ?></p>
  <p class="lead"><?php echo count(checkCurrentUserFollows($connect, $_GET["user"])) . " following"; ?></p>
  <?php
  if ($_GET["user"] != $_SESSION["userID"]) {
    echo '<hr class="my-4">';
    $my_follows = checkCurrentUserFollows($connect, $_SESSION["userID"]);
    $userFollowed = false;
    foreach($my_follows as $key => $value) {
      if ($value[0] == $_GET["user"]) $userFollowed = true;
    }

    if ($userFollowed) {
      echo '<a href="aux/unfollow.php?from='. $_SESSION["userID"] .'&to='. $_GET["user"] . '" class="btn btn-warning btn-md mr-4">Unfollow</a>';
    } else {
      echo '<a href="aux/follow.php?from='. $_SESSION["userID"] .'&to='. $_GET["user"] . '" class="btn btn-success btn-md mr-4">Follow</a>';
    }
  }
  ?>
</div>