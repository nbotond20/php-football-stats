<?php 
    session_start();
    $teams_json = file_get_contents("../data/teams.json");
    $teams = json_decode($teams_json, true);    
  
    $matches_json = file_get_contents("../data/matches.json");
    $matches = json_decode($matches_json, true);

    $users_json = file_get_contents("../data/users.json");
    $users = json_decode($users_json, true);

    if($matches){
        usort($matches, function ($item1, $item2) {
            return $item2['date'] <=> $item1['date'];
        });
    }
    $isAdmin = false;
    if(isset($_SESSION['userid'])){
        $isAdmin = in_array("admin",$users[$_SESSION['userid']]['roles']) ? true : false;
    }

    function checkWin($team1ID, $team2ID, $score1, $score2, $curTeamID){
        $id = $curTeamID;
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

    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>

<table class="matches-table" id="<?= $_GET['num'] ?>">
    <?php
        if($matches){
            usort($matches, function ($item1, $item2) {
                return $item2['date'] <=> $item1['date'];
            });
        }
        ?>
    <?php $i=0?>
    <?php $j=0?>
    <?php if($matches && $teams) : ?>
    <?php foreach($matches as $match):?>
    <?php if($i < intval($_GET['num']) && $match["team1-score"] != "" && $match["team2-score"] != ""): ?>
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
            <?= ($isAdmin) ? '<a href="edit.php?id='.$matches[array_keys($matches)[$j]]["id"].'&url='."./index.php".'"><i class="bx bxs-edit"></i></a>' : "" ?>
        </td>
    </tr>
    <?php $i= $i + 1?>
    <?php endif ?>
    <?php $j= $j + 1?>
    <?php endforeach ?>
    <?php endif ?>
</table>