<?php
  $error;
  if(isset($_GET['error'])){
    $error = $_GET['error'];
  }else{
    $error = "";
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="./css/login.css">
    <link rel="shortcut icon" type="image/jpg" href="./res/login/login.ico"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <title>E L S - Login</title>
  </head>
  
  <body>
    <div class="main">
      <span class="reg"><?= (isset($_GET['reg'])) ? "Registered successfully, Please log in!" : "" ?></span>
      <h1 class="sign">Sign in</h1>
      <form class="login" action="./lib/login_handler.php" novalidate method="post">

        <span class="error nouser"><?=($error === "emptyinput") ? "Please fill in all login details!" : "" ?><?=($error === "nouser") ? "User not found!" : "" ?></span>
        <input class="username" name="uid" type="text" placeholder="Username/Email" value="<?= (isset($_GET['username'])) ? $_GET['username'] : "" ?>">

        <span class="error wrongpass"><?=($error === "wrongpass") ? "Wrong password!" : "" ?></span>
        <input class="password" name="pwd" type="password" placeholder="Password">
        <i class="bi bi-eye-slash" id="togglePassword"></i>
        <button class="submit" name="submit" type="submit">Sign in</button>
      </form>       
      <p class="register"><a href="register.php">No account? Register!</p>
    </div>   
    <script src="./js/login.js"></script>
  </body>
</html>