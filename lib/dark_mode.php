<?php
session_start(); 
if(isset($_SESSION['dark'])){
    unset($_SESSION['dark']);
}else{
    $_SESSION['dark'] = true;
}

header("location: ". $_GET['url']);
exit();