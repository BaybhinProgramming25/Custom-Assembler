<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Twitter clone | Sign up </title>
  <!-- Bootstrap styles cdn -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
  <?php require_once 'header.php';
  require_once 'membership_dal.php';
  ?>

  <div class="row my-5">
    <div class="container col-3"></div>
    <div class="container col-6">
      <form action=<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?> method="post">
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" class="form-control" name="txt_uname" id="txt_uname" placeholder="Enter username" required>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" class="form-control" name="txt_pwd" id="txt_pwd" required>
        </div>
        <button type="submit" class="btn btn-primary">Sign up</button>
      </form>
      <p class="mt-4">Already have an account? <a href="login.php">Log in</a></p>
    </div>
    <div class="container col-3"></div>
  </div>

  <?php
    if (isset($_POST["txt_uname"]) && isset($_POST["txt_pwd"])) {

      $response = registerNewUser($_POST["txt_uname"], $_POST["txt_pwd"], $connect);
      if ($response == 1) {
        $_SESSION["uname"] = $_POST["txt_uname"];
        redirect('./index.php');
      } else {
        $message = 'The username is already in use';
        include_once './components/alert.php';
      }
    }
  ?>

  <!-- Bootstrap scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
