<?php 
$user_json = file_get_contents("../data/users.json");
$users = json_decode($user_json, true);

function isAdmin($userid){
    global $users;
    if(isset($users[$userid])){
        if(in_array("admin", $users[$userid]['roles']) !== false){
            return true;
        }
    }
    return false;
}

if(isAdmin($_GET['id'])){
    $users[$_GET['id']]['roles'] = ["user"];
}else{
    $users[$_GET['id']]['roles'][] = "admin";
}

file_put_contents("../data/users.json", json_encode($users));
header("Location: ../manager.php");
exit();