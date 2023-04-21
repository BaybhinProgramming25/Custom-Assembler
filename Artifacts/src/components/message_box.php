<?php
$set_token = $_SESSION['csrf_token'];
echo<<<_END
<div class="row my-4">
  <div class="container col-2"></div>
  <div class="container col-8 bg-light p-3">
    <form action="aux/post_tweet.php" method="post" id="tweetBox">
      <div class="form-group">
        <input type="hidden" name="csrf_token" value="$set_token"></input>
        <label for="message">What's happening today?</label>
        <textarea class="form-control" name="txt_msg" id="txt_msg" rows="3" maxlength="144"></textarea>
      </div>
      <div class="form-group d-flex">
        <button type="submit" class="btn btn-success">Send</button>
        <p id="counter" class="ml-auto mr-2">0</p>
      </div>
    </form>
  </div>
  <div class="container col-2"></div>
</div>
_END;
?>
