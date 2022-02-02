<div class="sidebar">
            <div class="logo-details">
                <i class="bx bx-football icon"></i>
                <div class="logo_name">E L S</div>
                <i class="bx bx-menu" id="btn"></i>
            </div>
            <ul class="nav-list">
                <li>
                    <a href="./index.php">
                        <i class='bx bx-home'></i>
                        <span class="links_name">Home</span>
                    </a>
                    <span class="tooltip">Home</span>
                </li>
                <?php if(!isset($_SESSION['userid'])): ?>
                    <li>
                        <a href="./login.php">
                            <i class="bx bx-user"></i>
                            <span class="links_name">Login</span>
                        </a>
                        <span class="tooltip">Login</span>
                    </li>
                <?php endif?>
                <?php if(isset($_SESSION['userid'])): ?>
                    <li>
                        <a href="./favorites.php">
                            <i class="bx bx-heart"></i>
                            <span class="links_name">Saved</span>
                        </a>
                        <span class="tooltip">Saved</span>
                    </li>
                <?php endif?>
                <li>
                    <a href="./analytics.php">
                        <i class="bx bx-pie-chart-alt-2"></i>
                        <span class="links_name">Analytics</span>
                    </a>
                    <span class="tooltip">Analytics</span>
                </li>
                <?php if(isset($_SESSION['userid'])): ?>
                    <li>
                        <a href="./comments.php">
                            <i class="bx bx-chat"></i>
                            <span class="links_name">Comments</span>
                        </a>
                        <span class="tooltip">Comments</span>
                    </li>
                <?php endif?>
                <li>
                    <a href="./teams.php">
                        <i class='bx bx-group'></i>
                        <span class="links_name">Teams</span>
                    </a>
                    <span class="tooltip">Teams</span>
                </li>
                <?php if(isset($_SESSION['userid']) && in_array("admin", $users[$_SESSION['userid']]['roles'])): ?>
                    <li>
                        <a href="./manager.php">
                            <i class="bx bx-cog"></i>
                            <span class="links_name">Manager</span>
                        </a>
                        <span class="tooltip">Manager</span>
                    </li>
                <?php endif?>  
                <?php  
                    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                    $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                ?>
                <li id="dark-mode">
                    <a href="./lib/dark_mode.php?url=<?= $url ?>">
                        <?= (isset($_SESSION['dark'])) ? "<i class='bx bx-sun' ></i>" : "<i class='bx bx-moon' ></i>" ?>
                        <span class="links_name"><?= (isset($_SESSION['dark'])) ? "Light" : "Dark" ?> Mode</span>
                    </a>
                    <span class="tooltip"><?= (isset($_SESSION['dark'])) ? "Light" : "Dark" ?> Mode</span>
                </li>
                <li class="profile">
                    <div class="profile-details">
                        <div class="name_job">
                            <div class="name"></div>
                            <div class="job"><?= (isset($_SESSION['userid'])) ? "@".$users[$_SESSION['userid']]['username'] : "" ?></div>
                        </div>
                    </div>
                        <i class="bx bx-log-out" id="log_out"></i>
                </li>
            </ul>
</div>