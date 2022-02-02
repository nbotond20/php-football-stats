<?php
    if(strlen(trim($_POST['text'])) == 0){
        header("Location: ../team.php?id=".$_GET['id']."&error=emptycomment#comment");
        exit();
    }
    
    session_start();

    $comments_json = file_get_contents("../data/comments.json");
    $comments = json_decode($comments_json, true);

    $id = uniqid();

    date_default_timezone_set('Europe/Budapest');
    $time = time();

    $comments[$id]['time'] = date("Y-m-d H:i:s", $time);
    $comments[$id]['id'] = $id;
    $comments[$id]['userID'] = $_SESSION['userid'];
    $comments[$id]['text'] = $_POST['text'];
    $comments[$id]['teamID'] = $_GET['id'];

    file_put_contents("../data/comments.json", json_encode($comments));

    header("Location: ../team.php?id=".$_GET['id']."#comment");
    exit();
