<nav>
    <?php session_start();?>
    <div class="nav-wrapper yellow lighten-2 dohyeon-font">
        <!-- 로고 부분 -->
        <a href="/index.html" class="brand-logo center grey-text text-darken-4">
            <img src="/images/logo_black.png" class="logo_nav" alt="Lamp Games Logo">Lamp Games
        </a>

        <div class="container">
            <ul class="left">
                <li>
                    <a href="/review.html" class="grey-text text-darken-4">
                        <i class="material-icons grey-text text-darken-4">dehaze</i>
                    </a>
                </li>
            </ul>
        </div>

        <ul class="hide-on-med-and-down right">
            <?php 
            if(isset($_SESSION['user_id'])){
                echo '<li><a href="/myinfo.php" class="grey-text text-darken-4"><i class="material-icons left grey-text text-darken-4">person</i>' . $_SESSION['nickName'] . ' 님</a></li>';
            } else {
                echo '<li><a href="/login.html"><i class="material-icons grey-text text-darken-4">person</i></a></li>';
            }
            ?>

            <li>
                <form>
                    <div class="input-field">
                        <input id="search" type="search" required>
                        <label class="label-icon" for="search">
                                            <i class="material-icons grey-text text-darken-4">search</i>
                                        </label>
                        <i class="material-icons">close</i>
                    </div>
                </form>
            </li>
        </ul>

    </div>
</nav>