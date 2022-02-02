<?php 
    $comments_json = file_get_contents("../data/comments.json");
    $comments = json_decode($comments_json, true);
    $c_id = $_GET['id'];
    unset($comments[$c_id]);

    file_put_contents("../data/comments.json", json_encode($comments));
    if(isset($_GET['dest'])){
        header("Location: ../comments.php");
    }else{
        header("Location: ../team.php?id=".$_GET['teamID']."#comment");
    }
    exit();
?>