<!DOCTYPE html>
<html>
  <?php session_start();?>

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
    <link rel="stylesheet" type="text/css" media="screen" href="/list.css" />
    <!-- html 각각 관리(navbar, footer 등) -->
    <script src="/shareHTML/includeHTML.js"></script>
    <script src="/js/materializecss.js"></script>
  </head>

  <body>
    <header>
      <!-- 네비게이션 바 -->
      <nav include-html="/shareHTML/nav.php"></nav>
    </header>
    <main>
      <ul id="slide-out" class="sidenav" include-html="/shareHTML/sidebar.php"></ul>
      <div class="container">
        <blockquote class="dohyeon-font">
          <h2>Game News</h2>
        </blockquote>
        <div class="row" id="newslist">
          <!-- 게시판 리스트 -->
          <div class="col s12" id="newsList">
            <?php
                     $limitNumber = 0;
                        require_once $_SERVER["DOCUMENT_ROOT"].'/php/DBtoView/newsList.php';
                    ?>
          </div>

          <div class="col s12">
            <button
              id="more"
              name="more"
              class="waves-effect btn-large indigo white-text hoverable col s12"
              onclick="moreclick()"
            >
              더보기
            </button>
          </div>
        </div>
      </div>

      <script></script>

      <footer include-html="../shareHTML/footer.php"></footer>
      <!-- HTML 공통 파일 포함 -->
      <script>
        includeHTML();
      </script>

      <script src="/js/newsList/newsListMore.js"></script>
    </main>
  </body>
</html>
