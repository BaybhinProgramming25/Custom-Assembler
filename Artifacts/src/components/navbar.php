<nav class="navbar navbar-light bg-light">
  <a class="navbar-brand mr-auto" href="index.php">Twitter</a>
  <?php
    if (isset($_SESSION["uname"])) {
      if (!isset($_GET["user"])) {
        echo '<form class="form-inline" action=' . htmlspecialchars($_SERVER['PHP_SELF']) . '>' .
      '<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form>';
      }
      echo '<a href="./profile.php?user=' . $_SESSION["userID"] . '" class="btn btn-primary mr-2 ml-5">My Profile</a>';
      echo '<a href="./aux/logout.php" class="btn btn-danger">Log out</a>';
    }
  ?>
</nav>
