<?php
    session_start();

    $teams_json = file_get_contents("./data/teams.json");
    $teams = json_decode($teams_json, true);    
  
    $matches_json = file_get_contents("./data/matches.json");
    $matches = json_decode($matches_json, true);

    $users_json = file_get_contents("./data/users.json");
    $users = json_decode($users_json, true);

    function isAdmin($userid){
        global $users;
        if(isset($users[$userid])){
            if(in_array("admin", $users[$userid]['roles']) !== false){
                return true;
            }
        }
        return false;
    }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr" class="<?= (isset($_SESSION['dark'])) ? "dark-mode" : "" ?>">

<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="./css/index_sidebar.css" />
    <link rel="stylesheet" href="./css/teams.css">
    <link rel="stylesheet" href="./css/manager.css">
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" type="image/jpg" href="./res/index/bet1.ico" />
    <title>E L S - Manager</title>
</head>

<body>
    <?php include_once './lib/sidebar.php'?>
    <section class="home-section">
        <div class="wrapper">
            <?php foreach($users as $user): ?>
            <div class="card">
                <img class="profile-pic" src="./res/users/user.png">
                <h2 class="team-name"><?= $user['name'] ?></h2>
                <span class="username">@<?= $user['username'] ?></span>
                <div class="bottom-bar">
                    <a href="./lib/make_admin.php?id=<?= $user['id'] ?>"><?= (isAdmin($user['id'])) ? "<i class='bx bxs-star' style='color:#ffd700'  ></i>" : "<i class='bx bx-star'></i>" ?></a>
                    <a href="./lib/delete_user.php?id=<?= $user['id'] ?>"><i class='bx bx-trash'></i></a>
                </div>
            </div>
            <?php endforeach?>
        </div>
    </section>
    <script src="./js/sidebar.js"></script>
    <script src="./js/logout.js"></script>
</body>

</html>