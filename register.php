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
    <link rel="stylesheet" href="./css/register.css">
    <link rel="shortcut icon" type="image/jpg" href="./res/register/register.ico"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <title>E L S - Register</title>
  </head>
  
  <body>
    <div class="main">
      <h1 class="sign">Sign up</h1>
      <form class="register" action="./lib/register_handler.php" novalidate method="post">
        
        <span class="error empty"><?=($error === "emptyinput") ? "Please fill in all login details!" : "" ?></span>
        <input class="username" name="name" type="text" placeholder="Full name" value="<?= (isset($_GET['name'])) ? $_GET['name'] : "" ?>">

        <span class="error err-username"><?=($error === "invaliduid") ? "Invalid username!" : "" ?><?=($error === "usernametaken") ? "Username already taken!" : "" ?></span>
        <input class="username" name="uid" type="text" placeholder="Username" value="<?=(isset($_GET['username'])) ? $_GET['username'] : "" ?>">
        
        <span class="error err-email"><?=($error === "invalidemail") ? "Invalid email!" : "" ?><?=($error === "emailtaken") ? "Email already taken!" : "" ?></span>  
        <input class="email" name="email" type="email" placeholder="Email" value="<?=(isset($_GET['email'])) ? $_GET['email'] : "" ?>">
        
        <input class="password" name="pwd" id="pass1" type="password" placeholder="Password">
        <i class="bi bi-eye-slash" id="togglePassword1"></i>
        <span class="strength1"></span>
        
        <input class="password" name="pwdrepeat" id="pass2" type="password" placeholder="Password">
        <i class="bi bi-eye-slash" id="togglePassword2"></i>
        <span class="strength2"></span>
        
        <span class="error err-password"><?=($error === "invalidpwd") ? "Invalid password!" : "" ?><?=($error === "pwdlength") ? "Password must contain between 4 and 26 characters!" : "" ?><?=($error === "pwdmatch") ? "Make sure your passwords match!" : "" ?></span>
        
        <button class="submit" type="submit" name="submit" href="login.php">Sign up</button> 
        <p class="login"><a href="login.php">Already have an account? Log in!</p>
      </form>       
    </div>   
    <script src="./js/register.js"></script>
  </body>
</html>