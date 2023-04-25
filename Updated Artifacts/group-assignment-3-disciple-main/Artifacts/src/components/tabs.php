<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Tweets</a>
    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Likes</a>
    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Following</a>
    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-follows" role="tab" aria-controls="nav-follows" aria-selected="false">Followers</a>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
  <?php
   if (isset($_GET["user"])) {
    $messages = filterMsgByUname($_GET["user"], $connect);
    $deleteTweet = false;
    $edit = true;
    if ($_SESSION["userID"] == $_GET["user"]) {
      $deleteTweet = true;
    }
    require "components/timeline.php";
  }
  ?>
  </div>
  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
  <?php
   if (isset($_GET["user"])) {
    $likes = getUserLikes($connect, $_GET["user"]);
    $messages = turnLikesArrayToMessages($connect, $likes);
    $deleteTweet = false;
    $edit = false;
    require "components/timeline.php";
  }
  ?>
  </div>
  <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
    <?php
      $users = checkCurrentUserFollows($connect, $_GET["user"]);
      foreach($users as $user) {
        $name = getAuthorName($connect, $user[0]);
        $userID = $user[0];
        $userFollowed = checkIfUserFollowsUser($connect, $_SESSION["userID"], $user[0]) == 0 ? false : true;
        $backURL = $_GET["user"];
        require "user_card.php";
      }
    ?>
  </div>
  <div class="tab-pane fade" id="nav-follows" role="tabpanel" aria-labelledby="nav-contact-tab">
    <?php
      $followers = getUserFollowers($connect, $_GET["user"]);
      foreach($followers as $value) {
        $name = getAuthorName($connect, $value[0]);
        $userID = $value[0];
        $userFollowed = checkIfUserFollowsUser($connect, $_SESSION["userID"], $value[0]) == 0 ? false : true;
        $backURL = $_GET["user"];
        require "user_card.php";
      }
    ?>
  </div>
</div>