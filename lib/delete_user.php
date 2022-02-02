<?php 
$user_json = file_get_contents("../data/users.json");
$users = json_decode($user_json, true);

$comments_json = file_get_contents("../data/comments.json");
$comments = json_decode($comments_json, true);

$indexes = [];

$i=0;
if($comments){
    foreach($comments as $c){
        if($c['userID'] === $_GET['id']){
            $indexes[] = $c['id'];
        }
    }
    foreach($indexes as $j){
        unset($comments[$j]);
    }
}

unset($users[$_GET['id']]);

file_put_contents("../data/users.json", json_encode($users));
file_put_contents("../data/comments.json", json_encode($comments));
header("Location: ../manager.php");
exit();