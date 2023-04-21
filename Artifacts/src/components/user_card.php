<div class="card mx-auto my-4 shadow d-flex flex-row" style="width: 50%;">
  <img class="rounded-circle p-3 my-auto" src="../assets/user_avatars/300.jpeg" alt="profile picture" height="150px" width="150px">
  <div class="card-body">
    <a href=<?php echo "profile.php?user=" . $userID ?>><h5 class="card-title">@<?php echo $name; ?></h5></a>
    <hr>
    <?php
      if ($userFollowed) {
        echo '<a href="aux/unfollow.php?from='. $_SESSION["userID"] .'&to='. $userID . '&back='. $backURL .'" class="btn btn-warning btn-md mr-4">Unfollow</a>';
      } else {
        echo '<a href="aux/follow.php?from='. $_SESSION["userID"] .'&to='. $userID . '&back='. $backURL .'" class="btn btn-success btn-md mr-4">Follow</a>';
      }
    ?>
  </div>
</div>