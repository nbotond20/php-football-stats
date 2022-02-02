<?php
session_start();

$users_json = file_get_contents("../data/users.json");
$users = json_decode($users_json, true);

$user = $users[$_SESSION['userid']];

$found = false;
foreach($user['favorites'] as $f){
    if($f === $_GET['id'] ){
        $found = true;
    }
}
if(!$found){
    $users[$_SESSION['userid']]['favorites'][] = $_GET['id'];
    var_dump($users[$_SESSION['userid']]['favorites']);
    
}else{
    var_dump($user['favorites']);
    if (($key = array_search($_GET['id'], $user['favorites'])) !== false) {
        unset($user['favorites'][$key]);
    }
    $users[$_SESSION['userid']]['favorites'] = $user['favorites'];
}

file_put_contents("../data/users.json", json_encode($users));
if(isset($_GET['from'])){
    header("Location: ../teams.php");
}else{
    header("Location: ../team.php?id=".$_GET['id']);
}
exit();