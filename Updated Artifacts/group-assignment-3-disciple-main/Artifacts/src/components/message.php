<?php
  $checkLike = checkIfMessageHasLike($connect, $_SESSION["userID"], $msgID);
  $btnClass = $checkLike == 0 ? "btn-success" : "btn-warning";
  $btnText = $btnClass == "btn-success" ? "Like" : "Unlike";
?>

<div class="card mx-auto my-3 shadow position-relative" style="width:50%;">
  <div class="card-body">
    <h5 class="card-title"><a href=<?php echo 'profile.php?user=' . $userID ?>>@<?php echo $author ?></a></h5>
    <p class="card-text" id=<?php echo "text-" . $msgID; ?>><?php echo $message ?></p>
    <button
      type="button"
      <?php echo 'class="btn like-btn ' . $btnClass . '"'; ?>
      data-msg=<?php echo $msgID ?>
      data-usr=<?php echo $_SESSION["userID"] ?>
      <?php echo $author == $_SESSION["uname"] ? "disabled" : "not" ?>
      >
      <?php echo $btnText; ?>
      </button>
      <span class="ml-3" data-msg=<?php echo $msgID ?> >
      <?php echo getMessageLikes($connect, $msgID); ?>
      </span>
      <div class="position-absolute" style="right: 20px; bottom: 20px;">
        <?php echo $delete == true ? '<button class="btn btn-light mr-2" id="btn-edit-' . $msgID . '">Edit</button>' : ''; ?>
        <?php echo $delete == true ? '<a href="aux/delete_tweet.php?msg='. $msgID .'" class="btn btn-danger" >Delete</a>' : ''; ?>
      </div>
  </div>
</div>