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
                        }else if($match['team1-score'] === $match['team2-score']){
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
                        }else if($match['team2-score'] === $match['team1-score']){
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
        usort($team_anal, function ($item1, $item2) {
            return $item2['points'] <=> $item1['points'];
        });
    }


    file_put_contents("./data/analytics.json", json_encode($team_anal));
?>

<!DOCTYPE html>
<html lang="en" dir="ltr" class="<?= (isset($_SESSION['dark'])) ? "dark-mode" : "" ?>">

<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="./css/index_sidebar.css" />
    <link rel="stylesheet" href="./css/team.css">
    <link rel="stylesheet" href="./css/analytics.css">
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" type="image/jpg" href="./res/index/bet1.ico" />
    <title>E L S - Analytics</title>
</head>

<body>
    <?php include_once './lib/sidebar.php'?>
    <section class="home-section">
        <div class="podium">
            <div class="profile-card second">
                <h1 class="number">2</h1>
                <?php if($teams && $matches): ?>
                <img src="./res/teams/<?=$teams[$team_anal[array_keys($team_anal)[1]]['id']]['icon']?>" alt=""
                    class="profile-img">
                <h1 class="team-name"><?=$teams[$team_anal[array_keys($team_anal)[1]]['id']]['name']?></h1>
                <?php endif ?>
            </div>
            <div class="profile-card first">
                <h1 class="number">1</h1>
                <?php if($teams && $matches): ?>
                <img src="./res/teams/<?=$teams[$team_anal[array_keys($team_anal)[0]]['id']]['icon']?>" alt=""
                    class="profile-img">
                <h1 class="team-name"><?=$teams[$team_anal[array_keys($team_anal)[0]]['id']]['name']?></h1>
                <?php endif ?>
            </div>
            <div class="profile-card third">
                <h1 class="number">3</h1>
                <?php if($teams && $matches): ?>
                <img src="./res/teams/<?=$teams[$team_anal[array_keys($team_anal)[2]]['id']]['icon']?>" alt=""
                    class="profile-img">
                <h1 class="team-name"><?=$teams[$team_anal[array_keys($team_anal)[2]]['id']]['name']?></h1>
                <?php endif ?>
            </div>
        </div>
        <div class="main-card">
            <div class="matches">
                <h2 class="matches-title">Rankings</h2>
                <hr>
                <table class="matches-table">
                    <tr class="match">
                        <td class="date bold">Team</td>
                        <td class="match-detail">
                            <div class="left">
                                <span class="team1"></span>
                                <span class="team1-score bold" style="color: rgb(4, 196, 4);">Win</span>
                            </div>
                            <div class="dash bold" style="color: rgb(255, 166, 0);">Draw</div>
                            <div class="right">
                                <span class="team2-score bold" style="color: red;">Lose</span>
                                <span class="team2"></span>
                            </div>
                        </td>
                        <td class="edit-btn bold">Points</td>
                    </tr>
                    <?php $j = 0?>
                    <?php foreach($team_anal as $m): ?>
                    <tr class="match">
                        <td
                            class="date <?= ($j == 0) ? "gold" : (($j == 1)? "silver" : (($j == 2) ? "bronze" : "" ))?>">
                            <?=$teams[$m["id"]]['name']?></td>
                        <td class="match-detail">
                            <div class="left">
                                <span class="team1"></span>
                                <span class="team1-score" style="color: rgb(4, 196, 4);"><?= $m['win'] ?></span>
                            </div>
                            <div class="dash" style="color: rgb(255, 166, 0);"><?= $m['draw'] ?></div>
                            <div class="right">
                                <span class="team2-score" style="color: red;"><?= $m['lose'] ?></span>
                                <span class="team2"></span>
                            </div>
                        </td>
                        <td class="edit-btn"><?= $m['points']." p" ?></td>
                    </tr>
                    <?php $j++ ?>
                    <?php endforeach ?>
                </table>
            </div>
        </div>
    </section>
    <script src="./js/team.js"></script>
    <script src="./js/logout.js"></script>
    <script src="./js/sidebar.js"></script>
</body>

</html>