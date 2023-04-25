
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Twitter Clone</title>
  <!-- Bootstrap styles cdn -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
<?php require_once 'header.php'; ?>
<?php if (!isset($_SESSION["userID"])) require_once 'components/jumbotron.php'; ?>

<!-- Print message box and timeline -->
<?php
  if (isset($_SESSION["userID"])) {
    //Generate a random CSRF token
    $csrf_token_make = bin2hex(random_bytes(16));
    $_SESSION['csrf_token'] = $csrf_token_make;
    require_once "components/message_box.php";
    require_once "msg_dal.php";
    // Render timeline
    if (isset($_GET["search"])) {
      $messages = filterMsgByText($_GET["search"], $connect);
      $deleteTweet = false;
      $edit = false;
      require_once "components/timeline.php";
    } else {
      $messages = getMsgByUserID($_SESSION["userID"], $connect);
      $deleteTweet = false;
      $edit = false;
      require_once "components/timeline.php";
    }
  }
?>

  <!-- Bootstrap scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <!-- Scripts  -->
  <?php if (isset($_SESSION["userID"])) echo '<script src="js/index.js"></script>'; ?>
  <script src="js/message_counter.js"></script>
</body>
</html>
