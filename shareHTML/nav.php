<nav>
    <?php session_start();?>
    <div class="nav-wrapper yellow lighten-2 dohyeon-font">
        <!-- 로고 부분 -->
        <a href="/index.php" class="brand-logo center grey-text text-darken-4">
            <img src="/images/logo_black.png" class="logo_nav" alt="Lamp Games Logo">Lamp Games
        </a>


        <div class="container show-on-large">
            <ul class="left show-on-large">
                <li>
                    <a data-target="slide-out" class="sidenav-trigger show-on-large">
                        <i class="material-icons grey-text text-darken-4">menu</i>
                    </a>
                </li>
            </ul>

            <ul class="right hide-on-med-and-down">
                <?php 
                    if(isset($_SESSION['user_id'])){
                        if($_SESSION['user_id'] == 'admin'){
                            echo '<li><a href="/userinfo/sitemaster.php" class="grey-text text-darken-4"><i class="material-icons left grey-text text-darken-4">person</i>' . $_SESSION['nickName'] . ' 님</a></li>'; 
                        } else {
                            echo '<li><a href="/userinfo/myinfo.php" class="grey-text text-darken-4"><i class="material-icons left grey-text text-darken-4">person</i>' . $_SESSION['nickName'] . ' 님</a></li>'; 
                        } 
                    } else { echo '<li><a href="/login.php"><i class="material-icons grey-text text-darken-4">person</i></a></li>'; } ?>
            </ul>
        </div>



    </div>

</nav>