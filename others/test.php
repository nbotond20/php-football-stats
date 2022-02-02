<?php
$teams_json = file_get_contents("data/teams.json");
$teams = json_decode($teams_json, true);

function humanTiming ($time)
{   
    $time = strtotime($time);
    $time = $time - 3600;
    $time = time() - $time; // to get the time since that moment
    $time = ($time < 1 ) ? 1 : $time;
    $tokens = array (
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    );

    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'')." ago";
    }
}
/* echo humanTiming("2021-12-27 00:00") */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php $i=0; ?>
    <?php foreach($teams as $team): ?>
        <?php foreach($teams as $team2): ?>
            <?php
                if($team != $team2){
                    echo '"matchid'.$i.'": {';
                    $year = rand(20, 21);
                    $month = rand(1, 12);
                    $day = rand(1, 31);
                    if($month < 10){
                        $month = "0".$month;
                    }
                    if($day < 10){
                        $day = "0".$day;
                    }
                    echo   '"id": "matchid'.$i.'",';
                    echo   '"date": "20'.$year.'-'.$month.'-'.$day.'",';
                    echo    '"team1": "'.$team["id"].'",';
                    echo    '"team1-score": "'.rand(0,6).'",';
                    echo    '"team2": "'.$team2["id"].'",';
                    echo    '"team2-score": "'.rand(0,6).'"';
                    echo'},';
                }
            ?>
            <?php $i=$i+1 ?>      
        <?php endforeach?>
    <?php endforeach?>
</body>
</html>