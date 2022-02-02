<?php
    session_start();

    $teams_json = file_get_contents("./data/teams.json");
    $teams = json_decode($teams_json, true);    
  
    $matches_json = file_get_contents("./data/matches.json");
    $matches = json_decode($matches_json, true);

    $users_json = file_get_contents("./data/users.json");
    $users = json_decode($users_json, true);

    $team_anal = [];

    if($teams && $matches){
        foreach($teams as $team){
            $temp = [
                'id' => $team['id'],
                'win' => 0,
                'lose' => 0,
                'draw' => 0,
                'points' => 0
            ];  
            foreach($matches as $match){
                if($match['team1-score'] !== "" &&  $match['team2-score'] !== ""){
                    if($match['team1'] == $team['id']){
                        if($match['team1-score'] > $match['team2-score']){
                            $temp['win']++;
                            $temp['points'] += 3;
                        }else if($match['team1-score'] == $match['team2-score']){
                            $temp['draw']++;
                            $temp['points']++;
                        }else{
                            $temp['lose']++;
                        }
                    }
                    if($match['team2'] == $team['id']){
                        if($match['team2-score'] > $match['team1-score']){
                            $temp['win']++;
                            $temp['points'] += 3;
                        }else if($match['team2-score'] == $match['team1-score']){
                            $temp['draw']++;
                            $temp['points']++;
                        }else{
                            $temp['lose']++;
                        }
                    }
                }
            }
            $team_anal[$temp['id']] = $temp;
        }
        file_put_contents("./data/analytics.json", json_encode($team_anal));
    }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr" class="<?= (isset($_SESSION['dark'])) ? "dark-mode" : "" ?>">

<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="./css/index_sidebar.css" />
    <link rel="stylesheet" href="./css/teams.css">
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" type="image/jpg" href="./res/index/bet1.ico" />
    <title>E L S - Teams</title>
</head>

<body>
    <?php include_once './lib/sidebar.php'?>
    <section class="home-section">
        <div class="wrapper">
            <?php $i=0; ?>
            <?php foreach($teams as $team): ?>
            <div class="card">
                <?php 
                            $dest = (isset($_SESSION['userid']) && in_array($team['id'], $users[$_SESSION['userid']]['favorites'])) ? "heart_full.png" : "heart_empty.png";
                        ?>
                <img class="profile-pic" src="./res/teams/<?=$team['icon']?>">
                <a class="link" href="team.php?id=<?=$team["id"]?>">
                    <h2 class="team-name"><?= $team['name'] ?></h2>
                </a>
                <style>
                    <?=".a".$i?> {
                        stroke: #60da7e;
                        animation: donut<?=$i?> 3s;
                    }
                    @keyframes donut<?=$i?> {
                        0% {
                            stroke-dasharray: 0, 100;
                            }
                        100% {
                            stroke-dasharray: <?= round($team_anal[$team['id']]['win']/($team_anal[$team['id']]['win']+$team_anal[$team['id']]['draw']+$team_anal[$team['id']]['lose'])*100) ?>, <?= 100 - round($team_anal[$team['id']]['win']/($team_anal[$team['id']]['win']+$team_anal[$team['id']]['draw']+$team_anal[$team['id']]['lose'])*100) ?>;
                        }
                    }
                </style>
                <div class="svg-item">
                    <svg width="100%" height="100%" viewBox="0 0 40 40" class="donut">
                        <circle class="donut-hole" cx="20" cy="20" r="15.91549430918954"
                            fill="<?= (isset($_SESSION['dark'])) ? "#3030309a" : "#fff" ?>"></circle>
                        <circle class="donut-ring" cx="20" cy="20" r="15.91549430918954" fill="transparent"
                            stroke-width="3.5"></circle>
                        <circle class="donut-segment donut-segment-2 a<?=$i?>" cx="20" cy="20" r="15.91549430918954"
                            fill="transparent" stroke-width="3.5"
                            stroke-dasharray="<?= round($team_anal[$team['id']]['win']/($team_anal[$team['id']]['win']+$team_anal[$team['id']]['draw']+$team_anal[$team['id']]['lose'])*100) ?> <?= 100 - round($team_anal[$team['id']]['win']/($team_anal[$team['id']]['win']+$team_anal[$team['id']]['draw']+$team_anal[$team['id']]['lose'])*100) ?>"
                            stroke-dashoffset="25"></circle>
                        <g class="donut-text donut-text-1">
                            <text y="50%" transform="translate(0, 2)">
                                <tspan x="50%" text-anchor="middle" class="donut-percent">
                                    <?= round($team_anal[$team['id']]['win']/($team_anal[$team['id']]['win']+$team_anal[$team['id']]['draw']+$team_anal[$team['id']]['lose'])*100) ?>%
                                </tspan>
                            </text>
                            <text y="60%" transform="translate(0, 2)">
                                <tspan x="50%" text-anchor="middle" class="donut-data">Win</tspan>
                            </text>
                        </g>
                    </svg>
                </div>
                <div class="stats">
                    <span class="win">Wins: <span class="num"><?= $team_anal[$team['id']]['win'] ?></span></span><span
                        class="draw">Draws: <span class="num"><?= $team_anal[$team['id']]['draw'] ?></span></span><span
                        class="lose">Loses: <span class="num"><?= $team_anal[$team['id']]['lose'] ?></span></span>
                    <?= (isset($_SESSION['userid'])) ? ('<a href="./lib/favorite.php?from=teams&id=' . $team['id'] .'"><img class="heart" src="./res/team/'.$dest.'" alt=""></a>') : "" ?>
                </div>
            </div>
            <?php $i++; ?>
            <?php endforeach?>
        </div>
    </section>
    <script src="./js/sidebar.js"></script>
    <script src="./js/logout.js"></script>
</body>

</html>