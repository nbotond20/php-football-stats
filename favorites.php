<?php 
    session_start();
    $teams_json = file_get_contents("./data/teams.json");
    $teams = json_decode($teams_json, true);    
  
    $matches_json = file_get_contents("./data/matches.json");
    $matches = json_decode($matches_json, true);

    $users_json = file_get_contents("./data/users.json");
    $users = json_decode($users_json, true);

    $user = null;
    if(isset($_SESSION['userid'])){
        $user = $users[$_SESSION['userid']];
    }
    if($matches){
        usort($matches, function ($item1, $item2) {
            return $item2['date'] <=> $item1['date'];
        });
    }
    $favoriteMatches = [];
    if($matches && $user){
        foreach($matches as $match){
            if(in_array($match['team1'], $user['favorites']) || in_array($match['team2'], $user['favorites'])){
                $favoriteMatches[] = $match;
            }
        }

    }

    function checkWin($team1ID, $team2ID, $score1, $score2, $team){
        $id = $team;
        if($score1 === "" && $score2 === ""){
            return "";
        }

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

?>

<!DOCTYPE html>
<html lang="en" dir="ltr" class="<?= (isset($_SESSION['dark'])) ? "dark-mode" : "" ?>">
    <head>
        <meta charset="UTF-8" />
        <link rel="stylesheet" href="./css/index_sidebar.css" />
        <link rel="stylesheet" href="./css/index_main.css">
        <link rel="stylesheet" href="./css/favorites.css">
        <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="shortcut icon" type="image/jpg" href="./res/index/bet1.ico"/>
        <title>E L S - Favorites</title>
    </head>
    <body>
        <?php include_once './lib/sidebar.php'?>
        <section class="home-section">
            <div class="" id="teams">
                <h1 class="title">Favorites</h1>
            </div>
            <?php if($matches && $user): ?>
                <?php foreach($user['favorites'] as $teamID):?>
                <div class="card last5">
                    <div class="matches">
                        <h2 class="matches-title"><a href="./team.php?id=<?= $teamID ?>"><?= $teams[$teamID]['name'] ?></a></h2>
                        <hr>
                        <table class="matches-table">
                            <?php foreach($favoriteMatches as $m):?>
                                <?php if($m['team1'] === $teamID || $m['team2'] === $teamID):?>
                                    <tr class="match <?= checkWin($m["team1"], $m["team2"], $m["team1-score"], $m["team2-score"], $teamID)?>">
                                        <td class="date"><?= $m["date"]?></td>
                                        <td class="match-detail">
                                            <div class="left">
                                            <span class="team1 <?= ($m["team1"] === $teamID) ? "bold-team" : "" ?>"><?= $teams[$m["team1"]]["name"]?></span>
                                                <span class="team1-score"><?= $m["team1-score"]?></span>
                                            </div>
                                            <div class="dash">-</div>
                                            <div class="right">
                                                <span class="team2-score"><?= $m["team2-score"]?></span>
                                                <span class="team2 <?= ($m["team2"] === $teamID) ? "bold-team" : "" ?>"><?= $teams[$m["team2"]]["name"]?></span>
                                            </div>
                                        </td>
                                        <td class="edit-btn"></td>
                                    </tr>
                                <?php endif ?>
                            <?php endforeach ?>
                        </table>
                    </div>
                </div>
                <?php endforeach?>
            <?php endif ?>
        </section>
        <script src="./js/sidebar.js"></script>
        <script src="./js/logout.js"></script>
    </body>
</html>
