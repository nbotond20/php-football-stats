<?php 
    session_start();
    $teams_json = file_get_contents("./data/teams.json");
    $teams = json_decode($teams_json, true);    
  
    $matches_json = file_get_contents("./data/matches.json");
    $matches = json_decode($matches_json, true);

    $users_json = file_get_contents("./data/users.json");
    $users = json_decode($users_json, true);

    if($matches){
        usort($matches, function ($item1, $item2) {
            return $item2['date'] <=> $item1['date'];
        });
    }
    $isAdmin = false;
    if(isset($_SESSION['userid']) && $users){
        $isAdmin = in_array("admin",$users[$_SESSION['userid']]['roles']) ? true : false;
    }

    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="en" dir="ltr" class="<?= (isset($_SESSION['dark'])) ? "dark-mode" : "" ?>">

<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="./css/index_sidebar.css" />
    <link rel="stylesheet" href="./css/index_main.css">
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" type="image/jpg" href="./res/index/bet1.ico" />
    <title>E L S - Home Page</title>
</head>

<body>
    <?php include_once './lib/sidebar.php'?>
    <section class="home-section">
        <div class="card" id="teams">
            <!-- <img class="arrow" src="./res/index/arrow.png" alt=""> -->
            <h1 class="title">Teams</h1>
            <div class="wrapper">
                <i class='bx bx-chevron-left' id="left-arrow"></i>
                <div class="slider">
                    <ul class="items">
                        <?php if($teams) :?>
                        <?php foreach($teams as $team): ?>
                        <a href="team.php?id=<?=$team["id"]?>">
                            <li class="item">
                                <img src="./res/teams/<?=$team["icon"]?>" alt="<?=$team["id"]?>">
                                <h2 class="team-name"><?=$team["name"]?></h2>
                            </li>
                        </a>
                        <?php endforeach?>
                        <?php endif ?>
                    </ul>
                </div>
                <i class='bx bx-chevron-right' id="right-arrow"></i>
            </div>
        </div>
        <div class="card" id="last5">
            <div class="matches">
                <h2 class="matches-title">Upcoming 5 Matches</h2>
                <hr>
                <table class="matches-table">
                    <?php $i=0?>
                    <?php $j=0?>
                    <?php
                            if($matches){
                                usort($matches, function ($item1, $item2) {
                                    return $item1['date'] <=> $item2['date'];
                                });
                            }
                    ?>
                    <?php if($matches && $teams) : ?>
                    <?php foreach($matches as $match):?>
                    <?php if($i<5 && $match["team1-score"] === "" && $match["team2-score"] === ""): ?>
                    <tr class="match">
                        <td class="date"><?= $match["date"]?></td>
                        <td class="match-detail">
                            <div class="left">
                                <span
                                    class="team1 <?= (isset($_SESSION['userid']) && in_array($match['team1'], $users[$_SESSION['userid']]['favorites'])) ? 'bold-team' : '' ?>"><?= $teams[$match["team1"]]["name"]?></span>
                                <span class="team1-score"><?= $match["team1-score"]?></span>
                            </div>
                            <div class="dash">-</div>
                            <div class="right">
                                <span class="team2-score"><?= $match["team2-score"]?></span>
                                <span
                                    class="team2 <?= (isset($_SESSION['userid']) && in_array($match['team2'], $users[$_SESSION['userid']]['favorites'])) ? 'bold-team' : '' ?>"><?= $teams[$match["team2"]]["name"]?></span>
                            </div>
                        </td>
                        <td class="edit-btn">
                            <?= ($isAdmin) ? '<a href="edit.php?id='.$matches[array_keys($matches)[$j]]["id"]. '&url='.$url.'"><i class="bx bxs-edit"></i></a>' : "" ?>
                        </td>
                    </tr>
                    <?php $i= $i + 1?>
                    <?php endif ?>
                    <?php $j++ ?>
                    <?php endforeach ?>
                    <?php endif ?>
                </table>
            </div>
        </div>
        <div class="card" id="last5">
            <div class="matches">
                <h2 class="matches-title">Matches</h2>
                <hr>
                <table class="matches-table" id="matches">
                    <i class="num <?= count($matches) ?>" id="5" style="display: none;"></i>
                    <?php $i=0?>
                    <?php $j=0 ?>
                    <?php
                            if($matches){
                                usort($matches, function ($item1, $item2) {
                                    return $item2['date'] <=> $item1['date'];
                                });
                            }
                        ?>
                    <?php if($matches && $teams) : ?>
                    <?php foreach($matches as $match):?>
                    <?php if($i<5 && $match["team1-score"] !== "" && $match["team2-score"] !== ""): ?>
                    <tr class="match">
                        <td class="date"><?= $match["date"]?></td>
                        <td class="match-detail">
                            <div class="left">
                                <span
                                    class="team1 <?= (isset($_SESSION['userid']) && in_array($match['team1'], $users[$_SESSION['userid']]['favorites'])) ? 'bold-team' : '' ?>"><?= $teams[$match["team1"]]["name"]?></span>
                                <span class="team1-score"><?= $match["team1-score"]?></span>
                            </div>
                            <div class="dash">-</div>
                            <div class="right">
                                <span class="team2-score"><?= $match["team2-score"]?></span>
                                <span
                                    class="team2 <?= (isset($_SESSION['userid']) && in_array($match['team2'], $users[$_SESSION['userid']]['favorites'])) ? 'bold-team' : '' ?>"><?= $teams[$match["team2"]]["name"]?></span>
                            </div>
                        </td>
                        <td class="edit-btn">
                            <?= ($isAdmin) ? '<a href="edit.php?id='.$matches[array_keys($matches)[$j]]["id"]. '&url='.$url.'"><i class="bx bxs-edit"></i></a>' : "" ?>
                        </td>
                    </tr>
                    <?php $i= $i + 1?>
                    <?php endif ?>
                    <?php $j++ ?>
                    <?php endforeach ?>
                    <?php endif ?>
                </table>
                <button class="load-more">Load more...</button>
            </div>
        </div>
    </section>
    <script src="./js/index.js"></script>
    <script src="./js/logout.js"></script>
    <script src="./js/load-more.js"></script>
    <script src="./js/sidebar.js"></script>
</body>

</html>