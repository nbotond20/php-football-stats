<?php
    include "./lib/helper.php";
    session_start();
    $userID = (isset($_SESSION['userid']) ? $_SESSION['userid'] : "" );
    $users_json = file_get_contents("./data/users.json");
    $users = json_decode($users_json, true);

    $teams_json = file_get_contents("./data/teams.json");
    $teams = json_decode($teams_json, true);

    $comments_json = file_get_contents("./data/comments.json");
    $comments = json_decode($comments_json, true);

    $comments_per_team = [];

    $hasComments = false;

    if($teams){
        foreach($teams as $t){
            $comments_per_team[$t['id']] = [
                'id' => $t['id'],
                'count' => 0
            ];
            if($comments){
                foreach($comments as $c){
                    if($c['teamID'] === $t['id'] && $c['userID'] === $userID){
                        $comments_per_team[$t['id']]['count']++;
                        $hasComments = true;
                    }
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr" class="<?= (isset($_SESSION['dark'])) ? "dark-mode" : "" ?>">
    <head>
        <meta charset="UTF-8" />
        <link rel="stylesheet" href="./css/index_sidebar.css" />
        <link rel="stylesheet" href="./css/team.css">
        <link rel="stylesheet" href="./css/comments.css">
        <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="shortcut icon" type="image/jpg" href="./res/index/bet1.ico"/>
        <title>E L S - Comments</title>
    </head>
    <body>
        <?php include_once './lib/sidebar.php'?>
        <section class="home-section">
            <div class="main-card">
                <?php 
                    usort($comments, function ($item1, $item2) {
                        return $item2['time'] <=> $item1['time'];});
                ?>
                <?php if(count($comments)<=0 || !$hasComments): ?>
                    <div class="comments">
                        <h2 class="comments-title">No comments yet!</h2>
                        <hr>
                    </div>
                <?php endif ?>

                <?php if($teams): ?>
                    <?php foreach($teams as $team) : ?>
                    <div class="comments">
                    <?php if($comments_per_team[$team['id']]['count'] > 0): ?>
                        <h2 class="comments-title"><a href="./team.php?id=<?= $team['id'] ?>"><?= $team["name"] ?></a></h2>
                        <hr>
                    <?php endif ?>
                    <?php foreach($comments as $c): ?>
                        <?php if($c['teamID'] == $team['id'] && $c['userID'] == $userID): ?>
                            <div class="comment">
                                <div class="comment-header">
                                    <span class="comment-author"><?= $users[$c['userID']]['username'] ?></span>
                                    <span class="comment-time"><?= humanTiming($c["time"]) ?><a href="./lib/delete_comment.php?id=<?=$c["id"]?>&dest=comments.php"><i class='delete-comment bx bxs-trash ' ></i></a></span>
                                </div>
                                <div class="comment-text">
                                    <?= $c["text"] ?></box-icon>
                                </div>
                            </div>
                        <?php endif ?>
                    <?php endforeach ?>
                    </div>
                <?php endforeach ?>
                <?php endif ?>
            </div>
        </section>
        <script src="./js/team.js"></script>
        <script src="./js/logout.js"></script>
        <script src="./js/sidebar.js"></script>
    </body>
</html>
