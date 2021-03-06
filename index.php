<!DOCTYPE html>
<html>
  <?php session_start();
?>

  <head>
    <meta charset="utf-8" />
    <!-- Compiled and minified CSS -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css"
    />
    <!-- Material 아이콘 사용하기 위한 용도 -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Lamp Games - news & Play Games!!</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- 개인용 css 파일 -->
    <link rel="stylesheet" type="text/css" media="screen" href="/main.css" />
    <!-- html 각각 관리(navbar, footer 등) -->
    <script src="/shareHTML/includeHTML.js"></script>
    <script src="/js/materializecss.js"></script>
  </head>

  <body>
    <header include-html="/shareHTML/nav.php"></header>
    <main>
      <ul id="slide-out" class="sidenav" include-html="/shareHTML/sidebar.php"></ul>

      <div class="container">
        <blockquote class="dohyeon-font">
          <h1>Play Games</h1>
        </blockquote>
        <div class="row">
          <div class="col s12 m6 l3">
            <a href="/games/rpstest/rockpaperscissors.html">
              <div class="card hoverable">
                <div class="card-image cardVerticalImgDiv">
                  <img class="cardVerticalImg" src="/images/rockpaperscissors.png" />
                </div>
                <div class="card-content">
                  <span class="card-title dohyeon-font black-text truncate">가위바위보</span>
                </div>
              </div>
            </a>
          </div>

          <div class="col s12 m6 l3">
            <a href="/games/Breakout/breakout.html">
              <div class="card hoverable">
                <div class="card-image cardVerticalImgDiv">
                  <img class="cardVerticalImg" src="/images/mdn-breakout-gameplay.png" />
                </div>
                <div class="card-content">
                  <span class="card-title dohyeon-font black-text truncate">벽돌깨기</span>
                </div>
              </div>
            </a>
          </div>

          <div class="col s12 m6 l3">
            <a href="/games/phaser_ex1/phaser_tutorial.html">
              <div class="card hoverable">
                <div class="card-image cardVerticalImgDiv">
                  <img class="cardVerticalImg" src="/images/tutorial_header.png" />
                </div>
                <div class="card-content">
                  <span class="card-title dohyeon-font black-text truncate">Phaser</span>
                </div>
              </div>
            </a>
          </div>

          <div class="col s12 m6 l3">
            <a href="http://54.180.115.109:8080/shootergame/">
              <div class="card hoverable">
                <div class="card-image cardVerticalImgDiv">
                  <img class="cardVerticalImg" src="/images/tankgame.png" />
                </div>
                <div class="card-content">
                  <span class="card-title dohyeon-font black-text truncate">Multi Game</span>
                </div>
              </div>
            </a>
          </div>
        </div>

        <blockquote class="dohyeon-font">
          <h2>Game News</h2>
        </blockquote>

        <div class="row col s12">
          <?php include $_SERVER["DOCUMENT_ROOT"].'/php/DBtoView/indexNewsList.php';?>

          <a
            class="waves-effect waves-light btn-large col s12 hoverable jua-font"
            href="/news/news.php"
            style="font-size:large;"
          >
            더보기
          </a>
        </div>
      </div>

      <footer include-html="/shareHTML/footer.php"></footer>

      <!-- HTML 공통 파일 포함 -->
      <script>
        var id;
        document.addEventListener('DOMContentLoaded', function() {
          includeHTML();
          id = document.getElementById('user_id');
        });
      </script>
    </main>
  </body>
</html>
