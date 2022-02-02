<?php
$user_json = file_get_contents("../data/users.json");
$users = json_decode($user_json, true);

function emptyInput($name, $email, $username, $pwd, $pwdRepeat){
    if(empty($name) || empty($email) || empty($username) || empty($pwd) || empty($pwdRepeat)){
        return true;
    }else{
        return false;
    }
}

function invalidUid($username){
    if(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
        return true;
    }else{
        return false;
    }
}

function invalidEmail($email){
    $result;
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        return true; 
    }else{
        return false; 
    }
}

function pwdLength($pwd){
    if(strlen($pwd) < 4 || strlen($pwd) > 26){
        return true; 
    }else{
        return false;
    }
}

function pwdMatch($pwd, $pwdRepeat){
    if($pwd !== $pwdRepeat){
        return true; 
    }else{
        return false;
    }
}

function uidExists($username){
    global $users;
    if($users){
        foreach($users as $user){
            if($user['username'] == $username){
                return true;
            }
        }
        return false;
    }
    return false;
}

function emailExists($email){
    global $users;
    if($users){
        foreach($users as $user){
            if($user['email'] == $email){
                return true;
            }
        }
        return false;
    }
    return false;
}

function invalidPwd($pwd){
    if(!preg_match("/^[a-zA-Z0-9_&#@!?-]*$/", $pwd)){
        return true; 
    }else{
        return false;
    }
}

function createUser($name, $email, $username, $pwd)
{ 
    global $users;
    $uniqid = uniqid();
    $users[$uniqid]['id'] = $uniqid;
    $users[$uniqid]['name'] = $name;
    $users[$uniqid]['username'] = $username;
    $users[$uniqid]['pwd'] = password_hash($pwd, PASSWORD_DEFAULT);
    $users[$uniqid]['email'] = $email;
    $users[$uniqid]['roles'] = ["user"];
    $users[$uniqid]['favorites'] = [];

    file_put_contents("../data/users.json", json_encode($users));
    header("location: ../login.php?reg=true");
}

function getReturnParams($name, $email, $username){
    $result = "";
    $result .= "../register.php?";
    $result .= (!empty($name)) ? "name=".$name ."&" : "";
    $result .= (!empty($email)) ? "email=".$email ."&": "";
    $result .= (!empty($username)) ? "username=".$username ."&": "";
    return $result;
}

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $username = $_POST['uid'];
    $pwd = $_POST['pwd'];
    $pwdRepeat = $_POST['pwdrepeat'];

    if(emptyInput($name, $email, $username, $pwd, $pwdRepeat) !== false){
        header("location: " . getReturnParams($name, $email, $username) . "error=emptyinput");
        exit();
    }
    if(invalidUid($username) !== false){
        header("location: " . getReturnParams($name, $email, $username) . "error=invaliduid");
        exit();
    }
    if(uidExists($username) !== false){
        header("location: " . getReturnParams($name, $email, $username) . "error=usernametaken");
        exit();
    }
    if(invalidEmail($email) !== false){
        header("location: " . getReturnParams($name, $email, $username) . "error=invalidemail");
        exit();
    }
    if(emailExists($email) !== false){
        header("location: " . getReturnParams($name, $email, $username) . "error=emailtaken");
        exit();
    }
    if(pwdLength($pwd) !== false){
        header("location: " . getReturnParams($name, $email, $username) . "error=pwdlength");
        exit();
    }
    if(invalidPwd($pwd) !== false){
        header("location: " . getReturnParams($name, $email, $username) . "error=invalidpwd");
        exit();
    }
    if(pwdMatch($pwd, $pwdRepeat) !== false){
        header("location: " . getReturnParams($name, $email, $username) . "error=pwdmatch");
        exit();
    }

    createUser($name, $email, $username, $pwd);

}else{
    header("location: ../register.php");
    exit();
}