<?php 
    session_start();
    $teams_json = file_get_contents("./data/teams.json");
    $teams = json_decode($teams_json, true);

    $matches_json = file_get_contents("./data/matches.json");
    $matches = json_decode($matches_json, true);

    $users_json = file_get_contents("./data/users.json");
    $users = json_decode($users_json, true);
    $error = false;
    if(isset($_POST['submit'])){
        if(trim($_POST['score1']) === "" && trim($_POST['score2']) === ""){
            $matches[$_GET['id']]['team1-score'] = "";
            $matches[$_GET['id']]['team2-score'] = "";
            $matches[$_GET['id']]['date'] = $_POST['date'];
            file_put_contents("./data/matches.json", json_encode($matches));
            header("Location: ". $_GET['url']);
            exit();
        }
        if((filter_var($_POST['score1'], FILTER_VALIDATE_INT) || filter_var($_POST['score1'], FILTER_VALIDATE_INT) === 0)  && (filter_var($_POST['score2'], FILTER_VALIDATE_INT) || filter_var($_POST['score2'], FILTER_VALIDATE_INT) === 0)){
            if(intval($_POST['score1']) >= 0 && intval($_POST['score2']) >= 0){
                $matches[$_GET['id']]['team1-score'] = intval($_POST['score1']);
                $matches[$_GET['id']]['team2-score'] = intval($_POST['score2']);
                $matches[$_GET['id']]['date'] = $_POST['date'];
                file_put_contents("./data/matches.json", json_encode($matches));
                header("Location: ". $_GET['url']);
                exit();
            }
        }
        $error = true;
    }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr" class="<?= (isset($_SESSION['dark'])) ? "dark-mode" : "" ?>">
    <head>
        <meta charset="UTF-8" />
        <link rel="stylesheet" href="./css/index_sidebar.css" />
        <link rel="stylesheet" href="./css/index_main.css">
        <link rel="stylesheet" href="./css/edit.css">
        <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="shortcut icon" type="image/jpg" href="./res/index/bet1.ico"/>
        <title>E L S - Edit</title>
    </head>
    <body>
        <?php include_once './lib/sidebar.php'?>
        <section class="home-section">
            <form class="card" method="post">
                <h1 class="title">Edit</h1>
                <input name="date" class="date" value="<?= $matches[$_GET['id']]['date'] ?>" type="date">
                <div class="matches">
                    <div class="left">
                        <span class="team1"><?= $teams[$matches[$_GET['id']]['team1']]['name'] ?></span>
                        <input maxlength="2" name="score1" type="text" value="<?= (isset($_POST['score1'])) ? trim($_POST['score1']) : $matches[$_GET['id']]['team1-score']?>" class="team1-score">
                    </div>
                    <div class="dash">-</div>
                    <div class="right">
                        <input maxlength="2" name="score2" type="text" value="<?= (isset($_POST['score2'])) ? trim($_POST['score2']) : $matches[$_GET['id']]['team2-score']?>" class="team2-score">
                        <span class="team2"><?= $teams[$matches[$_GET['id']]['team2']]['name'] ?></span>
                    </div>
                </div>
                <button class="submit" type="submit" name="submit">Save</button>
                <span class="error"><?= ($error) ? "Invalid input!" : ""?></span>
            </form>
        </section>
        <script src="./js/logout.js"></script>
        <script src="./js/sidebar.js"></script>
    </body>
</html>
