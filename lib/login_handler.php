<?php
$user_json = file_get_contents("../data/users.json");
$users = json_decode($user_json, true);

function getReturnParams($username){
    $result = "";
    $result .= "../login.php?";
    $result .= (!empty($username)) ? "username=".$username."&" : "";
    return $result;
}

function emptyInput($username, $pwd){
    if(empty($username) || empty($pwd)){
        return true;
    }else{
        return false;
    }
}

function userExists($username){
    global $users;
    if($users){
        foreach($users as $user){
            if($user['username'] == $username || $user['email'] == $username){
                return $user;
            }
        }
        return null;
    }
    return null;
}

function loginUser($username, $pwd){
    $user = userExists($username);
    if(userExists($username) === null){
        header("location: " . getReturnParams($username) . "error=nouser");
        exit();
    }
    if(password_verify($pwd, $user['pwd']) === false){
        header("location: " . getReturnParams($username) . "error=wrongpass");
        exit();
    }

    session_start();
    $_SESSION['userid'] = $user['id'];
    header("location: ../index.php");
}


if(isset($_POST['submit'])){
    $username = $_POST['uid'];
    $pwd = $_POST['pwd'];

    if(emptyInput($username, $pwd) !== false){
        header("location: " . getReturnParams($username) . "error=emptyinput");
        exit();
    }

    loginUser($username, $pwd);
}else{
    header("location: ../login.php");
    exit();
}