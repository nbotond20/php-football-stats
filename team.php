<?php
    include "./lib/helper.php";
    session_start();
    $users_json = file_get_contents("./data/users.json");
    $users = json_decode($users_json, true);

    $teams_json = file_get_contents("./data/teams.json");
    $teams = json_decode($teams_json, true);
    $id = $_GET["id"];
    $team = $teams[$id];

    $matches_json = file_get_contents("./data/matches.json");
    $matches = json_decode($matches_json, true);
    $good_matches = [];
    if($matches){
        foreach($matches as $match){
            if($match["team1"] == $team["id"] || $match["team2"] == $team["id"]){
                $good_matches[] = $match;
            }
        }   
    }

    function checkWin($team1ID, $team2ID, $score1, $score2){
        global $id;
        if($team1ID == $id){
            if($score1 > $score2){
                return "win";
            }else if($score1 == $score2){
                return "draw";
            }else{
                return "lose";
            }
        }
        if($team2ID == $id){
            if($score1 < $score2){
                return "win";
            }else if($score1 == $score2){
                return "draw";
            }else{
                return "lose";
            }
        }
    }

    $comments_json = file_get_contents("./data/comments.json");
    $comments_t = json_decode($comments_json, true);
    $comments = [];

    if($comments_t){
        foreach($comments_t as $comment){
            if($comment["teamID"] == $id){
                $comments[] = $comment;
            }
        }
    }

    function isAdmin($userid){
        global $users;
        if(isset($users[$userid])){
            if(in_array("admin", $users[$userid]['roles']) !== false){
                return true;
            }
        }
        return false;
    }

    $isAdmin = false;
    if(isset($_SESSION['userid'])){
        $isAdmin = isAdmin($_SESSION['userid']);
    }

    $favCount = 0;
    foreach($users as $user){
        if(in_array($id, $user['favorites']))
            $favCount++;
    }

    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="en" dir="ltr" class="<?= (isset($_SESSION['dark'])) ? "dark-mode" : "" ?>">
    <head>
        <meta charset="UTF-8" />
        <link rel="stylesheet" href="./css/index_sidebar.css" />
        <link rel="stylesheet" href="./css/team.css">
        <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="shortcut icon" type="image/jpg" href="./res/index/bet1.ico"/>
        <title>E L S - <?=$teams[$id]['name']?></title>
    </head>
    <body>
        <?php include_once './lib/sidebar.php'?>
        <section class="home-section">
            <div class="profile-card">
                <img src="./res/teams/<?=$team["icon"]?>" alt="" class="profile-img">
                <h1 class="team-name"><?=$team["name"]?></h1>
                <span class="like-count"><img class="small-heart" src="./res/team/heart_full.png" alt=""><?= $favCount ?></span>
            </div>
            <div class="main-card">
                <?php 
                    if(isset($_SESSION['userid'])){
                        $dest = (in_array($id, $users[$_SESSION['userid']]['favorites'])) ? "heart_full.png" : "heart_empty.png";
                    }   
                ?>
                <?= (isset($_SESSION['userid'])) ? ('<a href="./lib/favorite.php?id=' . $id .'"><img class="heart" src="./res/team/'.$dest.'" alt=""></a>') : "" ?>
                <div class="matches">
                    <h2 class="matches-title">Upcoming Matches</h2>
                    <hr>
                    <table class="matches-table">
                        <?php 
                            usort($good_matches, function ($item1, $item2) {
                                return $item1['date'] <=> $item2['date'];});
                        ?>
                        <?php foreach($good_matches as $m): ?>
                            <?php if($m["team1-score"] === "" && $m["team2-score"] === ""): ?>
                            <tr class="match <?= checkWin($m["team1"], $m["team2"], $m["team1-score"], $m["team2-score"])?>">
                                <td class="date"><?=$m["date"]?></td>
                                <td class="match-detail">
                                    <div class="left">
                                        <span class="team1 <?=($m["team1"] == $id) ? 'bold-team' : '' ?>"><?=$teams[$m["team1"]]["name"]?></span>
                                        <span class="team1-score"><?=$m["team1-score"]?></span>
                                    </div>
                                    <div class="dash">-</div>
                                    <div class="right">
                                        <span class="team2-score"><?=$m["team2-score"]?></span>
                                        <span class="team2 <?=($m["team2"] == $id) ? 'bold-team' : '' ?>"><?=$teams[$m["team2"]]["name"]?></span>
                                    </div>
                                </td>
                                <td class="edit-btn"><?= ($isAdmin) ? '<a href="edit.php?id='.$m["id"].'&url='.$url.'"><i class="bx bxs-edit"></i></a>' : "" ?></td>
                            </tr>
                            <?php endif?>
                        <?php endforeach ?>
                    </table>
                </div>
                <div class="matches">
                    <h2 class="matches-title">Matches</h2>
                    <hr>
                    <table class="matches-table">
                        <?php 
                            usort($good_matches, function ($item1, $item2) {
                                return $item2['date'] <=> $item1['date'];});
                        ?>
                        <?php foreach($good_matches as $m): ?>
                            <?php if($m["team1-score"] !== "" && $m["team2-score"] !== ""): ?>
                            <tr class="match <?= checkWin($m["team1"], $m["team2"], $m["team1-score"], $m["team2-score"])?>">
                                <td class="date"><?=$m["date"]?></td>
                                <td class="match-detail">
                                    <div class="left">
                                        <span class="team1 <?=($m["team1"] == $id) ? 'bold-team' : '' ?>"><?=$teams[$m["team1"]]["name"]?></span>
                                        <span class="team1-score"><?=$m["team1-score"]?></span>
                                    </div>
                                    <div class="dash">-</div>
                                    <div class="right">
                                        <span class="team2-score"><?=$m["team2-score"]?></span>
                                        <span class="team2 <?=($m["team2"] == $id) ? 'bold-team' : '' ?>"><?=$teams[$m["team2"]]["name"]?></span>
                                    </div>
                                </td>
                                <td class="edit-btn"><?= ($isAdmin) ? '<a href="edit.php?id='.$m["id"].'&url='.$url.'"><i class="bx bxs-edit"></i></a>' : "" ?></td>
                            </tr>
                            <?php endif?>
                        <?php endforeach ?>
                    </table>
                </div>
                <div class="comments">
                    <h2 class="comments-title">Comments</h2>
                    <hr>
                    <?php 
                            usort($comments, function ($item1, $item2) {
                                return $item2['time'] <=> $item1['time'];});
                    ?>
                    <?php foreach($comments as $c): ?>
                    <div class="comment">
                        <div class="comment-header">
                            <span class="comment-author <?= (isset($_SESSION['userid']) && $_SESSION['userid'] === $c['userID']) ? "own-comment" : "" ?>"><?= (isAdmin($c['userID'])) ? "<i class='bx bxs-star' style='color:#ffd700'></i>" : "" ?><?= $users[$c["userID"]]['username'] ?></span>
                            <?php
                                $editable = false;
                                if(isset($_SESSION['userid']) && $_SESSION['userid'] === $c['userID'] ){
                                    $editable = true;
                                }
                            ?>
                            <span class="comment-time"><?= humanTiming($c["time"]) ?><?= ($editable || $isAdmin) ? '<a href="./lib/delete_comment.php?id='.$c["id"].'&teamID='.$id.'"><i class="delete-comment bx bxs-trash " ></i></a>' : "" ?></span>
                        </div>
                        <div class="comment-text"><?= $c["text"] ?></box-icon></div>
                    </div>
                    <?php endforeach ?>
                    <form class="comment send-comment" action="./lib/add_comment.php?id=<?=$id?>" method="post">
                        <span class="comment-author own-comment" id="post-author"><?= (isset($_SESSION['userid'])) ? $users[$_SESSION['userid']]['username'] : "" ?></span>
                        <textarea name="text" class="<?= (!isset($_SESSION['userid'])) ? "comment-input-nologin" : "comment-input" ?> comment-text" maxlength="2000" placeholder="<?= (!isset($_SESSION['userid'])) ? "You must be logged in to comment!" : "Write a comment..." ?>" <?= (!isset($_SESSION['userid'])) ? "disabled" : "" ?>></textarea>
                        <span class="comment-error"><?=(isset($_GET['error']) && $_GET['error'] === "emptycomment")? "The comment cannot be empty!" : ""?><a id="comment"> </a> </span>
                        <button type="submit" class="submit <?= (!isset($_SESSION['userid'])) ? "btn-disable" : "" ?>" <?= (!isset($_SESSION['userid'])) ? "disabled" : "" ?>>Post</button>
                    </form>
                </div>
            </div>
        </section>
        <script src="./js/team.js"></script>
        <script src="./js/logout.js"></script>
        <script src="./js/sidebar.js"></script>
    </body>
</html>
